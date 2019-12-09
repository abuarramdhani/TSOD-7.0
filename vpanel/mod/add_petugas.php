<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><img src="./assets/add.petugas.png" width="48"> Input petugas</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="inputpetugas" class="col-sm-2 control-label">User Name</label>
				<div class="col-sm-4">
					<input type="text" name="username" value="<?= $_POST[username] ?>" class="form-control" id="inputpetugas" placeholder="" required autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="inputpetugas" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input type="password" name="password1"  class="form-control" <?php if ($_GET[ac]=='renpetugas') { ?> disabled <?php } ?> />
				</div>
			</div>
			<div class="form-group">
				<label for="inputpetugas" class="col-sm-2 control-label">Nama Lengkap</label>
				<div class="col-sm-4">
					<input type="text" name="real_name"  class="form-control" value="<?php echo "$_POST[real_name]";?>" placeholder="" required/>
				</div>
			</div>
			<div class="form-group">
                  <label for="inputpetugas" class="col-sm-2 control-label">Ruang</label>
				<div class="col-sm-4">
                  <select name="kd_kelas" class="form-control">
                    <?php if (empty($_POST[kd_kelas])) 
		echo "<option selected>- pilih ruang -</option>";
	$hasil=mysql_query("SELECT * FROM ruang left join sekolah on sekolah.kd_sek=ruang.kd_sek ORDER BY ruang.nm_ruang");
	while ($dt1=mysql_fetch_array($hasil))
	{
		if ($dt1[kd_ruang]==$_POST[kd_kelas])
			echo "<option value=$dt1[kd_ruang] selected>$dt1[nm_ruang] - $dt1[nm_sek]</option>";
		else
			echo "<option value=$dt1[kd_ruang]>$dt1[nm_ruang] - $dt1[nm_sek]</option>";
	}
  ?>
                  </select>
				</div>
			</div>		
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<input type="hidden" name="kd" value="<?= " $_GET[ren] "; ?>">
				<?php if ($_GET[ac]=='renpetugas') { ?>
				<button type="submit" name="updatepetugas" value="ok" class="btn btn-warning">Update</button>
				<?php } else { ?>
				<button type="submit" name="submitpetugas" value="ok" class="btn btn-primary">Simpan</button>
				<?php } ?>

				<button type="cancel" class="btn btn-default">Reset</button>
			</div>
		</div>
		<!-- /.box-footer -->
	</form>
</div>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Data Petugas Ujian</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="30">No.</th>
					<th width="60">Action</th>
					<th width="200">Ruang</th>
					<th>Nama Petugas</th>
				</tr>
			</thead>
			<tbody>
				<?php $hasil=mysql_query("SELECT * FROM ruang right join users on ruang.kd_ruang=users.kd_kelas WHERE users.user_id < 1000 and user_id > 10 and users.kd_kelas!='' ORDER BY nm_ruang");
	while ($dt=mysql_fetch_array($hasil))
	{		
		$i++;
		$kd=$converter->encode("$dt[user_id]");
?>
				<tr>
					<td>
						<?= $i ?>. </td>
					<td align="center">
						<a href="?ac=renpetugas&ren=<?= $kd ?>"><i class="glyphicon glyphicon-pencil"></i></a> |
						<a href="?ac=delpetugas&del=<?= $kd?>"><i class="glyphicon glyphicon-trash" onclick="<?php Kdel($dt[real_name]); ?>"></i></a>
					</td>
					<td align="center"><?= $dt[nm_ruang] ?></td>
					<td>
						<?= "$dt[real_name] - ( $dt[username] )"; ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th width="30">No.</th>
					<th width="60">Action</th>
					<th width="200">Ruang</th>
					<th>Nama Petugas</th>
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