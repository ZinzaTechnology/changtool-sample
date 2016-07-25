<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $qt_id
 * @property integer $q_id
 * @property string $qt_content
 *
 * @property Question $q
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_id', 'qt_content'], 'required'],
            [['q_id'], 'integer'],
            [['qt_content'], 'string', 'max' => 32],
            [['q_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['q_id' => 'q_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qt_id' => 'Qt ID',
            'q_id' => 'Q ID',
            'qt_content' => 'Qt Content',
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
