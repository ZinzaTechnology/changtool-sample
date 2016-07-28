<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */
namespace common\lib\logic;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Question;
use common\models\QuestionTag;
use common\models\TestExamQuestions;
use common\lib\components\AppConstant;

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
            $q_content = $params ['content'];
            $q_category = $params ['category'];
            $q_type = $params ['type'];
            $qt_content = $params ['qt_content'];
            $q_level = $params ['level'];
            
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
                $q_ids = ArrayHelper::getColumn($qtags, 'q_id');
                
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

    /**
     *
     * @return Question|null (found ActiveRecord)
     */
    public function createQuestion($params)
    {
        $question = new Question();
        if (! empty($params)) {
            $question->q_content = $params ['q_content'];
            $question->q_category = $params ['q_category'];
            $question->q_type = $params ['q_type'];
            $question->q_level = $params ['q_level'];
            $question->is_deleted = 0;
            if ($question->save() && $question->validate()) {
                return $question;
            } else
                $question = null;
        }
        
        return $question;
    }

    public function updateQuestion($params)
    {
        if (! empty($params)) {
            $question = $this->findQuestionById($params ['q_id']);
            if ($question != null) {
                $question->q_content = $params ['q_content'];
                $question->q_category = $params ['q_category'];
                $question->q_type = $params ['q_type'];
                $question->q_level = $params ['q_level'];
                $question->is_deleted = 0;
                if ($question->save() && $question->validate()) {
                    return $question;
                } else
                    $question = null;
            } else
                $question = null;
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
}
