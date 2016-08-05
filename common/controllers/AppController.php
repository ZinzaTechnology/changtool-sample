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

    public function goReferrer()
    {
        $url = Yii::$app->request->referrer || 'index';
        return $this->redirect($url);
    }
}
