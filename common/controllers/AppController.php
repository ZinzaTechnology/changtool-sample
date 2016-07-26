<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * this is the base class for all controllers in both frontend and backend
 */
class AppController extends Controller
{
    /**
     * define common process here
     */

    /**
     * redirect to referrer url
     * if no referrer url, return to index action of this controller
     */
    public function goReferrer()
    {
        $url = empty(Yii::$app->request->referrer) ? 'index' : Yii::$app->request->referrer;
        return $this->redirect($url);
    }

    /**
     * set message to session flash
     */
    public function setSessionFlash($type, $message)
    {
        Yii::$app->session->setFlash($type, $message);
    }
}
