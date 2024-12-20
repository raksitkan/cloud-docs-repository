<?php
	$conn = new PDO( 'mysql:host=localhost;dbname=smp_db_fms', 'root', '');
	if(!$conn){
		die("Fatal Error: Connection Failed!");
	}
?>