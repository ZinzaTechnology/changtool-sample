<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\models;

use yii\db\ActiveRecord;
use common\lib\behaviors\DateTimeBehavior;

/**
 * This class is the base class for models that interact with DB
 * dedicating to this app.
 * Any model that want to extends ActiveRecord should extends AppActiveRecord
 *
 */

class AppActiveRecord extends ActiveRecord
{

    // for all table that has column `is_deleted`, $is_logic_delete should be set to true
    public static $is_logic_delete = false;

    // all tables should have attribute created_at, updated_at
    public function behaviors()
    {
        return [
            DateTimeBehavior::className(),
        ];
    }

    /**
     * replacement for default [[find()]] function
     * to generate ActiveQuery that contain checking for logic delete
     */
    public static function query($check_deleted = true)
    {
        if (static::$is_logic_delete && $check_deleted) {
            return parent::find()->where(['is_deleted' => 0]);
        } else {
            return parent::find()->where("1 = 1");
        }
    }


    /**
     * replacement for default [[findAll()]] function
     * to generate ActiveQuery that contain checking for logic delete
     */
    public static function queryAll($condition, $check_deleted = true)
    {
        $query = static::findByCondition($condition);
        if (static::$is_logic_delete && $check_deleted) {
            $query->andWhere(['is_deleted' => 0]);
        }
        return $query->all();
    }

    /**
     * replacement for default [[findOne()]] function
     * to generate ActiveQuery that contain checking for logic delete
     */
    public static function queryOne($condition, $check_deleted = true)
    {
        $query = static::findByCondition($condition);
        if (static::$is_logic_delete && $check_deleted) {
            $query->andWhere(['is_deleted' => 0]);
        }
        return $query->one();
    }
}
