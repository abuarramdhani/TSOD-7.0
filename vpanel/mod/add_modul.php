<?php
if (!$sudah_konek) {
	require "../bin/setup.php";
	//if (!isset($_SESSION[is_admin])) header("Location: ./login.php");
	require "../bin/exec.php";
}
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><img src="./assets/add.modul.png" width="48"> Input Modul</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label for="inputmodul" class="col-sm-2 control-label">Nama Modul </label>
                <div class="col-sm-4">
                    <input type="text" name="nm_modul" value="<?= $_POST[nm_modul] ?>" class="form-control" id="inputmodul" placeholder="" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="inputmodul" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-4">
                    <input type="checkbox" name="status" tabindex="2" value="Aktif" <?php if ($_POST[status]=='Aktif')
		echo " checked=\"checked\""; ?> />
                    <span class="check"></span>
                    Aktif

                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <input type="hidden" name="kd" value="<?= "$_GET[ren]"; ?>">
                <?php if ($_GET[ac]=='renmodul') { ?>
                <button type="submit" name="updatemodul" value="ok" class="btn btn-warning">Update</button>
                <?php } else { ?>
                <button type="submit" name="submitmodul" value="ok" class="btn btn-primary">Simpan</button>
                <?php } ?>

                <button type="cancel" class="btn btn-default">Reset</button>
            </div>
        </div>
        <!-- /.box-footer -->
    </form>
</div>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Data modul</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th width="60">Action</th>
                    <th width="60">Status</th>
                    <th>Nama modul</th>
                    <th width="200">Jumlah Soal</th>
                </tr>
            </thead>
            <tbody>
                <?php $hasil=mysql_query("SELECT * FROM modul ORDER BY nm_modul $sort");
	while ($dt=mysql_fetch_array($hasil))
	{		
		$i++;
		$view=$dt[0];
		$kd=$converter->encode("$dt[0]");
		$ins=$converter->encode("stsmodul|$dt[0]|$dt[2]");
		$h=mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$dt[0]'");
?>
                <tr>
                    <td><?= $i ?>. </td>
                    <td align="center">
                        <a href="?ac=renmodul&ren=<?= $kd ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                        |
                        <?php
			if (mysql_num_rows($h)==0) { ?>
                        <a href="?ac=delmodul&del=<?= $kd?>" onclick="<?php Kdel($dt[1]); ?>"><i class="glyphicon glyphicon-trash"></i></a> <?php } else { ?>
                        <i class="glyphicon glyphicon-trash"></i> <?php } ?>
                        |
                        <a href="<?= "../ujianview.php?id_ujian=$view"; ?>" target="_blank"><i class="fa fa-eye"></i></a></td>

                    <td align="center">
                        <label for="checkbox"><input type="checkbox" name="checkbox" class="direk" id="<?php echo $ins ?>" <?php if ($dt[2]=='Aktif') echo 'checked="checked"'; ?> /> Aktif</label> </td>

                    <td><?= $dt[1]; ?></td>
                    <td><?php $jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE kd_modul='$dt[0]'"));
  	echo "$jml soal";
  ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th width="30">No.</th>
                    <th width="60">Action</th>
                    <th width="60">Status</th>
                    <th>Nama modul</th>
                    <th width="200">Jumlah Soal</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#example1').dataTable({
                "aLengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                "iDisplayLength": 50
            });
        });

    </script>
    <!-- /.box-body -->
</div>
<script>
    $('input[type=checkbox].direk').click(function() {
        var isinya = this.id;
        $('#isi').load('./mod/add_modul.php?act=' + isinya);
    });

</script>
