<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use backend\controllers\BackendController;
use common\lib\components\AppConstant;
use common\lib\logic\LogicQuestion;

class QuestionController extends BackendController
{
    public function actionIndex()
    {	
        $category = AppConstant::$QUESTION_CATEGORY_NAME;
        $type = AppConstant::$QUESTION_TYPE_NAME;
        $level = AppConstant::$QUESTION_LEVEL_NAME;

        $params = Yii::$app->request->post();
        $logicQuestion = new LogicQuestion();
        $question = $logicQuestion->getQuestionBySearch($params);

        $data = [
            'question' => $question,
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
        //var_dump($request);exit();
        //&& $request2 =Yii::$app->request->post()['Answer']
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
        $q_id = Yii::$app->request->get('q_id');
        $question= new Question();
        $answer=new Answer();
        $question = Question::findone($q_id);
        $answer = Answer::find()->where(['q_id'=>$q_id]);
        $answer->andWhere([ 'qa_is_deleted'=> '1']);
        $answer=$answer->all();
        return $this->render('view', ['answer' => $answer,'question'=>$question]);
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
                    //var_dump($answer);exit();
                    for($i=0 ;$i<$count ; $i++) 
                    {
                        $answer[$i]->qa_is_deleted='0';
                        $answer[$i]->save();	
                        //return $this->redirect('index');
                    }
                    return $this->redirect('index');
                }


            }

        }

    }

}
