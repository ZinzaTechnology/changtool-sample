<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use yii\helpers\ArrayHelper;
use common\models\TestExamQuestions;
use common\lib\components\AppConstant;

class LogicTestExamQuestions extends LogicBase
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return (int) array (found ids)
     */
    public function findQuestionIdByTestId($te_id)
    {
        return ArrayHelper::getColumn(TestExamQuestions::queryAll(['te_id' => $te_id]), 'q_id');
    }

    /**
     * @return int (number of deleted rows)
     */
    public function deleteTestExamQuestionsByQuestionId($q_id)
    {
        return TestExamQuestions::deleteAll(['q_id' => $q_id]);
    }

    /**
     * @return int (number of deleted rows)
     */
    public function deleteTestExamQuestionsByTestId($te_id)
    {
        return TestExamQuestions::deleteAll(['te_id' => $te_id]);
    }
    
    public function deleteTestExamQuestions($te_id, $q_id)
    {
        return TestExamQuestions::deleteAll(['te_id' => $te_id, 'q_id' => $q_id]);
    }
    
    public function insertTestExamQuestion($te_id, $q_id)
    {
        $testExamQuestion = new TestExamQuestions();
        $form_name = $testExamQuestion->formName();
        $params = [
            $form_name => [
                'te_id' => $te_id,
                'q_id' => $q_id,
            ]
        ];
        if ($testExamQuestion->load($params) && $testExamQuestion->validate()) {
            if ($testExamQuestion->save()) {
                return true;
            }
        }

        return false;
    }
}
