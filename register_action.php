<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include_once('config.php');
include_once('time.php');

$f_name = $l_name = $email = $phone = $file = $password = "";
$image_err  = $login_err = "";

$f_name = trim(strtoupper($_POST['f_name']));
$l_name = trim(strtoupper($_POST['l_name']));
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
//$file = file_get_contents($_FILES['file']['tmp_name']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//'$file', image, 

$record1 = mysqli_query($con, "SELECT COUNT(*) AS count FROM users");
$row1 = mysqli_fetch_array($record1);
$status = ($row1['count'] == 0) ? 1 : 2;

$role = $_POST['role'];
$record = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
$row = mysqli_fetch_array($record);
if ($row == "") {
    $query = "INSERT INTO users (f_name, l_name, email, phone, password, role, status)
            VALUES ('$f_name','$l_name', '$email', '$phone', '$password', '$role', '$status')";
    mysqli_query($con, $query);

    $_SESSION['message'] = '<p><div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <strong>Success!</strong> Your  account has been created. Now you can login.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div></p>';

    $_SESSION['username'] = $l_name;
    $_SESSION['email'] = $email;
    $_SESSION['reset_status'] = 0;
    echo '<script> location.replace("index"); </script>';
} else {
    echo '<div class="alert alert-warning"><strong>Sorry!</strong> Email address is already registered.</div>';
}
