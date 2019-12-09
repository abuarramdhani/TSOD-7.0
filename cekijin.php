<?php
	//if($_SESSION[darilogin]!=true) header("Location: ./");	
	require "./bin/setup.php";
	if ($_POST[Submitijin])
	{
		$passwd=md5($_POST[password]);
		$hasil=mysql_query("SELECT password FROM users WHERE password='$passwd' and user_id < '999' LIMIT 1");
		$dt=mysql_num_rows($hasil);	
		if ($dt>0)
		{
			$temppassword=md5($_SESSION[temppassword]);
			$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, g.nm_kelas FROM users as u left join kelas as g on u.kd_kelas=g.kd_kelas WHERE u.username='$_SESSION[tempusername]' and `password`='$temppassword'");
			$dt=mysql_fetch_row($hasil);
			$sesid=session_id();			
			$is_login=microtime();
			$is_login=substr($is_login,11,10);
			mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");			
			$_SESSION['kode_id']=$dt[4];
			$_SESSION['user_id']=$dt[0];
			$_SESSION['is_name']=$dt[2];
			$_SESSION['is_sekolah']=$dt[3];	
			$_SESSION['is_kelas']=$dt[5];	
			$_SESSION['sts']="token";
			$_SESSION['is_login']=$is_login;			
			header ("Location: ./");
			exit;			
		}	
		else
		{
			$msg="Maaf password verifikasi yang anda masukan salah!";
			$msg=$converter->encode($msg);
			$_SESSION['sts']='ijinadmin';
			header ("Location: ./?msg=$msg");
		}
	}

?>