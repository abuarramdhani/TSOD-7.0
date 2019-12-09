<?php
	$filter=$_GET[filter];
	$value=$converter->decode($_GET[value]);
?>
<div class="box">
    <div class="box-header">
        <img src="./assets/view.result.png" width="48"> Hasil Ujian
        <?php if ($filter=='mapel') { ?>
        per Mapel :
        <select id="nm_ujian" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <?php 	
	echo "<option value=\"./?to=$_GET[to]&filter=mapel&value=all\" selected> Semua Ujian</option>";
	$qry=mysql_query("SELECT * FROM ujian ORDER BY nm_ujian"); 
	while ($dt=mysql_fetch_array($qry))
	{
		$kode=$converter->encode($dt[kd_ujian]);
		if ($dt[kd_ujian]==$value)
			echo "<option value=\"./?to=$_GET[to]&filter=mapel&value=$_GET[kd_ujian]\" selected>$dt[nm_ujian]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&filter=mapel&value=$kode\">$dt[nm_ujian]</option>";
	}
?>
        </select>
        <?php } elseif ($filter=='sekolah') { ?>
        per Sekolah :
        <select id="nm_ujian" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <?php 	
	echo "<option value=\"./?to=$_GET[to]&filter=sekolah&value=all\" selected> Semua Sekolah</option>";
	$qry=mysql_query("SELECT * FROM sekolah ORDER BY nm_sek"); 
	while ($dt=mysql_fetch_array($qry))
	{
		$kode=$converter->encode($dt[nm_sek]);
		if ($dt[nm_sek]==$value)
			echo "<option value=\"./?to=$_GET[to]&filter=sekolah&value=$_GET[nm_sek]\" selected>$dt[nm_sek]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&filter=sekolah&value=$kode\">$dt[nm_sek]</option>";
	}
?>
        </select>
        <?php } elseif ($filter=='kelas') { ?>
        per Kelas :
        <select id="nm_ujian" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <?php 	
	echo "<option value=\"./?to=$_GET[to]&filter=kelas&value=all\" selected> Semua Kelas</option>";
	$qry=mysql_query("SELECT * FROM kelas ORDER BY nm_kelas"); 
	while ($dt=mysql_fetch_array($qry))
	{
		$kode=$converter->encode($dt[kd_kelas]);
		if ($dt[nm_kelas]==$value)
			echo "<option value=\"./?to=$_GET[to]&filter=kelas&value=$_GET[nm_kelas]\" selected>$dt[nm_kelas]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&filter=kelas&value=$kode\">$dt[nm_kelas]</option>";
	}
?>
        </select> <?php } ?>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20">No.</th>
                    <th width="60">Action</th>
                    <th width="80">Id</th>
                    <th>Nama Lengkap</th>
                    <th width="40">Kelas</th>
                    <th width="200">Ujian</th>
                    <th width="40">Benar</th>
                    <th width="40">Soal</th>
                    <th width="40">Nilai</th>
                    <th width="80">Waktu</th>
                    <th>Lama Pengerjaan</th>
                </tr>
            </thead>
            <tbody>
                <?php   
		if ($_SESSION['is_admin'])
		{
			switch ($filter)  
			{
				case "kelas" : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM users right join hasil on users.user_id=hasil.user_id left join ujian on ujian.kd_ujian=hasil.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas WHERE users.kd_kelas='$value' ";
					break;
                 case "sekolah" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM users right join hasil on users.user_id=hasil.user_id left join ujian on ujian.kd_ujian=hasil.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas WHERE  users.kode_sekolah='$value'";
					break;        
				case "mapel" : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM users right join hasil on users.user_id=hasil.user_id left join ujian on ujian.kd_ujian=hasil.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas WHERE ujian.kd_ujian='$value' ";
					break;								
				default : 					
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM users right join hasil on users.user_id=hasil.user_id left join ujian on ujian.kd_ujian=hasil.kd_ujian left join kelas on kelas.kd_kelas=users.kd_kelas";
					break;
			}
		}
		elseif ($_SESSION['is_adminsekolah'])
		{
			switch ($filter) 
			{
				case "kelas" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM hasil, users, ujian, kelas WHERE   users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasil.user_id=users.user_id and ujian.kd_ujian=hasil.kd_ujian and kelas.kd_kelas=users.kd_kelas and users.kd_kelas='$value' ";//and hasil.status=10 ";
					break;                
				case "mapel" : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM hasil, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasil.user_id=users.user_id and ujian.kd_ujian=hasil.kd_ujian and kelas.kd_kelas=users.kd_kelas and ujian.kd_ujian='$value' ";//and hasil.status=10 ";
					break;								
				default : 
					$qry="SELECT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, hasil.benar, hasil.soal, hasil.nilai, hasil.tgl_test, hasil.kd_hasil, users.user_id, hasil.tgl_selesai-hasil.tgl_test as selisih, users.user_id FROM hasil, users, ujian, kelas WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and hasil.user_id=users.user_id and ujian.kd_ujian=hasil.kd_ujian and kelas.kd_kelas=users.kd_kelas ";//and hasil.status=10 ";
					break;
			}
		}			
           
		$query=mysql_query($qry);
		while ($dt=mysql_fetch_array($query))
		{		
			$kd=$converter->encode($dt[kd_hasil]);
			if (!empty($dt[tgl_test])) $tgl=date("d-m-Y H:i", $dt[tgl_test]);		
			else $tgl='-';		
			$selisih='';			
			$selisih1=$dt[selisih];
			if (floor($selisih1/86400)>=1)		
			{	
				$selisih=floor($selisih1/86400)." Hari ";
				$selisih1=$selisih1-($selisih*86400);
			}
			if (floor($selisih1/3600)>=1)		
			{	
				$selisih.=floor($selisih1/3600)." Jam ";
				$selisih1=$selisih1-($selisih*3600);
			}
			if (floor($selisih1/60)>=1)	$selisih.=floor($selisih1/60)." Menit ";
			//if ($selisih1%60!=0) 		$selisih.=($selisih1%60)." Detik";
			$i++;
  ?>

                <tr>
                    <td align="center"><?= $i ?>. </td>
                    <td align="center">
                        <a href="./?ac=badresult&del=<?= "$kd&filter=$_GET[filter]&value=$_GET[value]" ?>"><i class="fa fa-trash"></i></a> |
                        <a href="#" onclick="window.open('<?= "$namaserver/vpanel/view_result.php?id=$kd"; ?>', '_blank');"><i class="fa fa-search"></i></a> |


                        <a href="#" data-toggle="modal" data-target="#modal-default<?= $i ?>"><i class="fa fa-history"></i></a>

                        <div class="modal fade" id="modal-default<?= $i ?>">
                            <div class="modal-dialog">
                                <form method="post" target="">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Konfirmasi Ujian</h4>
                                        </div>
                                        <div class="modal-body row" align="left">
                                            <div class="col-sm-4" align="right">Mengujikan kembali Mapel :</div>
                                            <div class="col-sm-8" align="left"><?= $dt[nm_ujian] ?>
                                            </div>
                                        </div>
                                        <div class="row" align="left">
                                            <div class="col-sm-4" align="right">Pesera ujian :</div>
                                            <div class="col-sm-8" align="left"><?= $dt[real_name]; ?></div>
                                        </div>
                                        <div class="modal-body row" align="left">
                                            <div class="col-sm-4" align="right">DiUjian selama :</div>
                                            <div class="input-group col-sm-3" align="left">
                                                <input type="text" name="lama" value="30" class="form-control" align="left">
                                                <span class="input-group-addon">Menit</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="kd_hasil" value="<?= $kd ?>">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                                            <button type="submit" name="loop" value="ok" class="btn btn-primary">Restore</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </form>
                            </div>

                            <!-- /.modal-dialog -->
                        </div>



                        <!--<a href="./?ac=loop&loop=<?= "$kd&filter=$_GET[filter]&value=$_GET[value]" ?>"><i class="fa fa-history"></i></a>-->

                    </td>
                    <td align="left"><?= $dt[username]; ?></td>
                    <td><?= $dt[real_name]; ?></td>
                    <td><?= $dt[nm_kelas]; ?></td>
                    <td><?= $dt[nm_ujian]; ?></td>
                    <td><?= $dt[benar] ?></td>
                    <td><?= $dt[soal] ?></td>
                    <td><?= $dt[nilai] ?></td>
                    <td><?= date('d-m-Y H:i', $dt[tgl_test]); ?></td>
                    <td><?= $selisih; ?></td>
                </tr>
                <?php } ?>
            </tbody>
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
