<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_exam_questions".
 *
 * @property integer $te_id
 * @property integer $q_id
 * @property boolean $not_use
 *
 * @property TestExam $te
 * @property Question $q
 */
class TestExamQuestions extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_exam_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id', 'q_id'], 'required'],
            [['te_id', 'q_id'], 'integer'],
            [['not_use'], 'boolean'],
            [['te_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestExam::className(), 'targetAttribute' => ['te_id' => 'te_id']],
            [['q_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['q_id' => 'q_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'te_id' => 'Te ID',
            'q_id' => 'Q ID',
            'not_use' => 'Not Use',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTe()
    {
        return $this->hasOne(TestExam::className(), ['te_id' => 'te_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQ()
    {
        return $this->hasOne(Question::className(), ['q_id' => 'q_id']);
    }
}
