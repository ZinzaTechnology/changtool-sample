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
        return [
            [
                [
                    'q_id',
                    'q_content',
                    'q_category',
                    'q_type',
                    'q_level' 
                ],
                'required' 
            ],
            [
                [
                    'q_id' 
                ],
                'integer' 
            ],
            [
                [
                    'q_content' 
                ],
                'string' 
            ],
            [
                [
                    'q_level' 
                ],
                'integer' 
            ],
            [
                [
                    'q_type' 
                ],
                'integer' 
            ] 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'q_id' => 'ID',
            'q_category' => 'Category',
            'q_level' => 'Level',
            'q_type' => 'Type',
            'q_content' => 'Content',
            'create_at' => 'Create at',
            'update_at' => 'Update_at' 
        ];
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
