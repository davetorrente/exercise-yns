<?php
require "Database.php";

$database = new Database();
//
//$title = "My Post1";
//$body = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum";
//


/*INSERT
	$database->query('INSERT INTO posts (title, body) VALUES(:title, :body)');
	$database->bind(':title',$title);
	$database->bind(':body',$body);
	$database->execute();
*/



/*UPDATE

	$database->query('UPDATE posts SET body = :body WHERE id = :id');
	$database->bind(':body',$body);
	$database->bind(':id',1);
	$database->execute();

	$database->query('SELECT * FROM posts');
	$database->query('SELECT * FROM posts WHERE id = :id' );
	$database->bind(':id', 1);
*/


$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(isset($_POST['delete']))
{
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
}

if(isset($postform['submit']))
{
    $post = $postform['post'];

    $database->query('INSERT INTO posts (post) VALUES(:post)');
    $database->bind(':post',$post);
    $database->execute();
     if($database->lastInsertId())
     {
     	echo 'SUCCESS!';
     }
}

//$database->query('SELECT * FROM posts ');
//
//$rows = $database->resultset();
//
//?>

<h1>Add Post</h1>
<form method='post' action='<?php $_SERVER['PHP_SELF']; ?>'>
    <label>Post Body</label><br/>
    <textarea name="post"></textarea><br/><br/>
    <input type="submit" name="submit" value="Submit"/>
</form>


<h1>Posts</h1>
<div>
<!--    --><?php
//    $compname = "dave";
//    foreach($rows as $row) :
//        ?>
<!--        <h3><a href="getphp.php?value_key=--><?php //echo $row['id']; ?><!--">--><?php //echo $row['title']; ?><!--</a></h3>-->
<!--        <p>--><?php //echo $row['body']; ?><!--</p>-->
<!--        <form method="post" action="--><?php //$_SERVER['PHP_SELF']; ?><!--">-->
<!--            <input type="hidden" name="delete_id" value="--><?php //echo $row['id']; ?><!--" />-->
<!--            <input type="submit" name="delete" value="Delete"/>-->
<!--        </form>-->
<!--        --><?php
//    endforeach;
//    ?>

</div>