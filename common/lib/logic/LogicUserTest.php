<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\Query;
use common\lib\components\AppConstant;
use common\models\UserTest;
use common\models\Answer;
use common\models\TestExamQuestions;
use backend\models\QuestionClone;
use backend\models\AnswerClone;

class LogicUserTest extends LogicBase {

    private $_assignedSuccess = false,
            $_testExam,
            $_teID,
            $_userID,
            $_testExamParams = [],
            $_trueAnswers = [];
    private $_categoryID,
            $_levelID,
            $_request = [];

    public function __construct() {
        parent::__construct();
    }

    public function parseRequest($request) {
        $this->_testExam = $request['TestExam'];
        $this->_userID = json_decode($request['User']['u_id']);
        $this->_teID = json_decode($this->_testExam['te_id']);
        $this->_categoryID = $this->_testExam['te_category'];
        $this->_levelID = $this->_testExam['te_level'];
        if (!empty($this->_testExam['te_category'])) {
            $this->_testExamParams = array_merge($this->_testExamParams, ['te_category' => $this->_testExam['te_category']]);
        } elseif (!empty($this->_testExam['te_level'])) {
            $this->_testExamParams = array_merge($this->_testExamParams, ['te_level' => $this->_testExam['te_level']]);
        }
        $this->_testExam['te_id'] = $this->_teID;
        $this->_testExam['u_id'] = $this->_userID;
        $this->_testExamParams = array_filter($this->_testExamParams);
        $this->_request = array_merge([$request['_csrf-backend']], ['UserTest' => $this->_testExam]);
        if (!$this->isTestEmpty() && !$this->isUserEmpty()) {
            $this->assignTest();
        }
    }

    public function isTestEmpty() {
        return empty($this->_teID);
    }

    public function isUserEmpty() {
        return empty($this->_userID);
    }

    public function isAssignedSuccess() {
        return $this->_assignedSuccess;
    }

    public function getTestExamParams() {
        return $this->_testExamParams;
    }

    public function getChoice() {
        return [$this->_categoryID, $this->_levelID];
    }

    public function assignTest() {
        $userTest = new UserTest;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($lastUT_ID_count = $userTest->saveUserTest($this->_request)) {
                $questions = [];
                $userTestID = $lastUT_ID_count[0];
                foreach ($this->_teID as $teID) {
                    $question = $this->getQuestions($teID);
                    foreach ($this->_userID as $userID) {
                        $questions[] = array_merge(['ut_id' => $userTestID], ['question' => $question]);
                        $userTestID++;
                    }
                }
                if ($questionCloneID_count = (new QuestionClone)->saveQuestionClone($questions)) {
                    $answers = [];
                    $questionCloneID = $questionCloneID_count[0];
                    foreach ($questions as $question => $aQuesttion) {
                        foreach ($aQuesttion['question'] as $elementOfQuestion => $attribute) {
                            $answer = $this->getAnswersRandom($attribute['q_id'], $attribute['q_type']);
                            $answers[] = array_merge(['qc_id' => $questionCloneID], ['answer' => $answer]);
                            $questionCloneID++;
                        }
                    }
                    if ($answerCloneID = (new AnswerClone)->saveAnswerClone($answers)) {
                        
                    }
                }
            }
            $transaction->commit();
            $this->_assignedSuccess = true;
        } catch (\Exception $ex) {
            $this->_assignedSuccess = false;
            $transaction->rollback();
            throw $ex;
        }
    }

    public function deteleTest($id) {
        $transaction = Yii::$app->db->beginTransaction();
        $userTest = new UserTest;
        $command = Yii::$app->db->createCommand();
        try {
            $record = $userTest->findOne(['ut_id' => $id]);
            switch ($record->ut_status) {
                case 'ASSIGNED':
                    $questionCloneID = ArrayHelper::getColumn(QuestionClone::findAll(['ut_id' => $id]), 'qc_id');
                    if (count($questionCloneID))
                        AnswerClone::deleteAll("qc_id in (" . implode(', ', $questionCloneID) . ")");
                    QuestionClone::deleteAll("ut_id = {$id}");
                    $record->delete();
                    break;
                case 'DONE':
                    break;
                case 'DOING':
                    break;
            }
            $transaction->commit();
            return true;
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return false;
    }

    public static function getWithParams($params) {
        $query = new Query;
        $query  ->from('user_test')
                ->innerJoin('user', 'user_test.u_id = user.u_id')
                ->innerJoin('test_exam', 'user_test.te_id = test_exam.te_id')
                ->andFilterWhere(['like', 'u_name', $params['u_name']])
                ->andFilterWhere(['like', 'te_title', $params['te_title']])
                ->andFilterWhere(['te_category' => $params['te_category'], 'te_level' => $params['te_level']])
                ->andFilterWhere(['>=', 'ut_start_at', $params['ut_start_at']])
                ->andFilterWhere(['<=', 'ut_finished_at', $params['ut_finished_at']])
                ->addOrderBy(['ut_id' => SORT_DESC]);
        return $query->all();
    }

    public function getTest($userTestID) {
        $question = QuestionClone::find()->select('qc_id,qc_content')
            ->where(['ut_id' => $userTestID])
            ->asArray()
            ->all();
        $count = 0;
        while ($count < count($question)) {
            $this->_trueAnswers = array_merge(
                $this->_trueAnswers,
                AnswerClone::find()
                    ->select('ac_content')
                    ->where(['qc_id' => $question[$count]['qc_id'], 'ac_status' => 1])
                    ->asArray()
                    ->all()
            );
            $question[$count]['answer'] = AnswerClone::find()
                ->where(['qc_id' => $question[$count]['qc_id']])
                ->asArray()
                ->all();
            $count++;
        }
        return $question;
    }

    public function getTrueAnswer() {
        return $this->_trueAnswers;
    }

    public function getUserAnswer($userTestID) {
        if ($infor = UserTest::findOne($userTestID)) {
            return unserialize($infor->ut_user_answer_ids);
        }
        return null;
    }

    public function getQuestions($testID) {
        return (TestExamQuestions::find()
            ->select('test_exam_questions.te_id,question.q_id,question.q_type,question.q_content')
            ->innerJoin('question', 'test_exam_questions.q_id = question.q_id')
            ->where(['test_exam_questions.te_id' => $testID, 'question.is_deleted' => 0])
            ->asArray()
            ->all()
        );
    }

    public function getAnswersRandom($questionID, $type) {
        $selectTrue = Answer::find()
            ->where(['q_id' => $questionID, 'qa_status' => 1])
            ->orderBy(new Expression('rand()'))
            ->limit($type)
            ->asArray()
            ->all();
        $selectFalse = Answer::find()
            ->where(['q_id' => $questionID, 'qa_status' => 0])
            ->orderBy(new Expression('rand()'))
            ->limit(4 - $type)
            ->asArray()
            ->all();
        $result = array_merge($selectTrue, $selectFalse);
        shuffle($result);
        return $result;
    }

}
