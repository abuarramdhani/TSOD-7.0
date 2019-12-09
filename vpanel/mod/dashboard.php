<legend><img src="./assets/list.ujian.png" width="48"> Daftar Jadwal Ujian</legend>

<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="10">No.</th>
                    <th width="200">Nama Ujian</th>
                    <th width="100">jadwal</th>
                    <th>Kelas</th>
                    <th width="60">Soal</th>
                    <th width="30">Ket</th>
                </tr>
            </thead>
            <tbody>
                <?php 									
									$hasil=mysql_query("SELECT ujian.kd_ujian, ujian.nm_ujian, modul.nm_modul, ujian.jml_soal, ujian.tgl_mulai, ujian.tgl_selesai, modul.kd_modul, ujian.acak, ujian.jenis, ujian.lama FROM ujian, modul WHERE modul.kd_modul=ujian.kd_modul ORDER BY ujian.tgl_mulai, ujian.kd_ujian");
	while ($dt=mysql_fetch_array($hasil))
	{
		if ($dt[acak]==true) $acak="diacak"; else $acak="";
		$i++;
?>
                <tr>
                    <td><?= $i ?>. </td>
                    <td><?= $dt[nm_ujian]; ?></td>
                    <td><?= "$dt[tgl_mulai]<br/>$dt[tgl_selesai]"; ?></td>
                    <td><?php $query=mysql_query("SELECT kelas.nm_kelas FROM kelas, d_ujian WHERE kelas.kd_kelas=d_ujian.kd_kelas and d_ujian.kd_ujian='$dt[0]'");
  while($dt1=mysql_fetch_row($query))
  {
  	echo "$dt1[0], "; 
  }
  $jml_soal=mysql_fetch_row(mysql_query("SELECT count(kd_soal) FROM soal WHERE kd_modul='$dt[6]'")); 
  ?></td>
                    <td><?php echo "$dt[3] $acak"; ?></td>
                    <td><?= "$dt[lama] Menit<br/>jenis : $dt[jenis]"; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nama Ujian</th>
                    <th>jadwal</th>
                    <th>Kelas</th>
                    <th>Soal</th>
                    <th>Ket</th>
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
