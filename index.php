<?php
	require "./bin/setup.php";    
	define('gaklangsung', TRUE);
	
	if (empty($_GET[to])) $ke=$_SESSION['sts']; 
	else $ke=$converter->decode($_GET[to]);	
	if ((is_file("$ke.php")) && (file_exists("$ke.php"))) 
	{
		require ("$ke.php"); 	
	}
	else
	{   
        //echo $_GET[p];
        if($_GET[p]==$pin)
        {
            require ("login.php");	
        }
        else
        {    
            require ("login2.php");	
        }
	}

	mysql_close();
	exit;
	?>