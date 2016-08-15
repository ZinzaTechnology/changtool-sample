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

class UsertestController extends Controller
{

    public $params;

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
        if ($param = Yii::$app->request->post()) {
            $this->params = $param;
        }
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

    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'info' => UserTest::getTest($id),
        ]);
    }

    public $listTest,
            $choice,
            $data;

    public function actionCreate()
    {

        /**
         *  REQUIRE SETUP http://www.yiiframework.com/extension/yii2-dual-list-box/
         *
         * del field ut_question_clone_ids in userTest
         */
        $param = [];
        $userTest = new UserTest;
        if ($request = Yii::$app->request->post()) {
            array_shift($request);
            $this->choice = array_merge($request['User'], $request['TestExam']);
            if ($request['TestExam']['te_category']) {
                $param = array_merge($param, ['te_category' => $request['TestExam']['te_category']]);
            }
            if ($request['TestExam']['te_level']) {
                $param = array_merge($param, ['te_level' => $request['TestExam']['te_level']]);
            }
            if (!empty($request['TestExam']['te_id']) && !empty($request['User']['u_id'])) {
                $testIDs = array_filter(str_split(preg_replace('/\D/', '', $request['TestExam']['te_id'])));
                $userIDs = array_filter(str_split(preg_replace('/\D/', '', $request['User']['u_id'])));
                foreach ($testIDs as $test) {
                    foreach ($userIDs as $user) {
                        $userTest->assignTest($user, $test);
                    }
                }
            }
        }
        $testList = TestExam::find()->select('te_id,te_title')->where($param);
        return $this->render('create', [
                    'user' => new User,
                    'testExam' => new TestExam,
                    'choosen' => $this->choice,
                    'testList' => $testList,
//                    'erros' => $userTest->errors(),
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
