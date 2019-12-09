<?php
	require "./bin/setup.php";
	if ($_POST[Submittoken])
	{
		$tm=time();
		$hasil=mysql_query("SELECT t.token, t.expired, dj.kd_ruang  FROM token as t left join dj on dj.kd_dj=t.kd_dj WHERE t.token='$_POST[token]'");
		$_POST[token]=strtoupper($_POST['token']);		
		if ($_POST[token]==$tokek) //tokenuniversal
		{			
			mysql_query("UPDATE login SET ruang='1' WHERE user_id='$_SESSION[user_id]'");
			$_SESSION['sts']="main";            
			header ("Location: ./?kode=$_POST[kode]");
			exit;			
		}
		elseif (mysql_num_rows($hasil)==1) //Token lokal...
		{
			$dt=mysql_fetch_row($hasil);		
			if ($dt[1] <= $tm) //expired
			{
				$msg="Token yang anda masukan sudah expired!";
				$msg=$converter->encode($msg);
				$_SESSION['sts']='token';
				header ("Location: ./?msg=$msg"); 
				exit;
			}			
			mysql_query("UPDATE login SET ruang='$dt[2]' WHERE user_id='$_SESSION[user_id]'");
			$_SESSION['sts']="main";
			header ("Location: ./?kode=$_POST[kode]");
			exit;			
		}	
		else
		{
			$msg="Token tidak dikenali!";
			$msg=$converter->encode($msg);
			$_SESSION['sts']='token';
			header ("Location: ./?msg=$msg"); 
			exit;
		}
	}
?>