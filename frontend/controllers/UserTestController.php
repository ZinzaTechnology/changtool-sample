<?php
namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\lib\logic\LogicUserTest;
use common\lib\logic\LogicTestExam;
use common\lib\helpers\AppArrayHelper;

use yii\helpers\Url;

/**
 * UserTestController implements the CRUD actions for UserTest model.
 */
class UserTestController extends FrontendController
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
                    'submit' => ['POST'],
                ],
            ],
        ];
    }

    public function actionStartTest($id)
    {
        // return to dashboard if no parameter
        if (!Yii::$app->request->get('id')) {
            return $this->redirect(Url::toRoute('/'));
        }
    
        $ut_id = Yii::$app->request->get('id');
        $logicUserTest = new LogicUserTest();

        $userTest = LogicUserTest::findUserTestBySearch(['ut_id' => $ut_id, 'u_id' => Yii::$app->user->id])[0];
        // return to dashboard if no valid user test found
        if (empty($userTest)) {
            $this->setSessionFlash('error', 'User test not found');
            return $this->redirect(Url::toRoute('/'));
        }

        // change the test status if not started yet
        if ($userTest['ut_status'] === 'ASSIGNED') {
            $logicUserTest->updateUserTest($id, ['ut_status' => 'DOING', 'ut_start_at' => date('Y-m-d H:i:s')]);
        }

        return $this->redirect(['/user-test/do', 'id' => $ut_id]);
    }

    public function actionDo($id)
    {
        // return to dashboard if no parameter
        if (!Yii::$app->request->get('id')) {
            return $this->redirect(Url::toRoute('/'));
        }
    
        $logicUserTest = new LogicUserTest();
        $logicTestExam = new LogicTestExam();
        $userTestData = $logicUserTest->findUserTestDataByUtId($id);

        // return to dashboard if no valid user test found
        $this->_redirectIfTestNotValid($userTestData);

        // if the test have not been started yet
        $this->_redirectIfTestNotStarted($userTestData);

        // if the test have been done, redirect to result page
        $this->_redirectIfTestDone($userTestData);

        $timeCount = 0;
        $testExam = $logicTestExam->findTestExamById($userTestData['te_id']);
        $testAllowed = $testExam['te_time'] * 60;
        $mustFinishedAt = strtotime($userTestData['ut_start_at']) + $testAllowed;
        $timeAccess = strtotime(date('Y-m-d H:i:s'));
        $timeCount = $mustFinishedAt - $timeAccess;

        // if time excess and not submit, score the test to 0
        // and redirect to result page
        if ($timeCount <= 0) {
            $logicUserTest->updateUserTest($id, ['ut_status' => 'DONE', 'ut_finished_at' => date('Y-m-d H:i:s'), 'ut_mark' => 0]);
            return $this->redirect(Url::toRoute(['result', 'id' => $id]));
        }

        // if no exceptions, user can start doing the test
        return $this->render('do', [
            'userTestData' => $userTestData,
            'timeCount' => $timeCount,
        ]);
    }

    public function actionSubmit()
    {
        $request = Yii::$app->request->post();
        if (empty($request)) {
            return $this->redirect(['/']);
        }

        $request = AppArrayHelper::filterKeys($request, ['ut_id', 'questions']);
        $ut_id = $request['ut_id'];
        $qaSubmit = $request['questions'];

        $logicUserTest = new LogicUserTest();
        $userTestData = $logicUserTest->findUserTestDataByUtId($ut_id);

        // return to dashboard if no valid user test found
        $this->_redirectIfTestNotValid($userTestData);

        // if the test have not been started yet
        $this->_redirectIfTestNotStarted($userTestData);

        // if the test have been done, redirect to result page
        $this->_redirectIfTestDone($userTestData);

        // score the test
        $score = $logicUserTest->scoreUserTest($userTestData, $qaSubmit);
        $answer = serialize($qaSubmit);
        $logicUserTest->updateUserTest($ut_id, ['ut_status' => 'DONE', 'ut_finished_at' => date('Y-m-d H:i:s'), 'ut_mark' => $score, 'ut_user_answer_ids' => $answer]);

        return $this->redirect(Url::toRoute(['result', 'id' => $ut_id]));
    }

    public function actionResult($id)
    {
        $logicUserTest = new LogicUserTest();
        $userTestData = $logicUserTest->findUserTestDataByUtId($id);

        // return to dashboard if no valid user test found
        $this->_redirectIfTestNotValid($userTestData);

        // if the test have not been started yet
        $this->_redirectIfTestNotStarted($userTestData);

        // if the test have not been scored, redirect to /do page
        $this->_redirectIfTestDoing($userTestData);

        // if no exceptions
        return $this->render('result', [
            'userTestData' => $userTestData,
        ]);
    }
    
    public function actionPagination()
    {
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

    /**********************************************
     * private helper function
     * ********************************************/
    private function _redirectIfTestNotValid($userTestData)
    {
        if (empty($userTestData) || $userTestData->u_id != Yii::$app->user->id) {
            $this->setSessionFlash('error', 'User test not found');
            $this->forceRedirect(Url::toRoute('/'));
        }
    }

    private function _redirectIfTestDone($userTestData)
    {
        if ($userTestData['ut_status'] === 'DONE') {
            $this->forceRedirect(Url::toRoute(['result', 'id' => $userTestData->ut_id]));
        }
    }

    private function _redirectIfTestNotStarted($userTestData)
    {
        if ($userTestData['ut_status'] === 'ASSIGNED') {
            $this->setSessionFlash('error', 'You have not started this test yet');
            $this->forceRedirect(Url::toRoute('/'));
        }
    }

    private function _redirectIfTestDoing($userTestData)
    {
        if ($userTestData['ut_status'] === "DOING") {
            $this->setSessionFlash('warning', 'Please continue to do the test');
            $this->forceRedirect(Url::toRoute(['do', 'id' => $userTestData->ut_id]));
        }
    }
}
