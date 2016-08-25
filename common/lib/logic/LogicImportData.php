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
        $defaultAttribute = ['question', 'category', 'level', 'type', 'content', 'answers', 'answer_is_true'];
        
        $data = $this->getDataFromFileExcel($fileDirectory);
        $data = array_map(null, $data);
        $attribute = array_slice($data[0], 0, 7);
        
        if(array_diff($defaultAttribute, $attribute)){
            Yii::$app->session->setFlash('error', 'INVALID FORMAT!');
            return;
        }
        array_shift($data);
        
        $questionsData = [];
        $answersData = [];
        $questionType = 0;
        $countTrueAnswer = 0;
        $countFalseAnswer = 0;
        $isNewQuestion = false;
        
        //first data
        $question = array_slice($data[0], 1, 4);
        $answer = array_slice($data[0], 5, 2);
        if (count(array_filter($question)) > 2) {
            $questionsData[] = array_merge($question, [date('Y-m-d H:i:s')]);
            if(empty($answer[1])){
                $answer = [$answer[0], 0];
            }
            if ($answer[1] == 0) {
                $countFalseAnswer++;
            } else {
                $countTrueAnswer++;
            }
            $answersData[] = $answer;
        } else {
            Yii::$app->session->setFlash('error', "First record must have question's information");
            return;
        }
        array_shift($data);
        
        $count = 0;
        foreach($data as $row){
            $count++;
            $question = array_slice($row, 1, 4);
            $answer = array_slice($row, 5, 2);
            if (count(array_filter($question)) > 2) {
                if ($countTrueAnswer > 0){
                    $countTrueAnswer = 0;
                    $countFalseAnswer = 0;
                } else {
                    Yii::$app->session->setFlash('error', "Must have at least 1 true answer! ~ question having line {$count}");
                    return;
                }
                if(empty($answer[1])){
                    $answer = [$answer[0], 0];
                }
                if ($answer[1] == 0) {
                    $countFalseAnswer++;
                } else {
                    $countTrueAnswer++;
                }
                $questionsData[] = array_merge($question, [date('Y-m-d H:i:s')]);
                $answersData[] = $answer;
            } else {
                if(empty($answer[1])){
                    $answer = [$answer[0], 0];
                }
                if ($answer[1] == 0) {
                    $countFalseAnswer++;
                } else {
                    $countTrueAnswer++;
                }
                $answersData[count($answersData) - 1] = array_merge($answersData[count($answersData) - 1], $answer);
            }
        }
        $transaction = Question::getDb()->beginTransaction();
        try{
            $questionsID = $this->insertQuestionToDatabase('question', $questionsData);
            $answersID = $this->insertAnswerToDatabase('answer', $questionsID, $answersData);
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Import successful!');
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
            $answerContent = [];
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
