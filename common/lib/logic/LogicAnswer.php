<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */
namespace common\lib\logic;

use yii\helpers\ArrayHelper;
use common\models\Answer;
use common\lib\components\AppConstant;

class LogicAnswer extends LogicBase
{

    public function __construct()
    {
        parent::__construct ();
    }

    /**
     *
     * @return [Answers]|null (found ActiveRecord)
     */
    public function findAnswerByQuestionId($q_id)
    {
        return Answer::queryAll ( [ 
            'q_id' => $q_id 
        ] );
    }

    /**
     *
     * @return int (deleted answer number)
     */
    public function deleteAnswersByQuestionId($q_id)
    {
        $answers = $this->findAnswerByQuestionId ( $q_id );
        $answers_ids = ArrayHelper::getColumn ( $answers, 'qa_id' );
        
        return Answer::updateAll ( [ 
            'is_deleted' => 1 
        ], [ 
            'qa_id' => $answers_ids 
        ] );
    }

    public function createAnswer($params, $q_id)
    {
        date_default_timezone_set ( "Asia/Ho_Chi_Minh" );
        $answer = new Answer ();
        
        if (! empty ( $params )) {
            
            $answer->q_id = $q_id;
            $answer->qa_content = $params ['qa_content'];
            $answer->qa_status = $params ['qa_status'];
            $answer->is_deleted = 0;
            $answer->save ();
        }
        
        return $answer;
    }

    public function deleteAnswerById($qa_id)
    {
        // must do in transaction
        $answer = Answer::queryOne ( $qa_id );
        if ($answer) {
            $answer->is_deleted = 1;
            $answer->save ();
            return $answer;
        }
        
        return null;
    }

    public function findByAnswerId($qa_id)
    {
        
        $answer = Answer::queryOne ( $qa_id );
        if ($answer) {
            return $answer->q_id;
        }
    
        return null;
    }
    public function findById($qa_id)
    {
      
        $answer = Answer::queryOne ( $qa_id );
       
        if ($answer) {
            return $answer;
        }
    
        return null;
    }
    
    public function initAnswer()
    {
        return $answer = new Answer ();
    }

    public function init2Answer()
    {
        return $answer = [ 
            new Answer () 
        ];
    }
}
