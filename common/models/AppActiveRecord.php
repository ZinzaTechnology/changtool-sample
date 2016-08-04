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
    public static $is_logic_delete = false;

    // all tables should have attribute created_at, updated_at
    public function behaviors()
    {
        return [
            DateTimeBehavior::className(),
        ];
    }

    /**
     * replacement for default find function to generate ActiveQuery that contain checking for logic delete
     */
    public static function query($check_deleted = true)
    {
        if (self::$is_logic_delete) {
            $is_deleted = $check_deleted ? 0 : 1;
            return parent::find()->where(['is_deleted' => 0]);
        } else {
            return parent::find()->where("1 = 1");
        }
    }
}
