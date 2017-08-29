<?php
require 'Database.php';
$database = new Database();

if (isset($_POST['search'])) {

//Search box value assigning to $Name variable.

    $Name = $_POST['search'];

//Search query.
    $database->query("SELECT username FROM users where username LIKE'%$Name%'");
    $usernames = $database->resultset();
    echo json_encode(array("query" => $usernames));
}