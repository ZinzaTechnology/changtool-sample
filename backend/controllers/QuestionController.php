<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use backend\controllers\BackendController;
use common\lib\components\AppConstant;
use common\lib\logic\LogicQuestion;
use common\lib\logic\LogicAnswer;

class QuestionController extends BackendController
{
    public function actionIndex()
    {	
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;

        $params = Yii::$app->request->post();
        $logicQuestion = new LogicQuestion();
        $questions = $logicQuestion->getQuestionBySearch($params);

        $data = [
            'questions' => $questions,
            'category' => $category,
            'type' => $type,
            'level' => $level,
        ];
        return $this->render('index', $data);

    }

    public function actionCreate()
    {	
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $category = array('1' => 'PHP', '2' => 'C','3'=>'Java','4'=>'SQL','5'=>'C#/C++');
        $tagarray= array('1' => 'Language','2' => 'Database','3' => 'Framework','4' => 'Logic','5' => 'C#/C++');
        $question= new Question();
        $answer=new Answer();
        $tag= new Tag();
        if ($question->load(Yii::$app->request->post()))
        {	 $request =Yii::$app->request->post()['Question'];
        $question->q_content = $request['q_content'];
        $question->q_category =$request['q_category'];
        $question->q_type =$request['q_type'];
        $question->q_level =$request['q_level'];
        $question->q_created_date=  date('Y-m-d H:i:s');
        $question->q_updated_date= null;
        $question->q_is_deleted= 1;
        if($question->save())
        {
            return $this->render('view', ['answer' => $answer,'question'=>$question]);
            exit();
        }else return $this->render('create', ['tag' => $tag,'question' => $question,'answer' => $answer,'category'=>$category,'tagarray'=>$tagarray]);
        }else return $this->render('create', ['tag' => $tag,'question' => $question,'answer' => $answer,'category'=>$category,'tagarray'=>$tagarray]);

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
        $answers = $logicAnswer->findAnswersByQuestionId($q_id);

        $data = [
            'question' => $question,
            'answers' => $answers,
            'category' => $category,
            'type' => $type,
            'level' => $level,
            'answer_status' => $answer_status,
        ];
        return $this->render('view', $data);
    }

    public function actionDelete()
    {
        if(($q_id = Yii::$app->request->get('q_id'))!= null)
        {
            if(($question = Question::findOne($q_id))!=null)
            {
                $question->q_is_deleted='0' ;
                if($question->save())
                {
                    $answer = Answer::find()->where(['q_id'=> $q_id])->all();

                    $count= Answer::find()->where(['q_id'=> $q_id])->count();
                    for($i=0 ;$i<$count ; $i++) 
                    {
                        $answer[$i]->qa_is_deleted='0';
                        $answer[$i]->save();	
                    }
                    return $this->redirect('index');
                }


            }

        }

    }

}
