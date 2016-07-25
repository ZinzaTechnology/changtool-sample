<?php
namespace frontend\models;
use Yii;

class User extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['u_id','u_name', 'u_mail', 'u_phone', 'u_password_hash'], 'required'],
            [['u_role'], 'string'],
            [['u_created_at', 'u_updated_at'], 'safe'],
            [['u_is_deleted'], 'integer'],
            [['u_name'], 'string', 'max' => 32],
            [['u_mail', 'u_phone', 'u_password_hash', 'u_password_reset_token', 'u_auth_key'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'u_id' => 'User ID',
            'u_name' => 'User Name',
            'u_mail' => 'User Mail',
            'u_phone' => 'User Phone',
            'u_password_hash' => 'User Password Hash',
            'u_password_reset_token' => 'User Password Reset Token',
            'u_auth_key' => 'User Auth Key',
            'u_role' => 'User Role',
            'u_created_at' => 'User Created At',
            'u_updated_at' => 'User Updated At',
            'u_is_deleted' => 'User Is Deleted',
        ];
    }

    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['u_id' => 'u_id']);
    }
}
