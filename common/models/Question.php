<?php

namespace common\models;

use Yii;

class Question extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = true;

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
        return [ ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), [
            'q_id' => 'q_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), [
            'q_id' => 'q_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestExamQuestions()
    {
        return $this->hasMany(TestExamQuestions::className(), [
            'q_id' => 'q_id'
        ]);
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasMany(TestExam::className(), [
            'te_id' => 'te_id'
        ])->viaTable('test_exam_questions', [
            'q_id' => 'q_id'
        ]);
    }
}
