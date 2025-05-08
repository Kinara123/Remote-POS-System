<?php
session_start();
include_once './config.php';
include_once './time.php';
require_once './vendor/autoload.php';

use SimpleCaptcha\Builder;

$captcha = Builder::create();
//$captcha->distortion = false;
$captcha->noiseFactor = 3;
$captcha->applyNoise = false;
$captcha->maxLinesBehind = 1;
$captcha->maxLinesFront = 1;
$captcha->maxAngle = 2;
$captcha->textColor = '#ffffff';


$capt = "";
if (isset($_SESSION['phrase']) && $captcha->compare($_SESSION['phrase'], $_POST['phrase'])) {
    $capt = true;
} else {
    $capt = false;
}

if ($capt) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id, f_name, email, phone, password, role, status FROM users WHERE email = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                ///for default password
                $stmt->bind_result($id, $f_name, $email, $phone, $password, $role, $status);
                if ($stmt->fetch()) {
                    $pass = $_POST['password'];
                    if (password_verify($pass, $password)) {
                        if ($status == 1) {
                            $uid = $id;
                            $length = 5;
                            $otp = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, $length);
                            $mobile = $phone;
                            include_once('../bulkSMS/register.php');
                            include_once('../emailSMS/register.php');

                            $query = "INSERT INTO otp_expiry (uid, otp, is_expired,created_on)
                                    VALUES ('$uid', '$otp', 0,'$time')";
                            mysqli_query($con, $query);
                            $otp_id = $con->insert_id;

                            $msg = '<p><div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                            <strong>Welcome ' . $f_name . '!</strong> Check your email or message for the OTP for verificaton.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div></p>
                                <audio autoplay><source src="success.mp3"></audio>
                                <script> 
                                    setTimeout(function () {
                                        location.replace("../otp");
                                    }, 5000);
                                </script>';

                            $_SESSION['otp_id'] = $otp_id;
                            $_SESSION['username'] = $f_name;
                            $_SESSION['email'] = $email;
                            $_SESSION['mobile'] = $mobile;
                            $_SESSION['redirector_page'] = 'login';
                            $_SESSION['home_page'] = 'admin/';
                            $_SESSION['user_id'] = $uid;
                            $_SESSION['role'] = $role;

                            echo $msg;
                        } else {
                            echo '
                            <audio autoplay><source src="error.mp3"></audio>
                            <div class="alert alert-warning"><strong>Sorry!</strong> Your account is disabled, please contact admin or the developer!</div>
                            ';
                        }
                    } else {
                        echo '
                        <audio autoplay><source src="error.mp3"></audio>
                        <div class="alert alert-warning"><strong>Sorry!</strong> Invalid password!</div>
                        <script>
                            $("#invalid_phrase").html("");
                            $("#valid_phrase").html("Looks good!");
                            $("#invalid_password").html("Wrong Password!");
                        </script>';
                    }
                }
            } else {
                echo '
                    <div class="alert alert-warning"><strong>Sorry!</strong> Invalid Email address!</div>
                    <audio autoplay><source src="error.mp3"></audio>
                    <script>
                        $("#invalid_phrase").html("");
                        $("#valid_phrase").html("Looks good!");
                        $("#invalid_email").html("Invalid email address!");
                    </script>';
            }
        } else {
            echo '
            <audio autoplay><source src="error.mp3"></audio>
            <div class="alert alert-warning"><strong>Sorry!</strong>
                Oops! Something went wrong. Please try again later.
            </div>';
        }
        $stmt->close();
    }
} else {
    echo '
    <audio autoplay><source src="error.mp3"></audio>
    <div class="alert alert-warning"><strong>Sorry!</strong> Wrong CAPTCHA phrase.</div>
    <script>
        $("#invalid_phrase").html("Wrong CAPTCHA phrase!");
        $("#valid_phrase").html("");
    </script>';
}
