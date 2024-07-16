// secure.php
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// User is authenticated, proceed with your application logic
