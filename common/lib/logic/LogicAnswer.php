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
use common\lib\components\AppConstant;

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
            'is_deleted' => AppConstant::MODEL_IS_DELETED_DELETED,
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

    public function updateAnswer($params)
    {
        $answer = $this->findByAnswerId($params['qa_id']);
        $answer->load(['Answer' => $params]);
        $answer->validate();
        $answer->save();
        
        return $answer;
    }

    public function deleteAnswerById($qa_id)
    {
        $num = Answer::updateAll(['is_deleted' => AppConstant::MODEL_IS_DELETED_DELETED], ['qa_id' => $qa_id]);
        return $num;
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
