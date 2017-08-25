<?php
require 'Database.php';
$database = new Database();

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $database->query("SELECT username FROM users where username = '$query'");
    $username= $database->resultset();
    echo json_encode ($username);
}
if (isset($_POST['search'])) {

//Search box value assigning to $Name variable.

    $Name = $_POST['search'];

//Search query.
    $database->query("SELECT username FROM users where username LIKE'%$Name%'");
    $usernames = $database->resultset();

//Creating unordered list to display result.

    echo '
 
        <ul>
 
   ';
    foreach($usernames as $username): ?>
    <li onclick='fill("<?php echo $username['username']; ?>")'>
        <a href="micro-profile.php?username=<?php echo htmlspecialchars($username['username']); ?>">

            <!-- Assigning searched result in "Search box" in "search.php" file. -->

            <?php echo $username['username']; ?>

    </li></a>
    <?php endforeach;
    //Fetching result from database.



}