<div class="box">
	<div class="box-header">
		<img src="./assets/list.petugas.png" width="48"> Data Petugas Ruang
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
						<a href="?ac=delpetugas&del=<?= $kd?>"><i class="glyphicon glyphicon-trash"></i></a>
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
	<!-- /.box-body -->
</div>
<script>
        $(document).ready(function() {
            $('#example1').dataTable({
                "aLengthMenu": [
                    [50, 100, 250, 500, -1],
                    [50, 100, 200, 500, "All"]
                ],
                "iDisplayLength": 100
            });
        });

    </script>