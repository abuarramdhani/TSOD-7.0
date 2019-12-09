<?php
require "../vpanel/bin/setup.php";
require "./cek.php";
$sesid=session_id();
//require "../vpanel/bin/exec.php";

if (!empty($_GET[act]))
{
	$act=$converter->decode($_GET[act]);
	$a=explode("|",$act);			
}
   
if ($a[0]=='testbad')
{
		if ($query=mysql_query("DELETE FROM tempo WHERE user_id='$a[1]'"))
		{
	        mysql_query("DELETE FROM login  WHERE user_id='$a[1]'");
	        mysql_query("DELETE FROM kunci  WHERE user_id='$a[1]'");
            $msg="Data ujian $a[1] sudah dihapus!";
			$msg=$converter->encode($msg);
		}
		else
		{
			$msg="Data ujian $a[1] gagal dihapus!";
			$msg=$converter->encode($msg);
		}
	}
elseif ($a[0]=="locktest")
{
	$d=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$a[1]'"));    
	$new_login=microtime();
	$new_login=substr($new_login,11,10);
	if ($d[sesi]!='Lock') 	//kunci siswa
	{  
        $e=mysql_fetch_array(mysql_query("SELECT kd_ujian FROM tempo WHERE user_id='$a[1]' LIMIT 1"));
        
        $sisa=$d[waktu]-($new_login-$d[mulai]);

        if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$a[1]' and kd_ujian='$e[kd_ujian]'"))>0)
		{
            mysql_query("UPDATE kunci SET waktu='$sisa', kd_ujian='$e[kd_ujian]' WHERE user_id='$a[1]'");
        }             
        else
        {
            mysql_query("INSERT INTO kunci VALUES('$a[1]','$sisa','$e[kd_ujian]')");
        }
        
        if (mysql_query("UPDATE login SET sesi='Lock', mulai='', waktu='' WHERE user_id='$a[1]'"))
        {
            $msg="Data ujian $a[1] sudah dikunci!";
            $msg=$converter->encode($msg);
        }
		else
		{
            $msg="Data ujian $a[1] gagal dikunci!";
			$msg=$converter->encode($msg);
        }
    }
	else				//dibuka
	{
        $e=mysql_fetch_array(mysql_query("SELECT * FROM kunci WHERE user_id='$a[1]'"));
        
		if ($query=mysql_query("UPDATE login SET login ='$new_login',  mulai='$new_login', waktu='$e[waktu]', sesi='$sesid' WHERE  user_id='$a[1]'"))
		{
            //mysql_query("DELETE FROM kunci WHERE user_id='$a[1]'");
            $msg="Data ujian $a[1] sudah dibuka!";
			$msg=$converter->encode($msg);
        }
		else
		{
            $msg="Data ujian $a[1] gagal dibuka!";
			$msg=$converter->encode($msg);
        }
    }		
}
$dtruang=mysql_fetch_array(mysql_query("SELECT * FROM ruang WHERE kd_ruang='$_SESSION[is_kdruang]'"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ujian Online</title>
    <!--<link href="asset/index1.css" rel="stylesheet" type="text/css">-->
    <link href="asset/index.css" rel="stylesheet" type="text/css">
    <link href="asset/css.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="header_dashboard">
        <div class="logo_left_dash"></div>
        <div class="status_right_dash">
            <?php
    if ($_SESSION[konek]) {
        $c1="status_text_dash_online";
        $t1="AKTIF";
    }    
    else { 
        $c1="status_text_dash_offline";
        $t1="OFFLINE";
            
    }
?>
            <p class="<?= $c1 ?>">
                <?= $t1 ?>
            </p>
        </div>
    </div>
    <div class="header_body_dash">
        <p class="status_link_dash">
            Dashboard - Status Peserta
        </p>
    </div>
    <div class="body_dash">
        <?php require "menu.php" ?>
        <div class="content_right_all">
            <div class="title_dash_position">
                <p class="txt_dash_position">Status Peserta</p>
            </div>
            <br>
            <div class="tb_count_daf">
                <table class="tb_daflll">
                    <tr class="tr_tb_daf">
                        <td class="head_tb_daf">Action</td>
                        <td class="head_tb_daf" width="140px">Status Ujian</td>
                        <td class="head_tb_daf" width="90px">No Ujian</td>
                        <td class="head_tb_daf">Nama Peserta</td>
                        <td class="head_tb_daf">Nama Ujian</td>
                        <td class="head_tb_daf" width="50px">Menjawab</td>
                        <td class="head_tb_daf" width="120px">Tanggal Ujian</td>
                    </tr>
                    <?php
            
				  	$hasil1=mysql_query("SELECT users.user_id, users.username, users.real_name, users.email, login.mulai FROM login left join users on login.user_id=users.user_id WHERE users.user_id >= '1000' and login.ruang='$_SESSION[is_kdruang]' ORDER BY username");
			while ($dt=mysql_fetch_array($hasil1))
			{
				$hasil2=mysql_query("SELECT ujian.kd_ujian, ujian.nm_ujian, ujian.jml_soal, count(tempo.kd_soal) as jml_soal FROM tempo left join ujian on tempo.kd_ujian=ujian.kd_ujian WHERE tempo.user_id='$dt[0]'");
				
				$hasil3=mysql_query("SELECT count(kd_soal) as jml_jawab FROM tempo WHERE user_id='$dt[0]' and jawaban!=''");
				$dt1=mysql_fetch_array($hasil2);
				$dt2=mysql_fetch_array($hasil3);				
						//if (empty($dt[mulai])) continue;
				
				$tgl=$dt[mulai];
				$tgluji=date("Y-m-d H:i",$tgl);
				$thn1=substr($tgluji,2,2);
				$bln1=substr($tgluji,5,2);
				$tgl1=substr($tgluji,8,2);
				$jam1=substr($tgluji,11,2);
				$mnt1=substr($tgluji,14,2);				
				$dt3=mysql_fetch_array(mysql_query("SELECT sesi FROM login WHERE user_id='$dt[user_id]'"));				
				$dt4=$converter->encode("locktest|$dt[user_id]");
				$dt5=$converter->encode("testbad|$dt[user_id]");
				$no++;
	?>
                    <tr <?php if (empty($dt1[nm_ujian])) { ?> class="isi_table_sync_warning" <?php } elseif ($dt3[0]=='Lock') { ?> class="isi_table_sync_error" <?php } else { ?>class="isi_table_sync" <?php } ?> style="color:#000;">
                        <td>
                            <?php if (!empty($dt1[nm_ujian])) { ?>
                            <a href="statuspeserta.php?act=<?= $dt4 ?>">
                                <?php if ($dt3[0]=='Lock') { ?>
                                <img src="./asset/img/unlock.png" />
                                <?php } else { ?>
                                <img src="./asset/img/lock.png" />
                                <?php } ?>
                            </a>
                            <a href="statuspeserta.php?act=<?= $dt5 ?>" onclick="<?php Kdel("Ujian $dt1[nm_ujian] milik $dt[username]"); ?>"><img src="./asset/img/delete.png" /></a>
                            <?php } ?>
                        </td>
                        <td>&nbsp;
                            <?php 
        if ($dt1[3]==0) echo "Belum dimulai"; 
        else if ($dt3[0]=='Lock') echo "Paused"; 
        else echo "Sedang Berlangsung"; 

?>
                        </td>
                        <td align="center"><?php echo "&nbsp; $dt[username]"; ?></td>
                        <td>&nbsp; <?php echo "$dt[real_name]"; ?></td>
                        <td><?php echo "$dt1[nm_ujian]"; ?></td>
                        <td align="center"><?php if (!empty($dt1[nm_ujian])) echo "$dt2[jml_jawab]/$dt1[jml_soal]"; ?></td>
                        <td align="center"><?php if (!empty($dt1[nm_ujian])) echo$tgluji; ?></td>
                    </tr>

                    <?php } ?>
                </table>
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
