<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */
namespace common\lib\logic;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Answer;

class LogicAnswer extends LogicBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @return [Answers]|null (found ActiveRecord)
     */
    public function findAnswerByQuestionId($q_id)
    {
        return Answer::queryAll([
            'q_id' => $q_id
        ]);
    }

    /**
     *
     * @return int (deleted answer number)
     */
    public function deleteAnswersByQuestionId($q_id)
    {
        $answers = $this->findAnswerByQuestionId($q_id);
        $answers_ids = ArrayHelper::getColumn($answers, 'qa_id');
        
        return Answer::updateAll([
            'is_deleted' => 1
        ], [
            'qa_id' => $answers_ids
        ]);
    }

    public function insertBatchAnswer($params)
    {
        $db = Yii::$app->db;
        $count = 0;
        $dataInsert = [];
        foreach ($params as $answer) {
            $dataInsert[] = [$answer['q_id'], $answer['qa_content'], $answer['qa_status'], date('Y-m-d H:i:s')];
        }
        $db->createCommand()->batchInsert(Answer::tableName(), ['q_id', 'qa_content', 'qa_status', 'created_at'], $dataInsert)->execute();
        return [$db->getLastInsertID(), $count];
    }

    public function updateAnswerByQuesion($params, $q_id)
    {
        if ($params != null && $q_id != null) {
            if ($params['qa_id'] == null) {
                $answer = new Answer();
                $answer->q_id = $q_id;
                $answer->qa_content = $params['qa_content'];
                $answer->qa_status = $params['qa_status'];
                $answer->is_deleted = 0;
                if ($answer->save() && $answer->validate()) {
                    return $answer;
                } else {
                    $answer = null;
                }
            } else {
                $answer = $this->findByAnswerId($params['qa_id']);
                if ($answer != null) {
                    $answer->qa_content = $params['qa_content'];
                    $answer->qa_status = $params['qa_status'];
                    $answer->is_deleted = 0;
                    if ($answer->validate() && $answer->save()) {
                        return $answer;
                    } else {
                        $answer = null;
                    }
                } else {
                    $answer = null;
                }
            }
        }
        
        return $answer;
    }

    public function createAnswer($params)
    {
        $answer = new Answer();
        
        if (! empty($params)) {
            $answer->q_id = $params['q_id'];
            $answer->qa_content = $params['qa_content'];
            $answer->qa_status = $params['qa_status'];
            $answer->is_deleted = 0;
            if ($answer->validate() && $answer->save()) {
                return $answer;
            } else {
                $answer = null;
            }
        }
        
        return $answer;
    }

    public function updateAnswer($params)
    {
        if (! empty($params)) {
            $answer = $this->findByAnswerId($params['qa_id']);
            
            if ($answer != null) {
                $answer->q_id = $params['q_id'];
                $answer->qa_content = $params['qa_content'];
                $answer->qa_status = $params['qa_status'];
                $answer->is_deleted = 0;
                
                if ($answer->validate() && $answer->save()) {
                    return $answer;
                } else {
                    $answer = null;
                }
            } else {
                $answer = null;
            }
        }
        
        return $answer;
    }

    public function deleteAnswerById($qa_id)
    {
        // must do in transaction
        $answer = Answer::queryOne($qa_id);
        if ($answer) {
            $answer->is_deleted = 1;
            $answer->save();
            return $answer;
        }
        
        return null;
    }

    public function findByAnswerId($qa_id)
    {
        $answer = Answer::queryOne($qa_id);
        
        return $answer;
    }

    public function initAnswer()
    {
        return $answer = new Answer();
    }
}
