<?php

namespace common\models;

use Yii;

class Answer extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_id', 'qa_content'], 'required'],
            [['q_id'], 'integer'],
            [['qa_content'], 'string'],
            [['qa_status'], 'boolean'],
            [['q_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['q_id' => 'q_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qa_id' => 'Qa ID',
            'q_id' => 'Q ID',
            'qa_content' => 'Qa Content',
            'qa_status' => 'Qa Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQ()
    {
        return $this->hasOne(Question::className(), ['q_id' => 'q_id']);
    }
}
