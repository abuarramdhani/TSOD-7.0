<div id="isi">
<div id="loaderz"></div>
<?php
$server_pusat="http://103.224.64.25";
$url1 	  = "$server_pusat/patch/super1.zip";
$zipFile1 = "../patch/super1.zip";
$url2 	  = "$server_pusat/patch/super2.zip";
$zipFile2 = "../patch/super2.zip";

$head1 = array_change_key_case(get_headers("$url1", TRUE));
$head2 = array_change_key_case(get_headers("$url2", TRUE));
?>
<legend> Download Patch</legend>
<div class="grid">
<div class="row">
<div class="span12" align="center">Modul ini hanya perlu jika terdapat perbedaan data antara server pusat dan sekolah<br/>Klik patch satu persatu<br/>Setelah mengklik tombol download, tunggu beberapa saat!<br />Sampai muncul notifikasi update selesai.<hr/></div>

<div class="span4" align="center">Paket Data<br/><br/></div>
<div class="span2" align="center">Pusat<br/><br/></div>
<div class="span2" align="center">Lokal<br/><br/></div>
<div class="span4" align="center">&nbsp;<br/><br/></div>

<div class="span4" align="center">Super bin<br/><br/></div>
<div class="span2" align="center"><?php echo $head1['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile1"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch1" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(1)" class="success">Patch</button><br/><br/>
</div>
	
<div class="span4" align="center">Super ui<br/><br/></div>
<div class="span2" align="center"><?php echo $head2['content-length']; ?><br/><br/></div>
<div class="span2" align="center"><?php echo filesize("$zipFile2"); ?><br/><br/></div>
<div class="span4" align="left"><button name="patch2" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(2)" class="success">Patch</button><br/><br/></div>
	
</div>
</div>
<div class="row">
<div class="span12" align="center">  

</div>
</div>
<script>
function pop(id) {
    window.open("<?php echo "$namaserver/patchsuper.php?id="; ?>"+id, "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=200,height=200");
}
	
$(document).ready(function(){
	$("#loaderz").fadeOut("medium");
})
</script>  
</div>