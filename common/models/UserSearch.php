<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\lib\logic\UserLogic;

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
            [['u_id', 'is_deleted'], 'integer'],
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
}
