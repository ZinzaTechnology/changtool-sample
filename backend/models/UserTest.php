<?php

namespace backend\models;

use Yii;
use yii\db\Query;

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
class UserTest extends \yii\db\ActiveRecord {

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
            [['u_id', 'te_id', 'ut_question_clone_ids'], 'required'],
            [['u_id', 'te_id', 'ut_mark'], 'integer'],
            [['ut_status', 'ut_question_clone_ids', 'ut_user_answer_ids'], 'string'],
            [['ut_start_at', 'ut_finished_at'], 'safe'],
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

    public static function getWithParams($params) {
        $query = new Query;
        $query->select(['ut_id', 'u_name', 'te_category', 'te_title', 'te_level', 'ut_status', 'ut_start_at', 'ut_finished_at'])
        ->from('user_test')
        ->join('INNER JOIN', 'user', 'user_test.u_id = user.u_id')
        ->join('INNER JOIN', 'test_exam', 'user_test.te_id = test_exam.te_id')
        ->andFilterWhere(['like', 'u_name', $params['u_name']])
        ->andFilterWhere(['like', 'te_title', $params['te_title']])
        ->andFilterWhere(['te_category' => $params['te_category'], 'te_level' => $params['te_level'],])
        ->andFilterWhere(['>=', 'ut_start_at', $params['ut_start_at']])
        ->andFilterWhere(['<=', 'ut_finished_at', $params['ut_finished_at']])
        ->addOrderBy(['ut_id' => SORT_DESC]);
        return $query->all();
    }

    public static function assignTest($userId, $testId) {
        // Create clone
        $query = new Query();
        
//        $userTest = new UserTest();
//        $userTest->u_id = $userId;
//        $userTest->te_id = $testId;
//        $userTest->save();
    }

}
