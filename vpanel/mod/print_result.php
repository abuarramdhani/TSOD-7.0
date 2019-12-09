<?php
	$uji=$converter->decode($_GET[uji]);

    if ($_SESSION['is_admin'])
	{
		$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM users right join hasil on users.user_id=hasil.user_id left join ujian on ujian.kd_ujian=hasil.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas";
        if (!empty($_GET[uji]))
            $qry.=" WHERE ujian.kd_ujian='$uji' ";
	}
	elseif ($_SESSION['is_adminsekolah'])
	{
		$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM hasil, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasil.user_id=users.user_id and ujian.kd_ujian=hasil.kd_ujian and kelas.kd_kelas=users.kd_kelas ";
            
        if (!empty($_GET[uji]))
            $qry.=" WHERE ujian.kd_ujian='$uji' ";
	}
    $qrycetak=$qry;
?>
<div class="box">
    <div class="box-header">
        <img src="./assets/view.result.png" width="48"> Hasil Ujian</div>

    <!-- /.box-header -->
    <form name="form1print" id="form1print" method="get">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-6">
                        <label for="kd_ujian" class="col-sm-3 control-label">Nama Ujian</label>

                        <div class="input-group col-sm-8">
                            <select id="nm_ujian" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <?php 	
	echo "<option value=\"./?to=$_GET[to]&uji=&tgl=$tgl\" selected> Semua Ujian</option>";
	$qry=mysql_query("SELECT * FROM ujian ORDER BY nm_ujian"); 
	while ($dt=mysql_fetch_array($qry))
	{
		$kode=$converter->encode($dt[kd_ujian]);
		if ($dt[kd_ujian]==$uji)
			echo "<option value=\"./?to=$_GET[to]&uji=$_GET[uji]&tgl=$tgl\" selected>$dt[nm_ujian]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&uji=$kode&tgl=$tgl\">$dt[nm_ujian]</option>";
	}
?>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-6">
                        <label for="inputjadwal" class="col-sm-3 control-label">Tanggal Filter : </label>

                        <div class="input-group col-sm-8">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" name="tgl" class="form-control pull-right" value="<?php if (!empty($tgl1)) echo "$tgl1 - $tgl2"; ?>" onchange="window.location = <?= "./?to=$_GET[to]&uji=$kode&" ?>+this.value;">
                        </div>
                    </div>-->
                </div>
            </div>
        </div>

    </form>
    <div class="box-body">
        <div class="col-md-2">
            <form id="TheForm" method="post" action="export.php" target="_Blank">
<input type="hidden" name="sql" value="<?php echo $qrycetak ?>" />
<button type="submit" class="btn btn-warning pull-left">Download</button>
</form>
            
            
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20">No.</th>
                    <th width="120">Id</th>
                    <th>Nama Lengkap</th>
                    <th width="60">Kelas</th>
                    <th width="200">Ujian</th>
                    <th width="60">Benar</th>
                    <th width="60">Soal</th>
                    <th width="60">Nilai</th>
                    <th width="150">Waktu</th>
                    <th>Lama Pengerjaan</th>
                </tr>
            </thead>
            <tbody>
<?php   
		//echo $qrycetak;
		$query=mysql_query($qrycetak);
		while ($dt=mysql_fetch_array($query))
		{		
			$kd=$converter->encode($dt[kd_hasil]);
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
</div>