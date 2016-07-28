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

    /**
     * force a redirect
     * warning: this will terminate the execution of the all scripts
     * Yii events and/or other post action processing will not work properly
     */
    public function forceRedirect($url, $httpCode = 302)
    {
        header('Location: '.$url, true, $httpCode);
        exit;
    }
}
