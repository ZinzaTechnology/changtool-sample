<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\components;

use yii\web\User as YiiUser;

class User extends YiiUser
{
    /**
     * redefine in case of configuration
     */
    public $loginUrl = ['user/login'];

    /**
     * check admin
     */

    public function getIsAdmin()
    {
        $identity = $this->getIdentity();
        if (isset($identity) && $identity->u_role === 'ADMIN') {
            return true;
        }
        return false;
    }
}
