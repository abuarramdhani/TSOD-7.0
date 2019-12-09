<link rel="stylesheet" href="./bower_components/bootstrap-daterangepicker/daterangepicker.css">
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><img src="./assets/add.ujian.png" width="48"> Input Jadwal</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Nama Ujian</label>
                <div class="col-sm-4">
                    <input type="text" name="nm_ujian" value="<?= $_POST[nm_ujian] ?>" class="form-control" id="inputjadwal" tabindex="1" placeholder="" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Modul yang diujikan</label>
                <div class="col-sm-3">
                    <select name="kd_modul" tabindex="2" class="form-control" required>
                        <?php 
	if (empty($_POST[kd_modul])) echo "<option value=0 selected>- pilih modul -</option>";
	$hasil=mysql_query("SELECT * FROM modul where status='Aktif' ORDER BY nm_modul");
	while ($dt=mysql_fetch_row($hasil))
	{
		$jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$dt[0]'"));	
		$ada=mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian WHERE kd_modul='$dt[0]'"));	
        if ($ada>0) continue;
		if ($jml==0) $dis=" disabled=\"disabled\""; else $dis="";
		if ($dt[0]==$_POST[kd_modul])
			echo "<option value=\"$dt[0]\" selected> $ada - $dt[1] ($jml soal) </option>";
		else
			echo "<option value=\"$dt[0]\" $dis>$ada - $dt[1] ($jml soal)</option>";
	}
	$hasil=mysql_query("SELECT * FROM modul  where status='Aktif' ORDER BY nm_modul");
	while ($dt=mysql_fetch_row($hasil))
	{
		$jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$dt[0]'"));	
		$ada=mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian WHERE kd_modul='$dt[0]'"));	
        if ($ada==0) continue;
		if ($jml==0) $dis=" disabled=\"disabled\""; else $dis="";
		if ($dt[0]==$_POST[kd_modul])
			echo "<option value=\"$dt[0]\" selected> $ada - $dt[1] ($jml soal) </option>";
		else
			echo "<option value=\"$dt[0]\" $dis>$ada - $dt[1] ($jml soal)</option>";
	}
	?>
                    </select></div>
    <?php
        if (empty($_POST[max])) $_POST[max]=1;
        if ($_POST[acak]) $ce="checked";
    ?>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Jumlah Soal</label>
                <div class="col-sm-2">
                    <div class="input-group col-sm-8">
                        <input type="text" tabindex="3" name="jml_soal" value="<?= $_POST[jml_soal] ?>" class="form-control col-sm-2" required>
                        <span class="input-group-addon">Soal</span>
                    </div>
                </div>
                <label for="inputjadwal" class="col-sm-2 control-label">Acak Urutan Soal</label>
                <div class="input-control checkbox">
                    <label>
                        <?php if ($_POST[acak]==1) $ack='checked=\"checked\"'; else $ack=''; ?>
                        <input type="checkbox" tabindex="4" name="acak" value="1" <?php echo $ack ?> />
                        <span class="check">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ya</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Jadwal Ujian</label>

                <div style="right:-15px" class="input-group col-sm-3">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" tabindex="5" name="datetimes" class="form-control pull-right" value="<?php if (!empty($tgl1)) echo "$tgl1 - $tgl2"; ?>" required>
                </div>
            </div>
            <?php
if (empty($_POST[panduan]))
	$_POST[panduan]="Pilih Satu Jawaban Yang Benar!";
?>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Panduan</label>
                <div class="col-sm-4">
                    <input type="text" tabindex="6" name="panduan" value="<?php echo "$_POST[panduan]";?>" class="form-control" id="inputjadwal" placeholder="" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Diujikan sebanyak</label>
                <div class="col-sm-2">
                    <div class="input-group col-sm-6">
                        <input type="text" tabindex="7" name="max" value="<?= $_POST[max] ?>" class="form-control col-sm-1" required>
                        <span class="input-group-addon">Kali</span>
                    </div>
                </div>
                <?php if (empty($_POST[lama])) $_POST[lama]=90; ?>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">lama Ujian</label>
                <div class="col-sm-2">
                    <div class="input-group col-sm-8">
                        <input type="text" name="lama" tabindex="8" value="<?= $_POST[lama] ?>" class="form-control col-sm-1" required>
                        <span class="input-group-addon">Menit</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputjadwal" class="col-sm-2 control-label">Kelas yang mengikuti</label>
                <div class="col-sm-9" align="left">
                    <table>
                        <?php $jml=mysql_num_rows($query=mysql_query("SELECT * FROM kelas ORDER BY nm_kelas"));
  $jml=ceil($jml/5);
  $tb=9;
  for ($j=1; $j <= $jml; $j++)
  {
		 echo "<tr>";
		 $k=($j-1)*5;	 
	   $query=mysql_query("SELECT * FROM kelas ORDER BY nm_kelas LIMIT $k,5");
  	 while($dt=mysql_fetch_row($query))
  	 {
	    $i=$dt[0];	  
  
  		if (mysql_num_rows(mysql_query("SELECT kd_ujian FROM d_ujian WHERE kd_kelas='$dt[0]' and kd_ujian='$ren'")) > 0)
			$cek="checked=\"checked\"";
		else
			$cek="";
		
  ?> <td>
                            <label>
                                <input type="checkbox" tabindex="<?php echo $tb; ?>" name="<?php echo 'alow['.$i.']'; ?>" value="1" <?php echo $cek ?> />
                                <span class="check">
                                    <?php echo "$dt[1]"; ?>
                                </span>&nbsp; &nbsp; &nbsp;
                            </label></td>
                        <?php $tb++; } echo "</tr>"; } ?>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <input type="hidden" name="kd" value="<?= "$_GET[ren]"; ?>">
                <?php if ($_GET[ac]=='rentest') { ?>
                <button type="submit" name="updateujian" tabindex="<?= $tb ?>" value="ok" class="btn btn-warning">Update</button>
                <?php } else { ?>
                <button type="submit" name="submitujian" tabindex="<?= $tb ?>" value="ok" class="btn btn-primary">Simpan</button>
                <?php } ?>

                <button type="cancel" class="btn btn-default">Reset</button>
            </div>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
<!-- Select2 -->
<script src="./bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="./plugins/input-mask/jquery.inputmask.js"></script>
<script src="./plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="./plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="./bower_components/moment/min/moment.min.js"></script>
<script src="./bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })

</script>
<script>
    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    });

</script>
