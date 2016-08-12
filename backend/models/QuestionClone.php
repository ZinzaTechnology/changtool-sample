<?php

namespace backend\models;

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
class QuestionClone extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'question_clone';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['qc_content'], 'required'],
            [['qc_content'], 'string'],
            [['ut_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'qc_id' => 'Qc ID',
            'qc_content' => 'Qc Content',
            'ut_id' => 'Ut ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerClones() {
        return $this->hasMany(AnswerClone::className(), ['qc_id' => 'qc_id']);
    }

    public function saveQuestionClone($data) {
        $db = Yii::$app->db;
        $count = 0;
        $dataInsert = [];
        foreach ($data as $elements) {
            foreach ($elements['question'] as $question) {
                if ($question) {
                    $dataInsert[] = [$question['q_content'], $elements['ut_id']];
                    $count++;
                }
            }
        }
        $db->createCommand()->batchInsert(self::tableName(), ['qc_content', 'ut_id'], $dataInsert)->execute();
        return [$db->getLastInsertID(), $count];
    }

}
