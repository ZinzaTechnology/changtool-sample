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
            [
                [
                    'q_content',
                    'q_level',
                    'q_type',
                    'q_category'
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
                    'q_category'
                ],
                'integer'
            ],
            [
                [
                    'q_type'
                ],
                'integer'
            ],
            [
                [
                    'q_level'
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
            'q_content' => 'Content',
            'q_category' => 'Category',
            'q_type' => 'Type',
            'q_level' => 'Level',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
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
