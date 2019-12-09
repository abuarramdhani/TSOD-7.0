<?php
require "../vpanel/bin/setup.php";
  require "./cek.php";
	if ($_POST['token']) 
	{ 
		$karakter = 'ABCDEGHJKLMNPQRSTUWXYZ';  
		for($i = 0; $i < 6; $i++) 
	   	{  
			$karakter=str_replace($kar,'',$karakter);
			$pos = rand(0, strlen($karakter)-1);
			$kar=$karakter{$pos};
			$stringa .= $kar;  
	   	}  
		$tm=time()+(60*60*24);       
		mysql_query("INSERT INTO token VALUES (default, '$stringa', '$_SESSION[is_dj]', '$tm')");
	}
	$sekarang=date("Y-m-d H:i:s");
	//echo "SELECT ujian.nm_ujian FROM ujian left join d_ujian on d_ujian.kd_ujian=ujian.kd_ujian left join kelas on kelas.kd_kelas=d_ujian.kd_kelas  WHERE ujian.tgl_mulai <= '$sekarang' and ujian.tgl_selesai >= '$sekarang' ORDER BY kd_ujian";
	$query=mysql_query("SELECT ujian.nm_ujian, kelas.nm_kelas FROM ujian left join d_ujian on d_ujian.kd_ujian=ujian.kd_ujian left join kelas on kelas.kd_kelas=d_ujian.kd_kelas  WHERE ujian.tgl_mulai <= '$sekarang' and ujian.tgl_selesai >= '$sekarang' ORDER BY ujian.kd_ujian");	
	while ($dt=mysql_fetch_array($query))
	{
		$nama[$no]=strtoupper(str_replace(".","","$dt[nm_ujian]"));		
		$kls=explode(".",$dt[nm_kelas]);
		$kelas[$no]=strtoupper($kls[0]);
		$no++;
	}
	if ($no>0) { $nama=array_unique($nama); $kelas=array_unique($kelas); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ujian Online</title>
        <link href="asset/index1.css" rel="stylesheet" type="text/css">
			  <link href="asset/index.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <div class="header_dashboard">
            <div class="logo_left_dash"></div>
            <div class="status_right_dash">
<?php
    //require "../vpanel/bin/sutep.php";
    if ($_SESSION[konek]) {
        $c1="status_text_dash_online";
        $t1="AKTIF";
    }    
    else { 
        $c1="status_text_dash_offline";
        $t1="OFFLINE";
            
    }
?>                
                <p class="<?= $c1 ?>">
                    <?= $t1 ?>
                </p>            </div>
        </div>
        <div class="header_body_dash">
            <p class="status_link_dash">
                Dashboard - Status Tes
            </p>
        </div>
        <div class="body_dash">
					<?php require "menu.php"; ?>
            <div class="content_right_all">
                <div class="title_dash_position">
                    <p class="txt_dash_position">Status Tes</p>
                </div>
                <br>
<form method="post" name="form" action="" enctype="application/x-www-form-urlencoded">
	<div class="boox_status_test">
			<div class="status_left_test">Status:</div>
			<div class="status_right_test">
				<?php
                if (!$kon1)     echo "SERVER OFFLINE";
				elseif ($no>0)  echo "UJIAN DIBUKA";
				else            echo "TIDAK ADA UJIAN YANG DIBUKA";					
				?></div>
			<br>
			<div class="status_left_test">Mapel:</div>
			<div class="status_right_test">
				<input type="text" value="<?php foreach ($nama as $a) { echo "$a,"; } ?>" disabled class="inputan_dis">
				</div>
		<br>
			<div class="status_left_test">Kelas:</div>
			<div class="status_right_test"><input type="text" value="<?php foreach ($kelas as $k) { echo "$k,"; } ?>" disabled class="inputan_dis"></div>
		<br>
			<div class="status_left_test">Token:</div>
			<div class="status_right_test">
				<input type="text" value="<?php 
	$dt2=mysql_fetch_array(mysql_query("SELECT t.token, t.expired FROM token as t left join dj on dj.kd_dj=t.kd_dj WHERE dj.kd_ruang='$_SESSION[is_kdruang]' ORDER BY t.expired DESC LIMIT 1"));
	for($i = 0; $i < 6; $i++) 
   	{  
		$string.=substr($dt2[0],$i,1).' ';
   	}  
	$tm=time();
	if ($dt2[1]==0) echo "-";
	elseif ($dt2[1]<$tm) echo "$string &nbsp; (Expired)";
	else echo "$string, Expired :", date("d F Y",$dt2[1]), " pukul ",date("H:i:s",$dt2[1])," WIB";?>" disabled class="inputan_dis">
			</div>			
	</div>
	<div class="row">
<?php 
    if ($_SESSION[konek])    
        echo "<input type=\"submit\" name=\"token\" tabindex=\"1\" value=\"Generate\" class=\"btn_generate\"> "; 
    else
        echo "<input type=\"submit\" name=\"token\" tabindex=\"1\" value=\"Generate\" class=\"btn_generate2\" disabled> "; 

?>
</div>
</form>
					</div>
            
        </div>
        <div class="footer_dash">
            <div class="cut_footer"></div>
            <div class="box_footer">
                <p class="text_footer_dash">
                    2017 SMKN 1 Banyuwangi CBT Sync
                </p>
            </div>
            <div class="cut_footer"></div>
        </div>
    </body>
</html>