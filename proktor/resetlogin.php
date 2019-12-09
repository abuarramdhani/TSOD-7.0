<?php
require "../vpanel/bin/setup.php";
require "./cek.php";
if (!empty($_GET[act]))
{
	$user_id=$converter->decode($_GET[act]);    
	$user_id=explode("|",$user_id);
	if ($user_id[0]=='reset')
	{
        $a=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$user_id[1]'"));
        $b=mysql_fetch_array(mysql_query("SELECT * FROM kunci WHERE user_id='$user_id[1]'"));
        
        $new_login=microtime();
        $new_login=substr($new_login,11,10);
        
        if ($a[waktu]>0) 	//siswa sedang mengerjakan
        {  
            $e=mysql_fetch_array(mysql_query("SELECT kd_ujian FROM tempo WHERE user_id='$user_id[1]' LIMIT 1"));
            
            $sisa=$a[waktu]-($new_login-$a[mulai]);

            if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$user_id[1]' and kd_ujian='$e[kd_ujian]'"))>0)
            {
                mysql_query("UPDATE kunci SET waktu='$sisa', kd_ujian='$e[kd_ujian]' WHERE user_id='$user_id[1]'");
            }             
            else
            {
                mysql_query("INSERT INTO kunci VALUES('$user_id[1]','$sisa','$e[kd_ujian]')");
            }

            if (mysql_query("DELETE FROM login WHERE user_id='$user_id[1]'"))
            {
                $msg="Data ujian $user_id[1] sudah direset!";
                $msg=$converter->encode($msg);
            }
            else
            {
                $msg="Data ujian $user_id[1] gagal direset!";
                $msg=$converter->encode($msg);
            }
        }
        else
        {
            if (mysql_query("DELETE FROM login WHERE user_id='$user_id[1]'"))
            {
                $msg="Data ujian $user_id[1] sudah direset!";
                $msg=$converter->encode($msg);
            }
            else
            {
                $msg="Data ujian $user_id[1] gagal direset!";
                $msg=$converter->encode($msg);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ujian Online</title>
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
            Dashboard - Reset login
        </p>
    </div>
    <div class="body_dash">
        <?php require "menu.php" ?>
        <div class="content_right_all">
            <div class="title_dash_position">
                <p class="txt_dash_position">Reset Login Peserta</p>
            </div>
            <br>
            <div class="tb_count_daf">
                <table class="tb_daflll">
                    <tr class="tr_tb_daf">
                        <td class="head_tb_daf" width="35px">No</td>
                        <td class="head_tb_daf">
                            <div class="nptn">
                                <input type="text" class="input_daftar" name="realname" id="inputrealname" onkeyup="myFunction()">
                                <input type="submit" name="btn_daf" class="btn_daf" id="btn_daf" value=" ">
                                <label for="btn_daf" class="label_btn_daf">
                                    <img src="asset/img/filter.png" class="img_daf_inpt">
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <table class="tb_daflll" id="myTable">
                    <?php
					$qry="SELECT users.user_id, users.username, users.real_name, users.email, login.mulai, kelas.nm_kelas FROM login left join users on login.user_id=users.user_id left join kelas on kelas.kd_kelas=users.kd_kelas WHERE users.user_id >= '1000' and login.ruang='$_SESSION[is_kdruang]' ORDER BY username";
					$q=mysql_query($qry);
					while ($d=mysql_fetch_array($q))
					{					
						$no++;
						$userid=$converter->encode("reset|$d[user_id]");
	?>
                    <tr class="isi_table_sync" style="color:#000;">
                        <td width="50px" align="center"><?php echo $no ?>.</td>
                        <td width="50px" align="center" valign="middle">
                            <a href="resetlogin.php?act=<?php echo $userid; ?>"><img src="./asset/img/btnHapus.png" /></a></td>
                        <td width="140px"><?php echo "$d[username]"; ?></td>
                        <td><?php echo $d[real_name] ?></td>
                        <td width="60px"><?php echo $d[nm_kelas] ?></td>
                        <td width="300px"><?php echo $d[email] ?></td>
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
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("inputrealname");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
</body>

</html>
