<?php
	require "./bin/setup.php";
	require "./bin/exec.php";	
	$id=$converter->decode($_GET[id]);
	$tm1=time()-(60*15);
	mysql_query("DELETE FROM login WHERE login < '$tm1' and user_id>99 and mulai='' ");	
	$sql="SELECT users.real_name, ujian.nm_ujian, hasil.tgl_test, hasil.benar, hasil.soal, hasil.nilai, soal.q, jawaban.jawaban, soal.a, soal.kd_soal FROM hasil, users, jawaban, soal, ujian WHERE ujian.kd_ujian=hasil.kd_ujian and hasil.kd_hasil='$id' and jawaban.kd_hasil='$id' and users.user_id=hasil.user_id and soal.kd_soal=jawaban.kd_soal";
	$query1=mysql_query($sql);
	$data=mysql_fetch_array($query1);

	$tgl=date("d-m-Y H:i:s",$data[tgl_test]);
	$query1=mysql_query($sql);
	while ($dt=mysql_fetch_array($query1))
	{
		if ($dt[jawaban]!='') $menjawab++;
		else $kosong++;
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TSOD 7.0 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
	 <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>

  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body >
<div class="wrapper">
    <!-- Main content -->
    <div id="isi" class="content" style="border:1px; z-index:10">
			

<div class="box">
            <div class="box-header">
              <h3 class="box-title">Jawaban dari '<?php echo "$data[0]";?>' </h3>
            </div>
            <!-- /.box-header -->
					<div class="box-body">
              <dl class="dl-horizontal">
                <dt>Ujian &nbsp;:</dt>
                <dd><?php echo "$data[nm_ujian]";?></dd>
                <dt>Tanggal &nbsp;:</dt>
                <dd><?php echo "$tgl";?></dd>
								<dt>Jumlah Soal &nbsp;:</dt>
                <dd><?php echo $data[soal] ?></dd>                
                <dt>Menjawab&nbsp;:</dt>
                <dd><?php echo "$menjawab" ?></dd>
								<dt>Jawaban Benar&nbsp;:</dt>
                <dd><?php echo "$data[benar]" ?></dd>
								<dt>Tidak menjawab&nbsp;:</dt>
                <dd><?php echo "$kosong" ?></dd>
								<dt>Nilai&nbsp;:</dt>
                <dd><?= round($data[5]/10,2); ?></dd>
              </dl>
            </div>
	
            <div class="box-body">
							
              <table class="table table-bordered">
                <thead>
                <tr>
                  <th width="30">No.</th>
                  <th width="60">Kode Soal</th>
                  <th>Soal</th>
                </tr>
                </thead>
                <tbody>
<?php 
	$query1=mysql_query($sql);								
	while ($data=mysql_fetch_array($query1))
	{
			$i++;		
			if (empty($data[jawaban])) $data[jawaban]=" <i>Tidak menjawab</i>";
  ?>              
									<?php if ($data[a]==$data[jawaban]) { ?>
									<tr>
                  <td rowspan="2"><?= $i ?>. </td>
                  <td><?php echo "$data[kd_soal]";?></td>
									<td><?php echo "$data[q]";?></td>
                  </tr>
									<tr>
										<td align="center"><i class="glyphicon glyphicon-ok text-success" style="font-size:30px"></i></td>
										<td class="bg-green-active"><?php echo "$data[jawaban]";?></td>
									</tr>
									<?php } else { ?>
									
									<tr>
                  <td rowspan="3"><?= $i ?>. </td>
                  <td><?php echo "$data[kd_soal]";?></td>
									<td><?php echo "$data[q]";?></td>
                  </tr>
									<tr>
										<td align="center" rowspan="2"><i class="glyphicon glyphicon-remove text-danger" style="font-size:30px"></i></td>
										<td class="bg-red-active"><?php echo "$data[jawaban]";?></td>
									</tr>
									<tr>
										
										<td class="bg-green disabled"><?php echo "$data[a]";?></td>
									</tr><?php } ?>
<?php } ?>									
                </tbody>                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
		
		</div>
    <!-- /.content -->
  <br>
<br>
<br>
<br>
<br>

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="./bower_components/select2/dist/js/select2.full.min.js"></script>	
</body>
</html>


