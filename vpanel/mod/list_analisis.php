<?php
    error_reporting(1);
	if (empty($_GET[modul])) $_GET[modul]='none';
	else $_GET[modul]=$converter->decode($_GET[modul]);
?>
<legend><img src="./assets/list.soal.png" width="48"> Analisis Soal <?php if (!empty($_GET[modul]) and $_GET[modul]!='none') {
  		$dt=mysql_fetch_row(mysql_query("SELECT nm_modul FROM modul WHERE kd_modul='$_GET[modul]'"));
		echo "Modul $dt[0]";
  }
  ?></legend>

<div class="box">            
            <!-- /.box-header -->
            <div class="box-body">
							<div class="box-header"> Modul : 
              <select name="menu1"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
      <?php 			
	  	$kode=$converter->encode('none');

	    if ($_GET[modul]=="none") echo "<option value=\"to=$analisissoal&modul=$kode\" selected>pilih salah satu</option>";
		else echo "<option value=\"./?to=$analisissoal&kelas=$kode\">pilih salah satu</option>";
		
		$query=mysql_query("SELECT * FROM modul WHERE status='Aktif' ORDER BY nm_modul");
		while ($dt=mysql_fetch_row($query))
		{
			$kode=$converter->encode($dt[0]);

			if ($_GET[modul]==$dt[0])
				echo "<option value=\"./?to=$analisissoal&modul=$kode\" selected>$dt[1]</option>";
			else
				echo "<option value=\"./?to=$analisissoal&modul=$kode\">$dt[1]</option>";
		}
      ?>
      </select>
            </div>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="10">No.</th>
	                <th>Soal</th>
	                <th>Dikerjakan Sebanyak</th>
	                <th>Siswa menjawab benar</th>
	                <th>Siswa menjawab salah</th>
	                <th>Siswa tidak menjawab</th>
                </tr>
                </thead>
                <tbody>
 <?php              
    $hasil=mysql_query("SELECT kd_soal, q, a FROM soal WHERE  kd_modul='$_GET[modul]' ORDER BY kd_modul");   
	while ($dt=mysql_fetch_array($hasil)) 
	{
		$i++;
        $jml=mysql_num_rows(mysql_query("SELECT kd_jawaban FROM jawaban WHERE`kd_soal`='$dt[kd_soal]'"));   
        $benar=mysql_num_rows(mysql_query("SELECT kd_jawaban FROM jawaban WHERE`kd_soal`='$dt[kd_soal]' and jawaban='$dt[a]'")); $salah=mysql_num_rows(mysql_query("SELECT kd_jawaban FROM jawaban WHERE`kd_soal`='$dt[kd_soal]' and jawaban!='$dt[a]' and `option`!=''"));   
        $abstain=mysql_num_rows(mysql_query("SELECT kd_jawaban FROM jawaban WHERE`kd_soal`='$dt[kd_soal]' and `option`=''")); 
?>
                <tr>
                  <td><?= $i ?>. </td>
                  <td><?= substr($dt[q],0,100); ?></td>
                  <td><?= $jml ?></td>
                  <td><?= $benar ?></td>
                  <td><?= $salah ?></td>
                  <td><?= $abstain ?></td>
                </tr>     
<?php } ?>									
                </tbody>
                <tfoot>
<tr>
                    <th width="10">No.</th>
	                <th>Soal</th>
	                <th>Dikerjakan Sebanyak</th>
	                <th>Siswa menjawab benar</th>
	                <th>Siswa menjawab salah</th>
	                <th>Siswa tidak menjawab</th>
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