<?php 
	require "bin/setup.php";
	//require("ztrash/cekbroser.php");	
	$id=$converter->decode($_GET[id]);
	//cek apakah butuh login lagi apa tidak
	if (mysql_num_rows(mysql_query("SELECT user_id FROM login WHERE user_id='$_SESSION[user_id]'"))==0)
	{
		header("Location: logout.php"); //jika sesi login habis;
		exit;
	}
	//cek apa user login dan ujian dari komputer yang sama
	$ip=mysql_fetch_row(mysql_query("SELECT ip FROM login WHERE user_id='$_SESSION[user_id]'"));
	$sesiid=session_id();
	if ($sesiid!=$ip[0]) //jika sesi pada saat login dan sekarang berbeda
		mysql_query("UPDATE login SET ip='$sesiid' WHERE user_id='$_SESSION[user_id]'");
				
	//cek ujian apa bisa dikerjakan oleh user tersebut	
	
	$dt=mysql_fetch_array(mysql_query("SELECT ujian.nm_ujian, ujian.kd_modul, ujian.jml_soal, ujian.panduan, ujian.nomor, ujian.acak, ujian.lama, ujian.`max`, ujian.jenis FROM ujian, d_ujian, users, modul WHERE ujian.kd_ujian='$id' and ujian.kd_ujian=d_ujian.kd_ujian and d_ujian.kd_kelas=users.kd_kelas and users.user_id='$_SESSION[user_id]' and modul.kd_modul=ujian.kd_modul ORDER BY ujian.kd_ujian"));
	if (empty($dt[kd_modul])) header ("Location: ./?to=$warning&error=41");
	if ($dt[jenis]==3)
	{
		header ("Location: ./begintestarab.php?id=$_GET[id]"); exit;
	}
  elseif ($dt[jenis]==2)
	{
		header ("Location: ./begintestenglish.php?id=$_GET[id]"); exit;
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
	//hitung jml soal bank soal
	$punya_soal=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$kd_modul' ORDER BY kd_soal"));

	//echo "$sudah_pernah == $jml_soal"; exit;
	//jika dalam proses pengerjaan maka ulangi ujian
	$sudah_pernah=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo where user_id='$_SESSION[user_id]' ORDER BY kd_soal"));
	if ($jml_soal > $punya_soal) header ("Location: ./?to=$warning&error=11");//jika jml soal overload
	else if ($sudah_pernah == $jml_soal) //jika sedang ada ujian (soal==tempo)
	{		
		//ambil data lama
		$dt=mysql_fetch_array(mysql_query("SELECT tempo.kd_ujian, ujian.nm_ujian, ujian.panduan, ujian.lama, login.link, login.mulai FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian left join login on login.user_id=tempo.user_id where tempo.user_id='$_SESSION[user_id]' LIMIT 1"));
		
		$_SESSION[id_ujian]	=$dt[kd_ujian];
		$_SESSION[jml_soal]	=$sudah_pernah;
		$_SESSION[nm_ujian]	=$dt[nm_ujian];
		$_SESSION[panduan]	=$dt[panduan];
		
		//jika ujian diblock
		/*$dib=mysql_fetch_array(mysql_query("SELECT link FROM login WHERE user_id='$_SESSION[user_id]'"));
		$cib=explode("|",$dib[link]);	
		if ($cib[0]!='free')
		{
			$_SESSION[sts]='block';		
			header("Location: ./?to=$block");
			exit;
		}*/

		unset($_SESSION[curang]);
		unset($_SESSION[pinalti]);		
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		$_SESSION[waktumulaiujian]=$dt[mulai];		
		$_SESSION[sudah]	=false;
		$d=explode("|",$dt['link']);
		$_SESSION[waktupengerjaan]=($dt[lama]*60);
		mysql_query("UPDATE login SET login='$new_login' WHERE user_id='$_SESSION[user_id]'");
		header("Location: ujianesay.php");  //lanjutkan test
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
		unset($_SESSION[pinalti]);		
		
		
		if ($acak)			//jika soal di acak
		{
			//ambil query
			$query1=mysql_query("SELECT kd_soal, q, format FROM soal WHERE kd_modul='$kd_modul' ORDER BY rand() LIMIT $jml_soal");
			while ($dt=mysql_fetch_array($query1))					
			{
				$id=$dt[kd_soal];	
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$_SESSION[id_ujian]','$id','','','','','','','','Esay')");	
			}
		}
		else 				//soal tdk acak
		{	
			$query1=mysql_query("SELECT kd_soal, q, `format` FROM soal WHERE kd_modul='$kd_modul' ORDER BY kd_soal LIMIT 0,$jml_soal");
			while ($dt=mysql_fetch_array($query1))
			{				
				$kd_soal=$dt[kd_soal];
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$id_ujian','$kd_soal','','','','','','','','esay')");
			}
		}
		//simpan waktu ke tabel login
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		$_SESSION[waktumulaiujian]=$new_login;
		mysql_query("UPDATE login SET mulai='$new_login', login='$new_login', link='free|0' WHERE user_id='$_SESSION[user_id]'");
	}
?>
	<html>

	<head>
		<meta http-equiv='refresh' method='post' content='0; URL=<?php echo "ujianesay.php?";?>'>
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