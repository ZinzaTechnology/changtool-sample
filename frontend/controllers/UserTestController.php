<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserTest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * UserTestController implements the CRUD actions for UserTest model.
 */
class UserTestController extends Controller
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
     * Lists all UserTest models.
     * @return mixed
     */
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
    	$userTest = new UserTest();
    	$data = $userTest->getTest($id);
    	var_dump($data);
    	var_dump($id);
    }
    /**
     * Displays a single UserTest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserTest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing UserTest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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
    

    /**
     * Deletes an existing UserTest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPagination() {
    	//preparing the query
    	$query = UserTest::find();
    	// get the total number of users
    	$count = $query->count();
    	//creating the pagination object
    	$pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);
    	//limit the query using the pagination and retrieve the users
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

    /**
     * Finds the UserTest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserTest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserTest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
