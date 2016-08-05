<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use Yii;
use common\models\TestExam;
use common\models\Question;
use common\models\TestExamSearch;
use yii\data\ActiveDataProvider;

class LogicTestExam extends LogicBase
{
    public function __construct()
    {
        parent::__construct();
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
                $testExam->is_deleted = 1;
                if($testExam->save()) {
                    // delete corresponding test exam question relationship
                    $logicTestExamQuestions = new LogicTestExamQuestions();
                    $count = $logicTestExamQuestions->deleteTestExamQuestionsByTestId($te_id);

                    $transaction->commit();
                    return $testExam;
                }
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return null;
    }

}
