<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserTest;
use backend\models\TestExam;
use backend\models\User;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

class UsertestController extends Controller {

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

    public function actionIndex() {
        if ($param = Yii::$app->request->post())
            $this->params = $param;
        return $this->render('index', [
            'selected' => $this->params,
            'dataProvider' => new ArrayDataProvider([
                'allModels' => UserTest::getWithParams($this->params),
                'pagination' => [
                    'pageSize' => 15,
                ]
            ]),
        ]);
    }

    public function actionView($id) {
        return $this->render('view', 
                [
                    'model' => $this->findModel($id),
        ]);
    }

    public $extend,
            $listTest = [],
            $choice = ['User' => '', 'TestExam' => ''];

    public function actionCreate() {
        if ($request = Yii::$app->request->post()) {

            //First element of post() is '_csrf-backend => array_shift to remove it
            $this->extend = $request; // var extend gets all data from post(), to be used for 'selected' in dropdownlist
            $this->choice['User'] = User::find()
                    ->select('u_name')
                    ->where(['u_id' => $request['User']['u_id']])
                    ->one();

            //Check submit type
            switch ($request['submit']) {
                case 'choose':
                    //Search all Test exam by param got from post
                    $this->listTest = TestExam::find()
                                    ->select('te_id,te_title')
                                    ->where([
                                        'te_category' => $request['TestExam']['te_category'],
                                        'te_level' => $request['TestExam']['te_level'],
                                        'te_is_deleted' => 0
                                    ])->all();
                    break;
                case 'assign':
                    $this->choice['TestExam'] = TestExam::find()
                            ->select('te_title,te_time,te_time,te_num_of_questions')
                            ->where(['te_id' => $request['TestExam']['te_id']])
                            ->one();
                    break;
            }
        }
        return $this->render('create', [
            'user' => new User,
            'testExam' => new TestExam,
            'extInfo' => $this->extend,
            'listTest' => $this->listTest,
            'choosen' => $this->choice,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = UserTest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
