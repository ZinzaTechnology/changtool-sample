<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * TestSearch represents the model behind the search form about `app\models\Test`.
 */
class UserSearch extends User
{
    public $globalSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'is_deleted'], 'integer'],
            [['u_name', 'globalSearch', 'u_mail', 'u_fullname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->orFilterWhere(['like', 'u_name', $this->globalSearch])
            ->orFilterWhere(['like', 'u_mail', $this->globalSearch])
            ->orFilterWhere(['like', 'u_fullname', $this->globalSearch]);
        $query->andFilterWhere([
            'is_deleted' => $this->is_deleted,
        ]);
        return $dataProvider;
    }
}

class Changepassword extends User
{
    public $new_password;
    public $confirm_pwd_update;
    
    public function rules()
    {
        return [
            [['u_password_hash', 'new_password', 'confirm_pwd_update'], 'required', 'on' => 'changePwd'],
            [['u_password_hash'], 'findPasswords', 'on' => 'changepPwd'],
            [['confirm_pwd_update'], 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'],
        ];
    }
    
    public function findPasswords($attribute, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->u_id);
        if ($user->password != md5($this->u_password_hash)) {
            $this->addError($attribute, 'Old password is incorrect.');
        }
    }
}
