<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//--- Model ---//
use backend\models\UserTest;
use backend\models\UserTestSearch;
use backend\models\TestExam;
use backend\models\TestExamQuestions;
use backend\models\Question;
use backend\models\Answer;
use backend\models\User;
use yii\data\ArrayDataProvider;

/**
 * UserTestController implements the CRUD actions for UserTest model.
 */
class UsertestController extends Controller {

    /**
     * @inheritdoc
     */
    public $params;

    public function behaviors() {
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
    public function actionIndex() {
        if ($param = Yii::$app->request->get()) {
            if($param['a']=='Search')
                $this->params = $param;
            else $this->redirect ('/ba/usertest/');
        }
//                $dataProvider = new ArrayDataProvider([
//            'allModels' => UserTest::getUserTestInfo(),
//            'pagination' => [
//                'pageSize' => 15,]
//        ]);
        $data = UserTest::getUserTestInfoWithParams($this->params);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 15,]
        ]);
//        $searchModel = new UserTestSearch();

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
//        
//        $searchModel = new UserTestSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single UserTest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserTest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->ut_id]);
//        } else {
//            
//        }
        var_dump(\Yii::$app->request->post());
        return $this->render('create', [
                    'user' => new User,
                    'testExam' => new TestExam,
        ]);
    }

    /**
     * Updates an existing UserTest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
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
    public function actionDelete($id) {
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
    protected function findModel($id) {
        if (($model = UserTest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
