<?php

namespace backend\controllers;

use Yii;
use backend\models\TestExamQuestions;
use backend\models\TestExamQuestionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestExamQuestionsController implements the CRUD actions for TestExamQuestions model.
 */
class TestExamQuestionsController extends Controller
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
     * Lists all TestExamQuestions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestExamQuestionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestExamQuestions model.
     * @param integer $te_id
     * @param integer $q_id
     * @return mixed
     */
    public function actionView($te_id, $q_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($te_id, $q_id),
        ]);
    }

    /**
     * Creates a new TestExamQuestions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestExamQuestions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'te_id' => $model->te_id, 'q_id' => $model->q_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TestExamQuestions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $te_id
     * @param integer $q_id
     * @return mixed
     */
    public function actionUpdate($te_id, $q_id)
    {
        $model = $this->findModel($te_id, $q_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'te_id' => $model->te_id, 'q_id' => $model->q_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TestExamQuestions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $te_id
     * @param integer $q_id
     * @return mixed
     */
    public function actionDelete($te_id, $q_id)
    {
        $this->findModel($te_id, $q_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestExamQuestions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $te_id
     * @param integer $q_id
     * @return TestExamQuestions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($te_id, $q_id)
    {
        if (($model = TestExamQuestions::findOne(['te_id' => $te_id, 'q_id' => $q_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
