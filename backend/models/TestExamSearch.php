<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TestExam;

/**
 * TestExamSearch represents the model behind the search form about `backend\models\TestExam`.
 */
class TestExamSearch extends TestExam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id', 'te_category', 'te_level', 'te_time', 'te_num_of_questions', 'te_is_deleted'], 'integer'],
            [['te_code', 'te_title', 'te_created_at', 'te_last_updated_at'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TestExam::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'te_id' => $this->te_id,
            'te_category' => $this->te_category,
            'te_level' => $this->te_level,
            'te_time' => $this->te_time,
            'te_num_of_questions' => $this->te_num_of_questions,
            'te_created_at' => $this->te_created_at,
            'te_last_updated_at' => $this->te_last_updated_at,
            'te_is_deleted' => $this->te_is_deleted,
        ]);

        $query->andFilterWhere(['like', 'te_code', $this->te_code])
            ->andFilterWhere(['like', 'te_title', $this->te_title]);

        return $dataProvider;
    }
}
