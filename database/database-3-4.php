<?php
require "Database.php";
$database = new Database();

$database->query('SELECT * FROM posts WHERE id = :id' );
$database->bind(':id', 8);
$posts = $database->resultset();

$database->query('SELECT COUNT(id), country FROM customers GROUP BY country HAVING COUNT(id) > 1');
$customersCount = $database->resultset();

$database->query('SELECT orders.id, customers.name FROM orders INNER JOIN customers ON orders.customer_id = customers.id');
$innerjoinIDs = $database->resultset();

$database->query('SELECT customers.name, orders.id FROM customers LEFT JOIN orders ON customers.id = orders.customer_id ORDER by customers.name');
$leftouterIDs = $database->resultset();

$database->query('SELECT customers.name, orders.id FROM customers RIGHT JOIN orders ON customers.id = orders.customer_id ORDER by customers.name');
$rightouterIDs = $database->resultset();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-1</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>This select sql statement gets the post in posts table where id=30</h3>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Select * From posts WHERE id = 8</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Post</th>
                            <th>Created</th>
                            <th>Modified</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo $post['post']; ?></td>
                                <td><?php echo $post['created']; ?></td>
                                <td><?php echo $post['modified']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>This select sql statement lists the numbers of customers in each country with more than one customers</h3>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">SELECT COUNT(id), country FROM customers GROUP BY country HAVING COUNT(id) > 1</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Country</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($customersCount as $customerCount): ?>
                            <tr>
                                <td><?php echo $customerCount['COUNT(id)']; ?></td>
                                <td><?php echo $customerCount['country']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>This select sql statement selects order ID and customer name if there's an order's customer id</h3>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">SELECT orders.id, customers.name FROM orders INNER JOIN customers ON orders.customer_id = customers.id</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($innerjoinIDs as $innerjoinID): ?>
                            <tr>
                                <td><?php echo $innerjoinID['id']; ?></td>
                                <td><?php echo $innerjoinID['name']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>This select sql statement selects customer name and order id by left outer join that will show all the customer name and corresponding order id ordered by that customer if there is </h3>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">SELECT customers.name, orders.id FROM customers LEFT JOIN orders ON customers.id = orders.customer_id ORDER by customers.name</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">Name</th>
                            <th>ID</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($leftouterIDs as $leftouterID): ?>
                            <tr>
                                <td><?php echo $leftouterID['name']; ?></td>
                                <td><?php echo $leftouterID['id']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>This select sql statement selects customer name and order id by right outer join that will show all the orderi id and corresponding customer name ordered if there is </h3>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">SELECT customers.name, orders.id FROM customers RIGHT JOIN orders ON customers.id = orders.customer_id ORDER by customers.nam</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th class="hidden-xs">Name</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($rightouterIDs as $rightouterID): ?>
                            <tr>
                                <td><?php echo $rightouterID['id']; ?></td>
                                <td><?php echo $rightouterID['name']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div
    </div>
</div>
</body>
</html>