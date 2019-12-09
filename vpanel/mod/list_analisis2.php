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
	                <th>Username</th>
	                <th>Benar</th>
<?php                   
	if ($_GET[modul]!="none" && !empty($_GET[modul]))
    {
		$hasil1=mysql_query("SELECT soal.kd_soal FROM soal WHERE kd_modul='$_GET[modul]' ORDER BY kd_soal");                    
	   while ($dt1=mysql_fetch_array($hasil1))
	   {
            $n++;
            $soal[$n]=$dt1[0];
?>
            <th width="10"><?= $n ?></th>
<?php } } ?>                    
                </tr>
                </thead>
                <tbody>
 <?php              
    $hasil=mysql_query("SELECT DISTINCT(users.username), hasil.`kd_hasil`,hasil.`status`, hasil.`nilai` FROM hasil LEFT JOIN users ON users.`user_id`=hasil.`user_id` LEFT JOIN ujian ON ujian.`kd_ujian`=hasil.`kd_ujian` WHERE ujian.kd_modul='$_GET[modul]' ORDER BY users.`user_id`");   
	while ($dt=mysql_fetch_array($hasil)) 
	{
		$i++;
        $a=explode('|',$dt[2]);
        $benar=$a[0];
        
?>
                <tr>
                  <td><?= $i ?>. </td>
                  <td><?= $dt[username]; ?></td>
                  <td><?= $benar ?></td>
                <?php
                    for($j=1; $j<=$n; $j++)
	                   {
                            $dt2=mysql_fetch_array(mysql_query("SELECT jawaban.jawaban, soal.a FROM jawaban left join soal on soal.kd_soal=jawaban.kd_soal WHERE jawaban.kd_hasil='$dt[kd_hasil]' and jawaban.kd_soal='$soal[$j]'"));             
                            if ($dt2[0]==$dt2[1]) $st=1;
                            else $st=0;
                ?>
            <th width="10"><?= $st ?></th>
                <?php } ?>
                </tr>     
<?php } ?>									
                </tbody>
                <tfoot>
<tr>
                    <th width="10">No.</th>
	                <th>Username</th>
	                <th>Benar</th>
<?php                   
	   for($j=1; $j<=$n; $j++)
	   {
?>
            <th width="10"><?= $j ?></th>
<?php } ?>                    
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