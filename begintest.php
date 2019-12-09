<?php 
	require "bin/setup.php";
	$id=$converter->decode($_GET[id]);
	//cek apakah butuh login lagi apa tidak    
	if (mysql_num_rows(mysql_query("SELECT user_id FROM login WHERE user_id='$_SESSION[user_id]'"))==0) //blm login
	{
		header("Location: logout.php"); 
		exit;
	}
	//cek apa user login dan ujian dari komputer yang sama    
	$ip=mysql_fetch_row(mysql_query("SELECT sesi FROM login WHERE user_id='$_SESSION[user_id]'"));
	$sesiid=session_id();    
	if ($sesiid!=$ip[0]) //jika sesi pada saat login dan sekarang berbeda
		mysql_query("UPDATE login SET sesi='$sesiid' WHERE user_id='$_SESSION[user_id]'");
				
	//cek ujian apa bisa dikerjakan oleh user tersebut		
	$dt=mysql_fetch_array(mysql_query("SELECT ujian.nm_ujian, ujian.kd_modul, ujian.jml_soal, ujian.panduan, ujian.nomor, ujian.acak, ujian.lama, ujian.`max`, ujian.jenis FROM ujian, d_ujian, users, modul WHERE ujian.kd_ujian='$id' and ujian.kd_ujian=d_ujian.kd_ujian and d_ujian.kd_kelas=users.kd_kelas and users.user_id='$_SESSION[user_id]' and modul.kd_modul=ujian.kd_modul ORDER BY ujian.kd_ujian"));
	$_SESSION['jenis']=$dt[jenis];
	if (empty($dt[kd_modul])) //user tdk boleh akses ujian
	{
		header ("Location: ./?to=$warning&error=22"); 
        exit;
	}	
    if ($dt[jenis]==10)
	{
		header ("Location: ./begintestesay.php?id=$_GET[id]"); 
        exit;
	}
	elseif ($dt[jenis]==2)
	{	
		header ("Location: ./begintesteng.php?id=$_GET[id]"); 
        exit;
	}    
	$nm_ujian=$dt[nm_ujian]; 
	$kd_modul=$dt[kd_modul];
	$jml_soal=$dt[jml_soal];
	$panduan=$dt[panduan];
	$nomorbaru=$dt[nomor];
	$id_ujian=$id;
	$acak=$dt[acak];
	$waktupengerjaan=$dt[lama];
	$maxpengerjaan=$dt['max'];
    $jenissoal=$dt[jenis];

	//hitung jml soal bank soal
	$punya_soal=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$kd_modul' ORDER BY kd_soal"));

	//jika dalam proses pengerjaan maka ulangi ujian
	$sudah_pernah=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo where user_id='$_SESSION[user_id]' ORDER BY kd_soal"));

	if ($jml_soal > $punya_soal) 
    {
        header ("Location: ./?to=$warning&error=30");
        //jika jml soal overload
        exit;
    }
	else if ($sudah_pernah == $jml_soal) //jika sedang ada ujian (soal==tempo)
	{		
		//ambil data lama
        /*$dt0=mysql_fetch_array(mysql_query("SELECT * FROM kunci where user_id='$_SESSION[user_id]' and kd_ujian='$id_ujian'"));
        if ($dt0[waktu]<1)
        {
            header ("Location: ./?to=$warning&error=34");
            //ada soal yg blm terkumpul
            exit;            
        }*/
        
		$dt=mysql_fetch_array(mysql_query("SELECT tempo.kd_ujian, ujian.nm_ujian, ujian.panduan, ujian.lama, login.waktu, login.mulai, ujian.jenis FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian left join login on login.user_id=tempo.user_id where tempo.user_id='$_SESSION[user_id]' LIMIT 1"));
		
		$_SESSION[id_ujian]	=$dt[kd_ujian];
		$_SESSION[jml_soal]	=$sudah_pernah;
		$_SESSION[nm_ujian]	=$dt[nm_ujian];
		$_SESSION[panduan]	=$dt[panduan];
		$jenissoal=$dt[jenis];		
        
        if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$_SESSION[user_id]'"))>0)
        {
            $dta=mysql_fetch_array(mysql_query("SELECT * FROM kunci WHERE user_id='$_SESSION[user_id]'"));
            $dt0[waktu]=$dta[waktu];
            $_SESSION[id_ujian]=$dta[kd_ujian];
        }
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		$_SESSION[sudah]=false;
		$_SESSION[waktupengerjaan]=$dt0[waktu];
        $_SESSION[waktumulaiujian]=$new_login;
		if (mysql_query("UPDATE login SET mulai='$new_login', login='$new_login', waktu='$_SESSION[waktupengerjaan]' WHERE user_id='$_SESSION[user_id]'"))
            mysql_query("DELETE FROM kunci WHERE user_id='$_SESSION[user_id]' and kd_ujian='$_SESSION[id_ujian]'");
		header("Location: ujian.php");  //lanjutkan test
		exit;
	}
	else if ($sudah_pernah > 0 and $sudah_pernah!=$jml_soal)  // ada soal yg blm terkumpul tetapi jml tidak jelas
	{
		header ("Location: ./?to=$warning&error=31");//ada soal yg blm terkumpul
		exit;
	}
	else  //ujian baru
	{	
		//echo "ujianbaru";
		//generate soal baru
		$_SESSION['id_ujian']=$id_ujian;
		--$punya_soal;
		$_SESSION['punya_soal']=$punya_soal;
		$_SESSION['jml_soal']=$jml_soal;
		$_SESSION[nm_ujian]=$nm_ujian;
		$_SESSION[panduan]=$panduan;
		$_SESSION[waktupengerjaan]=$waktupengerjaan*60;
		$_SESSION[sudah]=false;
		unset($_SESSION[curang]);
		
		if ($acak)			//jika soal di acak
		{
			//ambil query
			$query1=mysql_query("SELECT kd_soal, q, a, alt_1, alt_2, alt_3, alt_4, format FROM soal WHERE kd_modul='$kd_modul' ORDER BY rand() LIMIT $jml_soal");
			while ($dt=mysql_fetch_array($query1))					
			{
				unset($data[0]);
				unset($data[1]);
				unset($data[2]);
				unset($data[3]);
				unset($data[4]);
				$id=$dt[kd_soal];	
				if ($dt[format]=='random') //jika jawaban acak
				{
					$bolong=0;
					if (empty($dt[alt_1])) $bolong++;
					if (empty($dt[alt_2])) $bolong++;
					if (empty($dt[alt_3])) $bolong++;
					if (empty($dt[alt_4])) $bolong++;
					
					$pil1=rand(2, 6-$bolong);
					$pil2=rand(2, 6-$bolong);
					if (!empty($dt[alt_2])) $pil3=rand(2, 6-$bolong);
					if (!empty($dt[alt_3])) $pil4=rand(2, 6-$bolong);
					if (!empty($dt[alt_4])) $pil5=rand(2, 6-$bolong);
						
					while  ($pil2==$pil1) 
						{ $pil2=rand(2, 6-$bolong); }
					if (!empty($dt[alt_2]))
					while (($pil3==$pil1) or ($pil3==$pil2)) 
						{ $pil3=rand(2, 6-$bolong); }
					if (!empty($dt[alt_3]))
					while (($pil4==$pil1) or ($pil4==$pil2) or ($pil4==$pil3)) 
						{ $pil4=rand(2, 6-$bolong); }
					if (!empty($dt[alt_4]))	
					while (($pil5==$pil1) or ($pil5==$pil2) or ($pil5==$pil3)or ($pil5==$pil4)) 
						{ $pil5=rand(2, 6-$bolong); 
							//echo "$id = $pil5 (2,6-$bolong)<br/>";
						}	
					
					$data[0]=mysql_escape_string($dt[$pil1]);
					$data[1]=mysql_escape_string($dt[$pil2]);
					if (!empty($dt[alt_2]))
						$data[2]=mysql_escape_string($dt[$pil3]);
					if (!empty($dt[alt_3]))
						$data[3]=mysql_escape_string($dt[$pil4]);
					if (!empty($dt[alt_4]))
						$data[4]=mysql_escape_string($dt[$pil5]);
				} 
				else //jika jawaban urut default ABCDE
				{
					$data[0]=$dt[2];
					$data[1]=$dt[3];
					if (!empty($dt[4])) $data[2]=$dt[4];
					if (!empty($dt[5])) $data[3]=$dt[5];
					if (!empty($dt[6])) $data[4]=$dt[6];
					//natcasesort($data);
					usort($data, "strnatcmp");
				}
//				echo htmlentities("=$data[0]-$data[1]-$data[2]-$data[3]-$data[4]="); echo "<br/>";
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$_SESSION[id_ujian]','$id','','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','','')");					
			}			
		}
		else 				//soal tdk acak
		{	
			$query1=mysql_query("SELECT kd_soal, q, a, alt_1, alt_2, alt_3, alt_4, `format` FROM soal WHERE kd_modul='$kd_modul' ORDER BY kd_soal LIMIT 0,$jml_soal");
			while ($dt=mysql_fetch_array($query1))
			{		
				unset($data[0]);
				unset($data[1]);
				unset($data[2]);
				unset($data[3]);
				unset($data[4]);
				$kd_soal=$dt[kd_soal];
				//	acak ABCDE
				if ($dt[format]!='default') //jika jawaban acak
				{
					$bolong=0;
					if (empty($dt[alt_3])) $bolong++;
					if (empty($dt[alt_4])) $bolong++;
					$pil1=rand(2, 6-$bolong);
					$pil2=rand(2, 6-$bolong);
					$pil3=rand(2, 6-$bolong);
					if (!empty($dt[alt_3])) $pil4=rand(2, 6-$bolong);
					if (!empty($dt[alt_4])) $pil5=rand(2, 6-$bolong);
						
					while  ($pil2==$pil1) 
						{ $pil2=rand(2, 6-$bolong); }
					while (($pil3==$pil1) or ($pil3==$pil2)) 
						{ $pil3=rand(2, 6-$bolong); }
					if (!empty($dt[5]))
					while (($pil4==$pil1) or ($pil4==$pil2) or ($pil4==$pil3)) 
						{ $pil4=rand(2, 6-$bolong); }
					if (!empty($dt[6]))	
					while (($pil5==$pil1) or ($pil5==$pil2) or ($pil5==$pil3)or ($pil5==$pil4)) 
						{ $pil5=rand(2, 6-$bolong); }	
						
						$data[0]=mysql_escape_string($dt[$pil1]);
						$data[1]=mysql_escape_string($dt[$pil2]);
						$data[2]=mysql_escape_string($dt[$pil3]);
						if ($dt[alt_3]!='') $data[3]=mysql_escape_string($dt[$pil4]);
						if ($dt[alt_4]!='') $data[4]=mysql_escape_string($dt[$pil5]);
				}
				else //jika jawaban urut default
				{
					$data[0]=$dt[a]; $data[1]=$dt[alt_1]; $data[2]=$dt[alt_2]; 
					if ($dt[alt_3]!='') $data[3]=$dt[alt_3];
					if ($dt[alt_4]!='') $data[4]=$dt[alt_4];
					usort($data, "strnatcmp");
				}
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$id_ujian','$kd_soal','','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','','')");
			}			 
		}
		//simpan waktu ke tabel login
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		$_SESSION[waktumulaiujian]=$new_login;
		mysql_query("UPDATE login SET mulai='$new_login', login='$new_login', waktu='$_SESSION[waktupengerjaan]' WHERE user_id='$_SESSION[user_id]'");
	}
?>
	<html>
	<head>
		<meta http-equiv='refresh' method='post' content='0; URL=<?= "ujian.php?"; ?>'>
		<style type="text/css">
			.mydiv {
				position: fixed;
				top: 50%;
				left: 50%;
				width: 400px;
				height: 300px;
				margin-top: -150px;
				/*set to a negative number 1/2 of your height*/
				margin-left: -200px;
				/*set to a negative number 1/2 of your width*/
			}
			
			body {
				background-color: #DCDCDC;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>

	<body>
		<div class="mydiv"><img src="assets/loading2 (2).gif" width="400" height="300"></div>
	</body>

	</html>