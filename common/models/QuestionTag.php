<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question_tag".
 *
 * @property integer $tag_id
 * @property integer $q_id
 *
 * @property Question $q
 */
class QuestionTag extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_id', 'tag_id'], 'required'],
            [['q_id'], 'integer'],
            [['q_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['q_id' => 'q_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQ()
    {
        return $this->hasOne(Question::className(), ['q_id' => 'q_id']);
    }
}
