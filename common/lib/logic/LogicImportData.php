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
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for($row=1;$row<= $highestRow;$row++)
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
        $data = $this->getDataFromFileExcel($fileDirectory);
        
        $highestColumnHavingData = count($data[0]);
        while (true) {
            if (empty($data[0][$highestColumnHavingData]))
                $highestColumnHavingData--;
            else break;
        }
        
        $indexOfAnswer = array_search('answers', $data[0]);
        $questionsDataRange = $indexOfAnswer - 1; // -1 cuoi cung la bo di phan tu 'question' ko su dung
        $answersDataRange = $highestColumnHavingData - $questionsDataRange;
        $countAnswerData = -1;
        $isNewQuestion = true;
        $questionsData = [];
        $answersData = [];
        $question = [];
        $answer = [];
        
        foreach($data as $row){
            if (!empty($row[0]))
                $isNewQuestion = true;
            else $isNewQuestion = false;
            if ($isNewQuestion) {
                $countAnswerData++;
                $questionsData[] = array_merge(array_slice($row, 1, $questionsDataRange), [date('Y-m-d H:i:s')]);
                $answersData[$countAnswerData] = array_slice($row, $indexOfAnswer, $answersDataRange);
            } else 
                $answersData[$countAnswerData] = array_merge($answersData[$countAnswerData],array_slice($row, $indexOfAnswer, $answersDataRange));
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
            for($i=0;$i<count($answer);$i++){
                if($i%2 == 0){
                    $answerContent = [$questionID, $answer[$i]];
                } else {
                    $answerStatus = [$answer[$i],date('Y-m-d H:i:s')];
                    $answersInsert[] = array_merge($answerContent,$answerStatus);
                }
            }
            $questionID++;
        }
        
        Yii::$app->db->createCommand()->batchInsert('answer', $answerAttribute, $answersInsert)->execute();
        return Yii::$app->db->getLastInsertID();
    }
}
