<?php
namespace backend\controllers;

use Yii;
use common\lib\components\AppConstant;
/**
 * Dashboard controller
 */
class DashboardController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index',['category'=>AppConstant::$QUESTION_CATEGORY_NAME]);
    }
}
