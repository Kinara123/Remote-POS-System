<?php  
date_default_timezone_set('Africa/Nairobi');
////////////////////year start////////
$year = date('Y');
$yrecord = mysqli_query($con, "SELECT * FROM year WHERE year='$year'");
if ($yrecord->num_rows > 0) {
    $Y = mysqli_fetch_array($yrecord);
    $yid = $Y['id'];
}else{
    $yquery = "INSERT INTO year (year)
            VALUES ('$year')";
    if (mysqli_query($con, $yquery)){
        $year_id = mysqli_insert_id($con);
    }
    $yid = $year_id;

}
$_SESSION["year_id"] = $yid;
$active_year = $yid;
/////////////////year end//////////////

//////////////month start///////////////
$month = date('m');
$yrecord = mysqli_query($con, "SELECT * FROM month WHERE month='$month' AND year_id='$yid'");
if ($yrecord->num_rows > 0) {
    $Y = mysqli_fetch_array($yrecord);
    $mid = $Y['id'];
}else{
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $yquery = "INSERT INTO month (year_id,month,name)
            VALUES ('$yid','$month','$monthName')";
    if (mysqli_query($con, $yquery)){
        $month_id = mysqli_insert_id($con);
    }
    $mid = $month_id;

}
$_SESSION["month_id"] = $mid;
$active_month = $mid;
/////////////month end///////////

///////////week start//////////////////////////
$week = date("W", time());
$yrecord = mysqli_query($con, "SELECT * FROM week WHERE week='$week' AND year_id='$yid' AND month_id='$mid'");
if ($yrecord->num_rows > 0) {
    $Y = mysqli_fetch_array($yrecord);
    $wid = $Y['id'];
}else{
    $monday = strtotime("last monday");
    $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
    $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $this_week_sd = date("Y-m-d",$monday);
    $this_week_ed = date("Y-m-d",$sunday);
    $yquery = "INSERT INTO week (year_id,month_id,week,week_start,week_end)
        VALUES ('$yid','$mid','$week','$this_week_sd','$this_week_ed')";
    if (mysqli_query($con, $yquery)){
        $week_id = mysqli_insert_id($con);
    }
    $wid = $week_id;

}
$_SESSION["week_id"] = $wid;
$active_week = $wid;
//////////////week end/////////////////

//////////////day start///////////////
$day = date('Y-m-d');
$_SESSION["active_date"] = $day;
$todayName = date('l', strtotime($day));
$model_result = mysqli_query($con, "SELECT * FROM day WHERE day='$day' AND year_id='$yid' AND month_id='$mid' AND week_id='$wid'");
if ($model_result->num_rows > 0) {
    $Y = mysqli_fetch_array($model_result);
    $did = $Y['id'];
}else{
    $yquery = "INSERT INTO day (year_id, month_id, week_id,day,name)
        VALUES ('$yid','$mid','$wid','$day','$todayName')";
    if (mysqli_query($con, $yquery)){
        $day_id = mysqli_insert_id($con);
    }
    $did = $day_id;
}                                                          
$_SESSION["day_id"] = $did;
$active_day = $did;
/////////////day end///////////
$active_time = date('F d, Y h:i:s A');
$active_time1 = date('F d, Y ');
$time = date("Y-m-d H:i:s");
$_SESSION["active_time"] = $active_time;

