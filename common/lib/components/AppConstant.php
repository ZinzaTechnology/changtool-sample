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

    // question
    const QUESTION_CATEGORY_PHP = 1001;
    const QUESTION_CATEGORY_C_CPP = 1002;
    const QUESTION_CATEGORY_JAVA = 1003;
    const QUESTION_CATEGORY_CS = 1004;

    public static $QUESTION_CATEGORY_NAME = array(
        self::QUESTION_CATEGORY_PHP => "PHP",
        self::QUESTION_CATEGORY_C_CPP => "C/C++",
        self::QUESTION_CATEGORY_JAVA => "JAVA",
        self::QUESTION_CATEGORY_CS => "C#",
    );

    const QUESTION_LEVEL_INTERMEDIATE = 1;
    const QUESTION_LEVEL_HARD = 2;

    public static $QUESTION_LEVEL_NAME = array(
        self::QUESTION_LEVEL_INTERMEDIATE => "Intermediate",
        self::QUESTION_LEVEL_HARD => "Hard",
    );

    const QUESTION_TYPE_SINGLE_ANSWER = 1;
    const QUESTION_TYPE_MULTIPLE_ANSWER = 2;

    public static $QUESTION_TYPE_NAME = array(
        self::QUESTION_TYPE_SINGLE_ANSWER => "Single answer",
        self::QUESTION_TYPE_MULTIPLE_ANSWER => "Multiple answer",
    );

    const QUESTION_TAG_LANGUAGE = 1101;
    const QUESTION_TAG_DB = 1102;
    const QUESTION_TAG_FRAMEWORK = 1103;
    const QUESTION_TAG_CODE_OUTPUT = 1104;
    const QUESTION_TAG_CODE_INPUT = 1105;
    const QUESTION_TAG_LOGIC = 1106;

    public static $QUESTION_TAG_NAME = array(
        self::QUESTION_TAG_LANGUAGE => "language",
        self::QUESTION_TAG_DB => "db",
        self::QUESTION_TAG_FRAMEWORK => "framework",
        self::QUESTION_TAG_CODE_OUTPUT => "code output",
        self::QUESTION_TAG_CODE_INPUT => "code input",
        self::QUESTION_TAG_LOGIC => "logic",
    );

    // test exam
    const TEST_EXAM_CATEGORY_PHP = 1;
    
    const TEST_EXAM_CATEGORY_NAME_PHP = "PHP";

    const TEST_EXAM_LEVEL_EASY = 1;

}
