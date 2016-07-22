<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "test_exam".
 *
 * @property integer $te_id
 * @property string $te_code
 * @property integer $te_category
 * @property integer $te_level
 * @property string $te_title
 * @property integer $te_time
 * @property integer $te_num_of_questions
 * @property string $te_created_at
 * @property string $te_last_updated_at
 * @property integer $te_is_deleted
 *
 * @property TestExamQuestions[] $testExamQuestions
 * @property Question[] $qs
 * @property UserTest[] $userTests
 */
class TestExam extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_exam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_code', 'te_category', 'te_level', 'te_title', 'te_time', 'te_num_of_questions'], 'required'],
            [['te_category', 'te_level', 'te_time', 'te_num_of_questions', 'te_is_deleted'], 'integer'],
            [['te_created_at', 'te_last_updated_at'], 'safe'],
            [['te_code'], 'string', 'max' => 15],
            [['te_title'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'te_id' => 'Te ID',
            'te_code' => 'Te Code',
            'te_category' => 'Te Category',
            'te_level' => 'Te Level',
            'te_title' => 'Te Title',
            'te_time' => 'Te Time',
            'te_num_of_questions' => 'Te Num Of Questions',
            'te_created_at' => 'Te Created At',
            'te_last_updated_at' => 'Te Last Updated At',
            'te_is_deleted' => 'Te Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestExamQuestions()
    {
        return $this->hasMany(TestExamQuestions::className(), ['te_id' => 'te_id']);
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQs()
    {
        return $this->hasMany(Question::className(), ['q_id' => 'q_id'])->viaTable('test_exam_questions', ['te_id' => 'te_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTests()
    {
        return $this->hasMany(UserTest::className(), ['te_id' => 'te_id']);
    }
}
