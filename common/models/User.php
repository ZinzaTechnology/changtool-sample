<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\lib\behaviors\DateTimeBehavior;
use yii\validators\UniqueValidator;

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
class User extends ActiveRecord implements IdentityInterface {

    const IS_DELETED_NOT_DELETED = 0;
    const IS_DELETED_DELETED = 1;
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => DateTimeBehavior::className(),
                'createdAtAttribute' => 'u_created_at',
                'updatedAtAttribute' => 'u_updated_at',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public $confirm_pwd_create;
    public $new_password;
    public $confirm_pwd_update;

    public function rules() {
        return [
            [['u_name', 'u_password_hash', 'u_fullname'], 'required'],
            [['u_name'], 'unique'],
            [['u_role'], 'string'],
            [['u_mail'], 'email'],
            [['u_created_at', 'u_updated_at'], 'safe'],
//            [['confirm_pwd_create'], 'compare', 'compareAttribute' => 'u_password_hash', 'message' => 'Confirm password incorrect!'],
            [['confirm_pwd_update'], 'compare', 'compareAttribute' => 'u_password_hash', 'message' => 'Confirm password incorrect!'],
            [['u_is_deleted'], 'integer'],
            [['u_name'], 'string', 'max' => 32],
            [['u_mail', 'u_phone', 'u_password_hash', 'u_password_reset_token', 'u_auth_key', 'u_fullname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'u_id' => 'User ID',
            'u_name' => 'Username',
            'u_mail' => 'Email',
            'u_phone' => 'Phone number',
            'u_password_hash' => 'Password',
            'u_password_reset_token' => 'User Password Reset Token',
            'u_auth_key' => 'User Auth Key',
            'u_role' => 'Role',
            'u_created_at' => 'User Created At',
            'u_updated_at' => 'User Updated At',
            'u_is_deleted' => 'User Is Deleted',
            'u_fullname' => 'Fullname',
            'globalSearch' => '',
            'confirm_pwd_create' => 'Confirm password',
            'new_password' => 'New password',
            'confirm_pwd_update' => 'Confirm password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests() {
        return $this->hasMany(UserTest::className(), ['u_id' => 'u_id']);
    }

    public static function findIdentity($id) {
        return static::findOne(['u_id' => $id, 'u_is_deleted' => self::IS_DELETED_NOT_DELETED]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username) {
        return static::findOne(['u_name' => $username, 'u_is_deleted' => self::IS_DELETED_NOT_DELETED]);
    }

    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'u_password_reset_token' => $token,
                    'u_status' => self::IS_DELETED_NOT_DELETED,
        ]);
    }

    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->u_auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->u_password_hash);
    }

    public function validateRole($role) {
        if (!$role) {
            return true;
        } else {
            return ($this->u_role === $role);
        }
    }

    public function setPassword($password) {
        $this->u_password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->u_auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken() {
        $this->u_password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken() {
        $this->u_password_reset_token = null;
    }

}
