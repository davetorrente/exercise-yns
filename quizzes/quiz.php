<?php
session_start();
if (!isset($_SESSION['authUser']))
    header("Location: quiz-login.php");

echo "HELLO";