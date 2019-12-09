<?php
require "./bin/setup.php";
//250=250;
function dire($source)
{
	$dir = @opendir($source);	
	$fi = new FilesystemIterator('../images/', FilesystemIterator::SKIP_DOTS);
	$jml=iterator_count($fi);
	$temp_unzip_path = '../images/';
	$jmldownload=1;	
	$jumlah=0;
	unlink("../images/imagesall.zip"); 
	$mulai=0;
	$sampai=2000;		
	$zip = new ZipArchive();
	$dirArray = array();
	$new_zip_file = $temp_unzip_path."imagesall.zip";

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
	} else {
        echo "Failed to create Zip";
	}
	$zip->close();
	
	echo "<br/><br/><br/>Selesai mengindex $jumlah Gambar";
}
dire("../images");
?>
