<?php 
	require "bin/setup.php";
	$do=$converter->decode($_GET['do']);
  
	if (isset($_SESSION[id_ujian])) $_POST[ujian]=$_SESSION[id_ujian];
	
	$dt9=mysql_fetch_array(mysql_query("SELECT user_id, password, real_name, kode_sekolah FROM users WHERE user_id='$_SESSION[user_id]'"));

    $dt10=mysql_fetch_array(mysql_query("SELECT waktu FROM login WHERE user_id='$_SESSION[user_id]'"));

	$is_name=$dt9[2];
	$is_sekolah=$dt9[3];
	
	$_SESSION['is_name']=$is_name;
	$_SESSION['is_sekolah']=$is_sekolah;	
	$dt=mysql_fetch_array(mysql_query("SELECT kd_modul, jml_soal FROM ujian WHERE kd_ujian='$_POST[ujian]'")); 
	$kd_modul=$dt[0];
	if ($query1=mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$_SESSION[user_id]'"))
	{
		while ($dt1=mysql_fetch_array($query1))
		{
			++$i;
			$id=$dt1[kd_soal];
			$dt2=mysql_fetch_array(mysql_query("SELECT jawaban FROM tempo WHERE kd_soal='$id' and user_id='$_SESSION[user_id]'"));
			$dt3=mysql_fetch_array(mysql_query("SELECT a FROM soal WHERE kd_soal='$id'"));
			if ($dt2[jawaban]===$dt3[a])
				$benar++;			
			elseif ($dt2[jawaban]=="")
				$kosong++;
			else $salah++;
		}
		//$nilai=($benar * 4) - ($salah);
		//echo "$benar | $salah | $kosong : $nilai"; exit;
		$nilai=round(($benar/$dt[1]) * 100);
		$tgl_test=time();
		$tgl_mulai=$_SESSION[waktumulaiujian];	
		$time_now=microtime();
		$time_now=substr($time_now,11,10);
        
        $sisawaktu=$dt10[waktu]-($time_now - $dt10[mulai]);
       
        $hapus_temp=mysql_query("INSERT INTO hasil VALUES (default,'$_POST[ujian]','$_SESSION[user_id]','$nilai','$tgl_mulai','$tgl_test','$sisawaktu','$benar','$dt[1]','$benar|$salah')");

		mysql_query("INSERT INTO hasiltemp VALUES (default,'$_POST[ujian]','$_SESSION[user_id]','$nilai','$tgl_mulai','$tgl_test','$sisawaktu','$benar','$dt[1]','$benar|$salah')");
			
		$query2=mysql_query("SELECT kd_hasil FROM hasil WHERE kd_ujian='$_POST[ujian]' and user_id='$_SESSION[user_id]' and tgl_selesai='$tgl_test'");
		$dt2=mysql_fetch_array($query2);
		$kd_hasil=$dt2[0];
        
		mysql_query("UPDATE login SET mulai='', ruang='', waktu='' WHERE user_id='$_SESSION[user_id]'");
        mysql_query("DELETE FROM kunci WHERE user_id='$_SESSION[user_id]'");
        
		$query1=mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$_SESSION[user_id]' ORDER BY kd_tempo ASC");
		while ($dt1=mysql_fetch_array($query1))
		{			
			$dt2=mysql_fetch_array(mysql_query("SELECT * FROM tempo WHERE kd_soal='$dt1[kd_soal]' and user_id='$_SESSION[user_id]'"));
						
			if (mysql_query("INSERT INTO jawaban VALUES (default,'$kd_hasil','$_SESSION[user_id]','$dt1[kd_soal]','$dt2[jawaban]','$dt2[a1]','$dt2[a2]','$dt2[a3]','$dt2[a4]','$dt2[a5]','$dt2[opt]')"))
			{
				mysql_query("DELETE FROM tempo WHERE user_id='$_SESSION[user_id]' and kd_soal='$dt1[0]'");
			}
		}
		if($hapus_temp) 
		{ 
			mysql_query("DELETE FROM tempo WHERE user_id='$_SESSION[user_id]'"); 
		}
	}
	$_SESSION[sudah]=true;
	header("Location: ./logout.php");
	exit;	
?>