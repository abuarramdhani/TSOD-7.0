<div id="isi">
<div id="loaderz"></div>
<?php
	require "../bin/setup.php";
		//bersikan login lebih dari 15 mnt.
		$tm1=time()-(60*15);
		mysql_query("DELETE FROM login WHERE login < '$tm1' and user_id>1000 and mulai='' ");	
	    //echo "SELECT login.user_id FROM login left join users on login.user_id=users.user_id  right join dj on dj.kd_dj=login.ruang right join ruang on ruang.kd_ruang=dj.kd_ruang WHERE users.user_id >= '100' and ruang.kd_ruang='$_SESSION[is_kdruang]' and login.login!='' ORDER BY username";
		$qry=mysql_query("SELECT login.user_id FROM login left join users on login.user_id=users.user_id  right join dj on dj.kd_dj=login.ruang right join ruang on ruang.kd_ruang=dj.kd_ruang WHERE users.user_id >= '1000' and ruang.kd_ruang='$_SESSION[is_kdruang]' and login.login!='' ORDER BY username");
	  	if ($qry)
			$jml=mysql_num_rows($qry);
		else
			$jml=0;
		if ($jml>0 && $jml<=5) $tinggi=70;
		elseif ($jml>5 && $jml<=10) $tinggi=52;
		elseif ($jml>10 && $jml<=15) $tinggi=36;
		elseif ($jml>15 && $jml<=20) $tinggi=28;
		elseif ($jml>20 && $jml<=25) $tinggi=24;
		elseif ($jml>25 && $jml<=30) $tinggi=22; //20
		else	$tinggi=20; //17
		$hari=date('N');
		$tgla=date('d');
		$blna=abs(date('m'));
		$thna=date('Y');
        $hhari=array('','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
		$bbulan=array('','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
?>
<style>
@media screen
{
	.tdganjil
	{
		display:none !important;
	}
	.tdgenap
	{
		display:none !important;
	}
}
@media print
{
	
	.th1, .th2
	{
		display:table-cell !important;
		border: 1px solid black !important;
		height:<?php echo $tinggi ?>px;
	}
	.td1
	{
		border: 1px solid black !important;
		height:<?php echo $tinggi ?>px;
	}
	.tdganjil
	{
		border: 1px solid black !important;
		height:<?php echo $tinggi ?>px;
		border-right: transparent !important;
	}
	.tdgenap
	{
		border: 1px solid black !important;
		height:<?php echo $tinggi ?>px;
		border-left: transparent !important;
	}
	.kop
	{
		display:block !important;
	}
	.foot
	{
		display:block !important;
	}
	.metro .table tr.warning td, .metro .table tr.error td, .metro .table tr.warning td *, .metro .table tr.error td *
	{
		background-color: #FFF !important;
		color: #ffffff !important; 
	}
}
</style>
<?php
	if (!empty($_GET[act]))
	{
		$act=$converter->decode($_GET[act]);
		$a=explode("|",$act);			
	}
	if ($a[0]=='testbad')
	{
		if ($query=mysql_query("DELETE FROM tempo WHERE user_id='$a[1]'"))
		{
			$msg="Data ujian $a[1] sudah dihapus!";
			$msg=$converter->encode($msg);
		}
		else
		{
			$msg="Data ujian $a[1] gagal dihapus!";
			$msg=$converter->encode($msg);
		}
	}
	if ($a[0]=="locktest")
	{
		$d=mysql_fetch_array(mysql_query("SELECT link FROM login WHERE user_id='$a[1]'"));
		$c=explode("|",$d[link]);
		$new_login=microtime();
		$new_login=substr($new_login,11,10);
		if ($c[0]=='free') 	//dikunci
		{
			if ($query=mysql_query("UPDATE login SET link='lock|$new_login|$c[1]' WHERE user_id='$a[1]'"))
			{
				$msg="Data ujian $a[1] sudah dikunci!";
				$msg=$converter->encode($msg);
			}
			else
			{
				$msg="Data ujian $a[1] gagal dikunci!";
				$msg=$converter->encode($msg);
			}
		}
		else				//dibuka
		{
			$extra=$new_login-$c[1]+$c[2];
			if ($query=mysql_query("UPDATE login SET link='free|$extra' WHERE user_id='$a[1]'"))
			{
				$msg="Data ujian $a[1] sudah dibuka!";
				$msg=$converter->encode($msg);
			}
			else
			{
				$msg="Data ujian $a[1] gagal dibuka!";
				$msg=$converter->encode($msg);
			}
		}
		
	}
    $dtruang=mysql_fetch_array(mysql_query("SELECT * FROM ruang WHERE kd_ruang='$_SESSION[is_kdruang]'"));
?>
<legend class="no-print"><i><img src="./assets/onthego.png" width="48"></i> Sedang Online</legend>
<div class="kop">
<center>
	<table width="100%" border="0">
      <tr>
        <td width="85" align="center" valign="middle"><img src="./assets/tutwuri.jpg" width="72px" /></td>
        <td align="center" valign="middle"><b>BERITA ACARA DAN DAFTAR HADIR<br/>PELAKSANAAN UJIAN SEKOLAH BERSTANDAR NASIONAL<br/>  BERBASIS KOMPUTER<br/>
          TAHUN PELAJARAN 2017/2018</b></td>
        <td width="85" align="center" valign="middle">
        </td>
      </tr>
    </table>
    <hr style="BORDER-RIGHT: medium none; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; HEIGHT: 1px"> 
	<table width="100%" border="0" style="font-size:12px">
      <tr>
        <td width="80%" align="left" height="25" >Pada hari ini <?php echo $hhari[$hari] ?>, Tanggal <?php echo $tgla ?> bulan <?php echo $bbulan[$blna] ?> tahun <?php echo $thna ?>, di <?php echo $_SESSION['kode_sekolah']; ?> telah diselenggarakan Ujian Semester / Try Out 1 Berbasis Komputer Mata pelajaran ...................................................................................., dari pukul ............................ sampai dengan pukul ............................ <?php echo $dtruang[nm_ruang] ?> sesi ............ Jumlah peserta seharusnya : ............ peserta, peserta tidak hadir : ............ peserta.<br/>
        Peserta yang hadir : <br/><br/>
</td>
      </tr>
    </table>
</center>    
</div>
  <table width="100%" cellpadding="5" cellspacing="1" class="table hovered">
  <tbody>
  <tr>
    <th align="center" class="th2">No</th>
    <th align="center" class="no-print">	Action	</th>
    <th align="center" class="th2">Nomor Peserta</th>
    <th align="center" class="th2">Nama Peserta</th>
    <th align="center" class="no-print">Nama Ujian</th>
    <th align="center" class="no-print">Mulai Ujian</th>
    <th align="center" class="no-print">Jumlah Soal</th>
    <th align="center" class="no-print">Terjawab</th>
    <th align="center" colspan="2" class="th1">Tanda Tangan</th>
  </tr>
  <?php 
  	$hasil1=mysql_query("SELECT users.user_id, users.username, users.real_name, users.email, login.mulai FROM login left join users on login.user_id=users.user_id  right join dj on dj.kd_dj=login.ruang right join ruang on ruang.kd_ruang=dj.kd_ruang WHERE users.user_id >= '100' and ruang.kd_ruang='$_SESSION[is_kdruang]' and login.login!='' ORDER BY username");
	
	
	while ($dt=mysql_fetch_array($hasil1))
	{
		$hasil2=mysql_query("SELECT ujian.kd_ujian, ujian.nm_ujian, ujian.jml_soal, count(tempo.kd_soal) as jml_soal FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian WHERE tempo.user_id='$dt[0]'");
		$hasil3=mysql_query("SELECT count(kd_soal) as jml_jawab FROM tempo WHERE user_id='$dt[0]' and jawaban!=''");
		$dt1=mysql_fetch_array($hasil2);
		$dt2=mysql_fetch_array($hasil3);
        if (empty($dt[mulai])) continue;
		if ($dta==$dta_selang) $dta=$dta_seling;
		else $dta=$dta_selang;
		$tgl=$dt[mulai];
        $tgluji=date("Y-m-d H:i",$tgl);
		$thn1=substr($tgluji,2,2);
		$bln1=substr($tgluji,5,2);
		$tgl1=substr($tgluji,8,2);
		$jam1=substr($tgluji,11,2);
		$mnt1=substr($tgluji,14,2);
		
		$dt3=mysql_fetch_array(mysql_query("SELECT link FROM login WHERE user_id='$dt[user_id]'"));
		$c=explode("|",$dt3[link]);
		$dt4=$converter->encode("locktest|$dt[user_id]");
		$dt5=$converter->encode("testbad|$dt[user_id]");
		$no++;
  ?>  
  <tr <?php if (empty($dt1[nm_ujian])) echo "class=\"warning\"";  elseif ($c[0]!='free') echo " class=\"error\" "; else echo "bgcolor=\"$dta\""; ?>>
    <td width="40" align="center" class="td1"><?php echo $no ?>.</td>
  <td width="60" align="center" class="no-print">
<?php
		if (!empty($dt1[nm_ujian])) {
		echo "<a href=\"#\" id=\"$dt4\" class=\"locktest\">";
		if ($c[0]!='free') echo "<i class=\"icon-unlocked\">";
		else  echo "<i class=\"icon-locked\">";
		echo "</i></a> | ";
		echo "<a href=\"#\" id=\"$dt5\" class=\"testbad\"><i class=\"icon-remove\"></i></a>";		
		}
?>		  
  </td>
  <td width="120" align="left" class="td1"><?php echo "&nbsp; $dt[username]"; ?></td>
  <td align="left" class="td1">&nbsp; <?php echo "$dt[real_name]"; ?></td>
  <td width="250" align="left" class="no-print"><?php echo "$dt1[nm_ujian]"; ?></td>
  <td width="100" align="center" class="no-print"><?php if (!empty($dt1[nm_ujian])) echo "$tgluji"; ?></td>
  <td width="40" align="center" class="no-print"><?php if (!empty($dt1[nm_ujian])) echo "$dt1[jml_soal]"; ?></td>
  <td width="40" align="center" class="no-print"><?php if (!empty($dt1[nm_ujian])) echo "$dt2[jml_jawab]"; ?></td>
  <td width="100" align="left" style="font-size:9px" class="tdganjil"><?php if ($no%2==1) echo "&nbsp;$no."; ?></td>
  <td width="100" align="left" style="font-size:9px" class="tdgenap"><?php if ($no%2==0) echo "&nbsp;$no."; ?></td>
  </tr>
  <?php }
  ?>
  </tbody>
  </table>  
<div class="foot">
<center>
	<table width="100%" border="0" style="font-size:12px">
      <tr>
        <td width="100%" align="left">
        Catatan selama pelaksanaan ujian:        
        </td>
      </tr>
      <tr>
        <td width="100%" align="left" height="30"></td>
      </tr>
      <tr>
        <td width="100%" align="center" style="border-bottom-style: solid; border-bottom-width: 1px; "></td>
      </tr>
    </table>

	<table width="100%" border="0" style="font-size:12px">
      <tr>
        <td align="left" >Yang membuat berita acara:</td>  
        <td></td>
        <td></td>              
      </tr>
      <tr>
        <td width="150" align="left" >Proktor/Pengawas</td>
        <td>:   ..................................................................................................</td>
        <td width="150" align="left" >1. ..................................................</td>        
      </tr>
      <tr>
        <td align="left"  height="30">NIP</td>
        <td>&nbsp; ..................................................................................................</td>
        <td align="left" ></td>
      </tr>     
    </table>
  <br/>
  <table width="100%" border="1" style="font-size:10px">
      <tr>
        <td align="left" ><b>Catatan:</b><br/>- 1 (satu) eksemplar untuk Sekolah penyelengara<br/>- 1 (satu) eksemplar untuk Sub Rayom</td>  
      </tr>    
    </table>
</center>    
</div>  
<input name="absen" type="button" class="no-print warning" onclick="window.print()" value="Cetak Presensi Kehadiran" /><br/>
<span class="no-print " style="font-size:10px">Pastikan seluruh siswa sudah login sebelum melakukan pencetakan!</span>

<script>
$(document).ready(function(){
	$("#loaderz").fadeOut("fast");
})
$('a.locktest').click(function() {
    var isinya = this.id;
    $('#isi').load('./vpanel/onthego.php?act='+ isinya);
});
$('a.testbad').click(function() {
    var isinya = this.id;
    $('#isi').load('./vpanel/onthego.php?act='+ isinya);
});
</script>
</div>