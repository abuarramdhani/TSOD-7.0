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
        <link href="asset/css.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <div class="header_dashboard">
            <div class="logo_left_dash"></div>
            <div class="status_right_dash">
<?php
    //require "../vpanel/bin/sutep.php";
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
                </p>            </div>
        </div>
        <div class="header_body_dash">
            <p class="status_link_dash">
                Dashboard - Daftar Peserta
            </p>
        </div>
        <div class="body_dash">
            <?php require "menu.php" ?>
            <div class="content_right_all">
                <div class="title_dash_position">
                    <p class="txt_dash_position">Daftar Peserta</p>
                </div>
                <br>
                <div class="tb_count_daf">
                <table class="tb_daflll" >
                    <tr class="tr_tb_daf">
                        <td class="head_tb_daf" width="35px" rowspan="2">No</td>
                        <td class="head_tb_daf" width="120px">User Name</td>
                        <td class="head_tb_daf" >Nama</td>
                        <td class="head_tb_daf" width="150px" rowspan="2">Kelas</td>
                        <td class="head_tb_daf" width="300px" rowspan="2">Paket</td>
                    </tr>
                    <tr>                       
                        <td class="head_tb_daf">
                            <div class="nptn">
                                <input type="text" class="input_daftar" name="user_name" id="inputusername" onkeyup="myFunction1()">
                            </div>
                        </td>
                        <td class="head_tb_daf">
                            <div class="nptn">
                                <input type="text" class="input_daftar" name="realname" id="inputrealname" onkeyup="myFunction2()">                               
                            </div>
                        </td>
                    </tr>
									</table>
									<table class="tb_daflll"  id="myTable">
									<?php
					$qry="SELECT * FROM users left join kelas on kelas.kd_kelas=users.kd_kelas WHERE user_id > 1000 and kode_sekolah='$_SESSION[kode_sekolah]'";
					$q=mysql_query($qry);
					while ($d=mysql_fetch_array($q))
					{					
						$no++;
	?>
									<tr class="isi_table_sync" style="color:#000;">
									  <td  width="50px" align="center"><?php echo $no ?>.</td>
										<td width="140px"><?php echo "$d[username]"; ?></td>
										<td><?php echo $d[real_name] ?></td>
										<td width="100px"><?php echo $d[nm_kelas] ?></td>
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
function myFunction1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("inputusername");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction2() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("inputrealname");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
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