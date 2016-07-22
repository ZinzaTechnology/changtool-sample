<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace frontend\controllers;

use Yii;
use common\controllers\AppController;

/**
 * this is the base class for all controllers in frontend
 * extends the common AppController
 */
class FrontendController extends AppController
{
    /**
     * control login process here
     */
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
            }
        }

        return true;
    }
}
