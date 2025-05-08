<?php
$systemCheck = mysqli_query($con, 'SELECT * FROM users');
$row = mysqli_fetch_array($systemCheck);
if ($row != '') {
    $newSystem = false;
    $_SESSION['log'] = false;
} else {
    $newSystem = true;
    $_SESSION['log'] = true;
}

$active_username = $_SESSION['username'];
$active_userID = $_SESSION['user_id'];
$active_email = $_SESSION['email'];
$active_role = $_SESSION['role'];

if ($active_role == 1) {
    $active_sidebar = './includes/supernav.php';
    $active_dashboard = 'adminDash.php';
} else {
    $active_sidebar = './includes/sidebar.php';
    $active_dashboard = 'userDashboard.php';
}


//check if user is allowed to use the system
$record = mysqli_query($con, "SELECT id,status FROM users WHERE id='$active_userID'");
$row = mysqli_fetch_array($record);
if ($row != "") {
    $active_status = $row["status"];
    if ($active_status != 1) {
        $_SESSION['message'] = '
            <div class="alert alert-danger"><strong>Sorry!</strong> Your account has been disabled or banned from using the system. Please contact admin.</div>
        ';
        session_destroy();
        echo '<script>window.location.href = "../../logout.php";</script>';
    }
}
