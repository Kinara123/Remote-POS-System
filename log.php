<?php
mysqli_query($con, "INSERT INTO logs (user_id,username,action,time)
    VALUES ('$active_userID','$active_username','$action','$active_time')");
