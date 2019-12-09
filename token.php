<?php
	if(!defined('gaklangsung'))
	die("<h3>Akses terbatas!</h3>");		
	$msg=$converter->decode($_GET[msg]); 
?>
<!doctype html>
<html lang="en">

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

        <?php if ($msg !=2) {
            ?>input.username {
                background: #fff;
            }

            <?php
        }

        else {
            ?>input.username {
                background: #FFB7B7;
            }

            <?php
        }

        if ($msg !=3) {
            ?>input.password {
                background: #fff;
            }

            <?php
        }

        else {
            ?>input.password {
                background: #FFB7B7;
            }

            <?php
        }

        ?>

    </style>

    <link href="./assets/css/fonts.css" rel="stylesheet" />
    <link href="./assets/css/main.css" rel="stylesheet" />
    <script language="javascript" type="text/javascript">
        function textCounter(textField) {
            if (textField.value.length == 6) {
                document.getElementById("btnToken").disabled = false;
            } else {
                document.getElementById("btnToken").disabled = true;
            }
        }

        function def() {
            document.getElementById("btnToken").disabled = true;
        }

    </script>

</head>

<body onload="def()">


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
                                <a href="logout.php" class="logout">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="main-content">


                <div class="page-column">
                    <?php if (!empty($msg)) { ?>
                    <div class="alert alert-danger" role="alert" style="font-size: 16px;">
                        <div class="validation-summary-valid" data-valmsg-summary="true">
                            <?php echo $msg; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="page-col-middle col-centered">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="panel-title page-label">Konfirmasi Data Peserta</h1>
                            </div>
                            <div class="panel-body">
                                <div class="inner-content">
                                    <form action="cektoken.php" method="post">
                                        <div class="inner-content">
                                            <div class="row">
                                                <div class="col-xs-1">&nbsp;</div>
                                                <div class="col-xs-11" style="font-size:14px">Nomor Ujian :
                                                    <br />
                                                    <?php echo $_SESSION['kode_id'] ?>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-11" style="font-size:14px">Nama Peserta :
                                                    <br />
                                                    <?php echo $_SESSION['is_name'] ?>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-11" style="font-size:14px">Asal Sekolah :
                                                    <br />
                                                    <?php echo $_SESSION['is_sekolah'] ?>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-11" style="font-size:14px">Mata Ujian :
                                                    <br />
                                                    <?php $jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo where user_id='$_SESSION[user_id]' ORDER BY kd_soal"));
	if ($jml > 0)
	{
		$dt011=mysql_fetch_row(mysql_query("SELECT tempo.kd_soal, tempo.kd_ujian, ujian.nm_ujian FROM tempo left join ujian on ujian.kd_ujian=tempo.kd_ujian where tempo.user_id='$_SESSION[user_id]' ORDER BY kd_soal LIMIT 1"));
		$blok=true;
		echo strtoupper($dt011[2])," - sedang berlangsung";
		$kode=$converter->encode($dt011[1]);
	}
	else
	{
		$sekarang=date("Y-m-d H:i:s");
		
		$query=mysql_query("SELECT ujian.kd_ujian, ujian.nm_ujian, ujian.max FROM ujian, d_ujian, users WHERE d_ujian.kd_ujian=ujian.kd_ujian and users.kd_kelas=d_ujian.kd_kelas and users.user_id='$_SESSION[user_id]' and ujian.tgl_mulai <= '$sekarang' and ujian.tgl_selesai >= '$sekarang' ORDER BY ujian.kd_ujian");	
		while ($dt=mysql_fetch_array($query))
		{
			if (!$blok)
			{
				$jl=mysql_num_rows(mysql_query("SELECT kd_hasil FROM hasil WHERE user_id='$_SESSION[user_id]' and kd_ujian='$dt[0]'"));
				if ($jl<$dt[2])
				{
					$kode=$converter->encode($dt[0]);			
					$dt[1]=str_replace(".","",$dt[1]);
					echo strtoupper($dt[1]);
					$blok=true; 
				}
			}
		}
	}						?>
                                                </div>
                                            </div>
                                            <hr />
                                            <?php if ($blok==true) { ?>
                                            <div class="row">
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-11" style="font-size:14px">Token:
                                                    <br />
                                                    <input type="hidden" name="kode" value="<?php echo $kode ?>" />
                                                    <input name="token" style="font-size:18px;" size="6" maxlength="6" type="text" class="text" onKeyPress="textCounter(this.form.token);" onKeyUp="textCounter(this.form.token);" onChange="textCounter(this.form.token);" autofocus required="required" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-xs-9"></div>
                                                <div class="col-xs-3">
                                                    <button type="submit" class="btn btn-success btn-block" name="Submittoken" value="1" id="btnToken">Lanjutkan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else echo "<h3 style=\"
    text-align: center;
    size: 16px;
    color: #F33;\">Tidak ada mata ujian yang dijadwalkan untuk anda!</h3>"; ?>
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
