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

/**
 * This is base class of Logic layer
 * all other logic class should extend this class
 *
 */

class LogicAnswer extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAnswersByQuestionId($q_id)
    {
        return Answer::queryAll(['q_id' => $q_id]);
    }

    public function deleteAnswersByQuestionId($q_id)
    {
        $answers = $this->findAnswersByQuestionId($q_id);
        $answers_ids = ArrayHelper::getColumn($answers, 'qa_id');

        return Answer::updateAll(['is_deleted' => 1], ['qa_id' => $answers_ids]);
    }
}
