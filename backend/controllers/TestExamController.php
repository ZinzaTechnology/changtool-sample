<?php

namespace backend\controllers;

use Yii;
use backend\models\TestExam;
use backend\models\TestExamSearch;
use backend\models\Question;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\TestExamQuestions;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\controllers\GlobalVariableController;

$session = Yii::$app->session;
if(!$session->isActive)
{
	$session->open();
}
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
    public $param;
    public function actionIndex()
    {
    	//print_r(GlobalVariableController::$category);
//         $searchModel = new TestExamSearch();

//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        //echo "<br \><br \><br \><br \>";
        //print_r(Yii::$app->request->queryParams);

    	Yii::$app->session->set('is_assign_test_exam', "no");
    	
    	$searchModel = new TestExamSearch();
    	$dataProvider = $searchModel->search([$searchModel->formname()=>['te_is_deleted'=>0]]);
    	
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'category' => GlobalVariableController::$category,
    			'level' => GlobalVariableController::$level,
    	]);
    	
    	
//         if($request = Yii::$app->request->get()){
//         	$this->param = array_filter($request['TestExam']);
//         }
//         $category = "php";//$catygory["$dataProvider->te_category"];
//         return $this->render('index', [
//             //'searchModel' => $searchModel,
//             'dataProvider' => new ArrayDataProvider([
//         		'allModels' => TestExam::getData($this->param),
//         	]),
//         	'category' => $category,
//         	'model' => new TestExam,	
//         ]);
    }

    /**
     * Displays a single TestExam model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	
    	$test_questions = TestExamQuestions::findAll($id);
    	$questions=array();
    	foreach($test_questions as $tq)
    	{
    		$q = Question::findOne($tq['q_id']);
    		array_push($questions, $q);
    	}
    	$category_index = array_search($model->te_category, array_column(GlobalVariableController::$category, 'id'));
    	$level_index = array_search($model->te_level, array_column(GlobalVariableController::$level, 'id'));
        return $this->render('view', [
            'model' => $model,
        	'questions' => $questions,
        	'category_name' => GlobalVariableController::$category[$category_index]['name'],
        	'level_name' => GlobalVariableController::$level[$level_index]['name'],
        ]);
    }

    /**
     * Creates a new TestExam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestExam();
		
        if ($model->load(Yii::$app->request->post())) {
        	// Date create Test is auto get by system
        	$model->te_created_at = date('Y-m-d h:m:s');
        	$model->save();
            return $this->redirect(['view', 'id' => $model->te_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'category' => GlobalVariableController::$category,
            	'level' => GlobalVariableController::$level,
            ]);
        }
    }

    /**
     * Updates an existing TestExam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$test_questions = TestExamQuestions::findAll($id);
		$questions=array();
		foreach($test_questions as $tq)
		{
			$q = Question::findOne($tq['q_id']);
			array_push($questions, $q);
		}
		//$test_question = $test_questions->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
        	$model->te_last_updated_at = date('Y-m-d h:m:s');
        	$model->save();
            return $this->redirect(['view', 
            	'id' => $model->te_id,
            	'questions' => $questions,
            	'category' => GlobalVariableController::$category,
            	'level' => GlobalVariableController::$level,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            	'questions' => $questions,
            	'category' => GlobalVariableController::$category,
            	'level' => GlobalVariableController::$level,
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
        $model = $this->findModel($id);
        $model->te_is_deleted = 1;
        $model->save();

        return $this->redirect(['index']);
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
    
	public function actionSearchtestexam()
	{	
		//Yii::$app->session->set('is_assign_test_exam', "yes");
		if($request= Yii::$app->request->get()){
			//var_dump($request);
		}
// 		echo "<br \><br \><br \><br \><br \>abc";
// 		var_dump($request);
		Yii::$app->session->set('te_level', $request['te_level']);
		Yii::$app->session->set('te_category', $request['te_category']);
		
		$searchModel = new TestExamSearch();
        $dataProvider = $searchModel->search([$searchModel->formname()=>['te_level'=>$request['te_level'],
        		'te_category'=>$request['te_category'], 
        		'te_is_deleted'=>0]]);
		if(($model = TestExam::findAll(['te_category' => $request['te_category'],
			'te_level' => $request['te_level']])) !== null)
		{
			return $this->render('index', 
					['dataProvider'=>$dataProvider,
					'category' => GlobalVariableController::$category,
					'level' => GlobalVariableController::$level,
					]);
		}
		else {
			throw new NotFoundHttpException('The requested page does not exist......');
		}
		return $this->render('index');
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
	
    /**
     * Finds the TestExam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TestExam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestExam::findOne($id)) !== null) {
            return $model;
        } 
        else 
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
