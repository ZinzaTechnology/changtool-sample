<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use frontend\models\ContactForm;
use frontend\models\User;
use frontend\models\UserTest;
use backend\models\TestExam;
use backend\models\AnswerClone;
use yii\helpers\Url;

/**
 * Dashboard controller
 */
class DashboardController extends FrontendController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionStartTest() {
        if ($id = Yii::$app->request->get('id')) {
            if ($userTest = UserTest::findOne($id)) {
                $time_count = 0;
                if ($userTest->ut_status == 'ASSIGNED') {
                    UserTest::updateStart($id);
                    $time_count = TestExam::findOne($userTest->te_id)->te_time * 60;
                } else {
                    $testAllowed = (TestExam::findOne($userTest->te_id)->te_time) * 60;
                    $mustFinishedAt = strtotime(UserTest::findOne($id)->ut_start_at) + $testAllowed;
                    $time_access = strtotime(date('Y-m-d H:i:s'));
                    $time_count = $mustFinishedAt - $time_access;
                }
                if ($checker = UserTest::findOne(['ut_id' => $id, 'u_id' => Yii::$app->user->id])) {
                    switch ($checker->ut_status) {
                        case "ASSIGNED":
                            goto action;
                            break;
                        case "DOING":
                            goto action;
                            break;
                        default:
                            goto home;
                            break;
                    }
                } else
                    goto home;
            } else
                goto home;
        } else
            goto home;

        home: {
            return $this->redirect(Url::toRoute('/'));
        }
        action: {
            if ($request = Yii::$app->request->post()) {
                UserTest::updateEnd($id, serialize($request));
                return $this->redirect(Url::toRoute(['mark', 'id' => $id]));
            }
            $data = (new UserTest())->getTest($id);
            return $this->render('test/start', [
                        'data' => $data,
                        'time_count' => $time_count,
            ]);
        }
    }

    public function actionMark() {
        $id = Yii::$app->request->get('id');
//        if ($id) {
        if ($mark = UserTest::getMark($id))
//            if ($mark) {
            return $this->render('test/result', [
                        'mark' => $mark
            ]);
//            } 
        else
            return $this->redirect(Url::toRoute('/'));
//        }
//        else return $this->redirect(Url::toRoute('/'));
    }

    public function actionIndex() {
        $user_test_models = UserTest::find()->where(['u_id' => Yii::$app->user->id])->asArray()->all();
        $test_exams = [];
        foreach ($user_test_models as $user_test) {
            $test_exam = TestExam::find()->where(['te_id' => $user_test])->asArray()->one();
            $test_exam = array_merge($test_exam, [
                'ut_start_at' => $user_test['ut_start_at'],
                'ut_finished_at' => $user_test['ut_finished_at']
            ]);
            array_push($test_exams, $test_exam);
        }
        return $this->render('index', [
                    'user_test_models' => $user_test_models,
                    'data' => $test_exams,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
