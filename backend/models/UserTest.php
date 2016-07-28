<?php

namespace backend\models;

use Yii;

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

    public static function getUserTestInfoWithParams($params) {
        $sql = "SELECT ut_id as 'Id', u_name as 'Username',te_category as 'Category', te_title as 'Title', te_level as 'Level', ut_status as 'Status', ut_start_at as 'Start time', ut_finished_at as 'End time' 
                    FROM user_test 
                    INNER JOIN user 
                    ON user_test.u_id = user.u_id 
                    INNER JOIN test_exam 
                    ON user_test.te_id = test_exam.te_id 
		";
        $params['a'] = null;
        $paraFilted = array_filter($params);
        if ($paraFilted) {
            if (count($paraFilted)) {
                $sql.= ' WHERE ';
                $count = 0;
                $keys = array_keys($paraFilted);
                foreach ($keys as $key) {
                    switch ($key) {
                        case 'ut_start_at':
                            $sql.= ' ut_start_at <= ? ';
                            break;
                        case 'ut_finished_at':
                            $sql.= ' ut_finished_at >= ? ';
                            break;
                        default:
                            $sql.= " {$key} = ? ";
                            break;
                    }
                    if ($count < (count($paraFilted) - 1)) {
                        $sql.= ' AND ';
                        $count++;
                    }
                }
            }
        }
        $sql.= ' ORDER BY ut_id DESC ';
        if ($query = Yii::$app->db->createCommand($sql)) {
            if ($paraFilted) {
                $x = 1;
                foreach ($paraFilted as $e) {
                    if ($x <= count($paraFilted)) {
                        $query->bindValue($x, $e);
                        $x++;
                    }
                }
            }
        }
        return $query->queryAll();
    }

}
