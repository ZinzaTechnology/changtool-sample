<?php

namespace backend\controllers;
use backend\models\Question;
use backend\models\Answer;
use backend\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
class 	QuestionController extends \yii\web\Controller
{
   
	
   	 public function actionIndex()
   	 {	
   	 	
   	 	//$this->layout ='testuser';
   	 	$category = array('1' => 'PHP', '2' => 'C','3'=>'Java','4'=>'SQL','5'=>'C#/C++');
   	 	//$tagarray= array('1' => 'Language','2' => 'Database','3' => 'Framework','4' => 'Logic','5' => 'C#/C++');
   	 	$question= new Question() ;
   	 	$tag =new Tag();
   	 	$answer=new Answer();
   	 	$question = Question::find() -> where(['q_is_deleted'=>'1']);
   	 	if($request = Yii::$app->request->post())
   	 	{
   	 	//array_shift($request);
   	 	$q_content = $request['q_content'];
   	 	$q_category= $request['category'];
   	 	$q_type= $request['type'];
   	 	$qt_content= $request['qt_content'];
   	 	$q_level= $request['level'];
   	 	if($q_content!=null)
   	 	{
   	 		$question->andWhere(['like', 'q_content', $q_content]);
   		
   	 	}
   	 	if($q_category != null)
   	 	{
   	 		$question->andWhere([ 'q_category'=> $q_category]);
   	 		 
   	 	}
   	 	if($q_type !=null)
   	 	{
   	 		$question->andWhere([ 'q_type'=> $q_type]);
   	 	}
   	 	if($q_level !=null)
   	 	{
   	 		$question->andWhere([ 'q_level'=> $q_level]);
   	 	}
   	 	if($qt_content !=null)
   	 	{
   	 		$tag = Tag::find()->where(['like', 'qt_content', $qt_content])->all();
   	 		
   	 		$count= Tag::find()->where(['like', 'qt_content', $qt_content])->count();
   	 			for($i=0 ;$i<$count ; $i++) 
					   	 		{
					   	 			$q_id = $tag[$i]->q_id;
					   	 			$question->orWhere(['q_id'=>$q_id]);
					   	 		}
   	 		
   	 	}
   	 	}
   	 	$question=$question->all();
   	  	//$question = Question::find()->all();
   	 	
   	 	return $this->render('index', ['question' => $question,'answer' => $answer,'category'=>$category]);
   	 	
   	 	
   	 	
   	 	
   	 	/*$query=Question::find()
				->select('Question.q_content,Answer.a_content')
				->joinWith(['Answer'])
				->all();
   	 	 $dataProvider = new ActiveDataProvider([
            'query' => Question::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
   	 	*/
   	 	// return $this->redirect(['view', 'id' => $model->id]);
   	 	
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
   	 	
   	 	//$this->layout ='testuser';
   	 	$q_id = Yii::$app->request->get('q_id');
   	 	//var_dump($q_id); exit();
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
