<?php 
	require "bin/setup.php";
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
	$sudah_pernah=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo where user_id='$_SESSION[user_id]' ORDER BY kd_soal"));
	if ($sudah_pernah >1) //jika sedang ada ujian (soal==tempo)
	{
		$qry=mysql_query("SELECT DISTINCT(tempo.kd_ujian), ujian.nm_ujian, ujian.panduan, ujian.lama, login.mulai, ujian.jml_soal FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian left join login on login.user_id=tempo.user_id where tempo.user_id='$_SESSION[user_id]' limit 1");
		$dt=mysql_fetch_array($qry);		
		$_SESSION['id_ujian']		="$dt[kd_ujian]";
		$_SESSION['jml_soal']  		="$dt[jml_soal]";
		$_SESSION['totalsoal'] 		=$dt[jml_soal];
		$_SESSION['nm_ujian']  		="$dt[nm_ujian]";
		$_SESSION['panduan']   		="$dt[panduan]";
		$_SESSION['waktupengerjaan']=$dt[lama]*60;
        //echo "#$_SESSION[id_ujian] - $_SESSION[jml_soal]#"; exit;
		//jika ujian diblock
		/*$dib=mysql_fetch_array(mysql_query("SELECT link FROM login WHERE user_id='$_SESSION[user_id]'"));
		$cib=explode("|",$dib[link]);	
		if ($cib[0]!='free')
		{
			$_SESSION[sts]='block';		
			header("Location: ./?to=$block");
			exit;
		}*/
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		$_SESSION[waktumulaiujian]=$dt[mulai];		
		$_SESSION[sudah]	=false;
		//$d=explode("|",$dt['link']);
		mysql_query("UPDATE login SET login='$new_login' WHERE user_id='$_SESSION[user_id]'");        
        header("Location: ujianeng.php");
		exit;
	}				
	
	$dt=mysql_fetch_array(mysql_query("SELECT ujian.nm_ujian, ujian.kd_modul, ujian.jml_soal, ujian.panduan, ujian.nomor, ujian.acak, ujian.lama, ujian.`max`, ujian.jenis FROM ujian, d_ujian, users, modul WHERE ujian.kd_ujian='$id' and ujian.kd_ujian=d_ujian.kd_ujian and d_ujian.kd_kelas=users.kd_kelas and users.user_id='$_SESSION[user_id]' and modul.kd_modul=ujian.kd_modul"));
	if (empty($dt[kd_modul])) header ("Location: ./?to=$warning&error=41");
	
	$kd_modu=$dt[kd_modul];
	$jml_soal=$dt[jml_soal];

	/*$_SESSION['id_ujian']		="";
	$_SESSION['punya_soal']		="";
	$_SESSION['jml_soal']		=0;
	$_SESSION['nm_ujian']		="";
	$_SESSION['panduan']		="";
	$_SESSION['waktupengerjaan']=0;
	$_SESSION['sudah']			='';
	$_SESSION['totalsoal']		=0;
    */
	//ambil_daftar_modul
   
	$qry1=mysql_query("SELECT d_ujian.`kd_ujian`, ujian.jenis, ujian.kd_modul, ujian.nm_ujian, ujian.panduan, ujian.lama, ujian.jml_soal FROM users RIGHT JOIN d_ujian ON users.`kd_kelas`=d_ujian.`kd_kelas` LEFT JOIN ujian ON ujian.`kd_ujian`=d_ujian.`kd_ujian` WHERE users.`user_id`='$_SESSION[user_id]' AND ujian.`jenis`>1 and ujian.kd_modul >='$kd_modu' ORDER BY ujian.jenis LIMIT 1");
	while ($d1=mysql_fetch_array($qry1))
	{
		$k++;
		$kd_ujian=$d1[0];
		$kd_modul=$d1[2];
		//hitung jml soal bank soal
		$punya_soal=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$d1[2]' ORDER BY kd_soal"));
		//jika dalam proses pengerjaan maka ulangi ujian
		$sudah_pernah=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo where user_id='$_SESSION[user_id]' ORDER BY kd_soal"));
		
		//generate soal baru
		$_SESSION['id_ujian']		="$kd_ujian";
		$_SESSION['jml_soal']  		="$d1[jml_soal]";
		$_SESSION['totalsoal'] 		=$d1[jml_soal];
		$_SESSION['nm_ujian']  		="$d1[nm_ujian]";
		$_SESSION['panduan']   		="$d1[panduan]";
		$_SESSION['waktupengerjaan']=$d1[lama]*60;
							
		if ($acak)			//jika soal di acak
		{
			for ($i=1; $i<=$jml_soal; $i++)
			{ //dicek
				$sl_now=rand(0,$punya_soal);
				$query1=mysql_query("SELECT kd_soal, q, a, alt_1, alt_2, alt_3, alt_4, format FROM soal WHERE kd_modul='$kd_modul' LIMIT $sl_now,1");
				$dt=mysql_fetch_row($query1);
								
				//ulangi sampe gak sama
				while (mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$_SESSION[user_id]' and kd_soal='$dt[0]'")) > 0)
				{
					$l++;
					$sl_now=rand(0,$punya_soal);
					$query1=mysql_query("SELECT kd_soal, q, a, alt_1, alt_2, alt_3, alt_4, format   FROM soal WHERE kd_modul='$kd_modul' LIMIT $sl_now,1");
					$dt=mysql_fetch_row($query1);
				}	
				$id=$dt[0];
				unset($data[0]); unset($data[1]); unset($data[2]); unset($data[3]); unset($data[4]);

				if ($dt[format]=='random') //jika jawaban acak
				{
					$bolong=0;
					if (empty($dt[5])) $bolong++;
					if (empty($dt[6])) $bolong++;
					$pil1=rand(2, 6-$bolong);
					$pil2=rand(2, 6-$bolong);
					$pil3=rand(2, 6-$bolong);
					if (!empty($dt[5])) $pil4=rand(2, 6-$bolong);
					if (!empty($dt[6])) $pil5=rand(2, 6-$bolong);
						
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
				}
				else //jika jawaban urut default ABCDE
				{
					$data[0]=$dt[2];
					$data[1]=$dt[3];
					$data[2]=$dt[4];
					if ($dt[5]!='') $data[3]=$dt[5];
					if ($dt[6]!='') $data[4]=$dt[6];
					
					//natcasesort($data);
					usort($data, "strnatcmp");
				}
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$kd_ujian','$id','','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','','')");	
			}
		}
		else 				//soal tdk acak
		{	
			$query1=mysql_query("SELECT kd_soal, q, a, alt_1, alt_2, alt_3, alt_4, `format` FROM soal WHERE kd_modul='$kd_modul' ORDER BY kd_soal LIMIT 0,$jml_soal");
			while ($dt=mysql_fetch_array($query1))
			{			
				$l++;	
				$kd_soal=$dt[kd_soal];
				unset($data[0]); unset($data[1]); unset($data[2]); unset($data[3]); unset($data[4]);

				//	acak ABCDE
				if ($dt[format]!='default') //jika jawaban acak
				{
					unset($data[0]); unset($data[1]); unset($data[2]); unset($data[3]); unset($data[4]);
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
					if (!empty($dt[alt_3]))
						while (($pil4==$pil1) or ($pil4==$pil2) or ($pil4==$pil3)) 
						{ $pil4=rand(2, 6-$bolong); }
					if (!empty($dt[alt_4]))	
						while (($pil5==$pil1) or ($pil5==$pil2) or ($pil5==$pil3)or ($pil5==$pil4)) 
						{ $pil5=rand(2, 6-$bolong); }	
						
					$data[0]=$dt[$pil1];
					$data[1]=$dt[$pil2];
					$data[2]=$dt[$pil3];
					if ($dt[alt_3]!='') $data[3]=$dt[$pil4];
					if ($dt[alt_4]!='') $data[4]=$dt[$pil5];
				}
				else //jika jawaban urut default
				{
					$data[0]=$dt[a]; $data[1]=$dt[alt_1]; $data[2]=$dt[alt_2]; 
					if ($dt[alt_3]!='') $data[3]=$dt[alt_3];
					if ($dt[alt_4]!='') $data[4]=$dt[alt_4];
					usort($data, "strnatcmp");
				}					
				mysql_query("INSERT INTO tempo VALUES (default,'$_SESSION[user_id]','$kd_ujian','$kd_soal','','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','','')");
			}
		}
	}	
	//simpan waktu ke tabel login
	$_SESSION['jmlmodul']		=$k;
	$new_login=microtime();
	$new_login=substr($new_login,11,10);
	$_SESSION[waktumulaiujian]=$new_login;
	mysql_query("UPDATE login SET mulai='$new_login', login='$new_login', waktu='$_SESSION[waktupengerjaan]' WHERE user_id='$_SESSION[user_id]'");
?>
<html>
<head>
<meta http-equiv='refresh' method='post' content='0; URL=<?php echo "ujianeng.php";?>'>
<style type="text/css">
.mydiv {
    position:fixed;
    top: 50%;
    left: 50%;
    width:400px;
    height:300px;
    margin-top: -150px; /*set to a negative number 1/2 of your height*/
    margin-left: -200px; /*set to a negative number 1/2 of your width*/
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