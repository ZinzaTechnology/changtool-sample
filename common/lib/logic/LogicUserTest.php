<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\Query;
use common\models\UserTest;
use common\models\Answer;
use common\models\QuestionClone;
use common\models\AnswerClone;
use common\lib\logic\LogicQuestion;
use common\lib\components\AppConstant;

class LogicUserTest extends LogicBase
{

    private $_assignedSuccess = false;
    private $_testExam;
    private $_testExamParams = [];
    private $_pageMax = 0;
    private $_page = 0;
    
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
    
    public function getPageMax()
    {
        return $this->_pageMax;
    }
    
    public function getPage()
    {
        return $this->_page;
    }
    
    public function getTestDataByPageParam($id, $page = null)
    {
        $data = $this->findTestDataByUtID($id);
        if($page<$this->_pageMax)
            throw new BadRequestHttpException('Page is larger than page max!');
        $limitPerPage = AppConstant::USER_TEST_QUESTION_LIMIT_PER_PAGE;
        $this->_pageMax = round((count($data)/$limitPerPage));
        if(count($data)%$limitPerPage)
            $this->_pageMax++;
        if (!empty($page)) {
            if (is_numeric($page) && $page>0)
                $this->_page = $page;
            else throw new \yii\web\BadRequestHttpException('Page must be a number and larger than 0!');
        } else $this->_page = 1;
        return array_slice($data, ($this->_page-1) * $limitPerPage, $limitPerPage);
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
                    $question = ArrayHelper::toArray((new LogicQuestion)->findQuestionByTestId($teID));
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
            $record = $userTest->findOne(['ut_id' => $id]);
            switch ($record->ut_status) {
                case 'ASSIGNED':
                    $questionCloneID = ArrayHelper::getColumn(QuestionClone::findAll(['ut_id' => $id]), 'qc_id');
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
                ->innerJoin('test_exam', 'user_test.te_id = test_exam.te_id')
                ->andFilterWhere(['like', 'u_name', $params['u_name']])
                ->andFilterWhere(['like', 'te_title', $params['te_title']])
                ->andFilterWhere(['te_category' => $params['te_category'], 'te_level' => $params['te_level'], 'ut_status' => $params['ut_status']])
                ->andFilterWhere(['>=', 'ut_start_at', $params['ut_start_at']])
                ->andFilterWhere(['<=', 'ut_finished_at', $params['ut_finished_at']])
                ->addOrderBy(['ut_id' => SORT_DESC]);
        return $query->all();
    }

    public function findTestDataByUtID($ut_id)
    {
        $answersClone = [];
        $questionsClone = $this->findQuestionCloneByUtId($ut_id);
        $testData = [];
        foreach ($questionsClone as $question) {
            $answer = $this->findAnswerCloneByQcId($question['qc_id']);
            $question = array_merge($question, ['trueAnswer' => ArrayHelper::getColumn($this->findAnswerCloneTrueByQcID($question['qc_id']), 'ac_content')]);
            $testData[] = array_merge($question, ['answer' => $answer]);
        }
        return $testData;
    }

    public function findQuestionCloneByUtId($ut_id)
    {
        return QuestionClone::find()->where(['ut_id' => $ut_id])->asArray()->all();
    }

    public function findAnswerCloneTrueByQcID($qc_id)
    {
        return AnswerClone::find()->select('ac_content')->where(['qc_id' => $qc_id, 'ac_status' => AppConstant::ANSWER_STATUS_RIGHT])->asArray()->all();
    }

    public function findAnswerCloneByQcId($qc_id)
    {
        return AnswerClone::find()->where(['qc_id' => $qc_id])->asArray()->all();
    }

    public function findUserAnswerByUtId($ut_id)
    {
        return unserialize(UserTest::findOne(['ut_id' => $ut_id])->ut_user_answer_ids);
    }

    public function findAnswersRandomByQuestionId($questionID, $type)
    {
        $selectTrue = Answer::find()
                ->where(['q_id' => $questionID, 'qa_status' => AppConstant::ANSWER_STATUS_RIGHT])
                ->orderBy(new Expression('rand()'))
                ->limit($type)
                ->asArray()
                ->all();
        $selectFalse = Answer::find()
                ->where(['q_id' => $questionID, 'qa_status' => AppConstant::ANSWER_STATUS_WRONG])
                ->orderBy(new Expression('rand()'))
                ->limit(AppConstant::QUESTION_ANSWERS_LIMIT - $type)
                ->asArray()
                ->all();
        $result = array_merge($selectTrue, $selectFalse);
        shuffle($result);
        return $result;
    }
}
