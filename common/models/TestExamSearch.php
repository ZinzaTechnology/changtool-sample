<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TestExam;

/**
 * TestExamSearch represents the model behind the search form about `common\models\TestExam`.
 */
class TestExamSearch extends TestExam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id', 'te_category', 'te_level', 'te_time', 'te_num_of_questions', 'is_deleted'], 'integer'],
            [['te_code', 'te_title', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

}
