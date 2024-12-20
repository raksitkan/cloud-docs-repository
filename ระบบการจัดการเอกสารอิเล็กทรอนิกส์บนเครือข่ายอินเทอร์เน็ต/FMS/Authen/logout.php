<?php
session_start();
include('../Authen/connlogin.php');
// $log_id = $_SESSION['log_id'];
$date = date_default_timezone_set("Asia/Bangkok");
$date = date('Y-m-d h:i:s');
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$m_username = $_SESSION['m_username'];
$a = ("Has Logout the system at!");
$sql = "update  history_log set
m_level = '{$_SESSION["m_level"]}',
ip = '{$_SERVER["REMOTE_ADDR"]}',
logout_time = '$date',
m_username = '$m_username',
host = '$host',
m_actions = '$a' WHERE m_username = '".$m_username."'";
  if (mysqli_query($condb, $sql)) {
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($condb);
  }
session_destroy();
echo '
<script type = "text/javascript">
alert("Logout Successfully..");
window.location = "../index.php";
</script>';
?>