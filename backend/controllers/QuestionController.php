<?php

namespace backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use backend\controllers\BackendController;
use common\lib\components\AppConstant;
use common\lib\logic\LogicQuestion;
use common\lib\logic\LogicAnswer;
use common\lib\helpers\AppArrayHelper;

class QuestionController extends BackendController
{

    public function actionIndex()
    {
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $request = Yii::$app->request->post();
        
        $params = AppArrayHelper::filterKeys($request, [
            'content',
            'category',
            'level',
            'type',
            'qt_content',
            'submit'
        ]);
        $logicQuestion = new LogicQuestion();
        $questions = $logicQuestion->findQuestionBySearch($params);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $questions,
            'pagination' => [
                'pagesize' => AppConstant::PAGING_INDEX_PAGE_SIZE,
            ]
        ]);
        $data = [
            'selected' => $params,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'type' => $type,
            'level' => $level,
        ];
        return $this->render('index', $data);
    }

    public function actionView($q_id)
    {
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $answer_status = AppConstant::$ANSWER_STATUS_NAME;

        $q_id = Yii::$app->request->get('q_id');

        $logicQuestion = new LogicQuestion();
        $logicAnswer = new LogicAnswer();

        $question = $logicQuestion->findQuestionById($q_id);
        $dataProvider = null;
        if ($question) {
            // find answer
            $answers = $logicAnswer->findAnswerByQuestionId($q_id);
            $dataProvider = new ArrayDataProvider([
                'allModels' => $answers,
                'pagination' => [
                    'pagesize' => AppConstant::PAGING_VIEW_PAGE_SIZE,
                ]
            ]);
        }
        
        $data = [
            'question' => $question,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'type' => $type,
            'level' => $level,
            'answer_status' => $answer_status ,
        ];
        return $this->render('view', $data);
    }

    public function insertQuestion($request_question, $request_answer, $logicAnswer, $logicQuestion, $category, $type, $level, $answer_status)
    {
        $params = [];
        // insert questions
        $params = AppArrayHelper::filterKeys($request_question, [
            'q_content',
            'q_category',
            'q_level',
            'q_type',
            'qt_content'
        ]);
        $question = $logicQuestion->createQuestion($params);
        if ($question != null) {
            $q_id = $question->q_id;
            // insert answers
            $answerarray = [];
            foreach ($request_answer as $val) {
                $params = AppArrayHelper::filterKeys($val, [
                    'qa_content',
                    'qa_status'
                ]);
                $answer = $logicAnswer->createAnswerByQuesion($params, $q_id);
                if ($answer != null) {
                    $answerarray[] = $answer;
                } else {
                    Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
                    return $this->goReferrer();
                }
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => $answerarray,
                'pagination' => [
                    'pagesize' => AppConstant::PAGING_ADD_QUESTION_PAGE_SIZE,
                ]
            ]);
            $data = [
                'dataProvider' => $dataProvider,
                'question' => $question,
                'category' => $category,
                'type' => $type,
                'level' => $level,
                'answer_status' => $answer_status,
            ];
            
            return $data;
        } else {
            Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
            return $this->goReferrer();
        }
    }

    public function actionInsertQuestion()
    {
        $answer_status = AppConstant::$ANSWER_STATUS_NAME;
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $tag = AppConstant::$QUESTION_TAG_NAME;

        $logicQuestion = new LogicQuestion();
        $logicAnswer = new LogicAnswer();

        $question = $logicQuestion->initQuestion();
        $answer = [
            $logicAnswer->initAnswer()
        ];
        $data = [
            'answer' => $answer,
            'question' => $question,
            'category' => $category,
            'type' => $type,
            'level' => $level,
            'answer_status' => $answer_status,
        ];

        $request = Yii::$app->request->post();
        if (! empty($request)) {
            $request_question = Yii::$app->request->post()['Question'];
            $request_answer = Yii::$app->request->post()['Answer'];
            if ((! empty($request_question)) && (! empty($request_answer))) {
                $countTrue = 0;
                $countFalse = 0;
                foreach ($request_answer as $val) {
                    if ($val['qa_status'] == 1) {
                        $countTrue++;
                    }else $countFalse++;
                }
                switch(true){
                    case ($countTrue < $request_question['q_type']):
                        Yii::$app->session->setFlash('error', 'Amount of true answer must be equal or more than question type!');
                        return $this->goReferrer();
                        break;
                    case ($countTrue >= 1 && $countFalse >= 1):
                        $data = $this->insertQuestion($request_question, $request_answer, $logicAnswer, $logicQuestion, $category, $type, $level, $answer_status);
                        break;
                    default:
                        Yii::$app->session->setFlash('error', 'Answer must have at least 1 true answer and 1 false answer!');
                        return $this->goReferrer();
                        break;
                }
                return $this->render('view', $data);
            }
        }

        return $this->render('insert-question', $data);
    }

    public function editQuestion($request_question, $request_answer, $logicAnswer, $logicQuestion, $category, $type, $level, $answer_status, $answer_old)
    {
        // update question
        $params = AppArrayHelper::filterKeys($request_question, [
            'q_id',
            'q_content',
            'q_category',
            'q_level',
            'q_type',
            'qt_content' 
        ]);
        
        $question = $logicQuestion->updateQuestion($params);
        if ($question != null) {
            $q_id = $question->q_id;
            // delete old answers
            if ($answer_old != null) {
                foreach ($answer_old as $val_old) {
                    
                    $i = 0;
                    foreach ($request_answer as $val) {
                        $params = AppArrayHelper::filterKeys($val, [
                            'qa_id' 
                        ]);
                        if ($val_old['qa_id'] == $params['qa_id']) {
                            $i = $i + 1;
                        }
                    }
                    if ($i == 0) {
                        $logicAnswer->deleteAnswerById($val_old['qa_id']);
                    }
                }
            }
            // update answer
            $answerarray = [];
            
            foreach ($request_answer as $val) {
                $params = AppArrayHelper::filterKeys($val, [
                    'qa_id',
                    'qa_content',
                    'qa_status' 
                ]);
                $answer = $logicAnswer->updateAnswerByQuesion($params, $q_id);
                if ($answer != null) {
                    $answerarray[] = $answer;
                } else {
                    Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                    return $this->goReferrer();
                }
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => $answerarray,
                'pagination' => [
                    'pagesize' => 5 
                ] 
            ]);
            $data = [
                'dataProvider' => $dataProvider,
                'question' => $question,
                'category' => $category,
                'type' => $type,
                'level' => $level,
                'answer_status' => $answer_status 
            ];
            return $data;
        } else {
            Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
            return $this->goReferrer();
        }
    }

    public function actionEditQuestion()
    {
        $session = Yii::$app->session;
        $answer_status = AppConstant::$ANSWER_STATUS_NAME;
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $tag = AppConstant::$QUESTION_TAG_NAME;
        $logicQuestion = new LogicQuestion();
        $logicAnswer = new LogicAnswer();
        if (($q_id = Yii::$app->request->get('q_id')) != null) {
            if (($question = $logicQuestion->findQuestionById($q_id)) != null) {
                $answer = [
                    $logicAnswer->initAnswer() 
                ];
                $data = [
                    'question' => $question,
                    'answer' => $answer,
                    'category' => $category,
                    'type' => $type,
                    'level' => $level,
                    'answer_status' => $answer_status,
                    'q_id' => $q_id 
                ];
                if (($answer = $logicAnswer->findAnswerByQuestionId($q_id)) != null) {
                    $session['answer'] = $answer;
                    $data = [
                        'question' => $question,
                        'answer' => $answer,
                        'category' => $category,
                        'type' => $type,
                        'level' => $level,
                        'answer_status' => $answer_status,
                        'q_id' => $q_id 
                    ];
                }
                return $this->render('edit-question', $data);
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when editting this answer!');
                return $this->goReferrer();
            }
        }
        
        $request = Yii::$app->request->post();
        $params = [];
        if (! empty($request)) {
            $answer_old = $session['answer'];
            unset($session['answer']);
            $request_question = Yii::$app->request->post()['Question'];
            $request_answer = Yii::$app->request->post()['Answer'];
            if ((! empty($request_question)) && (! empty($request_answer))) {
                $countTrue = 0;
                $countFalse = 0;
                foreach ($request_answer as $val) {
                    if ($val['qa_status'] == 1) {
                        $countTrue++;
                    }else $countFalse++;
                }
                switch(true){
                    case ($countTrue < $request_question['q_type']):
                        Yii::$app->session->setFlash('error', 'Amount of true answer must be equal or more than question type!');
                        return $this->goReferrer();
                        break;
                    case ($countTrue >= 1 && $countFalse >= 1):
                        $data = $this->insertQuestion($request_question, $request_answer, $logicAnswer, $logicQuestion, $category, $type, $level, $answer_status);
                        break;
                    default:
                        Yii::$app->session->setFlash('error', 'Answer must have at least 1 true answer and 1 false answer!');
                        return $this->goReferrer();
                        break;
                }
                return $this->render('view', $data);
            }
        }
    }

    public function actionDelete()
    {
        if (($q_id = Yii::$app->request->get('q_id')) != null) {
            $logicQuestion = new LogicQuestion();
            
            $result = $logicQuestion->deleteQuestionById($q_id);
            if ($result) {
                return $this->redirect([
                    '/question' 
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when deleting this question!');
                $this->goReferrer();
            }
        }
    }

   

   
}
