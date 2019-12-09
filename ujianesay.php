<?php
	
	require "bin/setup.php";	
	if (!empty($_GET['namber'])) 	$namber=$converter->decode($_GET['namber']);
	if (!empty($_GET['ragu'])) 		$ragu=$converter->decode($_GET['ragu']);
  elseif (!empty($_POST['ragu'])) $ragu=$converter->decode($_POST['ragu']);
	if (!empty($_GET['id'])) 		  $id=$converter->decode($_GET['id']);
	elseif (!empty($_POST['id'])) 		  $id=$converter->decode($_POST['id']);
	if (!empty($_GET['end'])) 		$end=$converter->decode($_GET['end']);
	elseif (!empty($_POST['end'])) 		$end=$converter->decode($_POST['end']);
	
	//cek kode ujian
	if (empty($_SESSION[id_ujian]) && empty($_SESSION[jml_soal]))
	{
		$_SESSION[sts]='main';
		header("Location: ./");
	}
	//alternatif
	if ((!isset($_SESSION['id_ujian'])) and (!empty($ujian))) $_SESSION['id_ujian']=$ujian;
	elseif ((isset($_SESSION['id_ujian'])) and (empty($ujian))) $ujian=$id_ujian;
	elseif ((!isset($_SESSION['id_ujian'])) and (empty($ujian))) header("Location: ./?to=$warning&error=21");
	$nomorbaru--;
	$jmlsoal=$_SESSION[jml_soal];		

	//cek blokir
	$d=mysql_fetch_array(mysql_query("SELECT link FROM login WHERE user_id='$_SESSION[user_id]'"));
	$c=explode("|",$d[link]);	
	if ($c[0]!='free')
	{
		header("Location: ./?to=$block");
		exit;
	}
	else $bonus=$c[1];	//extra time
	
	//cek soal terdaftar
	$jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$_SESSION[user_id]'"));
	if ($jml!=$_SESSION[jml_soal])
	{
		if ($jml==0)
		{
			unset($_SESSION[waktupengerjaan]);
			unset($_SESSION['id_ujian']);
			unset($_SESSION['jml_soal']);
			unset($_SESSION[nm_ujian]);
			unset($_SESSION[panduan]);
			header("Location: ./?to=$warning&error=33");
			exit;			
		}
		header("Location: ./?to=$warning&error=32");
		exit;			
	}

	$waktusekarang=time();
	$sisa=($_SESSION[waktupengerjaan]-($waktusekarang-$_SESSION[waktumulaiujian]))+$bonus;
	$lama=$converter->encode('timeup');
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
				var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
				for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}

			function startTimer(duration, display) {
				var timer = duration, minutes, seconds;
				setInterval(function () {
					minutes = parseInt(timer / 3600, 10)
					seconds = parseInt(timer / 60, 10);

					minutes = minutes < 10 ? "0" + minutes : minutes;
					seconds = seconds < 10 ? "0" + seconds : seconds;

					display.textContent = seconds + " Menit";

					if (--timer < 0) {
						timer = duration;
						window.location = ("resultesay.php?do=<?php echo $converter->encode('timeup'); ?>");
					}
				}, 1000);
			}
			window.onload = function () {
    	var fiveMinutes = <?php echo $sisa ?>,
        display = document.querySelector('#time');
    		startTimer(fiveMinutes, display);
			};
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
					<script type="text/javascript">
						<?php

	if ((!isset($_SESSION['id_ujian'])) and (!empty($ujian))) $_SESSION['id_ujian']=$ujian;
	elseif ((isset($_SESSION['id_ujian'])) and (empty($ujian))) $ujian=$id_ujian;
	elseif ((!isset($_SESSION['id_ujian'])) and (empty($ujian)))
	{
		echo "parent.location = './?to=$warning&error=21'"; exit;
	}
	if (empty($_SESSION[id_ujian]) && empty($_SESSION[jml_soal]))
	{
		echo "parent.location = './?to=$warning&error=51'"; exit;
	}
	$d=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$_SESSION[user_id]'"));
	$c=explode("|",$d[link]);

	if ($c[0]=='lock')
	{
		echo "parent.location = './?to=$block'"; exit;
	}
	else $bonus=$c[1];


	$jml=mysql_num_rows(mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$_SESSION[user_id]'"));
	if ($jml!=$_SESSION[jml_soal])
	{
		if ($jml==0)
		{
			unset($_SESSION[waktupengerjaan]);
			unset($_SESSION['id_ujian']);
			unset($_SESSION['jml_soal']);
			unset($_SESSION[nm_ujian]);
			unset($_SESSION[panduan]);
			echo "parent.location = './?to=$warning&error=33'";
			exit;
		}
		echo "parent.location = './?to=$warning&error=32'"; exit;
	}
	if ((!isset($_SESSION['id_ujian'])) and (empty($ujian)))
	{
		echo "parent.location = './?to=$warning&error=21'"; exit;
	}
?>
					</script>
					<?php
	if (!empty($_POST[jawaban]))
	{
		$ans=explode("_",$id);	
		$_POST['jawaban']=mysql_real_escape_string(trim($_POST['jawaban']));
		mysql_query("UPDATE tempo SET jawaban='$_POST[jawaban]' WHERE kd_soal='$ans[0]' and user_id='$_SESSION[user_id]' and kd_ujian='$_SESSION[id_ujian]'");		
	}
	if ($ragu=='tdkragu')
	{
		$ans=explode("_",$id);	
		mysql_query("UPDATE tempo SET ket='' WHERE kd_soal='$ans[0]' and user_id='$_SESSION[user_id]' and kd_ujian='$_SESSION[id_ujian]'");
	}
		elseif ($ragu=='ragu')
		{
			$ans=explode("_",$id);	
		mysql_query("UPDATE tempo SET ket='ragu' WHERE kd_soal='$ans[0]' and user_id='$_SESSION[user_id]' and kd_ujian='$_SESSION[id_ujian]'"); 			
		}
	$ceked1=""; $ceked2=""; $ceked3=""; $ceked4=""; $ceked5="";
 	$timenya=microtime();
	$timenya=substr($timenya,11,10);
	$qry=mysql_query("UPDATE login SET login='$timenya' WHERE user_id='$_SESSION[user_id]' LIMIT 1");
	$jmlrow=ceil($jmlsoal/10);
	$lebarrow=43*$jmlrow;

	if (empty($_GET[namber])) $namber=1;
	$nomorbaru=$namber-1;
	$jmlsoal=$_SESSION[jml_soal];
	$lamabanget=0;
	$timenow=microtime();
	$timenow=substr($timenow,11,10);
	$qry=mysql_fetch_row(mysql_query("SELECT lama FROM ujian WHERE kd_ujian='$ujian'"));
	$lama_ujian=$qry[0] * 60 + 1;
	$qry=mysql_fetch_row(mysql_query("SELECT mulai FROM login WHERE user_id='$_SESSION[user_id]'"));
	$begin=$timenow-$qry[0];
	$begin=$lama_ujian - $begin;
	if ($begin > 0)
	
	{ $menit = floor ($begin / 3600); $detik= floor (($begin / 60)); }
	else
	{ $menit="00"; $detik="01"; }
	if ($menit<9) $menit='0'.$menit;
	if ($detik<9) $detik='0'.$detik;
	$rec=mysql_fetch_array(mysql_query("SELECT * FROM tempo WHERE user_id='$_SESSION[user_id]' and kd_ujian='$ujian' ORDER BY kd_tempo LIMIT $nomorbaru,1"));
	$soalnya=$rec[kd_soal];
	$jawaban=$rec[jawaban];		
	$rag=$rec[ket];
	$nomor=$namber;
	$kdsoal=$soalnya;
	$query1=mysql_query("SELECT q FROM soal WHERE kd_soal='$soalnya'");
	$dtd01=mysql_fetch_row($query1);
?>
						<div data-bind="with: testDetailList">
							<section class="page-section timer-section" <?php if ($end==1) echo 'style="display: none"'; ?>>
								<div class="row">
									<div class="col-xs-9">
										<h1 class="page-label soal-label">SOAL NO <span class="soal-no <?php if($rag=='ragu') echo "unsure"; ?>"><?php echo $nomor ?></span> <?php echo strtoupper("$_SESSION[nm_ujian]");?></h1>
										<h4><?php echo "$_SESSION[panduan]";?></h4>
									</div>

									<div class="col-xs-3">
										<div class="widget-timer pull-right">
											<div class="wg-info">Sisa Waktu</div>
											<div class="wg-countdown"  id="time"><?php echo floor($sisa/60)," Menit"; //echo "$detik Menit"; ?></div>
										</div>
									</div>
								</div>
							</section>

							<div class="sizing-text" <?php if ($end==1) echo 'style="display:none"'; ?>>
								<span class="sizing-text-info">Ukuran font soal: </span>
								<ol class="sizing-text-list">
									<script>
										function akecil() {
											document.getElementById("pnlSoal").style = "font-size:75%;";
                                            
                                            document.getElementById("cilik").style = "color:rgb(151, 151, 151)";
                                            
                                            document.getElementById("gede").style = "color:rgb(37, 37, 37)";
                                            
                                            document.getElementById("sedeng").style = "color:rgb(37, 37, 37)";
                                            
											document.cookie = "size=75";
										}

										function asedang() {
											document.getElementById("pnlSoal").style.fontSize = "100%";
                                            
                                            document.getElementById("cilik").style = "color:rgb(37, 37, 37)";
                                            
                                            document.getElementById("sedeng").style = "color:rgb(151, 151, 151)";
                                            
                                            document.getElementById("gede").style = "color:rgb(37, 37, 37)";
                                            
											document.cookie = "size=100";
										}

										function abesar() {
											document.getElementById("pnlSoal").style.fontSize = "150%";
                                            
                                            document.getElementById("cilik").style = "color:rgb(37, 37, 37)";
                                            
                                            document.getElementById("gede").style = "color:rgb(151, 151, 151)";
                                            
                                            document.getElementById("sedeng").style = "color:rgb(37, 37, 37)";
                                            
											document.cookie = "size=150";
										}									
									</script>
									<li><a href="#" class="fontSmall" onClick="akecil()" id="cilik">A</a></li>
									<li><a href="#" class="fontMedium" onClick="asedang()"  class="current" id="sedeng" style="color:rgb(151, 151, 151)">A</a></li>
									<li><a href="#" class="fontLarge" onClick="abesar()" id="gede">A</a></li>
								</ol>
							</div>
						</div>
						<!--soal-->
						<form action="" method="post" id="form" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="ragugak" id="ragugak" value="<?php if($rag=='ragu') echo " 0 "; else echo "ragu "; ?>"/>
							<section class="page-section main-section" <?php if ($end==1) echo 'style="display:none"'; ?>>
								<!-- soal start -->
								<div id="pnlSoal" style="border-color: #E0E0E0; border-style: Solid;">
									<div id="examcontent" class="Section1">
										<div style="width:100%">
											<?php 
											echo $dtd01[0];
											$id=$converter->encode($kdsoal."_".$nomor);
											?>
										</div>
										<div style="clear:both"></div>
									</div>
									<div>
										<div>											
											<textarea name="jawaban" id="jawaban" rows="6" cols="100" placeholder="Ketik jawaban disini" wrap="soft" class="esay" autofocus><?php echo $jawaban ?></textarea>
											<button id="simpan" onclick="this.form.submit();" class="btn btn-success btn-simpan activebutton">Simpan Jawaban</button>
										</div>
									</div>
								</div>
									<!-- end soal -->
							</section>
							<!--3 tombol dibawah-->
							<?php
 	$query1=mysql_query("SELECT link FROM login WHERE user_id='$_SESSION[user_id]'");
	$dtd01=mysql_fetch_row($query1);
	echo "<input type=hidden name=namber value=$_GET[namber]>";
	echo "<input type=hidden name=user_id value=$_SESSION[user_id]>";
	echo "<input type=hidden name=ujian value=$ujian>";
	echo "<input type=hidden name=id value=$id>";											
												
	if ($namber==1) $dis1='disabled="disabled"';
	else $pref=$converter->encode($namber-1);
	$k--;
	if ($namber==$_SESSION[jml_soal])  $dis2='disabled="disabled"';
	else $next=$converter->encode($namber+1);
 ?>
								<section class="page-section soal-navigation" <?php if ($end==1) echo 'style="display:none"'; ?>>
									<div class="action-wrapper">
										<div class="row">
											<div class="col-xs-4">
												<button class="btn btn-primary btn-prev activebutton" id="btnPrevSoal" onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $pref ?>');return document.MM_returnValue" <?php echo $dis1 ?>>SOAL SEBELUMNYA</button>
											</div>
											<div class="col-xs-4 text-center">
												<div class="unsure-checkbox" data-bind="with: testDetails()[currentNo()]">
													<input name="<?php echo $kdsoal ?>" type="checkbox" id="unsureCheckbox" onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $_GET['namber'] ?>&id=<?php echo $converter->encode($soalnya) ?>&ragu=<?php if($rag=='ragu') echo $converter->encode('tdkragu'); else echo $converter->encode('ragu') ?>'); return document.MM_returnValue" <?php if($rag=='ragu' ) echo "checked"; ?> >
													<label class="labelUnsureCheckbox" for="unsureCheckbox"> RAGU - RAGU</label>
												</div>
											</div>
											<div class="col-xs-4 text-right">
												<button id="btnNextSoal" onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $next ?>');return document.MM_returnValue" class="btn btn-primary btn-next activebutton" <?php echo $dis2 ?>>SOAL BERIKUTNYA</button>

												<button id="btnSelesai" class="btn btn-primary btn-next" data-bind="css: { 'activebutton':(currentNo() &gt;= totalQuestions - 1)}, visible: (currentNo() &gt;= totalQuestions - 1),click: gotoFinish" style="display: none;">SELESAI</button>
											</div>
										</div>
									</div>
								</section>
								<script>
									function slidein() {
										var x = document.getElementById("slide");
										var y = document.getElementById("tbl");
										x.style = "right: -390px; transition-delay:0s; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -o-transition-duration: 0.3s;   transition-duration: 0.3s;margin-top:100px;";
										setTimeout(function () {
											y.style = "background-image:url(./assets/icon-arrow-left.png); background-repeat:no-repeat; background-position:7px 20px; font-size:1.1em; font-weight: 700;color: #fff; min-height: 40px; padding: 17px 0 0 28px;  width: 85px; left: -85px;margin-top:-50px;";
										}, 300);
										y.onclick = function () {
											slide();
										};
									}

									function slide() {

										var x = document.getElementById("slide");
										var y = document.getElementById("tbl");
										x.style = "right: 0px; transition-delay:0s; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -o-transition-duration: 0.3s;   transition-duration: 0.3s;margin-top:100px;";

										setTimeout(function () {
											y.style = "background-image:url(./assets/icon-arrow-right.png); background-repeat:no-repeat; background-position:7px 20px; font-size:0em; font-weight: 700;color: #fff; min-height: 30px; padding: 17px 0 0 28px;  width: 30px; left: -30px;margin-top:-50px;";
										}, 300);
										y.onclick = function () {
											slidein();
										};
									}
								</script>
								<!--slider kanan-->
								<div class="panel-soal-slide" id="slide" style="margin-top:100px;">
									<span class="btn-panel" style="background-image:url(./assets/icon-arrow-left.png); background-repeat:no-repeat; background-position:7px 20px; font-size:1.1em; font-weight: 700;color: #fff; min-height: 40px; padding: 17px 0 0 28px; margin-top:-50px;" id="tbl" onClick="slide()">DAFTAR SOAL</span>
									<div class="panel-slide-content">
										<ul>
											<?php
$qry=mysql_query("SELECT jawaban, ket FROM tempo WHERE user_id='$_SESSION[user_id]' ORDER BY kd_tempo");
while ($dt=mysql_fetch_array($qry))
{
	$no++;
	if ($dt[ket]!='') 		{ $sdh='unsure'; $mshragu++; }
	elseif ($dt[jawaban]!='') 	{ $sdh='current'; $shddijerjakan++; }
	else 					{ $sdh=''; $mshkosong++; }

?>
												<li class="<?php echo " $sdh " ?>">
													<a href="ujianesay.php?namber=<?php echo $converter->encode($no); ?>">
														<?php echo $no ?>
													</a><span></span></li>
												<?php } ?>
										</ul>
										<?php if ($shddijerjakan>=($jmlsoal*(3/4))) { ?>
											<button type="submit" class="btn btn-danger btn-block" onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $_GET['namber'] ?>&end=<?php echo $converter->encode('1'); ?>');return document.MM_returnValue">Selesai</button>
											<?php } ?>
									</div>
								</div>
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
								<div <?php if ($end==1) echo 'style="display: table"'; else echo 'style="display: none"'; ?> class="page-column">
									<?php if (empty($mshkosong) and empty($mshragu)) { //tdk ada yg kosong, tdk ada yg ragu?>

										<div id="dialogKonfirmasi">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h1 class="panel-title page-label">Konfirmasi Tes</h1>
												</div>
												<div class="panel-body">
													<div class="inner-content">
														<div class="row">
															<div class="col-xs-3 glyphicon-left-panel"><img src="./assets/warning.png" align="absmiddle" width="82px" /></div>
															<div class="col-xs-9">
																<div class="wysiwyg-content">
																	<p class="lblHasDoubt">
																		<br> Apakah anda yakin ingin mengakhiri ujian ini?
																		<br> Setelah selesai mengerjakan anda tidak bisa kembali mengerjakan soal ini. </p>
																</div>
																<div class="assent-checkbox">
																	<input class="assentcb-input" type="checkbox" id="0-ascb" onChange="cek(1);">
																	<label class="assentcb-label" for="0-ascb">
																		Centang, kemudian tekan tombol selesai.
																		<br> Anda tidak akan bisa kembali ke soal
																		<br> jika sudah menekan tombol selesai. </label>
																</div>
															</div>
														</div> 
													</div>
												</div>
												<div class="panel-footer">
													<div class="row">
														<div class="col-xs-6">
															<button type="submit" disabled class="btn btn-success btn-block" id="btnLanjut1" onClick="MM_goToURL('parent','resultesay.php');return document.MM_returnValue" data-bind="click: redirectToDone">SELESAI</button>
														</div>
														<div class="col-xs-6">
															<button onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $_GET['namber'] ?>');return document.MM_returnValue" type="submit" class="btn btn-danger btn-block">TIDAK</button>
														</div>
													</div>
												</div>
											</div>
											<?php } elseif (!empty($mshkosong) and empty($mshragu)) { //ada yg kosong tp tdk ada yg ragu?>
												<div id="dialogStillTimeKonfirmasi">
													<div class="panel panel-default">
														<div class="panel-heading">
															<h1 class="panel-title page-label">Konfirmasi Tes</h1>
														</div>
														<div class="panel-body">
															<div class="inner-content">
																<div class="row">
																	<div class="col-xs-3 glyphicon-left-panel"><img src="./assets/warning.png" align="absmiddle" width="82px" /></div>
																	<div class="col-xs-9">
																		<div class="wysiwyg-content">
																			<p class="lblHasDoubt">
																				<br> Masih ada soal yang belum terjawab.
																				<br> Apakah anda yakin ingin mengakhiri mata uji ini? </p>
																		</div>
																		<div class="assent-checkbox" style="text-align: left;">
																			<input class="assentcb-input" type="checkbox" data-target="#btnLanjut2" id="1-ascb" onChange="cek(2);">
																			<label class="assentcb-label" for="1-ascb">
																				Centang, kemudian tekan tombol selesai.
																				<br>Anda tidak akan bisa kembali ke soal
																				<br>jika sudah menekan tombol selesai. </label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!--<div class="panel-body">
                        <div class="inner-content">
                            <div class="row">
                                <div class="col-xs-3 glyphicon-left-panel"><img src="./assets/warning.png" align="absmiddle" width="82px" /></div>
                                <div class="col-xs-9">
                                    <div class="wysiwyg-content">
                                        <p class="lblHasDoubt"><br>
                                            Masih ada soal yang belum terjawab.<br>
                                        	Apakah anda yakin ingin mengakhiri mata uji ini?                                        </p>
                                    </div>
                                    <div class="assent-checkbox" style="text-align: left;">
                                        <input class="assentcb-input" type="checkbox" data-target="#btnLanjut2" id="1-ascb"  onChange="cek(2);">
                                        <label class="assentcb-label" for="1-ascb">
                                            Centang, kemudian tekan tombol selesai.<br>Anda tidak akan bisa kembali ke soal <br>jika sudah menekan tombol selesai.                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

														<div class="panel-footer">
															<div class="row">
																<div class="col-xs-6">
																	<button id="btnLanjut2" onClick="MM_goToURL('parent','resultesay.php');return document.MM_returnValue" type="submit" class="btn btn-success btn-block" disabled>SELESAI</button>
																</div>
																<div class="col-xs-6">
																	<button type="submit" class="btn btn-danger btn-block" onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $_GET['namber'] ?>');return document.MM_returnValue">TIDAK</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php } elseif (!empty($mshragu)) { ?>
													<div id="dialogRaguKonfirmasi">
														<div class="panel panel-default">
															<div class="panel-heading">
																<h1 class="panel-title page-label">Konfirmasi Tes</h1>
															</div>
															<div class="panel-body">
																<div class="inner-content">
																	<div class="row">
																		<div class="col-xs-3 glyphicon-left-panel"><img src="./assets/warning.png" align="absmiddle" width="82px" /></div>
																		<div class="col-xs-9">
																			<div class="wysiwyg-content">
																				<p class="lblHasDoubt">
																					<br> Anda masih ragu-ragu terhadap beberapa jawaban. Silahkan tinjau lagi jawaban anda. </p>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="panel-footer">
																<div class="row">
																	<div class="col-xs-12">
																		<button onClick="MM_goToURL('parent','ujianesay.php?namber=<?php echo $_GET['namber'] ?>');return document.MM_returnValue" type="submit" class="btn btn-danger btn-block">YA</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php } ?>
										</div>
										</section>
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
		<script>
			function cek(n) {
				if (n == 1) {
					if (document.getElementById("0-ascb").checked == true)
						document.getElementById("btnLanjut1").disabled = false;
					else document.getElementById("btnLanjut1").disabled = true;
				}
				if (n == 2) {
					if (document.getElementById("1-ascb").checked == true)
						document.getElementById("btnLanjut2").disabled = false;
					else document.getElementById("btnLanjut2").disabled = true;
				}
			}
		</script>
	</body>

	</html>