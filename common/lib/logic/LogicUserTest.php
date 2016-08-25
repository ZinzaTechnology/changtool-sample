<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
use yii\web\BadRequestHttpException;
use yii\db\Expression;
use yii\db\Query;
use common\lib\helpers\AppArrayHelper;
use common\models\UserTest;
use common\models\Answer;
use common\models\QuestionClone;
use common\models\AnswerClone;
use common\lib\logic\LogicQuestion;
use common\lib\components\AppConstant;
use common\models\TestExam;

class LogicUserTest extends LogicBase
{
    private $_assignedSuccess = false;
    private $_testExam;
    private $_testExamParams = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function parseRequest($request)
    {
        $this->_testExam = $request['TestExam'];
        $this->_testExam['te_id'] = !empty($this->_testExam['te_id']) ? json_decode($this->_testExam['te_id']) : '';
        $this->_testExam['u_id'] = !empty($request['User']['u_id']) ? json_decode($request['User']['u_id']) : '';
        if (!empty($this->_testExam['te_category'])) {
            $this->_testExamParams = array_merge($this->_testExamParams, ['te_category' => $this->_testExam['te_category']]);
        } elseif (!empty($this->_testExam['te_level'])) {
            $this->_testExamParams = array_merge($this->_testExamParams, ['te_level' => $this->_testExam['te_level']]);
        }
        $this->_testExamParams = array_filter($this->_testExamParams);
    }

    public function isTestEmpty()
    {
        return empty($this->_testExam['te_id']);
    }

    public function isUserEmpty()
    {
        return empty($this->_testExam['u_id']);
    }

    public function isAssignedSuccess()
    {
        return $this->_assignedSuccess;
    }

    public function getTestExamParams()
    {
        return $this->_testExamParams;
    }

    public function getChoice()
    {
        return [$this->_testExam['te_category'], $this->_testExam['te_level']];
    }

