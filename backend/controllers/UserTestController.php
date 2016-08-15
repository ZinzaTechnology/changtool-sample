<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use common\models\UserTest;
use common\models\TestExam;
use common\models\User;
use common\lib\components\AppConstant;
use common\lib\logic\LogicUserTest;
use common\lib\helpers\AppArrayHelper;

class UserTestController extends BackendController {

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

    public $params;

    public function actionIndex() {
        if ($param = Yii::$app->request->post())
            if ($param['submit'] == 'search')
                $this->params = $param;
        return $this->render('index', [
            'selected' => $this->params,
            'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            'dataProvider' => new ArrayDataProvider([
                'allModels' => (new LogicUserTest)->getWithParams($this->params),
                'pagination' => [
                    'pageSize' => 5,
                ]
            ]),
        ]);
    }

    public function actionDetail($id) {
        $userTest = UserTest::find()->where(['ut_id' => $id]);
        $logicUserTest = new LogicUserTest;
        if ($userTest->exists()) {
            $theUserTest = $userTest->one();
            $userAnswer = empty($theUserTest->ut_user_answer_ids) ? '' : unserialize($theUserTest->ut_user_answer_ids);
            return $this->render('detail',[
                'model' => $this->findModel($id),
                'data' => $logicUserTest->getTest($id),
                'trueAnswer' => $logicUserTest->getTrueAnswer(),
                'tile' => TestExam::findOne($theUserTest->te_id)->te_title,
                'userAnswer' => $userAnswer,
            ]);
        } else
            throw new NotFoundHttpException('This id not found');
    }

    public function actionAssign() {
        $userTest = new UserTest;
        $logicUserTest = new LogicUserTest();
        if ($request = Yii::$app->request->post()) {
            $logicUserTest->parseRequest($request);
            if ($logicUserTest->isAssignedSuccess()) {
                return $this->redirect('index');
            }
        }
        return $this->render('assign', [
            'user' => new User,
            'testExam' => new TestExam,
            'testList' => TestExam::find()->where($logicUserTest->getTestExamParams()),
            'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            'category_choice' => $logicUserTest->getChoice()[0],
            'level_choice' => $logicUserTest->getChoice()[1],
        ]);
    }

    public function actionDelete($id) {
        if (UserTest::find()->where(['ut_id' => $id])->exists()) {
            if ((new LogicUserTest)->deteleTest($id))
                $this->goReferrer();
        } else
            throw new NotFoundHttpException('User Test ID does not exists!');
    }

    protected function findModel($id) {
        if (($model = UserTest::findOne($id)) !== null) {
            return $model;
        } else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

}
