<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserTest;
use common\models\TestExam;
use backend\models\User;
use yii\data\ArrayDataProvider;

class UserTestController extends Controller {

    public $params;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
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

    public function actionDetail($id) {
        $requestID = Yii::$app->request->queryParams;
        if ($userTest = UserTest::findOne($id)) {
            $userAnswer = unserialize($userTest->ut_user_answer_ids);
            return $this->render('detail', [
                        'model' => $this->findModel($id),
                        'info' => UserTest::getTest($id),
                        'tile' => TestExam::findOne($userTest->te_id)->te_title,
                        'userAnswer' => $userAnswer,
            ]);
        } else
            throw new \yii\web\NotFoundHttpException('This id not found');
    }

    public $choice;

    public function actionAssign() {
        $param = [];
        $userTest = new UserTest;
        if ($request = Yii::$app->request->post()) {
            $testExam = $request['TestExam'];
            $user = $request['User'];
            array_shift($request);
            $this->choice = array_merge($user, $testExam);
            if ($testExam['te_category'])
                $param = array_merge($param, ['te_category' => $testExam['te_category']]);
            if ($testExam['te_level'])
                $param = array_merge($param, ['te_level' => $testExam['te_level']]);
            if (!empty($testExam['te_id']) && !empty($user['u_id'])) {
                $testIDs = array_filter(str_split(preg_replace('/\D/', '', $testExam['te_id'])));
                $userIDs = array_filter(str_split(preg_replace('/\D/', '', $user['u_id'])));
                foreach ($testIDs as $test) {
                    foreach ($userIDs as $user) {
                        $userTest->assignTest($user, $test);
                    }
                }
            }
        }
        return $this->render('assign', [
                    'user' => new User,
                    'testExam' => new TestExam,
                    'choosen' => $this->choice,
                    'testList' => TestExam::find()->select('te_id,te_title')->where($param),
        ]);
    }

    public function actionDelete($id) {
//        $requestID = Yii::$app->request->queryParams;
//        if ($userTest = UserTest::findOne($id))
//            $userTest->delete();
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
