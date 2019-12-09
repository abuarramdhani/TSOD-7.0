    <?php 
        $ruang=$converter->decode($_GET[ruang]); 
        $sekarang=time();
		if ($_SESSION['is_admin'])
		{
            $sql="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ruang.nm_ruang, login.mulai, users.user_id, login.ruang, login.login FROM login left join users on login.user_id=users.user_id left join kelas on users.kd_kelas=kelas.kd_kelas left join ruang on ruang.kd_ruang=login.ruang WHERE login.ruang!='0' and users.user_id>1000 ";
            if (!empty($_GET[ruang]))
                $sql.=" and ruang.kd_ruang='$ruang' ";
            $sql.=" ORDER BY ruang.kd_ruang";								
		}
		elseif ($_SESSION['is_adminsekolah'])
		{
			$sql="SELECT DISTINCT users.username, users.real_name, kelas.nm_kelas, ruang.nm_ruang, login.mulai, users.user_id, login.ruang, login.login FROM login left join users on login.user_id=users.user_id left join kelas on users.kd_kelas=kelas.kd_kelas left join ruang on ruang.kd_ruang=login.ruang WHERE login.ruang!='0' and ruang.kd_sek='$_SESSION[is_kelas]'  and users.user_id>1000 ";	
            if (!empty($_GET[ruang]))
                $sql.=" and ruang.kd_ruang='$ruang' ";
            $sql.=" ORDER BY ruang.kd_ruang";					
		}	
        else $sql="";
    
		$jml=mysql_num_rows(mysql_query($sql));
        
        if ($jml>=0 && $jml<=5) $tinggi=70;
		elseif ($jml>5 && $jml<=10) $tinggi=52;
		elseif ($jml>10 && $jml<=15) $tinggi=36;
		elseif ($jml>15 && $jml<=20) $tinggi=24;
		elseif ($jml>20 && $jml<=25) $tinggi=24;
		elseif ($jml>25 && $jml<=31) $tinggi=22; //20 
		elseif ($jml>31 && $jml<=40) $tinggi=20; //20 
		elseif ($jml>41 && $jml<=60) $tinggi=20; //20 
		$tinggi=16; //17 //20
		$hari=date('N');
		$tgla=date('d');
		$blna=abs(date('m'));
		$thna=date('Y');
		$hhari=array('','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
        $bbulan=array('','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        if (!empty($_GET[ruang]))
            $rr=mysql_fetch_array(mysql_query("SELECT nm_ruang, nm_sek  FROM ruang left join sekolah on ruang.kd_sek=sekolah.kd_sek WHERE ruang.kd_ruang='$ruang'"));
    ?>
    <style>
        @media print {
            .th1,
            .th2 {
                display: table-cell !important;
                border: 1px solid black !important;
                height: <?php echo $tinggi ?>px  !important;
            }
            .td1 {
                border: 1px solid black !important;
                height: <?php echo $tinggi ?>px  !important;
            }
            .tdganjil {
                border: 1px solid black !important;
                height: <?php echo $tinggi ?>px  !important;
                border-right: transparent !important;
            }
            .tdgenap {
                border: 1px solid black !important;
                height: <?php echo $tinggi ?>px  !important;
                border-left: transparent !important;
            }
            .kop {
                display: block !important;
            }
            .foot {
                display: block !important;
            }
        }
        @media screen {
            .th1 {
                display: none;
            }
            .tdganjil {
                display: none;
            }
            .tdgenap {
                display: none;
            }
            .kop {
                display: none;
            }
            .foot {
                display: none;
            }
        }
    </style>
        <div class="kop">
            <center>
                <table width="100%" border="0">
                    <tr>
                        <td width="85" align="center" valign="middle"><img src="./assets/tutwuri.jpg" width="72px" /></td>
                        <td align="center" valign="middle"><b>BERITA ACARA DAN DAFTAR HADIR<br />PELAKSANAAN PENILAIAN AKHIR SEMESTER GANJIL<br /> BERBASIS KOMPUTER<br />
                                TAHUN PELAJARAN 2019/2020</b></td>
                        <td width="85">
                        </td>
                    </tr>
                </table>
                <hr style="BORDER-RIGHT: medium none; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; HEIGHT: 1px">
                <table width="100%" border="0" style="font-size:12px">
                    <tr>
                        <td width="80%" align="left" height="25">Pada hari ini <?php echo $hhari[$hari] ?>, Tanggal <?php echo $tgla ?> bulan <?php echo $bbulan[$blna] ?> tahun <?php echo $thna ?>, di <?= $rr[nm_sek] ?> telah diselenggarakan Penilaian Akhir Semester Genap - Berbasis Komputer Mata pelajaran ...................................................................................., dari pukul .................... sampai dengan pukul .................... <?= $rr[nm_ruang] ?> sesi ......... Jumlah peserta seharusnya : ............ peserta, peserta tidak hadir : ............ peserta.<br />
                            Peserta yang hadir : <br /><br />
                        </td>
                    </tr>
                </table>
            </center>
        </div>
    <div class="box">
        <div class="box-header no-print">
            <img src="./assets/view.ujian.png" width="48" class="no-print"> Reset Login Peserta</div>

        <!-- /.box-header -->
        <div class="box-body no-print">
            <div class="form-group">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-6">
                        <label for="kd_ruang" class="col-sm-3 control-label">Nama Ruang</label>

                        <div class="input-group col-sm-6">
                            <select id="ruang" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <?php 	
	echo "<option value=\"./?to=$_GET[to]&ruang=\" selected> Semua Ruang</option>";
	$qry=mysql_query("SELECT * FROM ruang WHERE kd_sek='$_SESSION[is_kelas]' ORDER BY nm_ruang"); 
	while ($dt=mysql_fetch_array($qry))
	{
		$kode=$converter->encode($dt[kd_ruang]);
		if ($dt[kd_ruang]==$ruang)
			echo "<option value=\"./?to=$_GET[to]&ruang=$_GET[ruang]\" selected>$dt[nm_ruang]</option>";
		else 
			echo "<option value=\"./?to=$_GET[to]&ruang=$kode\">$dt[nm_ruang]</option>";
	}
?>
                            </select>
                            <input name="absen" type="button" class="no-print warning pull-right" onclick="window.print()" value="Cetak Presensi Kehadiran" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="20" class="th2">No.</th>
                        <th width="40" class="no-print">Action</th>
                        <th width="120"class="th2">Id</th>
                        <th class="th2">Nama Lengkap</th>
                        <th width="120" class="th2">Kelas</th>
                        <th width="250" class="no-print">Mapel Ujian</th>
                        <th width="60" class="no-print">Ruang</th>
                        <th width="160" class="no-print">Aktifitas terakhir</th>
                        <th width="160" class="no-print">Ujian Dimulai</th>
                        <th align="center" colspan="2" class="th1">Tanda Tangan</th>

                    </tr>
                </thead>
                <tbody>
  <?php   	      
	
   	$hasil=mysql_query($sql);
	while ($dt=mysql_fetch_array($hasil))
	{
		$i++;
		$kd=$converter->encode($dt[user_id]);
        $kd_ujian='';
        $qry1=mysql_query("SELECT * FROM tempo WHERE user_id='$dt[user_id]' LIMIT 1");
        if (mysql_num_rows($qry1)>0)
        {
            $dta=mysql_fetch_array($qry1);
            $qry2=mysql_query("SELECT * FROM ujian WHERE kd_ujian='$dta[kd_ujian]'");
            $dtb=mysql_fetch_array($qry2);
            $kd_ujian=$converter->encode($dtb[kd_ujian]);
            $blm=$dtb[nm_ujian];
        }
        else
            $blm="Belum memulai Ujian";
            
        
  ?>
                    <tr>
                        <td align="center" class="td1">
                            <?= $i ?>. </td>
                        <td align="center" class="no-print">
                        <?php
                            $d=mysql_fetch_row(mysql_query("SELECT waktu FROM login WHERE user_id='$dt[user_id]'")); 
                            if ($d[0]>1) {
                        ?>
                            <a href="./?ac=resetlogin&reslog=<?= $kd ?>&val=<?= $kd_ujian ?>" onclick="<?php Kdel($dt[username]); ?>"><i class="fa fa-recycle"></i></a>
                        <?php } else { ?>    
                            <i class="fa fa-recycle"></i>
                        <?php } ?>    
                        </td>
                        <td align="left" class="td1">
                            <?= $dt[username]; ?>
                        </td>
                        <td class="td1">
                            <?= $dt[real_name]; ?>
                        </td>
                        <td class="td1">
                            <?= $dt[nm_kelas]; ?>
                        </td>
                        <td class="no-print">
                            <?= $blm ?>
                        </td>
                        <td class="no-print">
                            <?= $dt[nm_ruang]; ?>
                        </td>
                        <td class="no-print">
                            <?= date('d-m-Y H:i:s', $dt[login]); ?>
                        </td>
                        <td class="no-print">
                            <?= date('d-m-Y H:i:s', $dt[mulai]); ?>
                        </td>
                        <td width="100" align="left" style="font-size:8px; vertical-align:text-top;" class="tdganjil"><?php if ($i%2==1) echo "&nbsp;$i."; ?></td>  
                        <td width="100" align="left" style="font-size:8px; vertical-align:text-top;" class="tdgenap"><?php if ($i%2==0) echo "&nbsp;$i."; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="no-print">
                    <tr>
                        <th>No.</th>
                        <th>Action</th>
                        <th>Id</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Mapel Ujian</th>
                        <th>Ruang</th>
                        <th>Aktifitas terakhir</th>
                        <th>Ujian Dimulai</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="foot">
<center>
	<table width="100%" border="0" style="font-size:12px">
      <tr>
        <td width="100%" align="left">
        Catatan selama pelaksanaan ujian:        
        </td>
      </tr>
      <tr>
        <td width="100%" align="left" height="30"></td>
      </tr>
      <tr>
        <td width="100%" align="center" style="border-bottom-style: solid; border-bottom-width: 1px; "></td>
      </tr>
    </table>

	<table width="100%" border="0" style="font-size:12px">
      <tr>
        <td align="left" >Yang membuat berita acara:</td>  
        <td></td>
        <td></td>              
      </tr>
      <tr>
        <td width="150" align="left" >Proktor/Pengawas</td>
        <td>:   ..................................................................................................</td>
        <td width="150" align="left" >1. ..................................................</td>        
      </tr>
      <tr>
        <td align="left"  height="30">NIP</td>
        <td>&nbsp; ..................................................................................................</td>
        <td align="left" ></td>
      </tr>     
    </table>
  <br/>
  <table width="100%" border="1" style="font-size:10px">
      <tr>
        <td align="left" ><b>&nbsp;Catatan:</b><br/>
            &nbsp;- 1 (satu) eksemplar untuk Sekolah penyelengara<br/>
            &nbsp;- 1 (satu) eksemplar untuk Sub Rayom<br/>
            &nbsp;- 1 (satu) eksemplar untuk Cabang Dinas
        </td>  
      </tr>    
    </table>
</center>    
</div> 