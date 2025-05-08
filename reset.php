<?php
session_start();
include_once './config.php';
include_once './time.php';

$uid = $_POST['uid'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$sql = "SELECT id, f_name, email, phone, password FROM users WHERE id = ?";
mysqli_query($con, "UPDATE users SET password='$password' WHERE id='$uid'");


if ($stmt = $con->prepare($sql)) {
  $stmt->bind_param("s", $param_uid);
  $param_uid = $uid;
  if ($stmt->execute()) {
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      ///for default password
      $stmt->bind_result($id, $f_name, $email, $phone, $password);
      $stmt->fetch();
    }
  }
}

$msg = '<p><div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <strong>Success!</strong> Your password has been changed, you will be redirected shortly.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div></p>
        <audio autoplay><source src="success.mp3"></audio>
        <script> 
            setTimeout(function () {
                location.replace("./app/admin");
            }, 2500);
        </script>';

$_SESSION['username'] = $f_name;
$_SESSION['email'] = $email;
$_SESSION['mobile'] = $phone;
$_SESSION['user_id'] = $uid;
echo $msg;
