<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $q_id
 * @property integer $q_category
 * @property integer $q_level
 * @property integer $q_type
 * @property string $q_content
 * @property string $q_created_date
 * @property string $q_updated_date
 * @property integer $q_is_deleted
 *
 * @property Answer[] $answers
 * @property Tag[] $tags
 * @property TestExamQuestions[] $testExamQuestions
 * @property TestExam[] $tes
 */
class Question extends \yii\db\ActiveRecord
{
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
            [['q_category', 'q_level', 'q_type', 'q_content', 'q_created_date'], 'required'],
            [['q_category', 'q_level', 'q_type', 'q_is_deleted'], 'integer'],
            [['q_content'], 'string'],
            [['q_created_date', 'q_updated_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q_id' => 'Q ID',
            'q_category' => 'Q Category',
            'q_level' => 'Q Level',
            'q_type' => 'Q Type',
            'q_content' => 'Q Content',
            'q_created_date' => 'Q Created Date',
            'q_updated_date' => 'Q Updated Date',
            'q_is_deleted' => 'Q Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['q_id' => 'q_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['q_id' => 'q_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestExamQuestions()
    {
        return $this->hasMany(TestExamQuestions::className(), ['q_id' => 'q_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTes()
    {
        return $this->hasMany(TestExam::className(), ['te_id' => 'te_id'])->viaTable('test_exam_questions', ['q_id' => 'q_id']);
    }
}
