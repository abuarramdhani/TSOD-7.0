<?php
	if(!defined('gaklangsung'))
	die("<h3>Akses terbatas!</h3>");		
	$msg=$converter->decode($_GET[msg]);
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
</script>
    <link href="./assets/css/combined.css" rel="stylesheet">
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
	$is_login=microtime();
	$sesid=session_id();
	$waktusekarang=substr($is_login,11,10);
	$sisa=($_SESSION[waktupengerjaan])-($waktusekarang-$_SESSION[waktumulaiujian])+$bonus;
?>
                                <span class="ac-name">
                                    <?php echo strtoupper($nama[real_name]) ?></span>
                                <a href="logout.php" class="logout">Logout</a> </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="main-content">
                <!--soal-->
                <!--3 tombol dibawah-->

                <!--slider kanan-->
                <!--tombol selesai-->
                <style>
                    .page-column {
margin: 5px auto;
}
.btn-group-vertical>.btn-group:after, .btn-toolbar:after, .clearfix:after, .container-fluid:after, .container:after, .dropdown-menu>li>a, .form-horizontal .form-group:after, .modal-footer:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .page-column:after, .panel-body:after, .row:after, .ui-helper-clearfix:after, .widget-timer:after, .modal-footer:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .page-column:after, .panel-body:after, .row:after, .ui-helper-clearfix:after, .widget-timer:after {
    clear: both;
	}
	div {
    display: block;
}
</style>
                <div style="display: table" class="page-column">
                    <?php if (!empty($msg)) { ?>
                    <div class="alert alert-danger" role="alert" style="font-size: 16px;">
                        <div class="validation-summary-valid" data-valmsg-summary="true">
                            <?php echo $msg; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <form action="cekijin.php" method="post">
                        <div id="dialogKonfirmasi">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h1 class="panel-title page-label">Minta Ijin Petugas</h1>
                                </div>
                                <div class="panel-body">
                                    <div class="inner-content">
                                        <div class="row">
                                            <div class="col-xs-12" style="font-size:14px">Password Petugas:
                                                <input name="password" style="font-size:18px;" type="password" class="text" onKeyPress="textCounter(this.form.token);" onKeyUp="textCounter(this.form.token);" onChange="textCounter(this.form.token);" autofocus required="required" /></div>
                                        </div>
                                    </div>
                                    <div class="wysiwyg-content">
                                        <p>
                                            Mintalah petugas untuk memasukan password.<br>
                                            Hal ini terjadi karena anda tidak logout sebelumnya.<br>
                                            Pastikan anda selalu logout setelah mengakhiri ujian.
                                        </p>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-success btn-block" name="Submitijin" value="1" id="btnToken">Lanjutkan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

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
