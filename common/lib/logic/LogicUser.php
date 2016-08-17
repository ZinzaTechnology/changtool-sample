<?php

namespace common\lib\logic;

use Yii;
use common\lib\helpers\AppArrayHelper;
use common\models\User;
use common\models\UserSearch;
use common\lib\components\AppConstant;
use yii\data\ActiveDataProvider;

class LogicUser extends LogicBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function createUserById($params)
    {
        $model = new User();
            
        $model->u_name = $params['u_name'];
        $model->u_fullname = $params['u_fullname'];
        $model->u_mail = $params['u_mail'];
        $model->u_role = $params['u_role'];
        $model->u_password_hash = Yii::$app->security->generatePasswordHash($params['u_password_hash']);

        if ($model->validate()) {
            $model->save();
        }
        return $model;
    }
    
    public function findUserById($u_id)
    {
        return User::queryOne($u_id);
    }
    
    public function deleteUserById($u_id)
    {
        $user = User::queryOne($u_id);
        $user->is_deleted = 1;
        $user->save();
    }
    
    public function updateUserById(&$user, $params)
    {
        $user->u_fullname = $params['u_fullname'];
        $user->u_mail = $params['u_mail'];
        $user->u_role = $params['u_role'];
        
        return $user->save();
    }
    
    public function changePasswordUserById(&$user, $params)
    {
        $user->u_password_hash = Yii::$app->security->generatePasswordHash($params['u_password_hash']);

        return $user->save();
    }
    
    public function findUserBySearch($params, &$userSearch)
    {
        $query = User::query();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $userSearch->load($params);

        if (!$userSearch->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['or', ['like', 'u_name', $userSearch->globalSearch],
            ['like', 'u_mail', $userSearch->globalSearch],
            ['like', 'u_fullname', $userSearch->globalSearch]]);
        
        return $dataProvider;
    }
}
