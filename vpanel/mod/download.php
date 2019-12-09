<div class="box">
	<div class="box-header">
		<img src="./assets/order.username.png" width="48"> Download Paket Data
	</div>
	<!-- /.box-header -->
	<div class="box-body">
        <div class="span12">Modul ini hanya perlu jika terdapat perbedaan data antara server pusat dan sekolah<br/>Setelah mengklik tombol download, tunggu beberapa saat!<br />Sampai muncul notifikasi update selesai.<hr/></div>
<?php
mysql_close();
require "./bin/sutep.php";	
$boleh=mysql_fetch_array(mysql_query("SELECT * FROM sinkron LIMIT 1",$kon1));        
$dt1=mysql_num_rows(mysql_query("SELECT kd_modul FROM modul",$kon1));
$dt2=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal",$kon1));
$dt11=$dt1+$dt2;        
//echo "$dt11<br/>";

$dt1=mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian",$kon1));
$dt2=mysql_num_rows(mysql_query("SELECT kd_kelas FROM d_ujian",$kon1));
$dt12=$dt1+$dt2;
//echo "$dt12<br/>";

//$dt1=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE (user_id>10 and user_id<1000) or (user_id=1)",$kon1));
//echo "SELECT user_id FROM users WHERE (user_id>10 or user_id=1) and kode_sekolah='$_SESSION[kode_sekolah]' ";        
$dt2=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE ((user_id>10 and user_id<1000) or user_id=1) or kode_sekolah='$_SESSION[kode_sekolah]'",$kon1));
     
$dt3=mysql_num_rows(mysql_query("SELECT kd_ruang FROM ruang",$kon1));  
$dt4=mysql_num_rows(mysql_query("SELECT kd_kelas FROM kelas",$kon1));  
$dt5=mysql_num_rows(mysql_query("SELECT kd_sek FROM sekolah",$kon1));
$dt13=$dt2+$dt3+$dt4+$dt5;
mysql_close();
?>
<?php 
datab($dblocation,$dbusername,$dbpassword,$dbname);
$dt1=mysql_num_rows(mysql_query("SELECT kd_modul FROM modul"));
$dt2=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal"));
$dt21=$dt1+$dt2;
//echo "$dt21<br/>";

$dt1=mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian"));
$dt2=mysql_num_rows(mysql_query("SELECT kd_kelas FROM d_ujian"));
$dt22=$dt1+$dt2;
//echo "$dt22<br/>";

//$dt1=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE (user_id>10 and user_id<1000) or (user_id=1)"));
$dt2=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE ((user_id>10 and user_id<1000) or user_id=1) or kode_sekolah='$_SESSION[kode_sekolah]'"));        
$dt3=mysql_num_rows(mysql_query("SELECT kd_ruang FROM ruang"));  
$dt4=mysql_num_rows(mysql_query("SELECT kd_kelas FROM kelas"));
$dt5=mysql_num_rows(mysql_query("SELECT kd_sek FROM sekolah"));
$dt23=$dt2+$dt3+$dt4+$dt5;

//echo "$dt11+$dt12+$dt13!=$dt21+$dt22+$dt23"; exit;        
if ($dt11==0 && $dt12==0 && $dt13==0) $blm='disabled';
elseif ($dt11+$dt12+$dt13==$dt21+$dt22+$dt23) $blm='disabled';
else $blm='';
        
$persen1=round($dt21/$dt11*100);
$persen2=round($dt22/$dt12*100);
$persen3=round($dt23/$dt13*100);

if ($persen1>100) { $cl11='Black'; $cl12='Black'; $persen1="error"; }        
elseif ($persen1>=90) { $cl11='success'; $cl12='green'; $persen1.="%"; }        
elseif ($persen1>=75) { $cl11='primary'; $cl12='light-blue'; $persen1.="%"; }   
elseif ($persen1>=40) { $cl11='yellow'; $cl12='yellow'; $persen1.="%"; }
else { $cl11='danger'; $cl12='red'; $persen1.=" %"; }        
        
if ($persen2>100) { $cl21='Error'; $cl22='Black'; $persen2="error"; }        
elseif ($persen2>=90) { $cl21='success'; $cl22='green'; $persen2.="%"; }       
elseif ($persen2>=75) { $cl21='primary'; $cl22='light-blue'; $persen2.="%"; }   
elseif ($persen2>=40) { $cl21='yellow'; $cl22='yellow'; $persen2.="%"; }
else { $cl21='danger'; $cl22='red'; $persen2.=" %"; }        

if ($persen3>100) { $cl31='Error'; $cl32='Black'; $persen3="error"; }        
elseif ($persen3>=90) { $cl31='success'; $cl32='green'; $persen3.="%"; }        
elseif ($persen3>=75) { $cl31='primary'; $cl32='light-blue'; $persen3.="%"; }   
elseif ($persen3>=40) { $cl31='yellow'; $cl32='yellow'; $persen3.="%"; }
else { $cl31='danger'; $cl32='red'; $persen3.="%"; }        
if ($boleh[0]!=1) {
    echo "#Akses Pusat Ditutup#"; 
    $cl11='Black'; $cl12='Black'; $persen1="None"; 
    $cl21='Black'; $cl22='Black'; $persen2="None";
    $cl31='Black'; $cl32='Black'; $persen3="None";
    $blm='disabled';
}

        
?>        
 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Paket Sinkron</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 30px">#</th>
                  <th style="width: 200px">Paket</th>
                  <th>Progress</th>
                  <th style="width: 80px">Persentase</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Data Paket Soal</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-<?= $cl11 ?>" style="width: <?= $persen1 ?>"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-<?= $cl12 ?>"><?= $persen1 ?></span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Data Paket Jadwal</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-<?= $cl21 ?>" style="width: <?= $persen2 ?>"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-<?= $cl22 ?>"><?= $persen2 ?></span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Paket Siswa</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-<?= $cl31 ?>" style="width: <?= $persen3 ?>"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-<?= $cl32 ?>"><?= $persen3 ?></span></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>       		
        <div class="span12" align="center">  
        <button type="submit"  name="downloadhasil" value="Download" class="btn btn-block btn-warning btn-flat" onclick="if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop()" <?= $blm ?>>Sinkron!</button>   

</div>
	</div>
	<!-- /.box-body -->
</div>
<script>
function pop() {
    myWindow = window.open("<?php echo "$namaserver/vpanel/sinkron.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=300,height=300");
}  
</script>