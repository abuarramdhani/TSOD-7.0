<?php
	if (empty($_GET[modul])) $_GET[modul]='all';
	else $_GET[modul]=$converter->decode($_GET[modul]);
?>
<legend><img src="./assets/list.soal.png" width="48"> Daftar Soal <?php if ($_GET[modul]=='all') echo "Keseluruhan"; else {
  		$dt=mysql_fetch_row(mysql_query("SELECT nm_modul FROM modul WHERE kd_modul='$_GET[modul]'"));
		echo "$dt[0]";
  }
  ?></legend>

<div class="box">            
            <!-- /.box-header -->
            <div class="box-body">
							<div class="box-header"> Modul : 
              <select name="menu1"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
      <?php 			
	  	$kode=$converter->encode('all');

	    if ($_GET[modul]=="all") echo "<option value=\"to=$listsoal&modul=$kode\" selected>seluruh</option>";
		else echo "<option value=\"./?to=$listsoal&kelas=$kode\">seluruh</option>";
		
		$query=mysql_query("SELECT * FROM modul WHERE status='Aktif' ORDER BY nm_modul");
		while ($dt=mysql_fetch_row($query))
		{
			$kode=$converter->encode($dt[0]);

			if ($_GET[modul]==$dt[0])
				echo "<option value=\"./?to=$listsoal&modul=$kode\" selected>$dt[1]</option>";
			else
				echo "<option value=\"./?to=$listsoal&modul=$kode\">$dt[1]</option>";
		}
      ?>
      </select>
            </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10">No.</th>
                  <th width="30">Action</th>
                  <th width="100">Modul</th>
									<th>Soal</th>
									<th width="200">Jawaban</th>
									<th width="30">Acak Jawaban</th>
                </tr>
                </thead>
                <tbody>
 <?php 
	if ($_GET[modul]=="all")
		$hasil=mysql_query("SELECT soal.kd_soal, modul.nm_modul, soal.q, soal.a, soal.format FROM soal, modul WHERE modul.kd_modul=soal.kd_modul and modul.status='Aktif' ORDER BY soal.kd_soal");
	else
		$hasil=mysql_query("SELECT soal.kd_soal, modul.nm_modul, soal.q, soal.a, soal.format FROM soal, modul WHERE modul.kd_modul=soal.kd_modul and soal.kd_modul='$_GET[modul]' and modul.status='Aktif' ORDER BY soal.kd_soal");
	while ($dt=mysql_fetch_array($hasil))
	{
		$i++;
		$kd=$converter->encode("$dt[0]");
?>
                <tr>
                  <td><?= $i ?>. </td>
                  <td><a href="?ac=rensoal&ren=<?= $kd ?>" ><i class="glyphicon glyphicon-pencil"></i></a> | 
  <a href="?ac=delsoal&del=<?= $kd?>" ><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                  <td><?= $dt[nm_modul]; ?></td>
									<td><?= $dt[q]; ?></td>
									<td><?= $dt[a]; ?></td>
									<td><?php if ($dt[format]=='random') echo "Ya"; else echo "Tidak"; ?></td>
									</tr>     
<?php } ?>									
                </tbody>
                <tfoot>
                <tr>
                  <th width="10">No.</th>
                  <th width="30">Action</th>
                  <th width="150">Modul</th>
									<th>Soal</th>
									<th width="200">Jawaban</th>
									<th width="30">Acak Jawaban</th>
                </tr>
                </tfoot>
              </table>
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
            <!-- /.box-body -->
          </div>