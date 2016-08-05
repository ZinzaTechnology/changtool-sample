<?php

namespace common\models;

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
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 *
 */
class TestExam extends \common\models\AppActiveRecord
{
    public static $is_logic_delete = true;

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
            [['te_category', 'te_level', 'te_time', 'te_num_of_questions'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'te_code' => 'Test Code',
            'te_category' => 'Test Category',
            'te_level' => 'Test Level',
            'te_title' => 'Test Title',
            'te_time' => 'Time to do test',
            'te_num_of_questions' => 'Number of Questions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    
    public static function getData($param){
    	if($param){
    		return self::find()->where($param)->all();
    	}else{
    		return self::find()->all();
    	}
    }
}
