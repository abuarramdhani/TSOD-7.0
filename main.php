<?php
	if(!defined('gaklangsung'))
	die("<h3>Akses terbatas!</h3>");	
	$kode=$converter->decode($_GET[kode]); 
	$dt=mysql_fetch_array(mysql_query("SELECT ujian.kd_ujian, ujian.nm_ujian, ujian.lama, ujian.jenis FROM ujian, d_ujian, users WHERE d_ujian.kd_ujian=ujian.kd_ujian and users.kd_kelas=d_ujian.kd_kelas and users.user_id='$_SESSION[user_id]' and ujian.kd_ujian='$kode' ORDER BY ujian.kd_ujian"));    
	if ($dt[jenis]>3)
	{
		$dt[nm_ujian]='Essay';
		$dt[lama]='15';
	}
    elseif ($dt[jenis]>2)
	{
		$dt[nm_ujian]='BAHASA ARAB';
		$dt[lama]='15';
    }

	if (!empty($dt[nm_ujian])) {
		$dt[nm_ujian]=str_replace(".","",$dt[nm_ujian]);
		$dt[nm_ujian]=strtoupper($dt[nm_ujian]);
		$jenistest="Online Test";
        $q=mysql_fetch_array(mysql_query("SELECT * FROM kunci WHERE user_id='$_SESSION[user_id]' and kd_ujian='$kode'"));
        if ($q[waktu]>1) 
            $waktu=ceil($q[waktu]/60)." Menit";
        else
            $waktu="$dt[lama] Menit";    
	}
	else
	{
		$dt[nm_ujian]="Tidak ada jadwal Ujian!";
		$jenistest="-";
		$waktu="-";
		$dis="disabled";
	}	    
?>
<!doctype html>
<html class="no-js" lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script src="./assets/js/SpryValidationTextField.js" type="text/javascript"></script>
<link href="./assets/css/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PUSPENDIK - CBT Application | </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function disableBackButton() {
            window.history.forward();
        }
        setTimeout("disableBackButton()", 0);

    </script>
    <style>
        .no-close .ui-dialog-titlebar-close {
            display: none;
        }

    </style>
    <link href="./assets/css/fonts.css" rel="stylesheet" />
    <link href="./assets/css/main.css" rel="stylesheet" />
</head>

<body>
    <main>
        <header>
            <nav class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="#">PUSPENDIK - CBT APPLICATION</a>
                    <div class="pull-right bg-dark">
                        <div class="access-panel">
                            <div class="ac-avatar"></div>
                            <div class="ac-info">
                                <span class="ac-welcome">Selamat Datang</span>
                                <span class="ac-name"><?php echo strtoupper($_SESSION['is_name']) ?></span>
                                <a href="logout.php" class="logout">Logout</a> </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="main-content">
                <div class="page-column">
                    <?php     
    $d=mysql_fetch_array(mysql_query("SELECT sesi FROM login WHERE user_id='$_SESSION[user_id]'"));
    if($d[sesi]=='Lock') 
    { 
        $dis="disabled";
                    ?>
                    <div class="alert alert-danger" role="alert" style="font-size: 16px;">
                        <div class="validation-summary-valid" data-valmsg-summary="true">Akses Ujian anda ditutup sementara, mintalah petugas untuk membuka kembali akses ujian anda!
                        </div>
                    </div>
                    <?php } ?>
                    <div class="page-col-middle col-left">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title page-label">Konfirmasi Tes</h1>
                            </div>
                            <div class="panel-body">
                                <div class="inner-content">
                                    <div class="row">
                                        <div class="col-xs-1">&nbsp;</div>
                                        <div class="col-xs-11" style="font-size:14px">Nama Tes :<br />
                                            <?= $dt[nm_ujian] ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-11" style="font-size:14px">
                                            Status Tes :<br /><?= $jenistest ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-11" style="font-size:14px">
                                            Tanggal Tes :<br /><?= date("d - m - Y"); ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-11" style="font-size:14px">
                                            Waktu Tes :<br /><?= date("H:i:s")," WIB"; ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-11" style="font-size:14px">
                                            Alokasi Waktu :<br /><?= $waktu ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-col-small col-right">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="inner-content">
                                    <form action="begintest.php" method="get">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <input type="hidden" name="id" value="<?= $_GET[kode] ?>" />
                                                <button type="submit" class="btn btn-danger btn-block" name="mulaiujian" value="1" id="btnUjian" <?= $dis ?>> Lanjutkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>SMKN 1 Banyuwangi, has-no-Copyrights</p>
        </div>
    </footer>
</body>

</html>
