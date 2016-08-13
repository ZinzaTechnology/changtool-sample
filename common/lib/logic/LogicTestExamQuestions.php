<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
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
    
    public function insertMultiTestExamQuestion($te_id, $q_ids)
    {
        if (!empty($q_ids)) {
            $created_at = date('Y:m:d h:m:s');
            $teqs = [];
            foreach ($q_ids as $q_id) {
                $teqs[] = [$te_id, $q_id, $created_at];
            }
            $q_count = count($q_ids);
            $q_inserted_count = Yii::$app->db->createCommand()->batchInsert(TestExamQuestions::tableName(), ['te_id', 'q_id', 'created_at'], $teqs)->execute();
            if ($q_count != $q_inserted_count) {
                return AppConstant::$ERROR_CAN_NOT_INSERT_TESTEXAM_QUESTIONS_TO_DB;
            }
        }
        return AppConstant::$ERROR_OK;
    }
    
    public function deleteMultiTestExamQuestion($te_id, $q_ids)
    {
        if (!empty($q_ids)) {
            $te_ids = [];
            foreach ($q_ids as $q_id) {
                $te_ids[] = (int)$te_id;
            }
            $q_count = count($q_ids);
            $q_deleted_count = Yii::$app->db->createCommand()->delete(TestExamQuestions::tableName(), ['te_id' => $te_ids, 'q_id' => $q_ids])->execute();
            if ($q_count != $q_deleted_count) {
                return AppConstant::$ERROR_CAN_NOT_DELETE_TESTEXAM_QUESTIONS_FROM_DB;
            }
        }
        return AppConstant::$ERROR_OK;
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
                return AppConstant::$ERROR_OK;
            }
        }
        return AppConstant::$ERROR_CAN_NOT_INSERT_TESTEXAM_QUESTIONS_TO_DB;
    }
}
