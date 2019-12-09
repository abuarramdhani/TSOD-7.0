<?php if ((empty($is_login)) and (empty($is_admin)))
		header ("Location: ./");
	else
	{
		$query=mysql_query("SELECT login, user_id FROM login WHERE user_id='$_SESSION[user_id]'");
		$dt=mysql_fetch_row($query);
		$batas=$dt[0]+7200;
		$dia=$dt[1];
		$new_login=microtime();
		$new_login=substr($new_login,11,10);

		if ($new_login > $batas)
		{
			echo "not pass 1 ";
			header ("Location: logout.php");
		}
		mysql_query("UPDATE login SET login='$new_login' WHERE user_id='$_SESSION[user_id]'");
		$is_login=$new_login;
		if ($_SESSION[user_id] <= 9)
		{
			$is_admin=$is_login;
			$_SESSION['is_admin'];
		}
		else
			$_SESSION['is_login'];			
	}
?>