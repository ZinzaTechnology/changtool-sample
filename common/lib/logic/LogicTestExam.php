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
     
    private function create_link($url, $filter = [])
    {
        $string = '';
        foreach ($filter as $key => $val) {
            if ($val != '') {
                $string .= "&{$key}={$val}";
            }
        }
        return $url . ($string ? '?'.ltrim($string, '&') : '');
    }
    
    public function pagingTestExam($te_id, $base_link, $current_page, $limit, $question_ids)
    {
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
        $pagging_questions_answers = $logicQuestion->findQuestionDataByIds($paging_question_ids);
        
        // Save questions on this page and return to display
        $paging['pagging_questions_answers'] = $pagging_questions_answers;
        
        return $paging;
    }
    
    public function generateQuestion($params)
    {
        $test_exam_easy = AppConstant::TEST_EXAM_EASY_PERCENT_QUESTION_INTERMEDIATE;
        $test_exam_medium = AppConstant::TEST_EXAM_MEDIUM_PERCENT_QUESTION_INTERMEDIATE;
        $test_exam_hard = AppConstant::TEST_EXAM_HARD_PERCENT_QUESTION_INTERMEDIATE;
        $test_exam_level_easy = AppConstant::TEST_EXAM_LEVEL_EASY;
        $test_exam_level_intermediate = AppConstant::TEST_EXAM_LEVEL_INTERMEDIATE;
        $test_exam_level_hard = AppConstant::TEST_EXAM_LEVEL_HARD;

        $amount = $params['te_num_of_questions'];
        $category = $params['te_category'];
        $level = $params['te_level'];

        $logicQuestion = new LogicQuestion();

        $transaction = TestExam::getDb()->beginTransaction();
        try {
            // first, insert a new test information
            $newTest = $this->insertTestExam(['TestExam' => $params]);

            if (!empty($newTest->errors)) {
                return $newTest;
            }
            switch ($level) {
                case ($test_exam_level_easy):
                    $amountIntermediate = $test_exam_easy;
                case ($test_exam_level_intermediate):
                    $amountIntermediate = $test_exam_medium;
                    break;
                case ($test_exam_level_hard):
                    $amountIntermediate = $test_exam_hard;
                    break;
            }

            $amountIntermediate = round($amountIntermediate * $amount / 100);
            $amountHard = $amount - $amountIntermediate;

            // find desired intermediate questions
            $qParams = ['q_category' => $category, 'q_level' => AppConstant::QUESTION_LEVEL_INTERMEDIATE];
            $intermediate = $logicQuestion->findRandomQuestion($qParams, $amountIntermediate);
            $count_intermediate = count($intermediate);
            
            // find desired hard questions
            $qParams = ['q_category' => $category, 'q_level' => AppConstant::QUESTION_LEVEL_HARD];
            $hard = $logicQuestion->findRandomQuestion($qParams, $amountHard);
            $count_hard = count($hard);

            // in case not enough hard questions
            // and number of intermediate questions is ok
            // compensate with intermediate questions
            if ($count_hard < $amountHard && $count_intermediate == $amountIntermediate) {
                $amountIntermediate = $amount - $count_hard;
                $qParams = ['q_category' => $category, 'q_level' => AppConstant::QUESTION_LEVEL_INTERMEDIATE];
                $intermediate = $logicQuestion->findRandomQuestion($qParams, $amountIntermediate);
                $count_intermediate = count($intermediate);
            }

            // in case not enough intermediate questions
            // and number of hard questions is ok
            // compensate with hard questions
            if ($count_hard == $amountHard && $count_intermediate < $amountIntermediate) {
                $amountHard = $amountHard + ($amountIntermediate - $count_intermediate);
                $qParams = ['q_category' => $category, 'q_level' => AppConstant::QUESTION_LEVEL_HARD];
                $intermediate = $logicQuestion->findRandomQuestion($qParams, $amountHard);
                $count_hard = count($hard);
            }
            
            // assign found questions to the test
            // insert into test_exam_questions
            $questions = array_merge($intermediate, $hard);
            $teQuestions = [];
            foreach ($questions as $question) {
                $teQuestions[] = [$newTest->te_id, $question->q_id, date('Y-m-d H:i:s')];
            }
            Yii::$app->db->createCommand()->batchInsert('test_exam_questions', ['te_id', 'q_id', 'created_at'], $teQuestions)->execute();

            // recalcuate the total number of questions
            // and level of the test
            $total = $count_hard + $count_intermediate;
            if ($total == 0) {
                return null;
            }
            $ratio = $count_intermediate * 100 / $total;
            if ($ratio >= $test_exam_medium && $ratio < $test_exam_easy) {
                $level = $test_exam_level_intermediate;
            } elseif ($ratio >= $test_exam_easy) {
                $level = $test_exam_level_easy;
            } else {
                $level = $test_exam_level_hard;
            }
            $newTest->te_level = $level;
            $newTest->te_num_of_questions = $total;
            $newTest->validate();
            $newTest->save();

            $transaction->commit();
            return $newTest;
        } catch (Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return null;
    }
    
    private function paging($link, $total_records, $current_page, $limit)
    {
        $total_page = ceil($total_records / $limit);

        if ($current_page > $total_page) {
            $current_page = $total_page;
        } elseif ($current_page < 1) {
            $current_page = 1;
        }

        $start = ($current_page - 1) * $limit;
        $html = '<div class="paging"><ul>';

        // Display pre button
        if ($total_page > 1) {
            if ($current_page > 1) {
                $html .= '<li><a href="'.str_replace('{page}', $current_page - 1, $link).'"> << </a></li>';
            } else {
                $html .= '<li><span> << </span></li>';
            }
            for ($i = 1; $i <= $total_page; $i++) {
                if ($i == $current_page) {
                    $html .= '<li><span>'.$i.'   </span></li>';
                } else {
                    $html .= '<li><a href="'.str_replace('{page}', $i, $link).'">'.$i.'</a></li>';
                }
            }
            if ($current_page < $total_page) {
                $html .= '<li><a href="'.str_replace('{page}', $current_page + 1, $link).'"> >> </a></li>';
            } else {
                $html .= '<li><span> >> </span></li>';
            }
        }
        
        $html .= "</ul></div>";
        return [
            'start' => $start,
            'limit' => $limit,
            'html' => $html
        ];
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
                'pageSize' => AppConstant::PAGING_INDEX_PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $dataProvider;
    }

    /**
     * @return TestExam|null (found ActiveRecord)
     */
    public function findTestExamById($id, $check_deleted = true)
    {
        return TestExam::queryOne($id, $check_deleted);
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
                $testExam->is_deleted = 1;
                $testExam->save();
                
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
        $testExam->load($params);
        $testExam->validate();
        $testExam->save();
        return $testExam;
    }

    public function updateTestExam($params)
    {
        $testExam = $this->findTestExamById($params['te_id']);
        if ($testExam == null) {
            return $testExam;
        }
        $testExam['te_level'] = $params['te_level'];
        $testExam['te_code'] = $params['te_code'];
        $testExam['te_category'] = $params['te_category'];
        $testExam['te_title'] = $params['te_title'];
        $testExam['te_time'] = $params['te_time'];
        $testExam['te_num_of_questions'] = $params['te_num_of_questions'];
        if ($testExam->validate() && $testExam->save()) {
                return $testExam;
        }
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
        return AppConstant::ERROR_OK;
    }
    
    
    public function updateTestExamInfoToSession($request)
    {
        if (!isset(Yii::$app->session['test_exam'])) {
            //throw new NotFoundHttpException('You must click edit buttion first to edit this testExam...');
            return AppConstant::ERROR_SESSION_EMPTY;
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
        return AppConstant::ERROR_OK;
    }
    
    public function updateTestExamQuestionsInfoToSession($options)
    {
        if (!isset(Yii::$app->session['test_exam'])) {
            return AppConstant::ERROR_SESSION_EMPTY;
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
        return AppConstant::ERROR_OK;
    }
    public function removeTestExamInfoFromSession()
    {
        Yii::$app->session->remove('test_exam');
        return AppConstant::ERROR_OK;
    }
    
    public function deleteQuestionOnSession($te_id, $q_id)
    {
        $test_exam = Yii::$app->session->get('test_exam');
        if ($test_exam['testExam']['te_id'] != $te_id) {
            return AppConstant::ERROR_CAN_NOT_EDIT_TWO_TESTEXAM_AT_THE_SAMETIME;
        }
        $all_questions = $test_exam['all_questions'];
        
        $idx_all = array_search($q_id, $all_questions);
        if ($idx_all === false) {
            return AppConstant::ERROR_QUESTION_NOT_EXIST_IN_TESTEXAM;
        }
        array_splice($all_questions, $idx_all, 1);

        $test_exam['all_questions'] = $all_questions;
        $test_exam['testExam']['te_num_of_questions'] = count($all_questions);
        Yii::$app->session->set('test_exam', $test_exam);
        
        return AppConstant::ERROR_OK;
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
                    return AppConstant::ERROR_CAN_NOT_SAVE_TESTEXAM_TO_DB;
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
                if (AppConstant::ERROR_OK != $ret) {
                    $transaction->rollBack();
                    return $ret;
                }
                // Delete removed questions of this exam
                $ret = $logicTestExamQuestions->deleteMultiTestExamQuestion($te_id, $removed_questions);
                if (AppConstant::ERROR_OK != $ret) {
                    $transaction->rollBack();
                    return $ret;
                }
                
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return AppConstant::ERROR_OK;
    }
}
