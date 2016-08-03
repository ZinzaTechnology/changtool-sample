<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\components;

use yii\db\ActiveRecord;

/**
 * This class is the base class for models that interact with DB
 * dedicating to this app.
 * Any model that want to extends ActiveRecord should extends AppActiveRecord
 *
 */

class AppActiveRecord extends ActiveRecord
{
    // all tables should have attribute created_at, updated_at
    public function behaviors()
    {
        return [
            DateTimeBehavior::className(),
        ];
    }
}
