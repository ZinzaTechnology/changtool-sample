<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use common\models\TestExam;
use common\models\Question;
use common\models\QuestionClone;
use common\models\Answer;
use common\models\AnswerClone;
use common\lib\logic\LogicUserTest;
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

    public function getTest($testID) {
        $question = QuestionClone::find()->select('qc_id,qc_content')
                ->where(['ut_id' => $testID])
                ->asArray()
                ->all();
        $count = 0;
        while ($count < count($question)) {
            $question[$count]['answer'] = AnswerClone::find()
                    ->select('ac_id,ac_content,ac_status')
                    ->where(['qc_id' => $question[$count]['qc_id']])
                    ->asArray()
                    ->all();
            $count++;
        }
        return $question;
    }

    public static function setMark($id) {
        $testExam = UserTest::findOne($id);
        if ($testExam && $testExam->ut_status == "DONE") {
            $answer = unserialize($testExam->ut_user_answer_ids);
            $amountQuestion = TestExam::findOne($testExam->te_id)->te_num_of_questions;
            $countTrue = 0;
            $keys = array_keys($answer);
            $parent = 0;
            foreach ($answer as $elements) {
                        $countInside = 0;
                        foreach ($elements as $element) {
                            if (AnswerClone::findOne($element)->ac_status == 1)
                                $countInside++;
                            else $countInside--;
                        }
                        if ($countInside == count(AnswerClone::find()->where(['qc_id'=>str_replace('question-','',$keys[$parent]),'ac_status'=>1])->asArray()->all()))
                            $countTrue++;
                        $parent++;
            }
            Yii::$app->db->createCommand()->update('user_test', [
                'ut_mark' => $countTrue
                    ], "ut_id = {$id}"
            )->execute();
        }
        
    }

    public static function getMark($id) {
        $userTest = UserTest::findOne($id);
        if ($userTest)
            return [$userTest->ut_mark, TestExam::findOne($userTest->te_id)->te_num_of_questions];
        else{
            return false;
        }
    }

   
    public function  updateUserTest($id, $params){
    	$updateTest = UserTest::findOne($id);
    
    	if (!$updateTest) {
    		return false;
    	}	
    	$params = AppArrayHelper::filterKeys($params );
    		$updateTest->load(['UserTest' => $params]);
    		var_dump('<prev>',$params);
    	if ($updateTest->validate()) {
    		return $updateTest->save();
    	}
     }
    

}
