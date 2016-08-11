use chang_dev;

INSERT INTO `question` (`q_id`, `q_category`, `q_level`, `q_type`, `q_content`, `q_created_date`, `q_updated_date`, `q_is_deleted`) VALUES
(1, 1, 2, 1, 'Question 1: What is your name?', '2016-07-26 00:00:00', '2016-07-26 00:00:00', 0),
(2, 2, 1, 2, 'Question 2: How old are you?\r\n$referenceTable = array();\r\n$referenceTable[''val1''] = array(1, 2);\r\n$referenceTable[''val2''] = 3;\r\n$referenceTable[''val3''] = array(4, 5);\r\n\r\n$testArray = array();\r\n\r\n$testArray = array_merge($testArray, $referenceTable[''val1'']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[''val2'']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[''val3'']);\r\nvar_dump($testArray);', '2016-07-19 00:00:00', '2016-07-19 00:00:00', 0),
(3, 1, 2, 2, '$x = 5;\r\necho $x;\r\necho "<br />";\r\necho $x+++$x++;\r\necho "<br />";\r\necho $x;\r\necho "<br />";\r\necho $x---$x--;\r\necho "<br />";\r\necho $x;', '2016-07-04 00:00:00', '2016-07-13 00:00:00', 0);
