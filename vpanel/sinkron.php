<?php
    require "./bin/setup.php";
    if (empty($_GET[id])) $id=1; 	
    else $id=$_GET[id];
?>
<html>
<head>
</head>
<body>
<?php
    if ($id<13)	
    {
        ?>
    <div class='fullscreenDiv'>
        <div class="center"><br/><br/><br/>Donlod #<?php echo $id+1 ?>/14</div>
    </div>   
<style>
.center {
    position: absolute;
    width: 100px;
    height: 50px;
    top: 50%;
    left: 50%;
    margin-left: -50px; /* margin is -0.5 * dimension */
    margin-top: -25px; 
	  background: url(./assets/load.gif) no-repeat center;	  
}
</style>
<?php } ?>    
<!--<script>window.close();</script>    -->
<?php    
if ($id==1){
	mysql_query('TRUNCATE TABLE `modul`;');
	mysql_query('TRUNCATE TABLE `soal`;');
	mysql_query('TRUNCATE TABLE `d_ujian`;');
	mysql_query('TRUNCATE TABLE `ujian`;');
	mysql_query('TRUNCATE TABLE `kelas`;');
	mysql_query('TRUNCATE TABLE `users`;');
	mysql_query('TRUNCATE TABLE `sekolah`;');
	mysql_query('TRUNCATE TABLE `ruang`;');
	mysql_close();
	require "./bin/sutep.php";
    $boleh=mysql_fetch_array(mysql_query("SELECT * FROM sinkron LIMIT 1",$kon1));
	//IMPORT ALL MODUL
	$sql1="INSERT INTO modul VALUES ";
	$q1=mysql_query("SELECT * FROM modul",$kon1);
	while ($d1=mysql_fetch_array($q1))
	{
		if ($sdh1) $sql1.=",";
		$sql1.="('$d1[0]','$d1[1]','$d1[2]')";
		$sdh1=true;
	}    
	//IMPORT ALL SOAL
	$sql1.=";";				    
	$jml1=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal",$kon1));
	$per=ceil($jml1/500);		
	for ($i=1; $i<=$per; $i++)
	{
		$k=($i-1)*500;
		$sql2[$i]="INSERT INTO `soal` VALUES";
		$q2=mysql_query("SELECT * FROM soal ORDER BY kd_soal LIMIT $k, 500",$kon1);

		while ($d2=mysql_fetch_array($q2))
		{
			if ($sdh2[$i]) $sql2[$i].=",";
			$sql2[$i].="($d2[0],$d2[1],'". addslashes($d2[2])."','". addslashes($d2[3])."','". addslashes($d2[4])."','". addslashes($d2[5])."','".   addslashes($d2[6])."','". addslashes($d2[7])."','$d2[8]')";
			$sdh2[$i]=true;
		}
		$sql2[$i].=";";		
	}		

	// IMPORT ALL DETAIL JADWAL
	$sql3="INSERT INTO d_ujian VALUES ";
	$q1=mysql_query("SELECT * FROM d_ujian ",$kon1);
	while ($d3=mysql_fetch_array($q1))
	{
		if ($sdh3) $sql3.=",";
		$sql3.="('$d3[0]','$d3[1]')";
		$sdh3=true;
	}
	$sql3.=";";				

	//IMPORT ALL JADWAL		
	$sql4="INSERT INTO ujian VALUES ";
	$q1=mysql_query("SELECT * FROM ujian ",$kon1);
	while ($d4=mysql_fetch_array($q1))
	{
		if ($sdh4) $sql4.=",";
		$sql4.="('$d4[0]','$d4[1]','$d4[2]','$d4[3]','$d4[4]','$d4[5]','$d4[6]','$d4[7]','$d4[8]','$d4[9]','$d4[10]','$d4[11]')";
		$sdh4=true;
	}
	$sql4.=";";				

	//IMPORT ALL KELAS		
	$sql5="INSERT INTO kelas VALUES ";
	$q1=mysql_query("SELECT * FROM kelas ",$kon1);
	while ($d5=mysql_fetch_array($q1))
	{
		if ($sdh5) $sql5.=",";
		$sql5.="('$d5[0]','$d5[1]')";
		$sdh5=true;
	}
	$sql5.=";";

	$jml21=mysql_num_rows(mysql_query("SELECT * FROM users WHERE ((user_id>10 and user_id<1000) or user_id=1) or kode_sekolah='$_SESSION[kode_sekolah]'",$kon1));
	for ($i=0; $i<$jml21; $i++)
	{			
    	$sql6[$i]="INSERT INTO `users` VALUES";
		//$q2=mysql_query("SELECT user_id FROM users WHERE user_id=1 or (user_id>100 and user_id<500)or (user_id>1000 and kode_sekolah='$_SESSION[kode_sekolah]') ORDER BY user_id LIMIT $i,1");
        $q2=mysql_query("SELECT * FROM users WHERE ((user_id>10 and user_id<1000) or user_id=1) or kode_sekolah='$_SESSION[kode_sekolah]' ORDER BY user_id LIMIT $i,1",$kon1);
        
		while ($d6=mysql_fetch_array($q2))
		{
			if ($sdh6[$i]) $sql6[$i].=",";
			$sql6[$i].="($d6[0],'". addslashes($d6[1])."','$d6[2]','". addslashes($d6[3])."','$d6[4]','". addslashes($d6[5])."','". addslashes($d6[6])."','$d6[7]')";
			$sdh6[$i]=true;
		}
		$sql6[$i].=";";	       
	}	
	//IMPORT USER PER SEKOLAH
	/*if ($_SESSION['user_id']!=21)
	{
		$jml22=mysql_num_rows(mysql_query("SELECT user_id FROM `users` WHERE user_id>1000 and kode_sekolah='$_SESSION[nm_sekolah]'"));

		$per22=ceil($jml22/250);

		for ($i=1; $i<=$per22; $i++)
		{
			$k=($i-1)*250;
			$sql7[$i]="INSERT INTO `users` VALUES";
			$q3=mysql_query("SELECT * FROM `users` WHERE user_id>1000 and kode_sekolah='$_SESSION[nm_sekolah]' ORDER BY user_id LIMIT $k, 250");

			while ($d7=mysql_fetch_array($q3))
			{
				if ($sdh7[$i]) $sql7[$i].=",";
				$sql7[$i].="($d7[0],'". addslashes($d7[1])."','$d7[2]','". addslashes($d7[3])."','$d7[4]','". addslashes($d7[5])."','".   addslashes($d7[6])."','$d7[7]')";
				$sdh7[$i]=true;
			}
			$sql7[$i].=";";		
		}	
	}*/

	//IMPORT ALL SEKOLAH
	$sql8="INSERT INTO sekolah VALUES ";
	$q1=mysql_query("SELECT * FROM sekolah ",$kon1);
	while ($d8=mysql_fetch_array($q1))
	{
		if ($sdh8) $sql8.=",";
		$sql8.="('$d8[0]','$d8[1]','$d8[2]','$d8[3]')";
		$sdh8=true;
	}
	$sql8.=";";

	//IMPORT ALL RUANG
	$sql9="INSERT INTO ruang VALUES ";
	$q1=mysql_query("SELECT * FROM ruang ",$kon1);
	while ($d9=mysql_fetch_array($q1))
	{
		if ($sdh9) $sql9.=",";
		$sql9.="('$d9[0]','$d9[1]','$d9[2]')";
		$sdh9=true;
	}
	$sql9.=";";

	mysql_close();
	datab($dblocation,$dbusername,$dbpassword,$dbname);
	
    mysql_query($sql1);    
	for ($i=1; $i<=$per; $i++)
	{
		mysql_query($sql2[$i]);		
	}
	mysql_query($sql3);	
	mysql_query($sql4);	
	mysql_query($sql5);	
	for ($i=0; $i<$jml21; $i++)
	{
        mysql_query($sql6[$i]);		
        //echo "$sql6[$i]<br/>";
    }      
    //exit;
	/*for ($i=1; $i<=$jml22; $i++)
	{			
        echo "$sql7[$i]<br/>";
		mysql_query($sql7[$i]);		
	}*/
	mysql_query($sql8);
	mysql_query($sql9);
	$files = glob('./images/*'); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
	}
}
$url = "$server_pusat/images/images[$id].zip";
$handles = fopen($url,"r");
if($handles == true){
	$zipFile = "./images/images[$id].zip"; // Local Zip File Path
	$zipResource = fopen($zipFile, "w");
	// Get The Zip File From Server
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zipResource);
	$page = curl_exec($ch);
	curl_close($ch);

	$zip = new ZipArchive;
	$res = $zip->open($zipFile);
	if ($res === TRUE) {
		$zip->extractTo('./images');
		$zip->close();
		echo "DATA GAMBAR [$id] BERHASIL DI SINGKRON<br/>";
	}
	else {
		echo "DATA GAMBAR [$id] GAGAL DIUPDATE!<br/>";
		echo "Klik <a href=\"sinkron.php\">disini</a> untuk mengulangi sinkron";
		exit;
	}
}
else echo "DATA SELESAI BERHASIL DI SINGKRON<br/>";
	

if ($id<13)
{
	echo '<script language="javascript" type="text/javascript" >', PHP_EOL;
	//echo '<!--', PHP_EOL;
	echo '      window.top.location.href = \' sinkron.php?id=',$id+1, '\'', PHP_EOL;
	//echo '// -->', PHP_EOL;
	echo '</script>', PHP_EOL;	
}
	?>
			</body>
</html>	 