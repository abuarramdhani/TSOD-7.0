<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ujian Online</title>
        <link href="asset/style1.css" rel="stylesheet" type="text/css">
    </head>
    <?php
        $r=rand(1,6);
        $r="iki$r.png";
    ?>
    <body style="overflow:hidden">
        <div style="background: url('./asset/img/<?= $r ?>')no-repeat; height: 100vh; display: inline-block; background-size: cover; width: 50%; z-index: 99999999999999;">
        
        </div>
        <div class="login_right">
            <div class="top_right_login">
                <div class="nama_server">
                    NAMA SERVER
                </div>
                <div class="asal_sekolah">
                    USBN-BK JATIM 2019
                </div>
            </div>
            <div class="countainer_login_right">
                
							<form action="ceklogin.php" method="post">
                <p class="title_login">CBT Sync Login 
                    <?php
					   if (empty($_GET[msg])) echo $_GET[msg];
				    ?>
				</p>
                <p class="title_desk">Selamat datang diaplikasi CBT Sync. Silahkan masukan ID Server dan periksa registrasi yang telah diberikan</p>
                <div class="inputan_login">
                    <input type="text" name="namauser" class="nputan_user" placeholder="username...">
                    <input type="text" name="passuser" class="nputan_pw" placeholder="Password...">
                </div>
                <div class="inputan_login2">
                    <!--<p class="akses0">akses CBT tools</p>-->
                    <input type="submit" name="btn_login" class="btn_login" value="SUBMIT">
                </div>
								</form>
            </div>
        </div>
    </body>
</html>