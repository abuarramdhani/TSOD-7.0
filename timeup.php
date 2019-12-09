<?php
	require "bin/setup.php";	
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PUSPENDIK - CBT Application | </title>
    <meta name="description" content="Ujian Online SMKN 1 Banyuwangi">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function disableBackButton() {
            window.history.forward();
        }
        setTimeout("disableBackButton()", 0);

        function MM_goToURL() { //v3.0
            var i, args = MM_goToURL.arguments;
            document.MM_returnValue = false;
            for (i = 0; i < (args.length - 1); i += 2) eval(args[i] + ".location='" + args[i + 1] + "'");
        }

    </script>
    <link href="css/combined.css" rel="stylesheet">
</head>

<body class="font-medium">
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
                                <?php $qry=mysql_query("SELECT users.real_name, kelas.nm_kelas, users.username, users.kode_sekolah FROM users, kelas WHERE user_id='$_SESSION[user_id]' and kelas.kd_kelas=users.kd_kelas");
	$nama=mysql_fetch_array($qry);	
	//echo "Nama : $nama[real_name] / $nama[username]<br/>Kelas : $nama[nm_kelas] / $nama[kode_sekolah]<br>";
	$is_login=microtime();
	$sesid=session_id();
	$waktusekarang=substr($is_login,11,10);
	$sisa=($_SESSION[waktupengerjaan])-($waktusekarang-$_SESSION[waktumulaiujian])+$bonus;
?>
                                <span class="ac-name"><?php echo strtoupper($nama[real_name]) ?></span>
                                <a href="logout.php" class="logout">Logout</a> </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="main-content" id="soal">
                <!--soal-->
                <form action="" method="get" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="jwban" id="affan" value="0" />
                    <input type="hidden" name="ragugak" id="ragugak" value="<?php if($rag=='ragu') echo "0"; else echo "ragu"; ?>" />
                    <!--3 tombol dibawah-->

                    <!--slider kanan-->
                    <!--tombol selesai-->
                    <style>
                        .page-column {
                            margin: 5px auto;
                        }

                        .btn-group-vertical>.btn-group:after,
                        .btn-toolbar:after,
                        .clearfix:after,
                        .container-fluid:after,
                        .container:after,
                        .dropdown-menu>li>a,
                        .form-horizontal .form-group:after,
                        .modal-footer:after,
                        .navbar-collapse:after,
                        .navbar-header:after,
                        .navbar:after,
                        .page-column:after,
                        .panel-body:after,
                        .row:after,
                        .ui-helper-clearfix:after,
                        .widget-timer:after,
                        .modal-footer:after,
                        .navbar-collapse:after,
                        .navbar-header:after,
                        .navbar:after,
                        .page-column:after,
                        .panel-body:after,
                        .row:after,
                        .ui-helper-clearfix:after,
                        .widget-timer:after {
                            clear: both;
                        }

                        div {
                            display: block;
                        }

                    </style>
                    <div style="display: table" class="page-column">

                        <div id="dialogKonfirmasi">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h1 class="panel-title page-label">Waktu Habis</h1>
                                </div>
                                <div class="panel-body">
                                    <div class="inner-content">
                                        <div class="row">
                                            <div class="col-xs-3 glyphicon-left-panel">
                                                <span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </div>
                                            <div class="col-xs-9">
                                                <div class="wysiwyg-content">
                                                    <p>
                                                        Waktu pengerjaan anda untuk ujian <?php echo "$_SESSION[nm_ujian] selama ",ceil($_SESSION[waktupengerjaan]/60); ?> menit telah habis!<br />
                                                        Secara otomatis program telah menarik hasil pekerjaan anda. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-success btn-success" id="btnLanjut1" onClick="MM_goToURL('parent','./?to=<?php echo $converter->encode('main');?>');return document.MM_returnValue" data-bind="click: redirectToDone">Menu Utama</button>
                                        </div>
                                        <div class="col-xs-6">
                                            <button onClick="MM_goToURL('parent','logout.php');return document.MM_returnValue" type="submit" class="btn btn-danger btn-block">Keluar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
