<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserTest;

/**
 * UserTestSearch represents the model behind the search form about `backend\models\UserTest`.
 */
class UserTestSearch extends UserTest {

//    /**
//     * @inheritdoc
//     */
    
    public function rules() {
        return [
            [['ut_id', 'u_id', 'te_id', 'ut_mark'], 'integer'],
            [['ut_status', 'ut_start_at', 'ut_finished_at', 'ut_question_clone_ids', 'ut_user_answer_ids'], 'safe'],
        ];
    }

//
//    /**
//     * @inheritdoc
//     */
    public function scenarios() {
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
    public function search($params) {
//        $sql = "SELECT ut_id as 'Id', u_name as 'Username',te_category as 'Category', te_title as 'Title', te_level as 'Level', ut_status as 'Status', ut_start_at as 'Start time', ut_finished_at as 'End time'
//                    FROM user_test
//                    INNER JOIN user
//                    ON user_test.u_id = user.u_id
//                    INNER JOIN test_exam
//                    ON user_test.te_id = test_exam.te_id
//                    ORDER BY ut_id DESC
//		";
//        $dataProvider = Yii::$app->db->createCommand($sql)->queryAll();
        // add conditions that should always apply here
        $query = UserTest::find()->joinWith(['user','test_exam']);
        // add conditions that should always apply here
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
        //$this->load($params);
        var_dump($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
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
            'ut_id' => $this->ut_id,
            'u_id' => $this->u_id,
            'te_id' => $this->te_id,
            'ut_mark' => $this->ut_mark,
            'ut_start_at' => $this->ut_start_at,
            'ut_finished_at' => $this->ut_finished_at,
        ]);

        $query->andFilterWhere(['like', 'ut_status', $this->ut_status])
                ->andFilterWhere(['like', 'ut_question_clone_ids', $this->ut_question_clone_ids])
                ->andFilterWhere(['like', 'ut_user_answer_ids', $this->ut_user_answer_ids]);

        return $dataProvider;
    }

}
