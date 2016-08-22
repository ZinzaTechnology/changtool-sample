<?php

/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */
namespace common\lib\logic;

use Yii;
use common\models\Question;

class LogicImportData extends LogicBase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataFromFileExcel($fileDirectory)
    {
        $rowData = [];
        try{
            $inputFileType = \PHPExcel_IOFactory::identify($fileDirectory);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileDirectory);
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for($row = 1; $row <= $highestRow; $row++)
            {
                $rowData = array_merge($rowData, $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE));
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
        
        return $rowData;
    }
    
    public function insertDataByFileExcel($fileDirectory)
    {
        $defaultAttribute = [
            0 => 'question',
            1 => 'category',
            2 => 'level',
            3 => 'type',
            4 => 'content',
            5 => 'answers',
            6 => 'answer_is_true'
        ];
        
        $data = $this->getDataFromFileExcel($fileDirectory);
        $attribute = $data[0];
        
        for($a = 0; $a < 7; $a++){
            if($defaultAttribute[$a] != $attribute[$a]){
                throw new \PHPExcel_Exception("INVALID FORMAT!");
            }
        }
        
        $countAnswerData = - 1;
        $isNewQuestion = true;
        $questionsData = [];
        $answersData = [];
        
        foreach($data as $row){
            if (!empty($row[0])) $isNewQuestion = true;
            else $isNewQuestion = false;
            if ($isNewQuestion) {
                $countAnswerData++;
                $questionsData[] = array_merge(array_slice($row, 1, 4), [date('Y-m-d H:i:s')]);
                $answersData[$countAnswerData] = array_slice($row, 5, 2);
            } else 
                $answersData[$countAnswerData] = array_merge($answersData[$countAnswerData], array_slice($row, 5, 2));
        }
        
        $transaction = Question::getDb()->beginTransaction();
        try{
            $questionsID = $this->insertQuestionToDatabase('question', $questionsData);
            $answersID = $this->insertAnswerToDatabase('answer', $questionsID, $answersData);
            $transaction->commit();
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }
    
    public function insertQuestionToDatabase($table, $data)
    {
        $questionAttribute = ['q_category', 'q_level', 'q_type', 'q_content', 'created_at'];
        Yii::$app->db->createCommand()->batchInsert($table, $questionAttribute, $data)->execute();
        return Yii::$app->db->getLastInsertID();
    }
    
    public function insertAnswerToDatabase($table, $q_id, $data)
    {
        $questionID = $q_id;
        $answerAttribute = ['q_id', 'qa_content', 'qa_status', 'created_at'];
        $answersInsert = [];
        $answerContent = '';
        $answerStatus = '';
        
        foreach($data as $answer){
            for($i=0; $i < count($answer); $i++){
                if($i%2 == 0){
                    $answerContent = [$questionID, $answer[$i]];
                } else {
                    $answerStatus = [$answer[$i], date('Y-m-d H:i:s')];
                    $answersInsert[] = array_merge($answerContent, $answerStatus);
                }
            }
            $questionID++;
        }
        
        Yii::$app->db->createCommand()->batchInsert('answer', $answerAttribute, $answersInsert)->execute();
        return Yii::$app->db->getLastInsertID();
    }
}
