<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
$sqlUsers = "CREATE TABLE IF NOT ExISTS users (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(30) NOT NULL,
description VARCHAR(255) NOT NULL,
phone VARCHAR(255) NOT NULL,
country VARCHAR(30) NOT NULL,
created DATETIME DEFAULT CURRENT_TIMESTAMP,
gender  enum('male','female') DEFAULT NULL,
upload TEXT NOT NULL
)";

$sqlPosts = "CREATE TABLE IF NOT ExISTS posts (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
post VARCHAR(255) NOT NULL,
created DATETIME NULL,
modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$sqlCustomers = "CREATE TABLE IF NOT ExISTS customers (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL,
country VARCHAR(255) NOT NULL
)";
$sqlDepartments = "CREATE TABLE IF NOT ExISTS departments (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL
)";
$sqlEmployees = "CREATE TABLE IF NOT ExISTS employees (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
middle_name VARCHAR(255) DEFAULT NULL,
department_id int(11) NOT NULL,
hire_date DATE NULL,
boss_id int(11) NULL
)";

$sqlEmployeepositions = "CREATE TABLE IF NOT ExISTS employee_positions (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
employee_id int(11) NOT NULL,
position_id int(11) NOT NULL
)";

$sqlOrders = "CREATE TABLE IF NOT ExISTS orders (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
customer_id int(11) NOT NULL,
order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
order_name VARCHAR(255) NOT NULL
)";

$sqlPositions = "CREATE TABLE IF NOT ExISTS positions (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL
)";

$sqlQuestions = "CREATE TABLE IF NOT ExISTS questions (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
question TEXT NOT NULL,
created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
$sqlAnswers = "CREATE TABLE IF NOT ExISTS answers (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
answer1 VARCHAR (255) NOT NULL,
answer2 VARCHAR(255) NOT NULL,
answer3 VARCHAR(255) NOT NULL,
answer VARCHAR(255) NOT NULL,
question_id INT(11) NOT NULL,
created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$sqlGrades = "CREATE TABLE IF NOT ExISTS grades (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
user_id INT(11) NOT NULL,
score INT(11) NULL,
created DATETIME NULL,
modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$sqlTweets = "CREATE TABLE IF NOT ExISTS tweets (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
tweet TEXT NOT NULL,
user_id INT(11) NOT NULL,
created DATETIME NULL,
modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$sqlFollows = "CREATE TABLE IF NOT ExISTS follows (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
user_id INT(11) NOT NULL,
follow_id INT(11) NOT NULL,
isFollow BOOLEAN DEFAULT 0,
created DATETIME NULL,
modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$sqlRetweets = "CREATE TABLE IF NOT ExISTS retweets (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
tweet_id INT(11) NOT NULL,
user_id INT(11) NOT NULL,
retweet TEXT NOT NULL,
isRetweet BOOLEAN DEFAULT 0,
created DATETIME NULL,
modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$database->query($sqlUsers);
$database->execute();
$database->query($sqlPosts);
$database->execute();
$database->query($sqlCustomers);
$database->execute();
$database->query($sqlDepartments);
$database->execute();
$database->query($sqlEmployees);
$database->execute();
$database->query($sqlEmployeepositions);
$database->execute();
$database->query($sqlOrders);
$database->execute();
$database->query($sqlPositions);
$database->execute();
$database->query($sqlQuestions);
$database->execute();
$database->query($sqlAnswers);
$database->execute();
$database->query($sqlGrades);
$database->execute();
$database->query($sqlTweets);
$database->execute();
$database->query($sqlFollows);
$database->execute();
$database->query($sqlRetweets);
$database->execute();

