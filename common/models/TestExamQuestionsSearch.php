<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\TestExamQuestions;

/**
 * TestExamQuestionsSearch represents the model behind the search form about `backend\models\TestExamQuestions`.
 */
class TestExamQuestionsSearch extends TestExamQuestions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id', 'q_id'], 'integer'],
            [['not_use'], 'boolean'],
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
        $query = TestExamQuestions::find();

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
            'q_id' => $this->q_id,
            'not_use' => $this->not_use,
        ]);

        return $dataProvider;
    }
}
