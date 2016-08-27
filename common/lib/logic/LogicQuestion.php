<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */
namespace common\lib\logic;

use Yii;
use common\models\Question;
use common\models\QuestionTag;
use common\models\TestExamQuestions;
use common\lib\components\AppConstant;
use common\lib\helpers\AppArrayHelper;

class LogicQuestion extends LogicBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @return Question|null (found ActiveRecord)
     */
    public function findQuestionBySearch($params)
    {
        $questionQuery = Question::query();
        
        if (! empty($params)) {
            $q_content = $params['content'];
            $q_category = $params['category'];
            $q_type = $params['type'];
            $qt_content = $params['qt_content'];
            $q_level = $params['level'];
            
            if ($q_content != null) {
                $questionQuery->andWhere([
                    'like',
                    'q_content',
                    $q_content
                ]);
            }
            if ($q_category != null) {
                $questionQuery->andWhere([
                    'q_category' => $q_category
                ]);
            }
            if ($q_type != null) {
                $questionQuery->andWhere([
                    'q_type' => $q_type
                ]);
            }
            if ($q_level != null) {
                $questionQuery->andWhere([
                    'q_level' => $q_level
                ]);
            }
            if ($qt_content != null) {
                $tagNames = explode(',', $qt_content);
                $tag_ids = array_keys(array_filter(AppConstant::$QUESTION_TAG_NAME, function ($v, $k) use ($tagNames) {
                    return in_array(strtolower($v), $tagNames);
                }, ARRAY_FILTER_USE_BOTH));
                $qtags = QuestionTag::query()->andWhere([
                    'IN',
                    'tag_id',
                    $tag_ids
                ])->all();
                $q_ids = AppArrayHelper::getColumn($qtags, 'q_id');
                
                $questionQuery->andWhere([
                    'IN',
                    'q_id',
                    $q_ids
                ]);
            }
        }
        $questions = $questionQuery->all();
        
        return $questions;
    }

    public function updateQuestion($params)
    {
        if (! empty($params)) {
            $question = $this->findQuestionById($params['q_id']);
            var_dump($question);
            die;
            if ($question != null) {
                $question->q_content = $params['q_content'];
                $question->q_category = $params['q_category'];
                $question->q_type = $params['q_type'];
                $question->q_level = $params['q_level'];
                $question->is_deleted = 0;
                if ($question->validate() && $question->save()) {
                    return $question;
                } else {
                    $question = null;
                }
            } else {
                $question = null;
            }
        }
        
        return $question;
    }

    public function initQuestion()
    {
        return $question = new Question();
    }

    /**
     *
     * @return Question|null (found ActiveRecord)
     */
    public function findQuestionById($q_id)
    {
        return Question::queryOne($q_id);
    }

    /**
     *
     * @return Question|null (deleted Question or null if error occur)
     */
    public function deleteQuestionById($q_id)
    {
        // must do in transaction
        $conn = Yii::$app->db;
        
        $question = Question::queryOne($q_id);
        if ($question) {
            $transaction = $conn->beginTransaction();
            
            try {
                $question->is_deleted = 1;
                if ($question->save()) {
                    // delete corresponding answers
                    $logicAnswer = new LogicAnswer();
                    $count = $logicAnswer->deleteAnswersByQuestionId($q_id);
                    
                    // delete corresponding test including this question
                    $logicTestExamQuestions = new LogicTestExamQuestions();
                    $count = $logicTestExamQuestions->deleteTestExamQuestionsByQuestionId($q_id);
                    
                    $transaction->commit();
                    return $question;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        
        return null;
    }

    /**
     *
     * @return (Question) array (found ActiveRecord)
     */
    public function findQuestionByTestId($te_id)
    {
        $logicTestExamQuestions = new LogicTestExamQuestions();
        $question_ids = $logicTestExamQuestions->findQuestionIdByTestId($te_id);
        $questions = [];
        if (! empty($question_ids)) {
            $questions = Question::queryAll([
                'q_id' => $question_ids
            ]);
        }
        return $questions;
    }

    /**
     *
     * @return (Question) array (found ActiveRecord)
     *         param: q_ids: list of all q_id need to get record
     */
    public function findQuestionByIds($q_ids)
    {
        $questions = [];
        if (! empty($q_ids)) {
            $questions = Question::queryAll([
                'q_id' => $q_ids
            ]);
        }
        return $questions;
    }
    
    public function findQuestionDataByIds($q_ids)
    {
        $questions = $this->findQuestionByIds($q_ids);
        $questions = AppArrayHelper::index($questions, 'q_id');

        if (!empty($questions)) {
            $logicAnswer = new LogicAnswer();
            $answers = $logicAnswer->findAnswerByQuestionId($q_ids);

            foreach ($answers as $answer) {
                $questions[$answer->q_id]->answers[] = $answer;
            }
        }
        return $questions;
    }

    /**
     *
     * @return (Question) array (found ActiveRecord)
     */
    public function findQuestionByCategory($q_category)
    {
        $questions = Question::queryAll([
            'q_category' => $q_category
        ]);
        return $questions;
    }

    /**
     *
     * @return (Question) (newly created ActiveRecord)
     */
    public function insertQuestionAndAnswers($questionParams, $answerParams)
    {
        $logicAnswer = new LogicAnswer();

        // insert questions
        $qParams = [];
        $qParams = AppArrayHelper::filterKeys($questionParams, [
            'q_content',
            'q_category',
            'q_level',
            'q_type',
            'qt_content'
        ]);
        $question = new Question;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // validate question model and insert into db
            $question->load(['Question' => $qParams]);
            if (! $question->validate() || ! $question->save()) {
                return $question;
            }

            // if ok, continue to insert answers
            if ($question != null) {
                $q_id = $question->q_id;
                // insert answers
                $answerarray = [];
                foreach ($answerParams as $answer) {
                    $ins = AppArrayHelper::filterKeys($answer, [
                        'qa_content',
                        'qa_status'
                    ]);
                    $ins['q_id'] = $q_id;
                    $aParams[] = $ins;
                }

                $answers = $logicAnswer->insertBatchAnswer($aParams);
                $question->answers = $logicAnswer->findAnswerByQuestionId($q_id);

                $transaction->commit();
                return $question;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
