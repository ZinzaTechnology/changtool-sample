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
    private $_questions = [];
    private $_answers = [];
    private $_trueAnswers = 0;
    private $_falseAnswers = 0;
    private $_isNewQuestion = false;
    
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
    
    public function parseQuestion($array)
    {
        $question = array_filter($array);
        if (count($question) == 4) {
            $this->_isNewQuestion = true;
            $this->_questions[] = array_merge($question, [date('Y-m-d H:i:s')]);
        } else {
            $this->_isNewQuestion = false;
        }
    }
    
    public function parseAnswer($array)
    {
        $answer = array_filter($array);
        if(count($answer) >= 1){
            $answer[0] = (string) $array[0];
            if (empty($answer[1])) {
                $answer = [$answer[0], 0]; 
            }
            if ($answer[1] == 1) {
                $this->_trueAnswers++;
            } else {
                $this->_falseAnswers++;
            }
            if ($this->_isNewQuestion) {
                $this->_answers[] = $array;
            }
            else {
                $this->_answers[count($this->_answers) - 1] = array_merge($this->_answers[count($this->_answers) - 1], $answer);
            }
        }
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
        
        $first_question = array_slice($data[0], 1, 4);
        $first_answer = array_slice($data[0], 5, 2);
        $first_question = array_filter($first_question);
        if (count($first_question) == 4) {
            $this->parseQuestion($first_question);
            $this->_isNewQuestion = true;
            $this->parseAnswer($first_answer);
        } else {
            Yii::$app->session->setFlash('error', "First record must have question's information");
            return;
        }
        array_shift($data);
        
        foreach($data as $position => $row){
            $question = array_slice($row, 1, 4);
            $answer = array_slice($row, 5, 2);
            $this->parseQuestion($question);
            if ($this->_isNewQuestion) {
                if ($this->_trueAnswers >= 1) {
                    $this->_trueAnswers = 0;
                    $this->_falseAnswers = 0;
                } else {
                    Yii::$app->session->setFlash('error', "Must have at least 1 true answer! ~ question having line {$position}");
                    return;
                }
            }
            $this->parseAnswer($answer);
        }
        
        $transaction = Question::getDb()->beginTransaction();
        try{
            $questionsID = $this->insertQuestionToDatabase('question', $this->_questions);
            $answersID = $this->insertAnswerToDatabase('answer', $questionsID, $this->_answers);
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Import successful!');
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
