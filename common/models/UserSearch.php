<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * TestSearch represents the model behind the search form about `app\models\Test`.
 */
class UserSearch extends User
{
	public $globalSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'u_is_deleted'], 'integer'],
            [['u_name', 'globalSearch', 'u_mail', 'u_fullname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
	
//    public function search($params)
//    {
//    	
//    	$query = User::find();
//    	
//    	$dataProvider = new ActiveDataProvider([
//    			'query' => $query,
//    			]);
//    	
//    	if(!($this->load($params) && $this->validate()))
//    	{
//    		return $dataProvider;	
//    	}
//    	
//    	/*$query->andFilterWhere([
//    		'u_id' => $this->u_id,
//    		]);*/
//    	//$query->andFilterWhere(['id' => $this->u_id]);
//    	$query->orFilterWhere(['like', 'u_name', $this->globalSearch])
//    		->orFilterWhere(['like', 'u_fullname', $this->globalSearch])
//    		->orFilterWhere(['like', 'u_mail', $this->globalSearch]);
//    	return $dataProvider;
//    	
//    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */ 
    
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }
		
        $query->orFilterWhere(['like', 'u_name', $this->globalSearch])
            ->orFilterWhere(['like', 'u_mail', $this->globalSearch])
            ->orFilterWhere(['like', 'u_fullname', $this->globalSearch]);
		$query->andFilterWhere([
            'u_is_deleted' => $this->u_is_deleted,
        ]);
        return $dataProvider;
    }
    
}
