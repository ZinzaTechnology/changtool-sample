<?php
namespace frontend\controllers;

use Yii;
use common\controllers\AppController;

class FrontendController extends AppController
{
    public function beforeAction($action)
    {
        if ($action->id === 'login'
            || $action->id === "about"
            || $action->id === "contact"
            || $action->id === 'error') {
            return true;
        } else {
            if (!Yii::$app->user->isGuest) {
                return true;
            } else {
                $this->redirect(['user/login']);
                return false;
            }
        }

        return true;
    }
}