    public function assignTest()
    {
        $userTest = new UserTest;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($lastUT_ID_count = $userTest->saveUserTest($this->_testExam)) {
                $questions = [];
                $userTestID = $lastUT_ID_count[0];
                foreach ($this->_testExam['te_id'] as $teID) {
                    $question = AppArrayHelper::toArray((new LogicQuestion)->findQuestionByTestId($teID));
                    foreach ($this->_testExam['u_id'] as $userID) {
                        $questions[] = array_merge(['ut_id' => $userTestID], ['question' => $question]);
                        $userTestID++;
                    }
                }
                if ($questionCloneID_count = (new QuestionClone)->saveQuestionClone($questions)) {
                    $answers = [];
                    $questionCloneID = $questionCloneID_count[0];
                    foreach ($questions as $question => $aQuesttion) {
                        foreach ($aQuesttion['question'] as $elementOfQuestion => $attribute) {
                            $answer = $this->findAnswersRandomByQuestionId($attribute['q_id'], $attribute['q_type']);
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

    public function deleteTestByUtId($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $userTest = new UserTest;
        $command = Yii::$app->db->createCommand();
        try {
            $record = $userTest->queryOne(['ut_id' => $id]);
            switch ($record->ut_status) {
                case 'ASSIGNED':
                    $questionCloneID = AppArrayHelper::getColumn(QuestionClone::queryAll(['ut_id' => $id]), 'qc_id');
                    if (count($questionCloneID)) {
                        AnswerClone::deleteAll("qc_id in (" . implode(', ', $questionCloneID) . ")");
                    }
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

    public static function findUserTestBySearch($params)
    {
        $query = new Query;
        $query->from('user_test')
            ->innerJoin('user', 'user_test.u_id = user.u_id')
            ->innerJoin('test_exam', 'user_test.te_id = test_exam.te_id');

        $params = AppArrayHelper::filterKeys($params, ['ut_id', 'u_id', 'u_name', 'te_title', 'te_category', 'te_level', 'ut_status', 'ut_start_at', 'ut_finished_at']);

        $query->andFilterWhere(['ut_id' => $params['ut_id']]);
        $query->andFilterWhere(['user_test.u_id' => $params['u_id']]);
        $query->andFilterWhere(['like', 'u_name', $params['u_name']]);
        $query->andFilterWhere(['like', 'te_title', $params['te_title']]);
        $query->andFilterWhere(['te_category' => $params['te_category']]);
        $query->andFilterWhere(['te_level' => $params['te_level']]);
        $query->andFilterWhere(['ut_status' => $params['ut_status']]);
        $query->andFilterWhere(['>=', 'ut_start_at', $params['ut_start_at']]);
        $query->andFilterWhere(['<=', 'ut_finished_at', $params['ut_finished_at']]);

        $query->addOrderBy(['ut_id' => SORT_DESC]);
        return $query->all();
    }
    
    public function findQuestionCloneByUtId($ut_id)
    {
        return QuestionClone::query()->andWhere(['ut_id' => $ut_id])->asArray()->all();
    }

    public function findAnswerCloneTrueByQcID($qc_id)
    {
        return AnswerClone::query()->select('ac_content')->where(['qc_id' => $qc_id, 'ac_status' => AppConstant::ANSWER_STATUS_RIGHT])->asArray()->all();
    }

    public function findAnswerCloneByQcId($qc_id)
    {
        return AnswerClone::query()->andWhere(['qc_id' => $qc_id])->asArray()->all();
    }

    public function updateUserTest($id, $params)
    {
        $updateTest = UserTest::queryOne($id);

        if (!$updateTest) {
            return false;
        }
        $params = AppArrayHelper::filterKeys($params, ['ut_status','ut_start_at','ut_finished_at','ut_user_answer_ids', 'ut_mark']);
        $updateTest->load(['UserTest' => $params]);
        if ($updateTest->validate()) {
            return $updateTest->save();
        }
    }

    public function findAnswersRandomByQuestionId($questionID, $type)
    {
        $amountTrueAnswer = mt_rand(1, 4);
        $selectTrue = Answer::query()
            ->where(['q_id' => $questionID, 'qa_status' => AppConstant::ANSWER_STATUS_RIGHT])
            ->orderBy(new Expression('rand()'))
            ->limit($amountTrueAnswer)
            ->asArray()
            ->all();
        $amountFalseAnswer = AppConstant::QUESTION_ANSWERS_LIMIT - count($selectTrue);
        $selectFalse = Answer::query()
            ->where(['q_id' => $questionID, 'qa_status' => AppConstant::ANSWER_STATUS_WRONG])
            ->orderBy(new Expression('rand()'))
            ->limit($amountFalseAnswer)
            ->asArray()
            ->all();
        $result = array_merge($selectTrue, $selectFalse);
        shuffle($result);
        return $result;
    }

    public function findUserTestDataByUtId($ut_id)
    {
        // find user test
        $userTest = $this->findUserTestInfoByUtId($ut_id);

        if ($userTest) {
            // find questions of the test
            $question_clones = $this->findQuestionCloneByUtId($ut_id);
            $userTest->question_clones = AppArrayHelper::index($question_clones, 'qc_id');
            // find answers of questions
            $answers = $this->findAnswerCloneByQcId(AppArrayHelper::getColumn($userTest->question_clones, 'qc_id'));
            foreach ($answers as $ac) {
                $ac_id = $ac['ac_id'];
                $userTest->question_clones[$ac['qc_id']]['answers'][$ac_id] = $ac;
            }
        }

        return $userTest;
    }

    public function findUserTestInfoByUtId($ut_id)
    {
        // find user test
        $userTest = UserTest::queryOne($ut_id);

        if ($userTest) {
            // find corresponding test exam data
            $logicTestExam = new LogicTestExam();
            $userTest->test_exam = $logicTestExam->findTestExamById($userTest->te_id);
        }

        return $userTest;
    }

    public function scoreUserTest($userTestData, $userAnswers)
    {
        $questions = $userTestData->question_clones;

        if (empty($questions) || empty($userAnswers)) {
            return 0;
        }

        $score = 0;
        foreach ($userAnswers as $qc_id => $userAnswer) {
            $question = $questions[$qc_id];

            $answerCorrect = true;
            $trueAnswerCount = 0;
            foreach ($question['answers'] as $answer) {
                if ($answer['ac_status'] == AppConstant::ANSWER_STATUS_RIGHT) {
                    // find the number of true answers
                    ++$trueAnswerCount;

                    // find the true answer in userAnswer
                    // if not found, the userAnswer is wrong
                    $key = array_search($answer['ac_id'], $userAnswer);
                    if ($key === false) {
                        $answerCorrect = false;
                    }
                }
            }
            
            if ($answerCorrect && (count($userAnswer) == $trueAnswerCount)) {
                ++$score;
            }
        }

        return $score;
    }
}
