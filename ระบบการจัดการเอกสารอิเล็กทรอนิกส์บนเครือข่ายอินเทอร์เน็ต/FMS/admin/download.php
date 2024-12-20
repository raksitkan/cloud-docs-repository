<?php

session_start();
// echo '<pre>';
//         print_r($_SESSION);
// echo '</pre>';
require_once('../Authen/connlogin.php');
require_once '../Authen/conn.php';

$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
$m_username = $_SESSION['m_username'];
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

if(ISSET($_REQUEST['id'])){
	$file = $_REQUEST['id'];
	$query = $conn->prepare("SELECT * FROM `file_tbl` WHERE `id`='$file'");
	$query->execute();
	$fetch = $query->fetch();
	header("Content-Disposition: attachment; filename=".$fetch['file_name_random']);
	header("Content-Type: application/octet-stream;");
	readfile("../filedata/".$fetch['file_name_random']);
	
	$status ='Download Successfully';
	$insert_stmt=$conn->prepare('INSERT INTO user_log(action,file_name,create_by,ip,host) VALUES(:actionup,:nameup,:create_byup,:ipup,:hostup)'); //sql insert query					
		 //bind all parameter 
	$insert_stmt->bindParam(':actionup',$status);
	$insert_stmt->bindParam(':nameup',$fetch['file']);
	$insert_stmt->bindParam(':create_byup',$m_username);
	$insert_stmt->bindParam(':ipup',$ip);
	$insert_stmt->bindParam(':hostup',$host);
	$insert_stmt->execute();
	exit;
}
?>