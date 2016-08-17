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
        
        $params = [];
        $selected = [
            "content" => "",
            "category" => "",
            "level" => "",
            "type" => "",
            "qt_content" => "" 
        ];
        
        if (! empty($request)) {
            $params = AppArrayHelper::filterKeys($request, [
                'content',
                'category',
                'level',
                'type',
                'qt_content' 
            ]);
            $selected = $params;
        }
        
        $logicQuestion = new LogicQuestion();
        $questions = $logicQuestion->findQuestionBySearch($params);
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $questions,
            'pagination' => [
                'pagesize' => 15 
            ] 
        ]);
        
        $data = [
            'selected' => $selected,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'type' => $type,
            'level' => $level 
        ];
        return $this->render('index', $data);
    }

    public function actionInsertQuestion()
    {
        $answer_status = AppConstant::$ANSWER_STATUS_NAME;
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $tag = AppConstant::$QUESTION_TAG_NAME;
        
        $request = Yii::$app->request->post();
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
            'answer_status' => $answer_status 
        ];
        
        $params = [];
        if (! empty($request)) {
            $request1 = Yii::$app->request->post() ['Question'];
            $request2 = Yii::$app->request->post() ['Answer'];
            if ((! empty($request1)) && (! empty($request2))) {
                $count = 0;
                foreach ($request2 as $val) {
                    if ($val ['qa_status'] == 1) {
                        $count = $count + 1;
                    }
                }
                
                if ($request1 ['q_type'] == 1) {
                    if ($count >= 1) {
                        
                        // insert questions
                        $params = AppArrayHelper::filterKeys($request1, [
                            'q_content',
                            'q_category',
                            'q_level',
                            'q_type',
                            'qt_content' 
                        ]);
                        $question = $logicQuestion->createQuestion($params);
                        if ($question != null) {
                            $q_id = $question->q_id;
                            
                            $answerarray = [];
                            // insert answers
                            foreach ($request2 as $val) {
                                $params = AppArrayHelper::filterKeys($val, [
                                    'qa_content',
                                    'qa_status' 
                                ]);
                                $answer = $logicAnswer->createAnswerByQuesion($params, $q_id);
                                if ($answer != null) {
                                    $answerarray [] = $answer;
                                } else {
                                    Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
                                    return $this->goReferrer();
                                }
                            }
                            
                            $data = [
                                'answers' => $answerarray,
                                'question' => $question,
                                'category' => $category,
                                'type' => $type,
                                'level' => $level,
                                'answer_status' => $answer_status 
                            ];
                            return $this->render('view', $data);
                        } else {
                            Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
                            return $this->goReferrer();
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Error : Answer right >= 1 !');
                        return $this->goReferrer();
                    }
                } else {
                    if ($count >= 2) {
                        
                        // insert questions
                        $params = AppArrayHelper::filterKeys($request1, [
                            'q_content',
                            'q_category',
                            'q_level',
                            'q_type',
                            'qt_content' 
                        ]);
                        $question = $logicQuestion->createQuestion($params);
                        if ($question != null) {
                            $q_id = $question->q_id;
                            $request2 = Yii::$app->request->post() ['Answer'];
                            
                            $answerarray = [];
                            // insert answers
                            foreach ($request2 as $val) {
                                $params = AppArrayHelper::filterKeys($val, [
                                    'qa_content',
                                    'qa_status' 
                                ]);
                                $answer = $logicAnswer->createAnswerByQuesion($params, $q_id);
                                if ($answer != null) {
                                    $answerarray [] = $answer;
                                } else {
                                    Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
                                    return $this->goReferrer();
                                }
                            }
                            
                            $data = [
                                'answers' => $answerarray,
                                'question' => $question,
                                'category' => $category,
                                'type' => $type,
                                'level' => $level,
                                'answer_status' => $answer_status 
                            ];
                            return $this->render('view', $data);
                        } else {
                            Yii::$app->session->setFlash('error', 'Error occurs when create this question!');
                            return $this->goReferrer();
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Error : Answer right >= 2 !');
                        return $this->goReferrer();
                    }
                }
            } else {
                return $this->render('insert-question', $data);
            }
        } else {
            return $this->render('insert-question', $data);
        }
    }

    public function actionEditQuestion()
    {
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
            $request1 = Yii::$app->request->post() ['Question'];
            $request2 = Yii::$app->request->post() ['Answer'];
            if ((! empty($request1)) && (! empty($request2))) {
                $count = 0;
                foreach ($request2 as $val) {
                    if ($val ['qa_status'] == 1) {
                        $count = $count + 1;
                    }
                }
                if ($request1 ['q_type'] == 1) {
                    if ($count >= 1) {
                        
                        // update question
                        $params = AppArrayHelper::filterKeys($request1, [
                            'q_id',
                            'q_content',
                            'q_category',
                            'q_level',
                            'q_type',
                            'qt_content' 
                        ]);
                        
                        $question = $logicQuestion->updateQuestion($params);
                        if ($question != null) {
                            $answerarray = [];
                            
                            foreach ($request2 as $val) {
                                
                                $params = AppArrayHelper::filterKeys($val, [
                                    'qa_id',
                                    'qa_content',
                                    'qa_status' 
                                ]);
                                $answer = $logicAnswer->updateAnswerByQuesion($params);
                                if ($answer != null) {
                                    $answerarray [] = $answer;
                                } else {
                                    Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                                    return $this->goReferrer();
                                }
                            }
                            
                            $data = [
                                'answers' => $answerarray,
                                'question' => $question,
                                'category' => $category,
                                'type' => $type,
                                'level' => $level,
                                'answer_status' => $answer_status 
                            ];
                            return $this->render('view', $data);
                        } else {
                            Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                            return $this->goReferrer();
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Error : Answer right >= 1 !');
                        return $this->goReferrer();
                    }
                } else {
                    if ($count >= 2) {
                        
                        // update question
                        $params = AppArrayHelper::filterKeys($request1, [
                            'q_id',
                            'q_content',
                            'q_category',
                            'q_level',
                            'q_type',
                            'qt_content' 
                        ]);
                        
                        $question = $logicQuestion->updateQuestion($params);
                        if ($question != null) {
                            $answerarray = [];
                            
                            foreach ($request2 as $val) {
                                
                                $params = AppArrayHelper::filterKeys($val, [
                                    'qa_id',
                                    'qa_content',
                                    'qa_status' 
                                ]);
                                $answer = $logicAnswer->updateAnswerByQuesion($params);
                                if ($answer != null) {
                                    $answerarray [] = $answer;
                                } else {
                                    Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                                    return $this->goReferrer();
                                }
                            }
                            
                            $data = [
                                'answers' => $answerarray,
                                'question' => $question,
                                'category' => $category,
                                'type' => $type,
                                'level' => $level,
                                'answer_status' => $answer_status 
                            ];
                            return $this->render('view', $data);
                        } else {
                            Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                            return $this->goReferrer();
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Error : Answer right >= 2 !');
                        return $this->goReferrer();
                    }
                }
            }
        }
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
        $answers = null;
        if ($question) {
            $answers = $logicAnswer->findAnswerByQuestionId($q_id);
        }
        
        $data = [
            'question' => $question,
            'answers' => $answers,
            'category' => $category,
            'type' => $type,
            'level' => $level,
            'answer_status' => $answer_status 
        ];
        return $this->render('view', $data);
    }

    public function actionDelete()
    {
        if (($q_id = Yii::$app->request->get('q_id')) != null) {
            $logicQuestion = new LogicQuestion();
            
            $result = $logicQuestion->deleteQuestionById($q_id);
            if ($result) {
                $this->redirect([
                    '/question' 
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when deleting this question!');
                $this->goReferrer();
            }
        }
    }

    public function actionDeleteAnswer()
    {
        if (($qa_id = Yii::$app->request->get('qa_id')) != null && ($q_id = Yii::$app->request->get('q_id')) != null) {
            $logicAnswer = new LogicAnswer();
            if ($q_id == ($checkid = $logicAnswer->findByAnswerId($qa_id))) {
                $result = $logicAnswer->deleteAnswerById($qa_id);
                if ($result) {
                    $this->redirect([
                        '/question/view',
                        'q_id' => $q_id 
                    ]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occurs when deleting this answer!');
                    $this->goReferrer();
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when deleting this answer!');
                $this->goReferrer();
            }
        }
    }

    public function actionError()
    {
        $this->render('error');
    }

    public function actionEditAnswer()
    {
        $params = [];
        $logicAnswer = new LogicAnswer();
        if (($qa_id = Yii::$app->request->get('qa_id')) != null && ($q_id = Yii::$app->request->get('q_id')) != null) {
            if ($q_id == ($checkid = $logicAnswer->findByAnswerId($qa_id))) {
                if (($answer = $logicAnswer->findById($qa_id)) != null) {
                    $data = [
                        'answer' => $answer,
                        'q_id' => $q_id,
                        'qa_id' => $qa_id 
                    ];
                    return $this->render('edit-answer', $data);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occurs when editting this answer!');
                    return $this->goReferrer();
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when edittting this answer!');
                return $this->goReferrer();
            }
        }
        
        $request = Yii::$app->request->post() ['Answer'];
        if (! empty($request)) {
            $params = AppArrayHelper::filterKeys($request, [
                'qa_id',
                'qa_content',
                'qa_status',
                'q_id' 
            ]);
            if (($answer = $logicAnswer->updateAnswer($params)) != null) {
                return $this->redirect([
                    '/question/view',
                    'q_id' => $params ['q_id'] 
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Error occurs when update this question!');
                return $this->goReferrer();
            }
        }
    }
}
