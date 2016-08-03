<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\components;

/**
 * This class is where all constants of the app should be define
 *
 */

class AppConstant
{

    // model common
    const MODEL_IS_DELETED_NOT_DELETED = 0;
    const MODEL_IS_DELETED_DELETED = 1;

    // user roles
    const USER_ROLE_USER = "USER";
    const USER_ROLE_ADMIN = "ADMIN";

    // test exam
    const TEST_EXAM_CATEGORY_PHP = 1;
    
    const TEST_EXAM_CATEGORY_NAME_PHP = "PHP";

    const TEST_EXAM_LEVEL_EASY = 1;

    // question
    const QUESTION_CATEGORY_PHP = 1;

    const QUESTION_CATEGORY_NAME_PHP = "PHP";

    const QUESTION_LEVEL_EASY = 1;

    const QUESTION_TYPE_SINGLE_ANSWER = 1;
    const QUESTION_TYPE_MULTIPLE_ANSWER = 2;
}
