<?php
session_start();
include_once './config.php';
include_once './time.php';

$em = $_POST['email'];
$sql = "SELECT id, f_name, email, phone, password FROM users WHERE email = ?";



if ($stmt = $con->prepare($sql)) {
  $stmt->bind_param("s", $param_email);
  $param_email = $em;
  if ($stmt->execute()) {
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      ///for default password
      $stmt->bind_result($id, $f_name, $email, $phone, $password);
      if ($stmt->fetch()) {

        if ($email == $em) {
          $uid = $id;
          $length = 5;
          $otp = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, $length);
          $mobile = $phone;
          include_once('otp_send.php');

          $query = "INSERT INTO otp_expiry (uid, otp, is_expired,created_on)
                            VALUES ('$uid', '$otp', 0,'$time')";
          mysqli_query($con, $query);
          $otp_id = $con->insert_id;

          $msg = '<p><div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                    <strong>Success!</strong> Check your email or message for the OTP for verificaton.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div></p>
                        <audio autoplay><source src="success.mp3"></audio>
                        <script> 
                            setTimeout(function () {
                                location.replace("otp.php");
                            }, 2500);
                        </script>';

          $_SESSION['otp_id'] = $otp_id;
          $_SESSION['username'] = $f_name;
          $_SESSION['email'] = $email;
          $_SESSION['mobile'] = $mobile;
          $_SESSION['redirector_page'] = 'reset';
          $_SESSION['user_id'] = $uid;
          echo $msg;
        }
      }
    } else {
      echo '
            <audio autoplay><source src="error.mp3"></audio>
            <div class="alert alert-warning"><strong>Sorry!</strong> Invalid Email address.</div>';
    }
  } else {
    echo '
        <audio autoplay><source src="error.mp3"></audio>
        <div class="alert alert-warning"><strong>Sorry!</strong> Failed to execute, please try again later.</div>';
  }
}
