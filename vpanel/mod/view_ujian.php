<?php
	$filter=$converter->decode($_GET[filter]);
	$value=$converter->decode($_GET[value]);
?>
<div class="box">
    <div class="box-header">
        <img src="./assets/view.ujian.png" width="48"> Ujian Sedang Berlangsung</div>

    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20">No.</th>
                    <th width="70">Action</th>
                    <th width="100">Id</th>
                    <th>Nama Lengkap</th>
                    <th width="40">Kelas</th>
                    <th width="200">Ujian</th>
                    <th width="40">Ruang</th>
                    <th width="40">Terjawab</th>
                    <th width="100">Waktu</th>
                    <th>Lama Pengerjaan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
  	 $sekarang=time();
		if ($_SESSION['is_admin'])
		{
			switch ($filter) 
			{
				case "kelas" : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ruang.nm_ruang, ujian.lama FROM tempo, users, ujian, kelas, login, ruang WHERE  tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and users.kd_kelas =  '$value' ";
					break;
				case "mapel" : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ruang.nm_ruang, ujian.lama FROM tempo, users, ujian, kelas, login, ruang WHERE  tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and ujian.kd_ujian='$value' ";
					break;
				case "modul" : 					
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ruang.nm_ruang, ujian.lama FROM tempo, users, ujian, kelas, login, ruang WHERE  tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and ujian.kd_modul='$value' ";
					break;
				default : 
					
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ruang.nm_ruang, ujian.lama FROM tempo, users, ujian, kelas, login, ruang WHERE  tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and ruang.kd_ruang=login.ruang";					
					break;
			}
		}
		elseif ($_SESSION['is_adminsekolah'])
		{
			switch ($filter) 
			{
				case "kelas" : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ujian.lama FROM tempo, users, ujian, kelas, login WHERE users.kode_sekolah='$_SESSION[is_nm_sekolah]' and  tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and users.kd_kelas =  '$value' ";
					break;
				case "mapel" : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ujian.lama FROM tempo, users, ujian, kelas, login WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and ujian.kd_ujian='$value' ";
					break;
				case "modul" : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ujian.lama FROM tempo, users, ujian, kelas, login WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id and ujian.kd_modul='$value' ";
					break;
				default : 
					$qry="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ujian.nm_ujian, ujian.jml_soal, login.mulai, users.user_id, login.waktu as selisih, login.sesi, login.ruang, users.user_id, ujian.lama FROM tempo, users, ujian, kelas, login WHERE  users.kode_sekolah='$_SESSION[is_nm_sekolah]' and tempo.user_id=users.user_id and ujian.kd_ujian=tempo.kd_ujian and kelas.kd_kelas=users.kd_kelas and login.user_id=users.user_id ";
					break;
			}
		}		
	//echo $qry;		
   	$hasil=mysql_query($qry);
	while ($dt=mysql_fetch_array($hasil))
	{
		$i++;
		$kd=$converter->encode($dt[user_id]);
		$terjawab=0;
		$qry2="SELECT jawaban FROM tempo WHERE user_id='$dt[user_id]'";
		$query2=mysql_query($qry2);
		while ($dt2=mysql_fetch_array($query2))
		{
			if ($dt2[0]!='') $terjawab++;
		}
        $now=time();
        $selisih=(($dt[lama]*60)-$dt[selisih])+($now-$dt[mulai]);
        $ts='';
		$selisih1=$selisih;
        //echo $selisih1;
		
		if (floor($selisih1/86400)>=1)
		{
			$ts=floor($selisih1/86400)." Hari ";
			$selisih1=$selisih1-($selisih*86400);
		}
		if (floor($selisih1/3600)>=1)		
		{	
			$ts.=floor($selisih1/3600)." Jam ";
			$selisih1=$selisih1-($selisih*3600);
		}
		if (floor($selisih1/60)>=1)	
			$ts.=floor($selisih1/60)." Menit ";
		
		if ($selisih1%60!=0) 		
            $ts.=($selisih1%60)." Detik";		
        
        $d=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$dt[user_id]'"));
        if ($d[sesi]=='Lock') 
        {    
            $konci=true;
            $c1="background-color: #ea6767; color: #FFF";
        }
        else 
        {
            $konci=false;
            $c1='';
        }
  ?>
                <tr style="<?= $c1 ?>">
                    <td align="center"><?= $i ?>. </td>
                    <td align="center">
                        <a href="./?ac=testbad&del=<?= "$kd&filter=$_GET[filter]&value=$_GET[value]" ?>"><i class="fa fa-trash"></i></a> |
                        <a href="#" onclick="window.open('<?= "$namaserver/vpanel/view_progres.php?id=$kd"; ?>', '_blank');"><i class="fa fa-search"></i></a> |
                        <a href="./?ac=locktest&lock=<?= "$kd&filter=$_GET[filter]&value=$_GET[value]" ?>"><i class="fa fa-lock"></i></a> |
                        <a href="./?ac=pull&pull=<?= "$kd&filter=$_GET[filter]&value=$_GET[value]" ?>"><i class="fa fa-magnet"></i></a>

                    </td>
                    <td align="left"><?= $dt[username]; ?></td>
                    <td><?= $dt[real_name]; ?></td>
                    <td><?= $dt[nm_kelas]; ?></td>
                    <td><?= $dt[nm_ujian]; ?></td>
                    <td><?= $dt[nm_ruang]; ?></td>
                    <td><?= "$terjawab dari $dt[jml_soal]"; ?></td>
                    <td><?= date('d-m-Y H:i:s', $dt[mulai]); ?></td>
                    <td><?= $ts; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Action</th>
                    <th>Id</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Ujian</th>
                    <th>Ruang</th>
                    <th>Soal Dikerjakan</th>
                    <th>Waktu</th>
                    <th>Lama Pengerjaan</th>
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
