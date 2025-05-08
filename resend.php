<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once "./config.php";
require_once "./time.php";
$otp_id = $_SESSION['otp_id'];
$email = $_SESSION['email'];

$length = 5;
$otp = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, $length);
mysqli_query($con, "UPDATE otp_expiry SET is_expired=0 , otp = '$otp', created_on= '$time' WHERE id='$otp_id'");

include_once('otp_send.php');

echo '
    <div class="alert alert-success">
        Success!</strong> Check your phone message or email, a new OTP password has been sent.
    </div>
    <audio autoplay><source src="success.mp3"></audio>';
