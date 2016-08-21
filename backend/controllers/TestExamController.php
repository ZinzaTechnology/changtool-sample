<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\models\TestExam;
use common\lib\components\AppConstant;
use common\lib\logic\LogicTestExam;
use common\lib\logic\LogicQuestion;
use common\lib\helpers\AppArrayHelper;
use common\lib\logic\LogicTestExamQuestions;
/**
 * TestExamController implements the CRUD actions for TestExam model.
 */
class TestExamController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TestExam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        $params = [];
        if (!empty($request)) {
            $params = AppArrayHelper::filterKeys($request, ['te_level', 'te_category']);

            Yii::$app->session->set('te_search', $params);
        } else {
            Yii::$app->session->remove('te_search');
        }

        $logicTestExam = new LogicTestExam();
        $dataProvider = $logicTestExam->findTestExamBySearch($params);
        
        $data = [
            'dataProvider' => $dataProvider,
            'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            'te_search' => Yii::$app->session->get('te_search'),
        ];
        return $this->render('index', $data);
    }

    /**
     * Displays a single TestExam model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $logicTestExam = new LogicTestExam();
        $logicTestExamQuestions = new LogicTestExamQuestions();
        $testExam = $logicTestExam->findTestExamById($id);

        if (!$testExam) {
            // Cannot find info for this testExam id
            $this->setSessionFlash('error', 'Can not find this testExam record in DB');
            return $this->redirect(['index']);
        }
        $request = Yii::$app->request->get();
        $page = 1; // Default current page
        if(isset($request['page'])){
            $page = $request['page'];
        }
        $question_ids = $logicTestExamQuestions->findQuestionIdByTestId($id);
        $paging = $logicTestExam->pagingTestExam($id, 'view', $page, $logicTestExam->paging_view_page_size, $question_ids);
        return $this->render('view', [
            'testExam' => $testExam,
            'questions' => $paging['pagging_questions'],
            'paging_html' => $paging['html'],
            'start' => $paging['start'],
            'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
        ]);
    }

    /**
     * Creates a new TestExam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $logicTestExam = new LogicTestExam();
        $request = Yii::$app->request->post();
        $params = [];
        $newTest = new TestExam();
        if (!empty($request)) {
            $params = AppArrayHelper::filterKeys(
                $request['TestExam'],
                ['te_code', 'te_category', 'te_level', 'te_title', 'te_time', 'te_num_of_questions']
            );

            $newTest = $logicTestExam->insertTestExam(['TestExam' => $params]);

            if ($newTest->te_id) {
                return $this->redirect(['update', 'id' => $newTest->te_id]);
            } else {
                $this->setSessionFlash('error', 'Error occur when creating new test'.Html::errorSummary($newTest));
            }
        }

        return $this->render('create', [
            'testExam' => $newTest,
            'testCategory' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'testLevel' => AppConstant::$TEST_EXAM_LEVEL_NAME,
        ]);
    }

    /**
     * Updates an existing TestExam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $logicTestExam = new LogicTestExam();
        $logicQuestion = new LogicQuestion();

        $request = Yii::$app->request->post();
        $get     = Yii::$app->request->get();
        $params = [];
        if (!empty($request) && isset($request['te_update'])) {
            if ($request['te_update'] == 'add_question') {
                $logicTestExam->updateTestExamInfoToSession($request);
                return $this->redirect(['test-index']);
                
            } elseif ($request['te_update'] == 'add_question_complete') {
                if (isset($request['option'])) {
                    $logicTestExam->updateTestExamQuestionsInfoToSession($request['option']);
                }
                return $this->redirect(['update', 'id' => $id]);
                
            } elseif ($request['te_update'] == 'cancel') {
                // User cancel update, rollback original data
                $logicTestExam->removeTestExamInfoFromSession();
                return $this->redirect(['index']);
                
            } else {
                // Update new data to session
                $ret = $logicTestExam->updateTestExamInfoToSession($request);
                if (AppConstant::$ERROR_SESSION_EMPTY == $ret) {
                    $this->setSessionFlash('error', 'Cannot update becasue session is not setted');
                    $this->redirect(['update', 'id' => $id]);
                }
                // Update new data to database
                $ret = $logicTestExam->updateChangesFromSessionToDB($this);
                if (AppConstant::$ERROR_CAN_NOT_SAVE_TESTEXAM_TO_DB == $ret) {
                    $this->setSessionFlash('error', 'Error occur when save Test Exam info');
                    $this->redirect(['update', 'id' => $id]);
                } elseif (AppConstant::$ERROR_CAN_NOT_INSERT_TESTEXAM_QUESTIONS_TO_DB == $ret) {
                    $this->setSessionFlash('error', 'Error occur when insert questions to test exam');
                    $this->redirect(['update', 'id' => $id]);
                } elseif (AppConstant::$ERROR_CAN_NOT_DELETE_TESTEXAM_QUESTIONS_FROM_DB == $ret) {
                    $this->setSessionFlash('error', 'Error occur when delete questions from test exam');
                    $this->redirect(['update', 'id' => $id]);
                }

                $logicTestExam->removeTestExamInfoFromSession();
                // Get question to display on View page
                return $this->redirect(['view','id' => $id]);
                
            }
        } elseif (isset($get['delete_question'])) {
            // User delete a question in testExam
            $all_questions = $logicQuestion->findQuestionByIds(Yii::$app->session->get('test_exam')['all_questions']);
            return $this->redirect(['update', 'id'=> $id]);
        } else {
            // When user click edit button
            if (isset(Yii::$app->session['test_exam'])) {
                // User is editting testExam
                $test_exam = Yii::$app->session['test_exam'];
                if ($test_exam['testExam']['te_id'] != $id) {
                    // User cannot edit 2 testExams at the same time
                    $this->setSessionFlash('error', "You are editting testExam id = ".$test_exam['testExam']['te_code'].". Please commit or cancel this to edit other testExam");
                    return $this->redirect(['update', 'id' => $test_exam['te_id']]);
                }
                $testExam  = $test_exam['testExam'];
            } else {
                // User start editting testExam
                $testExam = $logicTestExam->findTestExamById($id);
                if (!$testExam) {
                    $this->setSessionFlash('error', 'Trying to edit non-existing test');
                    return $this->redirect(['index']);
                }
                $test_questions = $logicQuestion->findQuestionByTestId($id);
                $logicTestExam->initTestExamInfoToSession($testExam, $id, $test_questions);
            }
            $test_exam = Yii::$app->session['test_exam'];
            if(isset($get['page'])){
                $test_exam['current_page'] = $get['page'];
                Yii::$app->session->set('test_exam', $test_exam);
            }
            $page = $test_exam['current_page'];
            $all_question_ids = Yii::$app->session->get('test_exam')['all_questions'];
            $paging = $logicTestExam->pagingTestExam($id, 'update', $page, $logicTestExam->paging_view_page_size, $all_question_ids);

            return $this->render('update', [
                'testExam' => $testExam,
                'all_questions' => $paging['pagging_questions'],
                'paging_html' => $paging['html'],
                'start' => $paging['start'],
                'testCategory' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
                'testLevel' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            ]);
        }
    }

    /**
     * Deletes an existing TestExam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $logicTestExam = new LogicTestExam();
        if ($logicTestExam->deleteTestExamById($id)) {
            if (isset(Yii::$app->session['test_exam'])) {
                // User is editting testExam
                $test_exam = Yii::$app->session['test_exam'];
                if ($test_exam['testExam']['te_id'] == $id) {
                    // User delete editting testExam, remove session of this testExam
                    $logicTestExam->removeTestExamInfoFromSession();
                }
            }
            $this->redirect(['/test-exam']);
        } else {
            $this->setSessionFlash('error', 'Error occurs when deleting this test!');
            $this->goReferrer();
        }
    }

    /**
     * Delete an existing TestExamQuestion model
     * If the deletion is successful, the browser will not redirecte to anywhere, just reset Update display
     * @param integer $id: the question id
     * @param integer $id: the test exam id
     * return mixed
     */
    public function actionDeleteq($te_id, $q_id)
    {
        $test_exam = Yii::$app->session->get('test_exam');
        
        $logicTestExam = new LogicTestExam();
        $ret = $logicTestExam->deleteQuestionOnSession($te_id, $q_id);
        if (AppConstant::$ERROR_CAN_NOT_EDIT_TWO_TESTEXAM_AT_THE_SAMETIME == $ret) {
            $this->setSessionFlash('error', "You are editting testExam id = ".$test_exam['testExam']['te_id']." Please commit edit or cancel to edit other testExam");
            return $this->redirect('index');
        } elseif (AppConstant::$ERROR_QUESTION_NOT_EXIST_IN_TESTEXAM == $ret) {
            $this->setSessionFlash('error', 'Question does not exist in this testExan');
            $this->redirect(['update', 'id' => $id]);
        }
        
        return $this->redirect(["update?id=$te_id&delete_question=TRUE"]);
    }

    //[tho.nt] add.
    public function actionTestIndex()
    {
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $test_exam = Yii::$app->session->get('test_exam');
        $category = $test_exam['testExam']['te_category'];
        
        
        $request = Yii::$app->request->post();
        $params = [];
        
        $params = AppArrayHelper::filterKeys($request, ['content', 'category', 'level', 'type', 'qt_content']);
        $params['category'] = $category;

        $logicQuestion = new LogicQuestion();
        $questions = $logicQuestion->findQuestionBySearch($params);

        $data = [
            'id' => $test_exam['te_id'],
            'te_code' => $test_exam['testExam']['te_code'],
            'all_questions' => $test_exam['all_questions'],
            'questions' => $questions,
            'category' => AppConstant::$QUESTION_CATEGORY_NAME[$category],
            'type' => $type,
            'level' => $level,
            'search_param' => $params,
        ];
        return $this->render('test_index', $data);
    }
}
