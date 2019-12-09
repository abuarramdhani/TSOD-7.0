<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><img src="./assets/add.user.png" width="48"> Input User
            &nbsp; &nbsp; <button type="button" class="btn btn-warning" onclick="location.href='./?to=<?= $importuser ?>';">Import Dari Excel</button>

        </h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="inputuser" class="col-sm-2 control-label">User Name</label>
				<div class="col-sm-4">
<?php if ($_GET[ac]!='renuser') { ?>
					<input type="text" name="username" value="<?= $_POST[username] ?>" class="form-control" id="inputuser" placeholder="" required autofocus>
<?php } else { echo "$_POST[username]"; } ?>					
				</div>
			</div>
			<div class="form-group">
				<label for="inputuser" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-4">
					<input type="password" name="password1"  class="form-control" <?php if ($_GET[ac]=='renuser') { ?> disabled <?php } ?> />
				</div>
			</div>
			<div class="form-group">
				<label for="inputuser" class="col-sm-2 control-label">Nama Lengkap</label>
				<div class="col-sm-4">
					<input type="text" name="real_name"  class="form-control" value="<?php echo "$_POST[real_name]";?>" placeholder="" required/>
				</div>
			</div>
			<div class="form-group">
				<label for="inputuser" class="col-sm-2 control-label">Email/Kelas</label>
				<div class="col-sm-4">
					<input type="text" name="email"  class="form-control" value="<?php echo "$_POST[email]";?>" placeholder="" required/>
				</div>
			</div>
			<div class="form-group">
				<label for="inputuser" class="col-sm-2 control-label">Asal Sekolah</label>
				<div class="col-sm-4">
					<input type="text" name="kode_sekolah"  class="form-control" value="<?php echo "$_POST[kode_sekolah]";?>" placeholder="" required/>
				</div>
			</div>
			<div class="form-group">
                  <label for="inputuser" class="col-sm-2 control-label">Kelas</label>
				<div class="col-sm-4">
  <select name="kd_kelas" class="form-control">                    
  <?php if (empty($_POST[kd_kelas])) 
		echo "<option selected>- pilih kelas -</option>";
	$hasil=mysql_query("SELECT * FROM kelas ORDER BY nm_kelas");
	while ($dt1=mysql_fetch_row($hasil))
	{
		if ($dt1[0]==$_POST[kd_kelas])
			echo "<option value=$dt1[0] selected>$dt1[1]</option>";
		else
			echo "<option value=$dt1[0]>$dt1[1]</option>";
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
				<?php if ($_GET[ac]=='renuser') { ?>
				<input type="hidden" name="kd" value="<?= " $_GET[ren] "; ?>">
				<input type="hidden" name="kelas" value="<?= " $_GET[kelas] "; ?>">
				<input type="hidden" name="sek" value="<?= " $_GET[sek] "; ?>">
				<input type="hidden" name="hal" value="<?= " $_GET[hal] "; ?>">
				<button type="submit" name="updateuser" value="ok" class="btn btn-warning">Update</button>
				<?php } else { ?>
				<button type="submit" name="submituser" value="ok" class="btn btn-primary">Simpan</button>
				<?php } ?>

				<button type="cancel" class="btn btn-default">Reset</button>
			</div>
		</div>
		<!-- /.box-footer -->
	</form>
</div>