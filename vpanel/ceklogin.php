<?php 
	require "./bin/setup.php";	
	$_POST[username]=$_POST["username"];
	$password=$_POST["password"];		
	
	$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, m.nm_modul, u.kd_kelas FROM users as u left join modul as m on u.kd_kelas=m.kd_modul WHERE u.username='$_POST[username]'");
	if ($_POST[calc]!=$_SESSION[cap]) $msg=$converter->encode('Capcha tidak valid!');
	elseif (mysql_num_rows($hasil)==1)
	{					
		$dt=mysql_fetch_array($hasil);
		if ($dt[password] == md5($password))
		{					
			$is_login=microtime();
			$sesid=session_id();
			$is_login=substr($is_login,11,10);
			if(empty($_SESSION[user_id]))
			{
				$ipadd=$_SERVER['REMOTE_ADDR'];	
				if (mysql_num_rows(mysql_query("SELECT * FROM login WHERE user_id='$dt[0]'")) > 0)
					mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");
				else
					mysql_query("INSERT INTO login VALUES ('$dt[0]','$is_login','','','$sesid','')");
			}
			else mysql_query("UPDATE login SET login='$is_login' WHERE user_id='$dt[0]'");
//--------------------						
			if ($dt[0]<=10 && $dt[0]>0 ) //ADMIN UTAMA
			{		
				mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");
				$_SESSION['kode_id']=$dt[4];
				$_SESSION['user_id']=$dt[0];
				$_SESSION['is_name']=$dt[2];
				$_SESSION['is_sekolah']=$dt[3];
				$_SESSION['nm_sekolah']=$dt[3];					
				$_SESSION['is_kelas']=$dt[kd_kelas];	
				$_SESSION['sts']='main';
				$_SESSION['is_admin']=$is_login;
				header ("Location: ./");
				exit;
			}		
/*			elseif ($dt[0]<=20 && $dt[0]>11 ) //ENTRY SOAL 
			{	
				mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");
				$_SESSION['kode_id']=$dt[4];
				$_SESSION['user_id']=$dt[0];
				$_SESSION['is_name']=$dt[2];
				$_SESSION['is_sekolah']=$dt[3];
				$_SESSION['nm_sekolah']=$dt[3];					
				$_SESSION['is_kelas']=$dt[kd_kelas];	
				$_SESSION['sts']='main';
				$_SESSION['is_admin']=$is_login;
				header ("Location: ./");
			}				*/
			elseif ($dt[0]<=100 && $dt[0]>20 ) //PROKTOR UTAMA/SEKOLAH
			{					
				mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");
				$dt1=mysql_fetch_array(mysql_query("SELECT * FROM sekolah WHERE kd_sek='$dt[6]'"));
				$_SESSION['is_logo']=$dt1[2];	
				$_SESSION['is_nm_sekolah']=$dt1[1];	

				$_SESSION['kode_id']=$dt[4];
				$_SESSION['user_id']=$dt[0];
				$_SESSION['is_name']=$dt[2];
				$_SESSION['is_sekolah']=$dt[kd_kelas];                
				$_SESSION['kode_sekolah']=$dt[3];
				$_SESSION['nm_sekolah']=$dt[3];					
				$_SESSION['sts']='main';
				$_SESSION['is_admin']=$is_login;               
				header ("Location: ./");
                exit;
			}
/*			elseif ($dt[0] <= 500  && $dt[0]>100 ) //PROKTOR RUANG
			{					
				$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, r.kd_ruang, r.nm_ruang FROM users as u left join ruang as r on u.kd_kelas=r.kd_ruang WHERE u.username='$_POST[username]'");
				$dt=mysql_fetch_array($hasil);
			
				mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");
				mysql_query("INSERT INTO dj VALUES ('','$dt[5]','$dt[0]','$is_login')");
				$dt1=mysql_fetch_array(mysql_query("SELECT kd_dj FROM dj WHERE kd_ruang='$dt[5]' and pukul='$is_login' LIMIT 1"));
				$_SESSION['kode_id']=$dt[4];
				$_SESSION['user_id']=$dt[0];
				$_SESSION['is_name']=$dt[2];
				$_SESSION['kode_sekolah']=$dt[3];	
				$_SESSION['nm_sekolah']=$dt[3];					
				$_SESSION['is_kdruang']=$dt[5];	
				$_SESSION['is_nmruang']=$dt[6];					
				$_SESSION['is_dj']=$dt1[0];
				$_SESSION['sts']='main';
				$_SESSION['is_proktor']=$is_login;
				header ("Location: ./proktor.php");
			}
			elseif ($dt[0] <= 999  && $dt[0]>500 ) //GURU MAPEL
			{									
				$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, m.kd_modul, m.nm_modul FROM users as u left join modul as m on u.kd_kelas=m.kd_modul WHERE u.username='$_POST[username]'");
				$dt=mysql_fetch_array($hasil);
			
				mysql_query("UPDATE login SET login='$is_login', ip='$sesid' WHERE user_id='$dt[0]'");				
				$_SESSION['kode_id']=$dt[4];
				$_SESSION['user_id']=$dt[0];
				$_SESSION['is_name']=$dt[2];
				$_SESSION['kode_sekolah']=$dt[3];	
				$_SESSION['nm_sekolah']=$dt[3];					
				$_SESSION['is_kdmodul']=$dt[5];	
				$_SESSION['is_nmmodul']=$dt[6];		
				$_SESSION['sts']='main';
				$_SESSION['is_guru']=$is_login;
				header ("Location: ./gurumapel.php");
			}
//--------------------			

			else
			{				
				session_destroy();				
				header ("Location: ./");
			}
			exit; */
		}
		else
			$msg=$converter->encode('User/Password tidak valid');
	}
	else
		$msg=$converter->encode('User/password tidak valid');
		
	header ("Location: ./login.php?msg=$msg");
	exit;
?>