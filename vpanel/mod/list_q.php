<?php
	$kode=$converter->encode('all');
	if (empty($_GET[kelas])) $_GET[kelas]=$kode;	
	if (empty($_GET[sek])) $_GET[sek]=$kode;
	if (empty($_GET[q])) $_GET[q]='';
	$kelas=$converter->decode($_GET[kelas]);
	$sek=$converter->decode($_GET[sek]);
?>
<div class="box">
	<div class="box-header">
<img src="./assets/list.q.png" width="48"> Daftar User</div>
      
	&nbsp; &nbsp; Kelas : 
	<select id="kelas" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
	  <?php   				
		echo "<option value=\"./?to=$_GET[to]&kelas=$kode&sek=$_GET[sek]\" selected>-All-</option>";
	  	$qry=mysql_query("SELECT DISTINCT kelas.kd_kelas, kelas.nm_kelas FROM kelas, users WHERE kelas.kd_kelas=users.kd_kelas and user_id >= 1000  ORDER BY kelas.nm_kelas"); //and (users.username like '%$_GET[q]%' or users.real_name like '%$_GET[q]%' or users.kode_sekolah like '%$_GET[q]%' or users.email like '%$_GET[q]%' or kelas.nm_kelas like '%$_GET[q]%') ORDER BY kelas.nm_kelas");
		while ($dt=mysql_fetch_row($qry))
		{
				$kode=$converter->encode($dt[0]);
	  		if ($dt[0]==$kelas)
				echo "<option value=\"./?to=$_GET[to]&kelas=$kode&sek=$_GET[sek]\" selected>$dt[1]</option>";
			else
				echo "<option value=\"./?to=$_GET[to]&kelas=$kode&sek=$_GET[sek]\">$dt[1]</option>";
		}		
	  ?>
      </select>
	&nbsp; &nbsp; Sekolah :       
      <select id="sekolah"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
<?php 	
	echo "<option value=\"./?to=$_GET[to]&kelas=$_GET[kelas]&sek=$kode\" selected>-All-</option>";
	$qry=mysql_query("SELECT DISTINCT kode_sekolah FROM users WHERE user_id >= 1000 ORDER BY kode_sekolah"); // and (username like '%$_GET[q]%' or real_name like '%$_GET[q]%' or kode_sekolah like '%$_GET[q]%' or email like '%$_GET[q]%' ) ORDER BY kode_sekolah");
	while ($dt=mysql_fetch_row($qry))
	{
		$kode=$converter->encode($dt[0]);
		if ($dt[0]==$sek)
			echo "<option value=\"./?to=$_GET[to]&kelas=$_GET[kelas]&sek=$kode\" selected>$dt[0]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&kelas=$_GET[kelas]&sek=$kode\">$dt[0]</option>";
	}
?>		
	  </select>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="30">No.</th>
					<th width="80">Action</th>
					<th>Nama Lengkap</th>
					<th width="60">Kelas</th>
					<th width="60">Email</th>
					<th width="200">Asal Sekolah</th>
					<th width="120">Join</th>
				</tr>
			</thead>
			<tbody>
				<?php 
  	$qry="SELECT users.user_id, users.username, users.real_name, users.kode_sekolah, users.email, users.date_joined, kelas.nm_kelas  FROM users, kelas WHERE kelas.kd_kelas=users.kd_kelas and user_id >= 1000 and (users.username like '%$_GET[q]%' or users.real_name like '%$_GET[q]%' or users.kode_sekolah like '%$_GET[q]%' or users.email like '%$_GET[q]%' or kelas.nm_kelas like '%$_GET[q]%') ";
	if ($kelas!='all') 	
		$qry.=" and kelas.kd_kelas='$kelas' ";
	if ($sek!='all') 	
		$qry.=" and users.kode_sekolah='$sek' ";		
   	$hasil=mysql_query($qry);
	while ($dt=mysql_fetch_array($hasil))
	{
		$i++;
		$kd=$converter->encode($dt[0]);
  ?>  
				<tr>
					<td align="center"><?= $i ?>. </td>
					<td align="center">
<?php if ($_SESSION[user_id] <= 2) { ?>
						
<a href="./?ac=burn&burn=<?= "$kd&kelas=$_GET[kelas]&sek=$_GET[sek]&hal=$_GET[hal]" ?>"><i class="fa fa-times-circle"></i></a> | <?php } ?>
						
<a href="./?ac=rst&rst=<?= "$kd&kelas=$_GET[kelas]&sek=$_GET[sek]&hal=$_GET[hal]" ?>"><i class="fa fa-key"></i></a>
<?php if ($_SESSION['user_id'] <= 5) { ?> | 
						
<a href="./?ac=renuser&ren=<?= "$kd&kelas=$_GET[kelas]&sek=$_GET[sek]&hal=$_GET[hal]" ?>"><i class="glyphicon glyphicon-pencil"></i></a> |
						
<a href="./?ac=deluser&del=<?= "$kd&kelas=$_GET[kelas]&sek=$_GET[sek]&hal=$_GET[hal]" ?>"><i class="fa fa-user-times"></i></a> <?php } ?>
						
					</td>
					<td align="left"><?= "($dt[username]) $dt[real_name]"; ?></td>
					<td><?= $dt[nm_kelas]; ?></td>
					<td><?= $dt[email]; ?></td>
					<td><?= $dt[kode_sekolah]; ?></td>
					<td><?= $dt[date_joined]; ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>No.</th>
					<th>Action</th>
					<th>Nama Lengkap</th>
					<th>Kelas</th>
					<th>Email</th>
					<th>Asal Sekolah</th>
					<th>Join</th>
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