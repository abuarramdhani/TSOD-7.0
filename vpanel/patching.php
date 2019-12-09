<?php
    require "./bin/setup.php";  
    switch ($_GET[id])
	{
		case '1'	: $url = "$server_pusat/patch/patch_css.zip";
            $zipFile = "./patch/patch_css.zip";
            $m=" Style ";
			break;

		case '2'	: $url = "$server_pusat/patch/patch_ass.zip";
            $zipFile = "./patch/patch_ass.zip";
            $m=" Assets ";
			break;

		case '3'	: $url = "$server_pusat/patch/patch_ui.zip";
			$zipFile = "./patch/patch_ui.zip";
            $m=" User Interface ";
			break;
		
		case '4'	: $url = "$server_pusat/patch/patch_adm.zip";
			$zipFile = "./patch/patch_adm.zip";
            $m=" Modul Admin ";
			break;
		
		case '5' 	: $url = "$server_pusat/patch/patch_mas.zip";
			$zipFile = "./patch/patch_mas.zip";
            $m=" Master Admin ";
			break;		
		
		case '6' 	: $url = "$server_pusat/patch/patch_bin.zip";
			$zipFile = "./patch/patch_bin.zip";
            $m=" BIN INTERFACE ";
			break;		
		
		case '7' 	: $url = "$server_pusat/patch/patch_aud.zip";
			$zipFile = "./patch/patch_aud.zip";
            $m=" AUDIO ";            
			break;
	}
	
	if (file_exists($zipFile)) 
	{
		unlink($zipFile);
	}
    $handles = fopen($url,"r");
    
    if($handles == true){
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
    if(!$page)
    {
        echo "Error :- ".curl_error($ch);
    }    
    curl_close($ch);
    
        
        
    $zip = new ZipArchive;
    $res = $zip->open($zipFile);
    if ($res === TRUE) {
	switch ($_GET[id])
	{
	   case '1'	: $zip->extractTo('../assets/css'); break;
	   case '2'	: $zip->extractTo('../assets'); break;
       case '3'	: $zip->extractTo('../'); break;
       case '4'	: $zip->extractTo('./'); break;
       case '5' 	: $zip->extractTo('./mod'); break;
       case '6' 	: $zip->extractTo('../bin'); break;	
       case '7' 	: $zip->extractTo('../sound'); break;	
    }				
    $zip->close();
    echo "<h2 align=center>DATA $m BERHASIL DI SINGKRON</h2>";;
}
else echo "<h2 align=center>DATA $m GAGAL DIUPDATE!</h2>";		
}
else echo "<h2 align=center>AKSES TIDAK VALID!</h2>";		
?>
