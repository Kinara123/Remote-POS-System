<?php
session_start();
require_once "config.php";
require_once "time.php";
require_once "boot.php";
$action = 'Logged out.';
require_once "log.php";

session_destroy();

// Redirect to the login page:
echo '<script> location.replace("index"); </script>';
//header('Location: index.php');
exit();