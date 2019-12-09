<?php
	$filter=$converter->decode($_GET[filter]);
	$value=$converter->decode($_GET[value]);
?>
<div class="box">
	<div class="box-header">
<img src="./assets/view.result.png" width="48"> Kirim Hasil Ujian</div>
    <form action="" method="post">
	<!-- /.box-header -->
    <div class="box-body" style="align=right;">
        <button type="submit" class="btn btn-primary btn-xs  pull-right" name="uploadhasil" value="ok"> &nbsp; &nbsp; &nbsp; Upload &nbsp; &nbsp; &nbsp; </button> 
    </div>    
	<div class="box-body">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="20">No.</th>
					<th width="100"><input type="checkbox" id="checkAll"> Check All</th>
					<th width="120">Id</th>
					<th>Nama Lengkap</th>
					<th width="60">Kelas</th>
					<th width="200">Ujian</th>
					<th width="60">Benar</th>
					<th width="60">Soal</th>
					<th width="60">Nilai</th>
					<th width="150">Waktu</th>
					<th >Lama Pengerjaan</th>					
				</tr>
			</thead>
			<tbody>
<?php   
		if ($_SESSION['is_admin'])
		{
			switch ($filter)  
			{
				case "kelas" : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasiltemp, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and users.kd_kelas='$value' "; //and hasiltemp.status=10 ";
					break;
				case "mapel" : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and ujian.kd_ujian='$value' ";//and hasiltemp.status=10 ";
					break;
				case "modul" : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas, modul WHERE modul.kd_modul=ujian.kd_modul and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and ujian.kd_modul='$value' ";//and hasiltemp.status=10 ";
					break;
				case "periode" : 
					$patokan1=$a[3]." 00:00:00";
					$patokan2=$a[4]." 23:59:59";					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and hasiltemp.tgl_test < '$patokan2' and hasiltemp.tgl_test > '$patokan1' ";//and hasiltemp.status=10 ";
					break;
				default : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM users right join hasiltemp on users.user_id=hasiltemp.user_id left join ujian on ujian.kd_ujian=hasiltemp.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas";// and hasiltemp.status=10 ";
					//$qry="SELECT * FROM hasiltemp LEFT JOIN users ON hasiltemp.user_id=users.user_id ";
					break;
			}
		}
		elseif ($_SESSION['is_adminsekolah'])
		{
			switch ($filter) 
			{
				case "kelas" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE   users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and users.kd_kelas='$value' ";//and hasiltemp.status=10 ";
					break;
				case "mapel" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and ujian.kd_ujian='$value' ";//and hasiltemp.status=10 ";
					break;
				case "modul" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas, modul WHERE users.kode_sekolah='$_SESSION[is_nm_sekolah]' and modul.kd_modul=ujian.kd_modul and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and ujian.kd_modul='$value' ";//and hasiltemp.status=10 ";
					break;
				case "periode" : 
					$patokan1=$a[3]." 00:00:00";
					$patokan2=$a[4]." 23:59:59";
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas and hasiltemp.tgl_test < '$patokan2' and hasiltemp.tgl_test > '$patokan1' ";//and hasiltemp.status=10 ";
					break;
				default : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasiltemp.benar, hasiltemp.soal, hasiltemp.nilai, hasiltemp.tgl_test, hasiltemp.kd_hasil, users.user_id, hasiltemp.tgl_selesai-hasiltemp.tgl_test as selisih, users.user_id FROM hasiltemp, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasiltemp.user_id=users.user_id and ujian.kd_ujian=hasiltemp.kd_ujian and kelas.kd_kelas=users.kd_kelas ";//and hasiltemp.status=10 ";
					break;
			}
		}		
		//echo $qry;
		$query=mysql_query($qry);
		while ($dt=mysql_fetch_array($query))
		{		
			//$kd=$converter->encode($dt[kd_hasil]);
			if (!empty($dt[tgl_test])) $tgl=date("d-m-Y H:i:s", $dt[tgl_test]);		
			else $tgl='-';		
			$selisih='';			
			$selisih1=$dt[selisih];
			if (floor($selisih1/86400)>=1)		
			{	
				$selisih=floor($selisih1/86400)." Hari ";
				$selisih1=$selisih1-($selisih*86400);
			}
			if (floor($selisih1/3600)>=1)		
			{	
				$selisih.=floor($selisih1/3600)." Jam ";
				$selisih1=$selisih1-($selisih*3600);
			}
			if (floor($selisih1/60)>=1)	$selisih.=floor($selisih1/60)." Menit ";
			if ($selisih1%60!=0) 		$selisih.=($selisih1%60)." Detik";
			$i++;
  ?>  
				
				<tr>
					<td align="center"><?= $i ?>. </td>
					<td align="center"><input type="checkbox" id="checkItem" name="pilih[<?= $dt[kd_hasil] ?>]" value="1">
						
					</td>
					<td align="left"><?= $dt[username]; ?></td>
					<td><?= $dt[real_name]; ?></td>
					<td><?= $dt[nm_kelas]; ?></td>
					<td><?= $dt[nm_ujian]; ?></td>
					<td><?= $dt[benar] ?></td>
					<td><?= $dt[soal] ?></td>
					<td><?= $dt[nilai] ?></td>
					<td><?= date('d-m-Y H:i:s', $dt[tgl_test]); ?></td>
					<td><?= $selisih; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
    </form>
    <script>
     $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
    </script>
</div>