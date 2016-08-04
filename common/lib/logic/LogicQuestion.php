<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\logic;

use yii\helpers\ArrayHelper;
use common\models\Question;
use common\models\QuestionTag;
use common\lib\components\AppConstant;

/**
 * This is base class of Logic layer
 * all other logic class should extend this class
 *
 */

class LogicQuestion extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getQuestionBySearch($params)
    {
        $questionQuery = Question::query();

        if($params)
        {
            $q_content = $params['content'];
            $q_category = $params['category'];
            $q_type = $params['type'];
            $qt_content = $params['qt_content'];
            $q_level = $params['level'];

            if ($q_content != null) {
                $questionQuery->andWhere(['like', 'q_content', $q_content]);
            }
            if ($q_category != null) {
                $questionQuery->andWhere(['q_category' => $q_category]);
            }
            if ($q_type != null) {
                $questionQuery->andWhere(['q_type' => $q_type]);
            }
            if($q_level != null) {
                $questionQuery->andWhere(['q_level' => $q_level]);
            }
            if($qt_content != null) {
                $tagNames = explode(',', $qt_content);
                $tag_ids = array_keys(array_filter(AppConstant::$QUESTION_TAG_NAME, function($v, $k) use ($tagNames) {
                    return in_array(strtolower($v), $tagNames);
                }, ARRAY_FILTER_USE_BOTH));
                $qtags = QuestionTag::query()->andWhere(['IN', 'tag_id', $tag_ids])->all();
                $q_ids = ArrayHelper::getColumn($qtags, 'q_id');

                $questionQuery->andWhere(['IN', 'q_id', $q_ids]);
            }
        }
        $questions = $questionQuery->all();

        return $questions;
    }

    public function findQuestionById($q_id)
    {
        return Question::queryOne($q_id);
    }
}
