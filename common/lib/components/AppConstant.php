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
    const USER_ROLE_USER = 'USER';
    const USER_ROLE_ADMIN = 'ADMIN';

    // question
    const QUESTION_ANSWERS_LIMIT = 4;

    const QUESTION_CATEGORY_PHP = 1001;
    const QUESTION_CATEGORY_C_CPP = 1002;
    const QUESTION_CATEGORY_JAVA = 1003;
    const QUESTION_CATEGORY_CS = 1004;
    const QUESTION_CATEGORY_HTML_CSS = 1005;
    const QUESTION_CATEGORY_JAVASCRIPT = 1006;
    const QUESTION_CATEGORY_SQL = 1007;
    const QUESTION_CATEGORY_TESTING = 1008;
    
    public static $QUESTION_CATEGORY_NAME = [
        self::QUESTION_CATEGORY_PHP => 'PHP',
        self::QUESTION_CATEGORY_C_CPP => 'C/C++',
        self::QUESTION_CATEGORY_JAVA => 'JAVA',
        self::QUESTION_CATEGORY_CS => 'C#',
        self::QUESTION_CATEGORY_HTML_CSS => "HTML/CSS",
        self::QUESTION_CATEGORY_JAVASCRIPT => "Javascript",
        self::QUESTION_CATEGORY_SQL => "SQL",
        self::QUESTION_CATEGORY_TESTING => "Testing",
    ];

    const QUESTION_LEVEL_INTERMEDIATE = 1;
    const QUESTION_LEVEL_HARD = 2;

    public static $QUESTION_LEVEL_NAME = [
        self::QUESTION_LEVEL_INTERMEDIATE => 'Intermediate',
        self::QUESTION_LEVEL_HARD => 'Hard',
    ];

    const QUESTION_TYPE_SINGLE_ANSWER = 1;
    const QUESTION_TYPE_MULTIPLE_ANSWER = 2;

    public static $QUESTION_TYPE_NAME = [
        self::QUESTION_TYPE_SINGLE_ANSWER => 'Single answer',
        self::QUESTION_TYPE_MULTIPLE_ANSWER => 'Multiple answer',
    ];

    const QUESTION_TAG_LANGUAGE = 1101;
    const QUESTION_TAG_DB = 1102;
    const QUESTION_TAG_FRAMEWORK = 1103;
    const QUESTION_TAG_CODE_OUTPUT = 1104;
    const QUESTION_TAG_CODE_INPUT = 1105;
    const QUESTION_TAG_LOGIC = 1106;

    public static $QUESTION_TAG_NAME = [
        self::QUESTION_TAG_LANGUAGE => 'language',
        self::QUESTION_TAG_DB => 'db',
        self::QUESTION_TAG_FRAMEWORK => 'framework',
        self::QUESTION_TAG_CODE_OUTPUT => 'code output',
        self::QUESTION_TAG_CODE_INPUT => 'code input',
        self::QUESTION_TAG_LOGIC => 'logic',
    ];

    // answer
    const ANSWER_STATUS_WRONG = 0;
    const ANSWER_STATUS_RIGHT = 1;

    public static $ANSWER_STATUS_NAME = [
        self::ANSWER_STATUS_WRONG => 'Wrong',
        self::ANSWER_STATUS_RIGHT => 'Right'
    ];

    // test exam
    const TEST_EXAM_CATEGORY_PHP = 1001;
    const TEST_EXAM_CATEGORY_C_CPP = 1002;
    const TEST_EXAM_CATEGORY_JAVA = 1003;
    const TEST_EXAM_CATEGORY_CS = 1004;
    const TEST_EXAM_CATEGORY_HTML_CSS = 1005;
    const TEST_EXAM_CATEGORY_JAVASCRIPT = 1006;
    const TEST_EXAM_CATEGORY_SQL = 1007;
    const TEST_EXAM_CATEGORY_TESTING = 1008;

    public static $TEST_EXAM_CATEGORY_NAME = [
        self::TEST_EXAM_CATEGORY_PHP => 'PHP',
        self::TEST_EXAM_CATEGORY_C_CPP => 'C/C++',
        self::TEST_EXAM_CATEGORY_JAVA => 'JAVA',
        self::TEST_EXAM_CATEGORY_CS => 'C#',
        self::TEST_EXAM_CATEGORY_HTML_CSS => "HTML/CSS",
        self::TEST_EXAM_CATEGORY_JAVASCRIPT => "Javascript",
        self::TEST_EXAM_CATEGORY_SQL => "SQL",
        self::TEST_EXAM_CATEGORY_TESTING => "Testing",
    ];

    const TEST_EXAM_LEVEL_EASY = 1;
    const TEST_EXAM_LEVEL_INTERMEDIATE = 2;
    const TEST_EXAM_LEVEL_HARD = 3;

    const TEST_EXAM_EASY_PERCENT_QUESTION_INTERMEDIATE = 75;
    const TEST_EXAM_MEDIUM_PERCENT_QUESTION_INTERMEDIATE = 50;
    const TEST_EXAM_HARD_PERCENT_QUESTION_INTERMEDIATE = 25;
    
    public static $TEST_EXAM_LEVEL_NAME = [
        self::TEST_EXAM_LEVEL_EASY => 'Easy',
        self::TEST_EXAM_LEVEL_INTERMEDIATE => 'Intermediate',
        self::TEST_EXAM_LEVEL_HARD => 'Hard',
    ];
    
    // user test
    const USER_TEST_ASSIGNED = 'ASSIGNED';
    const USER_TEST_DONE = 'DONE';
    const USER_TEST_DOING = 'DOING';
    const USER_TEST_QUESTION_LIMIT_PER_PAGE = 5;
    public static $USER_TEST_STATUS = [
        self::USER_TEST_ASSIGNED => self::USER_TEST_ASSIGNED,
        self::USER_TEST_DOING => self::USER_TEST_DOING,
        self::USER_TEST_DONE => self::USER_TEST_DONE
    ];
    const USER_TEST_TOLERANT_TIME = -10; // tolerate test submission after a certain amount of time

    /*
      * Define error
      */
    const ERROR_OK = 0;
    const ERROR_SESSION_EMPTY = 1;
    const ERROR_CAN_NOT_SAVE_TESTEXAM_TO_DB = 2;
    const ERROR_QUESTION_NOT_EXIST_IN_TESTEXAM = 3;
    const ERROR_CAN_NOT_INSERT_TESTEXAM_QUESTIONS_TO_DB = 4;
    const ERROR_CAN_NOT_DELETE_TESTEXAM_QUESTIONS_FROM_DB = 5;
    const ERROR_CAN_NOT_EDIT_TWO_TESTEXAM_AT_THE_SAMETIME = 6;
    
     /*
      * Define paging
      */
     // Const variable
    const PAGING_INDEX_PAGE_SIZE = 10;
    const PAGING_VIEW_PAGE_SIZE = 10;
    const PAGING_UPDATE_PAGE_SIZE = 10;
    const PAGING_ADD_QUESTION_PAGE_SIZE = 10;
}
