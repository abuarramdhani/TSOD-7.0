<?php
	require "../vpanel/bin/setup.php";	
	mysql_query("UPDATE login SET login='', sesi='' WHERE user_id='$_SESSION[user_id]'");
	$sesi=$_SESSION[user_agent];
	session_destroy();	
	header("Location: ./login.php");
	exit;
?>