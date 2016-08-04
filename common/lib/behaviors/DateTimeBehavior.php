<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\behaviors;

use yii\behaviors\TimestampBehavior;

/**
 * this class extends Yii built-in TimestampBehavior
 * for the purpose of returning DateTime data type
 * instead of Timestamp data type
 */

class DateTimeBehavior extends TimestampBehavior
{
    /**
     * redefine for the purpose of overiding
     * if neccessary
     */
    public $createdAtAttribute = 'created_at';
    public $updatedAtAttribute = 'updated_at';

    /**
     * @override
     *
     * @return DateTime format [[value]]
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return date('Y-m-d H:i:s', time());
        }
        return parent::getValue($event);
    }
}
