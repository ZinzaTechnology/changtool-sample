<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer_clone".
 *
 * @property integer $ac_id
 * @property integer $qc_id
 * @property string $ac_content
 * @property boolean $ac_status
 *
 * @property QuestionClone $qc
 */
class AnswerClone extends AppActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_clone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qc_id', 'ac_content'], 'required'],
            [['qc_id'], 'integer'],
            [['ac_content'], 'string'],
            [['ac_status'], 'boolean'],
            [['qc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionClone::className(), 'targetAttribute' => ['qc_id' => 'qc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ac_id' => 'Ac ID',
            'qc_id' => 'Qc ID',
            'ac_content' => 'Ac Content',
            'ac_status' => 'Ac Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQc()
    {
        return $this->hasOne(QuestionClone::className(), ['qc_id' => 'qc_id']);
    }

    public function saveAnswerClone($data)
    {
        $db = Yii::$app->db;
        $count = 0;
        $dataInsert = [];
        foreach ($data as $elements) {
            foreach ($elements['answer'] as $answer) {
                $dataInsert[] = [$elements['qc_id'], $answer['qa_content'], $answer['qa_status'], date('Y-m-d H:i:s')];
                $count++;
            }
        }
        $db->createCommand()->batchInsert(self::tableName(), ['qc_id', 'ac_content', 'ac_status', 'created_at'], $dataInsert)->execute();
        return [$db->getLastInsertID(), $count];
    }
}
