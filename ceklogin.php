<?php 
require "./bin/setup.php";
$_POST[username]=$_POST["username"];
//$password=$_POST[password];
$password=substr($_POST[password],6,4).'-'.substr($_POST[password],3,2).'-'.substr($_POST[password],0,2);		
$hasil=mysql_query("SELECT u.user_id, u.password, u.real_name, u.kode_sekolah, u.username, g.nm_kelas, u.kd_kelas FROM users as u left join kelas as g on u.kd_kelas=g.kd_kelas WHERE u.username='$_POST[username]'");
	if (mysql_num_rows($hasil)==1)// jika result pencarian 1 orang/valid
	{		
		$dt=mysql_fetch_array($hasil);
		if ($dt[password] == md5($password)) //jika password cocok
		{			
			$is_login=microtime();
			$sesid=session_id();
			$is_login=substr($is_login,11,10);
			$ipada=mysql_fetch_row(mysql_query("SELECT * FROM login WHERE user_id='$dt[user_id]'"));
            
            if ($ipada[4]!=$sesid && $ipada[4]!='') //CEK PERNAH LOGIN DGN SESI BERBEDA?
            { 
                $_SESSION['tempusername']=$_POST[username];
                $_SESSION['temppassword']=$password;
                $_SESSION['sts']="ijinadmin";
                $_SESSION['p']=$pin;                 
                header("Location: ./");					
                exit;
            }			
            elseif(empty($_SESSION[user_id]) || empty($ipada[0])) //SESI blm TERDAFTAR
            {
                if (mysql_num_rows(mysql_query("SELECT * FROM login WHERE user_id='$dt[0]'")) > 0)
                    mysql_query("UPDATE login SET login='$is_login', sesi='$sesid' WHERE user_id='$dt[0]'");
                else
                    mysql_query("INSERT INTO login VALUES ('$dt[0]','$is_login','','','$sesid',NULL)");
            }
            else	//SESI TERDAFTAR 
                mysql_query("UPDATE login SET login='$is_login', sesi='$sesid' WHERE user_id='$dt[0]'");

            $_SESSION['kode_id']=$dt[4];
            $_SESSION['user_id']=$dt[0];
            $_SESSION['is_name']=$dt[2];
            $_SESSION['is_sekolah']=$dt[3];	
            $_SESSION['is_kelas']=$dt[5];	
            $_SESSION['sts']="token";
            $_SESSION['is_login']=$is_login;
            $_SESSION['p']=$pin;            
            header ("Location: ./");
            exit;            
		}
		else
			$msg=$converter->encode('3');
	}
	else
		$msg=$converter->encode('2');
	
	header ("Location: ./?msg=$msg");
	exit;
?>