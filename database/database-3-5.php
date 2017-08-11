<?php
require "Database.php";
$database = new Database();
// problem# 1
$database->query("SELECT * FROM employees WHERE last_name LIKE 'K%'");
$employeesStartLastNames = $database->resultset();
// problem# 2
$database->query("SELECT * FROM employees WHERE last_name LIKE '%i'");
$employeesEndLastNames = $database->resultset();
// problem# 3
$database->query("SELECT first_name, last_name, middle_name, hire_date FROM employees WHERE hire_date BETWEEN '2015/1/1' AND '2015/3/31' ORDER by hire_date ASC");
$employeeshireDates = $database->resultset();

// problem# 4
$database->query("SELECT last_name, boss_id FROM employees WHERE boss_id IS NOT NULL");
$employeesWithBosses = $database->resultset();

// problem# 5
$database->query('SELECT last_name FROM employees INNER JOIN departments ON employees.department_id = departments.id WHERE employees.department_id=3 ORDER by employees.last_name DESC');
$employeesBelongToSalesdeps = $database->resultset();
// problem# 6
$database->query("SELECT COUNT(1)FROM employees WHERE middle_name IS NOT NULL");
$employeesWithMiddleNames = $database->resultset();
// problem# 7
$database->query("SELECT D.name, COUNT(D.name) FROM departments D INNER JOIN employees E ON E.department_id = D.id GROUP BY D.id");
$employeesNumbersinDeps = $database->resultset();
// problem# 8
$database->query("SELECT first_name, last_name, middle_name, hire_date FROM employees ORDER BY hire_date DESC LIMIT 1;");
$employeesNameAndHired = $database->resultset();
//problem# 9
$database->query('SELECT D.name FROM departments D LEFT JOIN employees E on D.id = E.department_id WHERE E.department_id IS NULL');
$departmentNoEmployees = $database->resultset();

//problem# 10
$database->query("SELECT E.first_name, E.last_name, E.middle_name FROM employees E INNER JOIN employee_positions EP ON EP.employee_id = E.id GROUP BY E.first_name, E.last_name, E.middle_name HAVING COUNT(EP.id) >= 2;");
$employeesNameMorePositions = $database->resultset();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>database-3-5</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">1.) Retrieve employees whose last name start with "K"</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Department ID</th>
                            <th>Hire Date</th>
                            <th>Boss ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesStartLastNames as $employeesStartLastName): ?>
                        <tr>
                            <td><?php echo $employeesStartLastName['id']; ?></td>
                            <td><?php echo $employeesStartLastName['first_name']; ?></td>
                            <td><?php echo $employeesStartLastName['last_name']; ?></td>
                            <td><?php echo $employeesStartLastName['middle_name']; ?></td>
                            <td><?php echo $employeesStartLastName['department_id']; ?></td>
                            <td><?php echo $employeesStartLastName['hire_date']; ?></td>
                            <td><?php echo $employeesStartLastName['boss_id']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">2.) Retrieve employees whose last name ends with "i"</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Department ID</th>
                            <th>Hire Date</th>
                            <th>Boss ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesEndLastNames as $employeesEndLastName): ?>
                            <tr>
                                <td><?php echo $employeesEndLastName['id']; ?></td>
                                <td><?php echo $employeesEndLastName['first_name']; ?></td>
                                <td><?php echo $employeesEndLastName['last_name']; ?></td>
                                <td><?php echo $employeesEndLastName['middle_name']; ?></td>
                                <td><?php echo $employeesEndLastName['department_id']; ?></td>
                                <td><?php echo $employeesEndLastName['hire_date']; ?></td>
                                <td><?php echo $employeesEndLastName['boss_id']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">3.) Retrieve employee's full name and their hire date whose hire date is between 2015/1/1 and 2015/3/31 ordered by ascending by hire date.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Hire Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeeshireDates as $employeeshireDate): ?>
                            <tr>
                                <td><?php echo $employeeshireDate['first_name']; ?></td>
                                <td><?php echo $employeeshireDate['last_name']; ?></td>
                                <td><?php echo $employeeshireDate['middle_name']; ?></td>
                                <td><?php echo $employeeshireDate['hire_date']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">4.) Retrieve employee's last name and their boss's last name. If they don't have boss, no need to retrieve and show.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>Last Name of BOSS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesWithBosses as $employeesWithBoss): ?>
                            <tr>
                                <td><?php echo $employeesWithBoss['last_name']; ?></td>
                                <?php $bossID = $employeesWithBoss['boss_id']; ?>
                                <?php  $database->query("SELECT last_name FROM employees WHERE id = :id");
                                $database->bind(':id', $bossID);
                                $employeesbossLastNames = $database->resultset();
                                foreach($employeesbossLastNames as $employeesbossLastName): ?>
                                    <td><?php echo $employeesbossLastName['last_name']; ?></td>
                                <?php endforeach ?>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">5.) Retrieve employee's last name who belong to Sales department ordered by descending by last name.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Last Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesBelongToSalesdeps as $employeesBelongToSalesdep): ?>
                        <tr>
                            <td><?php echo $employeesBelongToSalesdep['last_name']; ?></td>
                            <?php endforeach ?>
                        </tr>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">6.) Retrieve number of employee who has middle name.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>COUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesWithMiddleNames as $employeesWithMiddleName): ?>
                            <tr>
                                <td><?php echo $employeesWithMiddleName['COUNT(1)']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">7.) Retrieve department name and number of employee in each department. You don't need to retrieve the department name which doesn't have employee.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Employee Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesNumbersinDeps as $employeesNumbersinDep): ?>
                            <tr>
                                <td><?php echo $employeesNumbersinDep['name']; ?></td>
                                <td><?php echo $employeesNumbersinDep['COUNT(D.name)']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">8.) Retrieve employee's full name and hire date who was hired the most recently.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Hire Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesNameAndHired as $employeesNameAndHire): ?>
                            <tr>
                                <td><?php echo $employeesNameAndHire['first_name']; ?></td>
                                <td><?php echo $employeesNameAndHire['last_name']; ?></td>
                                <td><?php echo $employeesNameAndHire['middle_name']; ?></td>
                                 <td><?php echo $employeesNameAndHire['hire_date']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">9.) Retrieve department name which has no employee..</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($departmentNoEmployees as $departmentNoEmployee): ?>
                            <tr>
                                <td><?php echo $departmentNoEmployee['name']; ?></td>
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
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">10.) Retrieve employee's full name who has more than 2 positions.</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeesNameMorePositions as $employeesNameMorePosition): ?>
                            <tr>
                                <td><?php echo $employeesNameMorePosition['first_name']; ?></td>
                                <td><?php echo $employeesNameMorePosition['last_name']; ?></td>
                                <td><?php echo $employeesNameMorePosition['middle_name']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>