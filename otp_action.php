<?php
session_start();
require_once "config.php";
require_once "time.php";
$otp_id = $_SESSION['otp_id'];
$email = $_SESSION['email'];
$redirector_page = $_SESSION['redirector_page'];


$active_userID = $_SESSION['user_id'];
$active_username = $_SESSION['username'];


$otp = trim($_POST['otp']);
$record = mysqli_query($con, "SELECT * FROM otp_expiry WHERE id='$otp_id' AND otp='$otp'");
$row = mysqli_fetch_array($record);
if ($row != "") {

  $record = mysqli_query($con, "SELECT * FROM otp_expiry WHERE created_on > date_sub(now(), interval 8 minute) AND id='$otp_id'");
  $row = mysqli_fetch_array($record);
  if ($row != "") {
    if ($redirector_page == "reset") {
      mysqli_query($con, "UPDATE otp_expiry SET is_expired=1 WHERE id='$otp_id'");
      unset($_SESSION['otp_id']);
      $_SESSION['message'] = "";
      $_SESSION["reset"] = true;
      echo '<script> location.replace("new-password.php"); </script>';
    } else {
      $action = 'Logged In.';
      mysqli_query($con, "UPDATE otp_expiry SET is_expired=1 WHERE id='$otp_id'");
      unset($_SESSION['otp_id']);
      $_SESSION['message'] = "";
      $_SESSION["loggedin"] = true;
      require_once "log.php";
      echo '<script> location.replace("app/admin"); </script>';
    }
  } else {
    mysqli_query($con, "UPDATE otp_expiry SET is_expired=1 WHERE id='$otp_id'");
    echo '
            <audio autoplay><source src="error.mp3"></audio>
            <div class="alert alert-warning"> 
                <strong>Sorry! </strong>OTP Verification code has expired, please click on the "Resend OTP?" link below to receive another code.
            </div>';
  }
} else {
  echo '
    <audio autoplay><source src="error.mp3"></audio>
    <div class="alert alert-danger">
        <strong>Sorry!</strong> Invalid otp verification code.
    </div>';
}
