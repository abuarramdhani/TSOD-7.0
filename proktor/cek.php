<?php 
    if (empty($_SESSION['is_proktor']))
		header ("Location: ./login.php");
	else
	{	
		$query=mysql_query("SELECT login, user_id FROM login WHERE user_id='$_SESSION[user_id]'");
		$dt=mysql_fetch_row($query);
		$batas=$dt[0]+7200;
		$dia=$dt[1];
		$new_login=microtime();
		$new_login=substr($new_login,11,10);		
        //echo "$new_login > $batas"; exit;
		if ($new_login > $batas)
		{
			header ("Location: logout.php"); exit;
		}
		mysql_query("UPDATE login SET login='$new_login' WHERE user_id='$_SESSION[user_id]'");
	}
?>