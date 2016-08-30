<?php

namespace backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use backend\controllers\BackendController;
use common\lib\components\AppConstant;
use common\lib\logic\LogicQuestion;
use common\lib\logic\LogicAnswer;
use common\lib\helpers\AppArrayHelper;
use yii\helpers\Html;

class QuestionController extends BackendController
{

    public function actionIndex()
    {
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;
        $request = Yii::$app->request->get();
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


        // In case first access
        if (empty(Yii::$app->request->post())) {
            return $this->render('insert-question', $data);
        }

        $request = AppArrayHelper::filterKeys(Yii::$app->request->post(), ['Question', 'Answer']);
        // In case parameters are invalid
        if (empty($request['Question']) || empty($request['Answer'])) {
            $this->setSessionFlash('error', 'Invalid parameters');
            return $this->render('insert-question', $data);
        }

        // Error if there are no true answers
        if (!$logicQuestion->checkValidTrueAnswerNumber($request['Question'], $request['Answer'])) {
            $this->setSessionFlash('error', 'Number of right answer must be > 0!');
            return $this->render('insert-question', $data);
        }
        
        // Go on to insert question
        $question = $logicQuestion->insertQuestionAndAnswers($request['Question'], $request['Answer']);
        if (! empty($question->errors)) {
            $this->setSessionFlash('error', Html::errorSummary($question));
            return $this->render('insert-question', $data);
        }

        // Insert success
        return $this->redirect(['view', 'q_id' => $question->q_id]);
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
        $q_id = Yii::$app->request->get('q_id');
        $question = $logicQuestion->findQuestionById($q_id);

        // invalid question id provided
        if (!$question) {
            $this->setSessionFlash('error', 'Question not found');
            return $this->redirect('index');
        }

        // find question answer
        $answers = $logicAnswer->findAnswerByQuestionId($q_id);
        if (!$answers) {
            $answers = [$logicAnswer->initAnswer()];
        }
        Yii::$app->session->set('edit-answers', $answers);
        $data = [
            'question' => $question,
            'answers' => $answers,
            'category' => $category,
            'type' => $type,
            'level' => $level,
            'answer_status' => $answer_status,
        ];
        return $this->render('edit-question', $data);
    }

    public function actionExecuteEdit()
    {
        // if no post request, return to index
        $request = Yii::$app->request->post();
        if (empty($request)) {
            $this->setSessionFlash('error', 'Invalid parameters');
            return $this->goReferrer();
        }

        // if no old answers in session, redirect to index page
        $oldAnswers = Yii::$app->session->get('edit-answers');
        if (!$oldAnswers) {
            $this->setSessionFlash('error', 'Unknown error occurs! Please try again');
            return $this->goReferrer();
        }

        $request = AppArrayHelper::filterKeys($request, ['Question', 'Answer']);
        // In case parameters are invalid
        if (empty($request['Question']) || empty($request['Answer'])) {
            $this->setSessionFlash('error', 'Invalid parameters');
            return $this->goReferrer();
        }

        // Error if there are no true answers
        $logicQuestion = new LogicQuestion();
        if (!$logicQuestion->checkValidTrueAnswerNumber($request['Question'], $request['Answer'])) {
            $this->setSessionFlash('error', 'Number of right answer must be > 0!');
            return $this->goReferrer();
        }

        // Go on to update question
        $question = $logicQuestion->updateQuestionAndAnswers($request['Question'], $request['Answer']);
        if (!$question) {
            $this->setSessionFlash('error', 'Corresponding question not found');
            return $this->goReferrer();
        }
        if (! empty($question->errors)) {
            $this->setSessionFlash('error', Html::errorSummary($question));
            return $this->goReferrer();
        }

        // updat success
        return $this->redirect(['view', 'q_id' => $question->q_id]);
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
