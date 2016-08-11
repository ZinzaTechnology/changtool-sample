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
        $request= Yii::$app->request->get();
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
        $logicQuestion = new LogicQuestion();
        $testExam = $logicTestExam->findTestExamById($id);

        $testQuestions = null;
        if ($testExam) {
            $testQuestions = $logicQuestion->findQuestionByTestId($id);
        }
        return $this->render('view', [
            'testExam' => $testExam,
            'questions' => $testQuestions,
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
            $params = AppArrayHelper::filterKeys($request['TestExam'],
               ['te_code', 'te_category', 'te_level', 'te_title', 'te_time', 'te_num_of_questions']);

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

        $testExam = $logicTestExam->findTestExamById($id);
        if (!$testExam) {
            $this->setSessionFlash('error', 'Trying to edit non-existing test');
            $this->redirect('index');
        }

        $test_questions = $logicQuestion->findQuestionByTestId($id);

        $request = Yii::$app->request->post();
        $params = [];
        if (!empty($request)) {
            $params['TestExam'] = [];
            $params['Question'] = [];
            $logicTestExam->updateTestExam($params);
            return $this->redirect(['view', 
                'id' => $model->te_id,
                'questions' => $questions,
                'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
                'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            ]);
        } else {
            return $this->render('update', [
                'testExam' => $testExam,
                'questions' => $test_questions,
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
            $this->redirect(['/test-exam']);
        } else {
            Yii::$app->session->setFlash('error', 'Error occurs when deleting this test!');
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
        if (($model = TestExamQuestions::findOne(['te_id' => $te_id, 'q_id' => $q_id])) == null) 
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();
        return $this->redirect(["update?id=$te_id"]);
    }

    public function actionAssigntestexam()
    {
        if($request= Yii::$app->request->get())
        {
            foreach($request['selection'] as $selection)
            {
                echo $selection."<br \>";


            }
            print_r($request['selection']);
        }
    }

}
