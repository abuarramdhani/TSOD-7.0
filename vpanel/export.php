<?php
	require "./bin/setup.php";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=export.xls");
?>
<table border="1">
<tr>
<th>Id</th>
<th>No Ujian</th>
<th>Nama</th>
<th>Kelas</th>
<th>Ujian</th>
<th>Benar</th>
<th>Soal</th>
<th>Score</th>
<th>Tanggal ujian</th>
<th>Lama ujian</th>	
</tr>  
<?php
	$query=mysql_query($_POST[sql]);
	while ($dt1=mysql_fetch_array($query))
	{		
		if (!empty($dt1[7])) $tgl=date("d-m-Y H:i:s", $dt1[7]);		
		else $tgl='-';
		if ($dt1[selisih]>0)
			$lama=ceil($dt1[selisih]/60) . " Menit";
		else
			$lama="0 menit";
?>
<tr>
<td><?php echo "$dt1[9]";?></td>
<td><?php echo "$dt1[0]";?></td>
<td><?php echo "$dt1[1]";?></td>
<td><?php echo "$dt1[2]";?></td>
<td><?php echo "$dt1[3]";?></td>
<td><?php echo "$dt1[4]";?></td>
<td><?php echo "$dt1[5]";?></td>
<td><?php echo "$dt1[6]";?></td>
<td><?php echo $tgl;?></td>
<td><?php echo $lama;?></td>	
</tr>
<?php } ?>
</table>