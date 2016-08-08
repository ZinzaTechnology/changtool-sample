<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use backend\models\TestExam;
use backend\models\QuestionClone;
use backend\models\Answer;
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
            [['u_id', 'te_id'], 'required'],
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
        $query
                ->select(['ut_id', 'u_name', 'te_category', 'te_title', 'te_level', 'ut_status', 'ut_start_at', 'ut_finished_at'])
                ->from('user_test')
                ->innerJoin('user', 'user_test.u_id = user.u_id')
                ->innerJoin('test_exam', 'user_test.te_id = test_exam.te_id')
                ->andFilterWhere(['like', 'u_name', $params['u_name']])
                ->andFilterWhere(['like', 'te_title', $params['te_title']])
                ->andFilterWhere(['te_category' => $params['te_category'], 'te_level' => $params['te_level'],])
                ->andFilterWhere(['>=', 'ut_start_at', $params['ut_start_at']])
                ->andFilterWhere(['<=', 'ut_finished_at', $params['ut_finished_at']])
                ->addOrderBy(['ut_id' => SORT_DESC]);
        return $query->all();
    }

    public static function assignTest($userId, $testId) {
        /*
         * NOTE:
         *  Thay đổi database, ut_question_clone_ids => NULL
         */
        if (self::findAll(['u_id' => $userId, 'te_id' => $testId])) {
            $user = User::findOne(['u_id' => $userId])->u_name;
            $test = TestExam::findOne(['te_id' => $testId])->te_title;
            self::setErrors(["{$test} has been assigned to {$user}"]);
        } else {
            $newUT = new self;
            $newUT->u_id = $userId;
            $newUT->te_id = $testId;
            if ($newUT->save()) {
                //get Id of User Test which just added
                $utID = self::findOne(['u_id' => $userId, 'te_id' => $testId])->ut_id;

                $questions = self::getQuestions($testId);
                $answerRand = [];

                //DELETE QUESTION CLONE
//            if (QuestionClone::findAll(['ut_id' => $utID]))
//                QuestionClone::deleteAll('ut_id = :ut_id',[':ut_id'=>$utID]);
//                
                // Add to clone tables
                foreach ($questions as $question => $content) {
                    //Add question clone
                    $qClone = new QuestionClone;
                    $qClone->qc_content = $content['q_content'];
                    $qClone->ut_id = $utID;
                    $qClone->save();
                    $answerRand[] = self::getAnswersRandom($content['q_id'], $content['q_type']);
                }
                $answerRand = array_filter($answerRand);

                //Get question clone id
                $questionClones = QuestionClone::find()
                        ->select('qc_id')
                        ->where(['ut_id' => $utID])
                        ->asArray()
                        ->all();

                //Update question clone to UserTest
                $countAns = 0;
                foreach ($questionClones as $question) {
                    //DELETE ANSWER CLONE
//                if (AnswerClone::findAll(['qc_id' => $question['qc_id']]))
//                    AnswerClone::deleteAll('qc_id = :qc_id', [':qc_id' => $question['qc_id']]);
                    $ans = $answerRand[$countAns];
                    foreach ($answerRand[$countAns] as $ans) {
                        $ansClone = new AnswerClone;
                        $ansClone->qc_id = $question['qc_id'];
                        $ansClone->ac_content = $ans['qa_content'];
                        $ansClone->ac_status = $ans['qa_status'];
                        $ansClone->save();
                    }
                    $countAns++;
                }
            } else
                self::setErrors(["Can not assign test id {$testId} for user id {$userId}"]);
        }
    }

    private static function setErrors($error) {
        $session = Yii::$app->session;
        if ($errors = $session->get('assignErrors')) {
            $errors = array_merge($errors, $error);
            $session->setFlash('assignErrors', $errors);
        } else
            $session->setFlash('assignErrors', $error);
    }

    //GET DATA
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

    private static function getQuestions($userTestID) {
        return (TestExamQuestions::find()
                        ->select('question.q_id,question.q_type,question.q_content')
                        ->innerJoin('question', 'test_exam_questions.q_id = question.q_id')
                        ->where(['te_id' => $userTestID])
                        ->asArray()
                        ->all());
    }

    private static function getAnswersRandom($questionID, $type) {
        $selectTrue = Answer::find()
                ->select('qa_id,qa_content,qa_status')
                ->where(['q_id' => $questionID, 'qa_status' => 1])
                ->orderBy(new Expression('rand()'))
                ->limit($type)
                ->asArray()
                ->all();
        $selectFalse = Answer::find()
                ->select('qa_id,qa_content,qa_status')
                ->where(['q_id' => $questionID, 'qa_status' => 0])
                ->orderBy(new Expression('rand()'))
                ->limit(4 - $type)
                ->asArray()
                ->all();
        $result = array_merge($selectTrue, $selectFalse);
        return $result;
    }

    public function getUserAnswer($userTestID) {
        if ($infor = self::findOne($userTestID)) {
            return unserialize($infor->ut_user_answer_ids);
        }
        return null;
    }

    // MARK
    public static function setMark($id) {
        $testExam = self::findOne($id);
        if ($testExam && $testExam->ut_status == "DONE") {
            $answer = unserialize($testExam->ut_user_answer_ids);
            array_shift($answer);
            $amountQuestion = TestExam::findOne($testExam->te_id)->te_num_of_questions;
            $countTrue = 0;
            foreach ($answer as $elements) {
                switch (count($elements)) {
                    case 1:
                        if (AnswerClone::findOne($elements[0])->ac_status == 1)
                            $countTrue++;
                        break;
                    default:
                        $countInside = 0;
                        foreach ($elements as $element) {
                            if (AnswerClone::findOne($element)->ac_status == 1)
                                $countInside++;
                        }
                        if ($countInside == count($elements))
                            $countTrue++;
                        break;
                }
            }
            Yii::$app->db->createCommand()->update('user_test', [
                'ut_mark' => $countTrue
                    ], "ut_id = {$id}"
            )->execute();
        }
    }

    public static function getMark($id) {
        if ($userTest = self::findOne($id))
            return [$userTest->ut_mark, TestExam::findOne($userTest->te_id)->te_num_of_questions];
        else
            return false;
    }

}
