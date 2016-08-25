<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question_clone".
 *
 * @property integer $qc_id
 * @property string $qc_content
 * @property integer $ut_id
 *
 * @property AnswerClone[] $answerClones
 */
class QuestionClone extends AppActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_clone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qc_content'], 'required'],
            [['qc_content'], 'string'],
            [['ut_id'], 'integer'],
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qc_id' => 'Qc ID',
            'qc_content' => 'Qc Content',
            'ut_id' => 'Ut ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerClones()
    {
        return $this->hasMany(AnswerClone::className(), ['qc_id' => 'qc_id']);
    }

    public function saveQuestionClone($data)
    {
        $db = Yii::$app->db;
        $count = 0;
        $dataInsert = [];
        foreach ($data as $elements) {
            foreach ($elements['question'] as $question) {
                if ($question) {
                    $dataInsert[] = [$question['q_content'], $question['q_type'], $elements['ut_id'], $question['q_id'], date('Y-m-d H:i:s')];
                    $count++;
                }
            }
        }
        $db->createCommand()->batchInsert(self::tableName(), ['qc_content', 'qc_type', 'ut_id', 'q_id', 'created_at'], $dataInsert)->execute();
        return [$db->getLastInsertID(), $count];
    }
}
