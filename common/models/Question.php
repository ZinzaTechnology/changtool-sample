<?php

namespace common\models;

use Yii;

class Question extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = true;
    public $answers = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_content', 'q_level', 'q_type', 'q_category'], 'required'],
            [['q_id'], 'integer'],
            [['q_content'], 'string'],
            [['q_category'], 'integer'],
            [['q_type'], 'integer'],
            [['q_level'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q_id' => 'ID',
            'q_content' => 'Content',
            'q_category' => 'Category',
            'q_type' => 'Type',
            'q_level' => 'Level',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];
    }
}
