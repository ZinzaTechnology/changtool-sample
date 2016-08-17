<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace backend\controllers;

use Yii;
use common\controllers\AppController;

/**
 * this is the base class for all controllers in backend
 * extends the common AppController
 */
class BackendController extends AppController
{

    /**
     * only admin can access backend
     * except for login action
     */
    public function beforeAction($action)
    {
        if ($action->id === 'login'
            || $action->id === 'error') {
            return true;
        } else {
            if (Yii::$app->user->isAdmin) {
                return true;
            } else {
                $this->redirect(['user/login']);
            }
        }

        return true;
    }
}
