<?php
	if(!defined('gaklangsung'))
	die("<h3>Akses terbatas!</h3>");
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
                                <h1 class="panel-title page-label"> Error Code : <?php if (!empty($_GET[error])) echo $_GET[error]; else echo "unknown"; ?></h1>
                            </div>
                            <div class="panel-body">
                                <div class="inner-content">
                                    <div class="row">
                                        <div class="col-xs-3 glyphicon-left-panel">
                                            <img src="./assets/warning.png" align="absmiddle" width="82px" /> </div>
                                        <div class="col-xs-9">
                                            <div class="wysiwyg-content"><br>

                                                <p>
                                                    <?php
	switch ($_GET[error])
	{
        //fatal error    
        case '11'	: echo "Mohon maaf atas gangguan ini.<br/>System sedang melakukan update bank soal<br/>Silahkan reload halaman dalam 10 menit,<br/>atau jika hal tersebut tidak membantu <br/>silahkan masuk ke menu utama<br/>dan mengulangi pemilihan jadwal ujian.<br/><br/>Jika kesalahan ini terjadi lagi silahkan hubungi operator.";
					  break;	
        //error hak akses ujian    
		case '21'	: echo "System gagal mengenali ujian yang sedang diujikan<br/>Silahkan masuk ke menu utama<br/>dan mengulangi pemilihan jadwal ujian.<br/><br/>Jika kesalahan ini terjadi lagi silahkan hubungi petugas.";
					  break;	
		case '22'	: echo "Jadwal ujian sudah kadarluarsa<br/>Silahkan ulangi login dan memasukan token.";
					  break;	
        //error soal    
        case '30'	: echo "Ada perubahan pada bank soal<br/>System tidak diperkenankan melanjutkan proses<br/><br/>Mintalah petugas melakukan pengecekan pada jadwal ujian anda.";
					  break;    
		case '31'	: echo "Ada kesalahan dalam peroses ujian anda sebelumnya<br/>Jumlah soal yang anda miliki berbeda dengan system kami. System tidak diperkenankan melanjutkan proses<br/><br/>silahkan hubungi petugas.";
					  break;
		case '32'	: echo "Ada kesalahan jumlah soal yang anda miliki<br/>Sampai hal tersebut terselesaikan System tidak diperkenankan melanjutkan proses<br/><br/>silahkan hubungi petugas.";
					  break;	
        case '33'	: echo "Anda sedang dalam pengerjaan ujian,<br/>Dan anehnya, pekerjaan anda tidak terbaca disistem<br/><br/>Silahkan hubungi petugas.";
					  break;	    
		case '34'	: echo "Ini sedikit aneh.<br/>Anda sedang dalam pengerjaan ujian sebelumnya.<br/>Namun, anda tidak memiliki akses didalamnya<br/><br/>Silahkan hubungi petugas.";
					  break;	
        //error session    
		case '41'	: echo "Anda tidak diperkenankan mengakses ujian tersebut.<br/>Silahkan masuk ke menu utama<br/>dan mengulangi pemilihan jadwal ujian.<br/><br/>Jika kesalahan ini terjadi lagi silahkan hubungi petugas.";
					  break;	
		case '42'	: echo "Sesi Ujian anda tidak valid<br/>Silahkan mengulangi peroses login.<br/><br/>Jika kesalahan ini terjadi lagi silahkan hubungi petugas.";
        //unknown error    
					  break;	
		default		: echo "Kesalahan tidak dikenali!<br/><br/>Mohon hubungi pengelola Aplikasi anda.";	
					  break;
	}
?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button onClick="MM_goToURL('parent','<?php 
$dt=mysql_fetch_array(mysql_query("SELECT ujian.jenis FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian left join login on login.user_id=tempo.user_id where tempo.user_id='$_SESSION[user_id]' LIMIT 1"));
if ($dt[jenis]==10)
    echo "ujianesay.php";
else
    echo "ujian.php";
				 ?>
                                                         ');return document.MM_returnValue" type="submit" class="btn btn-success btn-block">Reload</button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button onClick="MM_goToURL('parent','logout.php');return document.MM_returnValue" type="submit" class="btn btn-danger btn-block">Keluar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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