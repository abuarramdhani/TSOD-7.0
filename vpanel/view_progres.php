<?php
	require "./bin/setup.php";
	$id=$converter->decode($_GET[id]);
//	$tm1=time()-(60*15);    
	$query1=mysql_query("SELECT users.real_name, ujian.nm_ujian, ujian.jml_soal, soal.q, soal.a, soal.kd_soal, login.mulai, login.sesi, tempo.jawaban FROM tempo, users, soal, ujian, login WHERE ujian.kd_ujian=tempo.kd_ujian and tempo.user_id=login.user_id and users.user_id=tempo.user_id and soal.kd_soal=tempo.kd_soal and login.user_id='$id'");
	$data=mysql_fetch_array($query1);
	$tgl=date("Y-m-d H:i:s",$data[mulai]);
	$dt1=$converter->encode("$a[0]|$a[1]|$a[2]|$a[3]|$a[4]|$a[5]");
	
	while ($dt=mysql_fetch_array($query1))
	{
		if ($dt[jawaban]!='') $menjawab++;
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
              <h3 class="box-title">Jawaban sementara dari '<?php echo "$data[0]";?>' </h3>
            </div>
            <!-- /.box-header -->
					<div class="box-body">
              <dl class="dl-horizontal">
                <dt>Ujian &nbsp;:</dt>
                <dd><?php echo "$data[nm_ujian]";?></dd>
                <dt>Jumlah Soal &nbsp;:</dt>
                <dd><?php echo $data[jml_soal] ?></dd>
                <dt>Tanggal &nbsp;:</dt>
                <dd><?php echo "$tgl";?></dd>
                <dt>Menjawab&nbsp;:</dt>
                <dd><?php echo "$menjawab" ?></dd>
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
<?php $query1=mysql_query("SELECT ujian.jml_soal, soal.kd_soal, soal.q, soal.a, tempo.jawaban, tempo.a1, tempo.a2, tempo.a3, tempo.a4, tempo.a5  FROM tempo, users, soal, ujian WHERE ujian.kd_ujian=tempo.kd_ujian and users.user_id=tempo.user_id and soal.kd_soal=tempo.kd_soal and tempo.user_id='$id' ORDER BY tempo.kd_tempo ASC");

	while ($data=mysql_fetch_array($query1))
	{
			$i++;
			$sty='bg-red-active';
			if ($data[a]==$data[jawaban])
			{
				$jml=2;
				$sty='bg-green-active';
			}
			else $jml=3;
			if (empty($data[jawaban]))
			{
				$sty='bg-yellow-active';
				$data[jawaban]=" <i>Belum menjawab</i>";
			}
  ?>                  <tr>
                  <td rowspan="<?= $jml ?>"><?= $i ?>. </td>
                  <td rowspan="<?= $jml ?>"><?php echo "$data[kd_soal]";?></td>
									<td><?php echo "$data[q]";?></td>
                  </tr>
									<tr>
										<td class="<?= $sty ?>"><?php echo "$data[jawaban]";?></td>
									</tr>
									<?php if ($data[a]!=$data[jawaban]) { ?>
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