$sqlInsertPosts = ("INSERT IGNORE INTO `posts` (`id`, `post`, `created`) VALUES
(1, 'dummy1', '$datetime'),
(2, 'dummy2', '$datetime'),
(3, 'dummy3', '$datetime'),
(4, 'dummy4', '$datetime'),
(5, 'dummy5', '$datetime'),
(6,  'dummy6', '$datetime'),
(7, 'dummy7', '$datetime'),
(8, 'dummy8', '$datetime'),
(9, 'dummy9', '$datetime'),
(10, 'dummy10', '$datetime');");
$database->query($sqlInsertPosts);
$database->execute();

$sqlInsertCustomers = ("INSERT IGNORE INTO `customers` (`id`, `name`, `country`) VALUES
(1, 'Dave', 'Philippines'),
(2, 'Robert', 'Brazil'),
(3, 'joe', 'France'),
(4, 'randy', 'brazil'),
(5, 'jomar', 'USA'),
(6, 'Albert', 'USA'),
(7, 'Ivy', 'Germany'),
(8, 'Sandra', 'Germany'),
(9, 'Digong', 'France'),
(10, 'Sheila', 'Brazil');
");
$database->query($sqlInsertCustomers);
$database->execute();

$sqlInsertDepartments = ("INSERT IGNORE INTO `departments` (`id`, `name`) VALUES
(1, 'Exective'),
(2, 'Admin'),
(3, 'Sales'),
(4, 'Development'),
(5, 'Design'),
(6, 'Marketing');");
$database->query($sqlInsertDepartments);
$database->execute();

$sqlInsertEmployees = ("INSERT IGNORE INTO `employees` (`id`, `first_name`, `last_name`, `middle_name`, `department_id`, `hire_date`, `boss_id`) VALUES
(1, 'Manabu', 'Yamazak', NULL, 1, NULL, NULL),
(2, 'Tomohiko', 'Takasago', NULL, 3, '2014-04-01', 1),
(3, 'Yuta', 'Kawakami', NULL, 4, '2014-04-01', 1),
(4, 'Shogo', 'Kubota', NULL, 4, '2014-12-01', 1),
(5, 'Lorraine ', 'San Jose', 'P.', 2, '2015-03-10', 1),
(6, 'Haille', 'Dela Cruz', 'A.', 3, '2015-02-15', 2),
(7, 'Godfrey', 'Sarmenta', 'L.', 4, '2015-01-01', 1),
(8, 'Alex', 'Amistad', 'F.', 4, '2015-04-10', 1),
(9, 'Hideshi', 'Ogoshi', NULL, 5, '2015-08-06', 1),
(10, 'Kim', '', NULL, 5, '2015-08-06', 1);");
$database->query($sqlInsertEmployees);
$database->execute();
$sqlInsertEmployeePositions = ("INSERT IGNORE INTO `employee_positions` (`id`, `employee_id`, `position_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 3, 5),
(6, 4, 5),
(7, 5, 5),
(8, 6, 5),
(9, 7, 5),
(10, 8, 5),
(11, 9, 5),
(12, 10, 5);");
$database->query($sqlInsertEmployeePositions);
$database->execute();

$sqlInsertOrders = "INSERT IGNORE INTO `orders` (`id`, `customer_id`, `order_date`, `order_name`) VALUES
(1, 1, '2017-08-10 03:02:58', 'Nike'),
(2, 2, '2017-08-10 03:04:58', 'Adidas'),
(3, 1, '2017-08-10 03:01:09', 'Nike'),
(4, 8, '2017-08-10 03:01:09', 'Adidas'),
(5, 99, '2017-08-10 04:51:14', 'FILA');";

$database->query($sqlInsertOrders);
$database->execute();
$nAme = '$nAme';
$sqlInsertQuestions = "INSERT IGNORE INTO `questions` (`id`, `question`) VALUES
(1, 'Which class name is generic empty reserved in PHP?'),
(2, 'Which of the functions is used to sort an array in descending order?'),
(3, 'Which is invalid variable?'),
(4, 'Which is a global array in php'),
(5, 'Which one of the following statements is used to create a table?'),
(6, 'Which one is correct syntax for Where clause in SQL server?'),
(7, 'Which of the following methods is used to execute the statement after the parameters have been bound?'),
(8, 'Which one of the following keyword is used to inherit our subclass into a superclass?'),
(9, 'If your object must inherit behavior from a number of sources you must use a/an'),
(10, 'Which one of the following methods is responsible for sending the query to the database?');";

$database->query($sqlInsertQuestions);
$database->execute();
$Name = '$'."Name";
$_name = '$'."_name";
$_REQUEST = '$'."_REQUEST";
$POST = '$'."POST";
$GET = '$'."GET";
$obj = '$'."obj";
$foo = '$'."foo";

$sqlInsertAnswers = "INSERT IGNORE INTO `answers` (`id`, `answer1`, `answer2`, `answer3`, `answer`, `question_id`) VALUES
(1, 'nameClass', 'stdClass', ' newClass', 'stdClass', 1),
(2, 'sort()', 'rsort()', ' asort()', 'rsort()', 2),
(3, '$2name', '$Name', '$_name', '$2name', 3),
(4, '$POST', '$GET', '$_REQUEST', '$_REQUEST', 4),
(5, 'CREATE TABLE table_name (column_name column_type);', 'CREATE table_name (column_name column_type);', 'CREATE table_name (column_type column_name);', 'CREATE TABLE table_name (column_name column_type);', 5),
(6, 'SELECT WHERE Col1, Col2 FROM;	', 'SELECT Col1, Col2 FROM WHERE;', 'SELECT Col1 + Col2 FROM WHERE;', 'SELECT Col1, Col2 FROM WHERE;', 6),
(7, 'bind_param()', 'bound_param()', 'bind_result()', 'bind_param()', 7),
(8, 'Extends', 'Inherits', 'implements', 'Extends', 8),
(9, 'static class', 'Interface', 'Object', 'Interface', 9),
(10, 'query()', 'send_query()', 'query_send()', 'query()', 10);";
$database->query($sqlInsertAnswers);
$database->execute();


echo "SUCCESS CREATING users, posts, customers, departments, employees, employee_positions, orders, positions, questions, answers, grades, tweets, follows, retweets" . "<br/>";
$database->query($sqlAnswers);
$database->execute();
$database->query($sqlGrades);
$database->execute();
$database->query($sqlTweets);
$database->execute();
$database->query($sqlFollows);
$database->execute();
$database->query($sqlRetweets);