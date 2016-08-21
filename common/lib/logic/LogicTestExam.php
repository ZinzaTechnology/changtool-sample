<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\TestExam;
use common\models\Question;
use common\models\TestExamSearch;
use yii\data\ActiveDataProvider;
use common\models\TestExamQuestions;
use common\lib\helpers\AppArrayHelper;
use common\lib\components\AppConstant;


class LogicTestExam extends LogicBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Const variable
    public $paging_index_page_size = 10;
    public $paging_view_page_size = 5;
    public $paging_update_page_size = 6;
     
    function create_link($url, $filter = [])
    {
        $string = '';
        foreach ($filter as $key => $val){
            if($val != ''){
                $string .= "&{$key}={$val}";
            }
        }
        return $url . ($string ? '?'.ltrim($string, '&') : '');
    }
    
    function pagingTestExam($te_id, $base_link, $current_page, $limit, $question_ids){
        $logicTestExamQuestions = new LogicTestExamQuestions();
        $logicQuestion = new LogicQuestion();
        
        // Get number of question on this exam
        $total_records = count($question_ids);
        
        // Create link for paging test exam
        $link = $this->create_link($base_link, ['id' => $te_id, 'page' => '{page}']);
        
        // Paging list of questions
        $paging = $this->paging($link, $total_records, $current_page, $limit);
        
        // Only query question on this page
        $paging_question_ids = array_slice($question_ids, $paging['start'], $paging['limit']);
        $paging_questions = $logicQuestion->findQuestionByIds($paging_question_ids);
        
        // Save questions on this page and return to display
        $paging['pagging_questions'] = $paging_questions;
        
        return $paging;
    }
    
    function paging($link, $total_records, $current_page, $limit)
    {
        $total_page = ceil($total_records / $limit);

        if($current_page > $total_page){
            $current_page = $total_page;
        }
        else if($current_page < 1){
            $current_page = 1;
        }

        $start = ($current_page - 1) * $limit;
        $html = '';

        // Display pre button
        if($current_page > 1 && $total_page > 1){
            $html .= '<a href="'.str_replace('{page}', $current_page - 1, $link).'">Prev   </a>';
        }
        for($i = 1; $i <= $total_page; $i++){
           if ($i == $current_page){
               $html .= '<span>'.$i.'   </span>';
           }
           else{
               $html .= '<a href="'.str_replace('{page}', $i, $link).'">'.$i.'   </a>';
           }
        }
        if ($current_page < $total_page && $total_page > 1){
            $html .= '<a href="'.str_replace('{page}', $current_page + 1, $link).'">Next</a>';
        }
        return array(
            'start' => $start,
            'limit' => $limit,
            'html' => $html
        );
     }
     
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function findTestExamBySearch($params)
    {
        $testExamSearch = new TestExamSearch();
        $query = TestExam::query();

        $testExamSearch->load([$testExamSearch->formName() => $params]);
        if (!$testExamSearch->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'te_id' => $testExamSearch->te_id,
            'te_category' => $testExamSearch->te_category,
            'te_level' => $testExamSearch->te_level,
            'te_time' => $testExamSearch->te_time,
            'te_num_of_questions' => $testExamSearch->te_num_of_questions,
            'created_at' => $testExamSearch->created_at,
            'updated_at' => $testExamSearch->updated_at,
            'is_deleted' => $testExamSearch->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'te_code', $testExamSearch->te_code])
            ->andFilterWhere(['like', 'te_title', $testExamSearch->te_title]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->paging_index_page_size,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * @return TestExam|null (found ActiveRecord)
     */
    public function findTestExamById($id)
    {
        return TestExam::queryOne($id);
    }

    /**
     * @return int|null (deleted question_id or null if error occur)
     */
    public function deleteTestExamById($te_id)
    {
        // must do in transaction
        $conn = Yii::$app->db;

        $testExam = TestExam::queryOne($te_id);
        if ($testExam) {
            $transaction = $conn->beginTransaction();

            try {
                // Delete from DataBase
                // Delete corresponding test exam question relationship
                $logicTestExamQuestions = new LogicTestExamQuestions();
                $count = $logicTestExamQuestions->deleteTestExamQuestionsByTestId($te_id);
                
                // Delete testExam
                $testExam->delete();
                
                // Delete ok, apply to Database
                $transaction->commit();
                
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return false;
    }

    /**
     * @return TestExam|null (newly created ActiveRecord)
     */
    public function insertTestExam($params)
    {
        $testExam = new TestExam();

        if ($testExam->load($params) && $testExam->validate()) {
            if ($testExam->save()) {
                return $testExam;
            }
        }

        return $testExam;
    }
    
    /**
     * @return TestExam|null (found ActiveRecord)
     * init all Edited Test Exam info of user when user update TestExam
     */
    public function initTestExamInfoToSession($testExam, $id, $test_questions)
    {
        if (isset(Yii::$app->session['test_exam'])) {
            Yii::$app->session->remove('test_exam');
        }
        
        // Get question Id
        $all_questions = [];
        foreach ($test_questions as $test_question) {
            $all_questions[] = $test_question->q_id;
        }
        sort($all_questions);
      
        $testExam['te_num_of_questions'] = count($all_questions);
        
        $test_exam_info = [
            'te_id' => $id,
            'testExam' => $testExam,
            'te_questions' => $test_questions,
            'all_questions' => $all_questions,
            'current_page' => 1, // Default current page
        ];
        Yii::$app->session->set('test_exam', $test_exam_info);
        return AppConstant::$ERROR_OK;
    }
    
    
    public function updateTestExamInfoToSession($request)
    {
        if (!isset(Yii::$app->session['test_exam'])) {
            //throw new NotFoundHttpException('You must click edit buttion first to edit this testExam...');
            return AppConstant::$ERROR_SESSION_EMPTY;
        }
        // Get testExam info from session
        $test_exam = Yii::$app->session->get('test_exam');
        
        // Filter request
        $params = AppArrayHelper::filterKeys(
            $request['TestExam'],
            ['te_code', 'te_category', 'te_level', 'te_title', 'te_time']
        );
        
        $test_exam['testExam']['te_category'] = $params['te_category'];
        $test_exam['testExam']['te_level'] = $params['te_level'];
        $test_exam['testExam']['te_code'] = $params['te_code'];
        $test_exam['testExam']['te_title'] = $params['te_title'];
        $test_exam['testExam']['te_time'] = $params['te_time'];

        Yii::$app->session->set('test_exam', $test_exam);
        return AppConstant::$ERROR_OK;
    }
    
    public function updateTestExamQuestionsInfoToSession($options)
    {
        if (!isset(Yii::$app->session['test_exam'])) {
            return AppConstant::$ERROR_SESSION_EMPTY;
        }
        // Get testExam info from session
        $test_exam = Yii::$app->session->get('test_exam');
        
        $all_questions = $test_exam['all_questions'];
               
        // Save new question id to session
        foreach ($options as $option) {
            if (!in_array($option, $all_questions)) {
                $all_questions[] = $option;
            }
        }
        // Sort $all_question
        sort($all_questions);
        
        $test_exam['all_questions'] = $all_questions;
        $test_exam['testExam']['te_num_of_questions'] = count($all_questions);
                    
        Yii::$app->session->set('test_exam', $test_exam);
        return AppConstant::$ERROR_OK;
    }
    public function removeTestExamInfoFromSession()
    {
        Yii::$app->session->remove('test_exam');
        return AppConstant::$ERROR_OK;
    }
    
    public function deleteQuestionOnSession($te_id, $q_id)
    {
        $test_exam = Yii::$app->session->get('test_exam');
        if ($test_exam['testExam']['te_id'] != $te_id) {
            return AppConstant::$ERROR_CAN_NOT_EDIT_TWO_TESTEXAM_AT_THE_SAMETIME;
        }
        $all_questions = $test_exam['all_questions'];
        
        $idx_all = array_search($q_id, $all_questions);
        if ($idx_all === false) {
            return AppConstant::$ERROR_QUESTION_NOT_EXIST_IN_TESTEXAM;
        }
        array_splice($all_questions, $idx_all, 1);

        $test_exam['all_questions'] = $all_questions;
        $test_exam['testExam']['te_num_of_questions'] = count($all_questions);
        Yii::$app->session->set('test_exam', $test_exam);
        
        return AppConstant::$ERROR_OK;
    }
    
    
    public function updateChangesFromSessionToDB()
    {
        if (isset(Yii::$app->session['test_exam'])) {
            $test_exam = Yii::$app->session->get('test_exam');
            $te_questions = $test_exam['te_questions'];
            $all_questions = $test_exam['all_questions'];
            $te_id = $test_exam['te_id'];
            // Update info for test exam question.
            //1. Search all questions in TestExamQuestion and delete which is deleted by user
            $logicTestExamQuestions = new LogicTestExamQuestions();

            // must do in transaction
            $conn = Yii::$app->db;
            $transaction = $conn->beginTransaction();

            try {
                // Update info to TestExam
                $testExam = $test_exam['testExam'];
                if (!$testExam->validate() || !$testExam->save()) {
                    $transaction->rollBack();
                    return AppConstant::$ERROR_CAN_NOT_SAVE_TESTEXAM_TO_DB;
                }
                
                // Update TestExam Question
                // List all old questions id
                $questions = [];
                foreach ($te_questions as $te_question) {
                    $questions[] = $te_question['q_id'];
                }
                $removed_questions = array_diff($questions, $all_questions);
                $removed_questions = array_values($removed_questions);
                $added_questions = array_diff($all_questions, $questions);
                $added_questions = array_values($added_questions);
                
                // Insert added questions for this exam
                $ret = $logicTestExamQuestions->insertMultiTestExamQuestion($te_id, $added_questions);
                if (AppConstant::$ERROR_OK != $ret) {
                    $transaction->rollBack();
                    return $ret;
                }
                // Delete removed questions of this exam
                $ret = $logicTestExamQuestions->deleteMultiTestExamQuestion($te_id, $removed_questions);
                if (AppConstant::$ERROR_OK != $ret) {
                    $transaction->rollBack();
                    return $ret;
                }
                
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return AppConstant::$ERROR_OK;
    }
}
