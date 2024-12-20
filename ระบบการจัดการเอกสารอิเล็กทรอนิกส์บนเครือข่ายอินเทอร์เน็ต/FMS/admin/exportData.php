<?php 
 

$condb= mysqli_connect("localhost","root","","smp_db_fms") or die("Error: " . mysqli_error($condb));
mysqli_query($condb, "SET NAMES 'utf8' ");
date_default_timezone_set('Asia/Bangkok');

// Fetch records from database 
if(isset($_POST['btn_add_log']))
{
$startdate	= $_POST['startdate'];
$enddate	= $_POST['enddate'];
// get Users
$query = "select * from add_user_log where time_add BETWEEN '" .$startdate. "' and '" .$enddate. "'ORDER BY log_id DESC";
// $query = "SELECT * FROM users";
if (!$result = mysqli_query($condb, $query)) {
    exit(mysqli_error($condb));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Users.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Log_id', 'Username', 'Password', 'Action','Action_By','Host','IP','Time'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
}
/////////////////////////////////////////////////
if(isset($_POST['btn_history']))
{
$startdate	= $_POST['startdate'];
$enddate	= $_POST['enddate'];
// get history_log
$query = "select * from history_log where login_time or logout_time BETWEEN '" .$startdate. "' and '" .$enddate. "' ORDER BY log_id DESC";

if (!$result = mysqli_query($condb, $query)) {
    exit(mysqli_error($condb));
}

$history = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }
}
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=history.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Log_id', 'Username', 'Level', 'Action','Time_in','Actions','Time_Out','IP','Host'));

if (count($history) > 0) {
    foreach ($history as $row) {
        fputcsv($output, $row);
    }
}
 }

 if(isset($_POST['btn_file_log']))
{
$startdate	= $_POST['startdate'];
$enddate	= $_POST['enddate'];
// get file_log
$query = "select * from file_log where create_time BETWEEN '" .$startdate. "' and '" .$enddate. "' ORDER BY log_id DESC";

if (!$result = mysqli_query($condb, $query)) {
    exit(mysqli_error($condb));
}

$file_log = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $file_log[] = $row;
    }
}
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=file_log.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Log_id', 'File name','File_random_name','Subject', 'Action','Action_By','IP','Host','Time'));

if (count($file_log) > 0) {
    foreach ($file_log as $row) {
        fputcsv($output, $row);
    }
}
 }



?>