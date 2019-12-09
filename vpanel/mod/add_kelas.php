<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><img src="./assets/add.kelas.png" width="48"> Input Kelas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputkelas" class="col-sm-2 control-label">Nama kelas</label>
                  <div class="col-sm-4">
                    <input type="text" name="nm_kelas" value="<?= $_POST[nm_kelas] ?>" class="form-control" id="inputkelas" placeholder="">
                  </div>
                </div>                                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
								<div class="col-sm-2"></div>
								<div class="col-sm-4">
									<input type="hidden" name="kd" value="<?= "$_GET[ren]"; ?>">
									<?php if ($_GET[ac]=='renkelas') { ?>
									<button type="submit" name="updatekelas" value="ok" class="btn btn-warning">Update</button>
									<?php } else { ?>
									<button type="submit" name="submitkelas" value="ok" class="btn btn-primary">Simpan</button>
									<?php } ?>
									
									<button type="cancel" class="btn btn-default">Reset</button>
								</div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Kelas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="30">No.</th>
                  <th width="60">Action</th>
                  <th>Nama Kelas</th>
                </tr>
                </thead>
                <tbody>
<?php $hasil=mysql_query("SELECT * FROM kelas ORDER BY nm_kelas $sort");
	while ($dt=mysql_fetch_row($hasil))
	{
		$i++;
		$kd=$converter->encode("$dt[0]");
?>
                <tr>
                  <td><?= $i ?>. </td>
                  <td><a href="?ac=renkelas&ren=<?= $kd ?>" ><i class="glyphicon glyphicon-pencil"></i></a> | 
  <a href="?ac=delkelas&del=<?= $kd?>" onclick="<?php Kdel($dt[1]); ?>"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                  <td><?= $dt[1]; ?></td></tr>     
<?php } ?>									
                </tbody>
                <tfoot>
                <tr>
                  <th>No.</th>
                  <th>Action</th>
                  <th>Nama Kelas</th>
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

  