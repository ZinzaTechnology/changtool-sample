<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\models\TestExam;
use backend\models\QuestionClone;
use backend\models\AnswerClone;
use yii\db\Expression;

/**
 * This is the model class for table "user_test".
 *
 * @property integer $ut_id
 * @property integer $u_id
 * @property integer $te_id
 * @property string $ut_status
 * @property integer $ut_mark
 * @property string $ut_start_at
 * @property string $ut_finished_at
 * @property string $ut_question_clone_ids
 * @property string $ut_user_answer_ids
 *
 * @property TestExam $te
 * @property User $u
 */
class UserTest extends \common\models\AppActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_test';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['u_id', 'te_id'], 'required'],
            [['u_id', 'te_id', 'ut_mark'], 'integer'],
            [['ut_status', 'ut_user_answer_ids'], 'string'],
            [['ut_start_at', 'ut_finished_at', 'created_at', 'updated_at'], 'safe'],
            [['te_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestExam::className(), 'targetAttribute' => ['te_id' => 'te_id']],
            [['u_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['u_id' => 'u_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ut_id' => 'Id',
            'u_id' => 'User ID',
            'te_id' => 'Test ID',
            'ut_status' => 'Status',
            'ut_mark' => 'Mark',
            'ut_start_at' => 'Start At',
            'ut_finished_at' => 'Finished At',
            'ut_question_clone_ids' => 'Question Clone Ids',
            'ut_user_answer_ids' => 'User Answer Ids',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTe() {
        return $this->hasOne(TestExam::className(), ['te_id' => 'te_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU() {
        return $this->hasOne(User::className(), ['u_id' => 'u_id']);
    }

    public static function saveUserTest($data) {
        $db = Yii::$app->db;
        $count = 0;
        $dataInsert = [];
        $dataUse = $data['UserTest'];
        foreach ($dataUse['te_id'] as $test) {
            foreach ($dataUse['u_id'] as $user) {
                if (!self::find()->where(['te_id' => $test, 'u_id' => $user])->exists()) {
                    $dataInsert[] = [$test, $user];
                    $count++;
                }
            }
        }
        $db->createCommand()->batchInsert(self::tableName(), ['te_id', 'u_id'], $dataInsert)->execute();
        return [$db->getLastInsertID(), $count];
    }

}
