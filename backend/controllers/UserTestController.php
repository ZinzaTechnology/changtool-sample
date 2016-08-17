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

class UserTestController extends BackendController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        $params = null;
        if ($param = Yii::$app->request->post()) {
            if ($param['submit'] == 'search') {
                $params = $param;
            }
        }
        return $this->render('index', [
                'selected' => $params,
                'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
                'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
                'status' => AppConstant::$USER_TEST_STATUS,
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => (new LogicUserTest)->findUserTestBySearch($params),
                    'pagination' => [
                        'pageSize' => 10,
                    ]
                ]),
        ]);
    }

    public function actionDetail($id)
    {
        $userTest = UserTest::find()->where(['ut_id' => $id]);
        $logicUserTest = new LogicUserTest;
        if ($userTest->exists()) {
            $theUserTest = $userTest->one();
            $userAnswer = empty($theUserTest->ut_user_answer_ids) ? '' : unserialize($theUserTest->ut_user_answer_ids);
            return $this->render('detail', [
                'data' => $logicUserTest->findTestDataByUtID($id),
                'userAnswer' => $logicUserTest->findUserAnswerByUtId($id),
                'tile' => TestExam::findOne($theUserTest->te_id)->te_title,
                'userAnswer' => $userAnswer,
            ]);
        } else {
            throw new NotFoundHttpException('This id not found');
        }
    }

    public function actionAssign()
    {
        $userTest = new UserTest;
        $logicUserTest = new LogicUserTest();
        if ($request = Yii::$app->request->post()) {
            $logicUserTest->parseRequest($request);
            if (!$logicUserTest->isTestEmpty() && !$logicUserTest->isUserEmpty()) {
                $logicUserTest->assignTest();
                if ($logicUserTest->isAssignedSuccess()) {
                    return $this->redirect('index');
                }
            }
        }
        $user = new User;
        $testExam = new TestExam;
        return $this->render('assign', [
            'userModel' => $user,
            'userData' => $user->find()->where(['is_deleted'=>0]),
            'testExam' => $testExam,
            'testList' => $testExam->find()->where($logicUserTest->getTestExamParams()),
            'category' => AppConstant::$TEST_EXAM_CATEGORY_NAME,
            'level' => AppConstant::$TEST_EXAM_LEVEL_NAME,
            'category_choice' => $logicUserTest->getChoice()[0],
            'level_choice' => $logicUserTest->getChoice()[1],
        ]);
    }

    public function actionDelete($id)
    {
        if (UserTest::find()->where(['ut_id' => $id])->exists()) {
            if ((new LogicUserTest)->deleteTestByUtId($id)) {
                $this->goReferrer();
            }
        } else {
            throw new NotFoundHttpException('User Test ID does not exists!');
        }
    }
}
