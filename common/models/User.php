<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\lib\behaviors\DateTimeBehavior;

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
class User extends ActiveRecord implements IdentityInterface
{
    const IS_DELETED_NOT_DELETED= 0;
    const IS_DELETED_DELETED= 1;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';

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
    public function behaviors()
    {
        return [
            DateTimeBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_name', 'u_mail', 'u_phone', 'u_password_hash'], 'required'],
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
            'u_id' => 'U ID',
            'u_name' => 'U Name',
            'u_mail' => 'U Mail',
            'u_phone' => 'U Phone',
            'u_password_hash' => 'U Password Hash',
            'u_password_reset_token' => 'U Password Reset Token',
            'u_auth_key' => 'U Auth Key',
            'u_role' => 'U Role',
            'u_created_at' => 'U Created At',
            'u_updated_at' => 'U Updated At',
            'u_is_deleted' => 'U Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['u_id' => 'u_id']);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['u_id' => $id, 'u_is_deleted' => self::IS_DELETED_NOT_DELETED]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['u_name' => $username, 'u_is_deleted' => self::IS_DELETED_NOT_DELETED]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'u_password_reset_token' => $token,
            'u_status' => self::IS_DELETED_NOT_DELETED,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->u_auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->u_password_hash);
    }

    /**
     * Validate role
     */
    public function validateRole($role)
    {
        if (!$role) {
            return true;
        } else {
            return ($this->u_role === $role);
        }
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->u_password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->u_auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->u_password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->u_password_reset_token = null;
    }
}
