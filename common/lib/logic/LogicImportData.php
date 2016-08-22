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
                throw new \PHPExcel_Exception('INVALID FORMAT!');
            }
        }
        
        array_shift($data);
        $questionsData = [];
        $answersData = [];
        $questionType = 0;
        $countTrueAnswer = 0;
        $countFalseAnswer = 0;
        
        //First element
        $firstQuestion = array_slice($data[0], 1, 4);
        $firstAnswer = array_slice($data[0], 5, 2);
        $questionsData[] = array_merge($firstQuestion, [date('Y-m-d H:i:s')]);
        $answersData[] = $firstAnswer;
        $questionType = $firstQuestion[2];
        
        if ($firstAnswer[1] == 1) {
            $countTrueAnswer++;
        } else {
            $countFalseAnswer++;
        }
        
        array_shift($data);
        
        foreach($data as $row){
            $answer = array_slice($row, 5, 2);
            if (!empty($row[1])) {
                if (($countFalseAnswer + $countTrueAnswer) < 4) {
                    throw new \Exception('Amount of answers must be equal or more than 4!');
                }
                if ($questionType > $countTrueAnswer) {
                    throw new \Exception('Amount of true answers must be equal or more than type of question!');
                }

                $question = array_slice($row, 1, 4);
                $questionType = $question[2];
                $questionsData[] = array_merge($question, [date('Y-m-d H:i:s')]);
                $answersData[] = $answer;

                $countTrueAnswer = 0;
                $countFalseAnswer = 0;
            } else {
                $answersData[count($answersData) - 1] = array_merge($answersData[count($answersData) - 1], $answer);
            }
            if ($answer[1] == 1) {
                $countTrueAnswer++;
            } else {
                $countFalseAnswer++;
            }
        }
        
        $transaction = Question::getDb()->beginTransaction();
        try{
            $questionsID = $this->insertQuestionToDatabase('question', $questionsData);
            $answersID = $this->insertAnswerToDatabase('answer', $questionsID, $answersData);
            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        
        return false;
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
            for($i = 0; $i < count($answer); $i++){
                if($i % 2 == 0){
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
