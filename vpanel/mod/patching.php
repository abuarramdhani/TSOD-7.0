<div id="isi">
<?php
	require "./bin/setup.php";
	require "./bin/exec.php";		
$url1 	  = "$server_pusat/patch/patch_css.zip";
$zipFile1 = "../patch/patch_css.zip";
$url2 	  = "$server_pusat/patch/patch_ass.zip";
$zipFile2 = "../patch/patch_ass.zip";
$url3 	  = "$server_pusat/patch/patch_ui.zip";
$zipFile3 = "../patch/patch_ui.zip";
$url4 	  = "$server_pusat/patch/patch_adm.zip";
$zipFile4 = "../patch/patch_adm.zip";
$url5 	  = "$server_pusat/patch/patch_aud.zip";
$zipFile5 = "../patch/patch_aud.zip";


$head1 = array_change_key_case(get_headers("$url1", TRUE));
$head2 = array_change_key_case(get_headers("$url2", TRUE));
$head3 = array_change_key_case(get_headers("$url3", TRUE));
$head4 = array_change_key_case(get_headers("$url4", TRUE)); 
$head5 = array_change_key_case(get_headers("$url5", TRUE));
?>
<legend> Download Patch</legend>
<div class="grid">
<div class="row">
<div class="span12" align="center">Modul ini hanya perlu jika terdapat perbedaan data antara server pusat dan sekolah<br/>Klik patch satu persatu<br/>Setelah mengklik tombol download, tunggu beberapa saat!<br />Sampai muncul notifikasi update selesai.<hr/></div>

<div class="span4" align="center">Paket Data<br/><br/></div>
<div class="span2" align="center">Pusat<br/><br/></div>
<div class="span2" align="center">Lokal<br/><br/></div>
<div class="span4" align="center">&nbsp;<br/><br/></div>

<div class="span4" align="center">Style<br/><br/></div>
<div class="span2" align="center"><?php echo $head1['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile1"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch1" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(1)" class="success">Patch</button><br/><br/>
</div>
	
<div class="span4" align="center">Aset<br/><br/></div>
<div class="span2" align="center"><?php echo $head2['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile2"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch2" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(2)" class="success">Patch</button><br/><br/></div>
	
<div class="span4" align="center">Interface<br/><br/></div>
<div class="span2" align="center"><?php echo $head3['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile3"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch3" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(3)" class="success">Patch</button><br/><br/></div>
	
<div class="span4" align="center">Modul<br/><br/></div>
<div class="span2" align="center"><?php echo $head4['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile4"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch4" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(4)" class="success">Patch</button><br/><br/></div>	
	
<div class="span4" align="center">Audio<br/><br/></div>
<div class="span2" align="center"><?php echo $head5['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile5"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch5" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pops()" class="success">Download</button><br/><br/></div>
  
</div>
</div>
<div class="row">
<div class="span12" align="center">  

</div>
</div>
<script>
function pop(id) {
    window.open("<?php echo "$namaserver/patch.php?id="; ?>"+id, "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=200,height=200");
}
function pops() {
    window.open("<?php echo "$namaserver/patch_aud.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=200,height=200");
}
	
$(document).ready(function(){
	$("#loaderz").fadeOut("medium");
})
</script>  
</div>