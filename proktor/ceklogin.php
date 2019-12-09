<?php
    session_start();
	require_once "../vpanel/bin/sutep.php";
    $j=mysql_num_rows(mysql_query("SELECT * FROM sinkron WHERE kd_sinkron=1"));
    if ($j>0) $_SESSION[konek]=true;
    mysql_close();

    require_once "../vpanel/bin/setup.php";
    $username=$_POST["namauser"];
	$password=md5($_POST["passuser"]);		
	$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, m.nm_modul, u.kd_kelas FROM users as u left join modul as m on u.kd_kelas=m.kd_modul WHERE u.username='$username'");
	$dt=mysql_fetch_array($hasil);
  
    if ($dt[0] >= 500 || $dt[0]<=100) 
    {
        $msg=$converter->encode('Akses tidak valid!');
    }
	elseif (mysql_num_rows($hasil)==1)
	{	
		$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, m.nm_modul, u.kd_kelas FROM users as u left join modul as m on u.kd_kelas=m.kd_modul WHERE u.username='$username'");
		$dt=mysql_fetch_array($hasil);
		
		if ($dt[password] == $password)
		{		
			$is_login=microtime();
			$sesid=session_id();
			$is_login=substr($is_login,11,10);
			if(empty($_SESSION[user_id]))
			{
				$ipadd=$_SERVER['REMOTE_ADDR'];	
				if (mysql_num_rows(mysql_query("SELECT * FROM login WHERE user_id='$dt[0]'")) > 0)
					mysql_query("UPDATE login SET login='$is_login', sesi='$sesid' WHERE user_id='$dt[0]'");
				else
					mysql_query("INSERT INTO login VALUES ('$dt[0]','$is_login','','','$sesid',NULL)");
			}
			else mysql_query("UPDATE login SET login='$is_login' WHERE user_id='$dt[0]'");

			$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, r.kd_ruang, r.nm_ruang FROM users as u left join ruang as r on u.kd_kelas=r.kd_ruang WHERE u.username='$username'");			
			$dt=mysql_fetch_array($hasil);
			
			mysql_query("UPDATE login SET login='$is_login', sesi='$sesid' WHERE user_id='$dt[0]'");
			mysql_query("INSERT INTO dj VALUES (default,'$dt[5]','$dt[0]','$is_login')");
			$dt1=mysql_fetch_array(mysql_query("SELECT kd_dj FROM dj WHERE kd_ruang='$dt[5]' and pukul='$is_login' LIMIT 1"));
			$_SESSION['user_id']=$dt[0];
			$_SESSION['is_name']=$dt[2];
			$_SESSION['kode_sekolah']=$dt[3];	
			$_SESSION['kode_id']=$dt[4];			
			$_SESSION['is_kdruang']=$dt[5];	
			$_SESSION['is_nmruang']=$dt[6];					
			$_SESSION['is_dj']=$dt1[0];
			$_SESSION['sts']='main';
			$_SESSION['is_proktor']=$is_login;
			header ("Location: ./");
            exit;
		}
		else $msg=$converter->encode('User/Password tidak valid');
	}
	else
    {
        $msg=$converter->encode('User/password tidak valid');
    }
	header ("Location: ./login.php?msg=$msg");
	exit;
?>