<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $u_id
 * @property string $u_name
 * @property string $u_mail
 * @property string $u_phone
 * @property string $u_password_hash
 * @property string $u_password_reset_token
 * @property string $u_auth_key
 * @property string $u_role
 * @property string $u_created_at
 * @property string $u_updated_at
 * @property integer $u_is_deleted
 *
 * @property UserTest[] $userTests
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['u_id' => 'u_id']);
    }
}
