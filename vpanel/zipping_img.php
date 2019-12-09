<?php
require "./bin/setup.php";
//250=250;
$im='../images/';
function dire($source)
{
	$dir = @opendir($source);
    //echo "$dir<br/>";
	$fi = new FilesystemIterator('../images/', FilesystemIterator::SKIP_DOTS);    
	$jml=iterator_count($fi);
	$jmldownload=ceil($jml/100);
	$temp_unzip_path = '../images/';
	//$jmldownload=1;
	for ($i=1; $i<=$jmldownload; $i++)
	{
		$jumlah=0;
		unlink("../images/images[$i].zip"); 
		$mulai=($i-1)*100;
		$sampai=$mulai+100;		
		$zip = new ZipArchive();
		$dirArray = array();
		$new_zip_file = $temp_unzip_path."images[$i].zip";

		$new = $zip->open($new_zip_file, ZIPARCHIVE::CREATE);
		if ($new === true) {
				$handle = opendir($temp_unzip_path);
				while (false !== ($entry = readdir($handle))) {
						if(!in_array($entry,array('.','..')) && (substr($entry,-3,3)!='zip'))
						{	
							$jumlah++;
							if ($jumlah>=$mulai && $jumlah<=$sampai) {
									$dirArray[] = $entry;
									$zip->addFile($temp_unzip_path.$entry,$entry);								
							}							
						}
				}
				//print_r ($dirArray);
				closedir($handle);
				echo "Zip[$i]<br/>";
		} else {
				echo "Failed to create Zip[$i]";
		}
	$zip->close();
	}	
	echo "<br/><br/><br/>Selesai mengindex $jumlah Gambar";
}
dire('../images/');
?>