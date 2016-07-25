<?php
namespace frontend\controllers;
use Yii;
use frontend\models\UserTest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class UserTestController extends Controller
{
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
    
    public function actionIndex()
    {
    	$model = new UserTest();
    	
    	$current_user = Yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => UserTest::find()->where(['u_id' => $current_user->u_id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        	'model' => $model,
        ]);
    }
    public function actionStart(){
    	$id = Yii::$app->request->get('ut_id');
    	if(UserTest::findOne(['ut_id' => $id, 'u_id'=>Yii::$app->user->id])){
    		if($request = Yii::$app->request->post())
    		$updateTest = UserTest::findOne($id);
    		$userTest = new UserTest();
    		$data = $userTest->getTest($id);
    		return $this->render('start',[
    				'data' => $data,
    		]);
    	}
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new UserTest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ut_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ut_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPagination() {
    	$query = UserTest::find();
    	$count = $query->count();
    	$pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);
    	$models = $query->offset($pagination->offset)
    	->limit($pagination->limit)
    	->all();
    	return $this->render('pagination', [
    			'models' => $models,
    			'pagination' => $pagination,
    	]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = UserTest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
