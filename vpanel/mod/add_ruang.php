<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><img src="./assets/add.ruang.png" width="48"> Input Ruang</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputruang" class="col-sm-2 control-label">Nama Ruang</label>
                  <div class="col-sm-4">
                    <input type="text" name="nm_ruang" value="<?= $_POST[nm_ruang] ?>" class="form-control" id="inputRuang" placeholder="">
                  </div>
                </div>                                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
								<div class="col-sm-2"></div>
								<div class="col-sm-4">
									<input type="hidden" name="kd" value="<?= "$_GET[ren]"; ?>">
									<?php if ($_GET[ac]=='renruang') { ?>
									<button type="submit" name="updateruang" value="ok" class="btn btn-warning">Update</button>
									<?php } else { ?>
									<button type="submit" name="submitruang" value="ok" class="btn btn-primary">Simpan</button>
									<?php } ?>
									
									<button type="cancel" class="btn btn-default">Reset</button>
								</div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Ruang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="30">No.</th>
                  <th width="60">Action</th>
                  <th>Nama Ruang</th>
                </tr>
                </thead>
                <tbody>
<?php $hasil=mysql_query("SELECT * FROM ruang left join sekolah on ruang.kd_sek=sekolah.kd_sek ORDER BY sekolah.nm_sek, nm_ruang");
	while ($dt=mysql_fetch_array($hasil))
	{
		$i++;
		$kd=$converter->encode("$dt[0]");
?>
                <tr>
                  <td><?= $i ?>. </td>
                  <td><a href="?ac=renruang&ren=<?= $kd ?>" ><i class="glyphicon glyphicon-pencil"></i></a> | 
  <a href="?ac=delruang&del=<?= $kd?>" onclick="<?php Kdel($dt[nm_ruang]); ?>" ><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                  <td><?= "$dt[nm_ruang] - ($dt[nm_sek])"; ?></td></tr>     
<?php } ?>									
                </tbody>
                <tfoot>
                <tr>
                  <th>No.</th>
                  <th>Action</th>
                  <th>Nama Ruang</th>
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

  