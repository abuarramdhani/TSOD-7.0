<?php
	require "./bin/setup.php";
	session_destroy();
	header("Location: ../");
	exit;
?>