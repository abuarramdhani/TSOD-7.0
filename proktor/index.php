<?php
	require "../vpanel/bin/setup.php";
    require "./cek.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ujian Online</title>
        <link href="asset/index1.css" rel="stylesheet" type="text/css">
        <link href="asset/index.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="header_dashboard">
            <div class="logo_left_dash"></div>
            <div class="status_right_dash">
<?php
    //require "../vpanel/bin/sutep.php";
    if ($_SESSION[konek]) {
        $c1="status_text_dash_online";
        $c2="alert_blue";
        $c3="id_server_blue";
        $c4="status_text_dash";
        $t1="AKTIF";
        $t2="CBTSync terkoneksi ke server pusat";
    }    
    else { 
        $c1="status_text_dash_offline";
        $c2="alert_red";    
        $c3="id_server_red";
        $c4="status_text_dash2";
        $t1="OFFLINE";
        $t2="CBTSync Tidak terkoneksi ke server pusat";
            
    }
?>                
                <p class="<?= $c1 ?>">
                    <?= $t1 ?>
                </p>
            </div>
        </div>
        <div class="header_body_dash">
            <p class="status_link_dash">
                Dashboard
            </p>
        </div>
        <div class="body_dash">
					<?php require "menu.php"; ?>
            <div class="content_right_all">
                <div class="title_dash_position">
                    <p class="txt_dash_position">DashBoard</p>
                </div>
                <div class="status_dash">
                <p class="<?= $c4 ?>">
                    <?= $t1 ?>
                </p>
                </div>
                <div class="<?= $c2 ?>">
                    <?= $t2 ?>
                </div>
                <div class="server_id">
                    Server ID : <p class="id_server_blue"><?php echo "$_SESSION[is_nmruang]"; ?></p>
                </div>
            </div>
            
        </div>
        <div class="footer_dash">
            <div class="cut_footer"></div>
            <div class="box_footer">
                <p class="text_footer_dash">
                    2017 SMKN 1 Banyuwangi CBT Sync
                </p>
            </div>
            <div class="cut_footer"></div>
        </div>
    </body>
</html>