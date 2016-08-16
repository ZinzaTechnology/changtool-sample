<?php
namespace frontend\controllers;

use Yii;
use frontend\models\UserTest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\lib\logic\LogicUserTest;
use common\lib\helpers\AppArrayHelper;

use yii\helpers\Url;

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
    public function actionStartTest($ut_id)
    {
        // return to dashboard if no parameter
        if (!Yii::$app->request->get('id')) {
            $this->redirect(Url::toRoute('/'));
        }
    
        $id = Yii::$app->request->get('id');
        $logicUserTest = new LogicUserTest();
        $userTest = LogicUserTest::findUserTestBySearch(['u_name' => null, 'ut_id' => $id, 'u_id' => Yii::$app->user->id])[0];
        // return to dashboard if no valid user test found
        if (!$userTest) {
            $this->redirect(Url::toRoute('/'));
        }
    
        $time_count = 0;
        if ($userTest['ut_status'] == 'ASSIGNED') {
            $logicUserTest->updateUserTest($id, ['ut_status' => 'DOING', 'ut_start_at' => date('Y-m-d H:i:s')]);
        
            $time_count = $userTest['te_time'] * 60;
        } else {
            $testAllowed = $userTest['te_time'] * 60;
            $mustFinishedAt = strtotime($userTest['ut_start_at']) + $testAllowed;
            $time_access = strtotime(date('Y-m-d H:i:s'));
            $time_count = $mustFinishedAt - $time_access;
        }
    
        switch ($userTest['ut_status']) {
            case "ASSIGNED":
            case "DOING":
                if ($request = Yii::$app->request->post()) {
                    unset($request[Yii::$app->request->csrfParam]);
                    $answer = serialize($request);
                    
                    $logicUserTest->updateUserTest($id, ['ut_status' => 'DONE', 'ut_finished_at' => date('Y-m-d H:i:s'), 'ut_user_answer_ids' => $answer]);
                    $logicUserTest->setMark($id);
                    
                    return $this->redirect(Url::toRoute(['mark', 'id' => $id]));
                }
                $data = (new UserTest())->getTest($id);
                return $this->render('test/start', [
                        'data' => $data,
                        'time_count' => $time_count,
                ]);
                break;
                
            default:
                $this->redirect(Url::toRoute('/'));
                break;
        }
    }
    public function actionMark()
    {
        $id = Yii::$app->request->get('id');
        $array = unserialize(UserTest::findOne($id)->ut_user_answer_ids);
        array_shift($array);
        if ($mark = UserTest::getMark($id)) {
            return $this->render('test/result', [
                    'mark' => $mark
            ]);
        } else {
            return $this->redirect(Url::toRoute('/'));
        }
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
    
    /**
     * Displays a single UserTest model.
     * @param integer $id
     * @return mixed
     */
    public function actionStart()
    {
        $id = Yii::$app->request->get('ut_id');
        if (UserTest::findOne(['ut_id' => $id, 'u_id' => Yii::$app->user->id])) {
            if ($request = Yii::$app->request->post()) {
                $updateTest = UserTest::findOne($id);
            }
            $userTest = new UserTest();
            $data = $userTest->getTest($id);
            return $this->render('start', [
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
