<?php
	$addkelas	=$converter->encode('add_kelas');	//
	$addmodul	=$converter->encode('add_modul');	//
	$adduser	=$converter->encode('add_user');	//
	$addtest	=$converter->encode('add_test');	//
	$addsoal	=$converter->encode('add_soal');	//
	$addruang	=$converter->encode('add_ruang');	//
	$addpetugas	=$converter->encode('add_petugas');	//
    $importsoal	=$converter->encode('import_soal');	//
	$resetlogin =$converter->encode('resetlogin');
    $listujin	=$converter->encode('list_ujian');
	$viewujian	=$converter->encode('view_ujian');	//
    $importuser	=$converter->encode('import_user');	//
	$listkelas	=$converter->encode('list_kelas');	//
	$listruang	=$converter->encode('list_ruang');	//
	$listpetugas=$converter->encode('list_petugas');//
	$listmodul	=$converter->encode('list_modul');	//
	$listtest	=$converter->encode('list_test');	//
	$listsoal	=$converter->encode('list_soal');	//
	$listq		=$converter->encode('list_q');		//
    $analisissoal=$converter->encode('list_analisis');//
	$viewresult	=$converter->encode('view_result');    //
	$viewanswer	=$converter->encode('view_answer');
	$printresult=$converter->encode('print_result');
	//$printanswer=$converter->encode('print_answer');
    //$korekdaftar=$converter->encode('korekdaftar');
    $download=$converter->encode('download');
    $zipping=$converter->encode('zipping');
    $upload=$converter->encode('upload');
    $patch=$converter->encode('patch');
    $patch1=$converter->encode('patching');
    $patch2=$converter->encode('patchingsuper');
	$ren=$converter->decode($_GET[ren]);
	$del=$converter->decode($_GET[del]);    
	
	if (isset($_GET[actno])) 
	{
		$_GET[act]=$converter->encode($_GET[actno]);
	}
	if (!empty($_GET[act]))
	{
		$act=$converter->decode($_GET[act]);
		$a=explode("|",$act);		
	}
	
//-------------------- upload hasil ujian --->		
	elseif ($_POST[uploadhasil])
	{		
		$q=mysql_query("SELECT * FROM hasiltemp");        
		while ($d1=mysql_fetch_array($q))
		{
            $t=$d1[kd_hasil]; 
            if ($_POST[pilih][$t]==1) {
                if ($sdh1) $sql1.=",";
                else $sql1="INSERT INTO hasil VALUES ";
                $sql1.="(default,'$d1[1]','$d1[2]','$d1[3]','$d1[4]','$d1[5]','$d1[6]','$d1[7]','$d1[8]','$d1[9]')";
                $sdh1=true;
                $j++;
                $hps[$j]=$d1[kd_hasil];
            }
        }
        if (!empty($sql1)){               
            require "sutep.php";	
            $sql1.=";";	
            mysql_query($sql1);
            mysql_close();
            datab($dblocation,$dbusername,$dbpassword,$dbname);
            for($i=1; $i<=$j; $i++)
		    {
                $h=$hps[$i];
                mysql_query("DELETE FROM hasiltemp WHERE kd_hasil='$h'");
		    }
        }
	}

//-------------------- basic input --->		
	elseif ($_POST[submitkelas])
	{
		if (empty($_POST[nm_kelas]))
			$msg_er="Nama Kelas tidak boleh kosong!";	
		elseif (strlen($_POST[nm_kelas]) < 3)
			$msg_er="Nama Kelas minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_kelas FROM kelas WHERE nm_kelas='$_POST[nm_kelas]'")) > 0)
			$msg_er="Kelas $_POST[nm_kelas] sudah ada";	
		else
		{			
			mysql_query("INSERT INTO kelas VALUES (default,'$_POST[nm_kelas]')");
			$msg=$converter->encode("Kelas $_POST[nm_kelas] telah disimpan");
			$_SESSION[tab]=1;
			header("Location: ./?to=$addkelas&msg=$msg;");	
			exit;
		}	
		$_GET['to']=$addkelas;
	}
	elseif ($_POST[updatekelas])
	{
		$kd=$converter->decode($_POST[kd]);
		if (empty($_POST[nm_kelas]))
			$msg_er="Nama Kelas tidak boleh kosong!";	
		elseif (strlen($_POST[nm_kelas]) < 3)
			$msg_er="Nama Kelas minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_kelas FROM kelas WHERE nm_kelas='$_POST[nm_kelas]' and kd_kelas!='$kd'")) > 0)
			$msg_er="Kelas $_POST[nm_kelas] sudah ada";	
		else
		{			
			mysql_query("UPDATE kelas SET nm_kelas='$_POST[nm_kelas]' WHERE kd_kelas='$kd'");
			$msg="Kelas $_POST[nm_kelas] telah dirubah";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addkelas&msg=$msg");	
			exit;
		}	
		$_GET['to']=$addkelas;
	}	
	elseif ($_GET[ac]=='renkelas')
	{		
		$dt=mysql_fetch_array(mysql_query("SELECT nm_kelas FROM kelas WHERE kd_kelas='$ren'"));		
		$_POST[nm_kelas]=$dt[nm_kelas];
		$_GET['to']=$addkelas;
	}
	elseif ($_GET[ac]=='delkelas')
	{
		//echo $del;
		$dt=mysql_fetch_row(mysql_query("SELECT nm_kelas FROM kelas WHERE kd_kelas='$del'"));
		mysql_query("DELETE FROM kelas WHERE kd_kelas='$del'");
		mysql_query("DELETE FROM d_kelas WHERE kd_kelas='$del'");
		$_GET[msg]=$converter->encode("Kelas $dt[0] sudah dihapus"); 
		$_GET['to']=$addkelas;
	}
	
	if ($_POST[submitruang])
	{
		if (empty($_POST[nm_ruang]))
			$msg_er="Nama Kelas tidak boleh kosong!";	
		elseif (strlen($_POST[nm_ruang]) < 3)
			$msg_er="Nama Kelas minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_ruang FROM ruang WHERE nm_ruang='$_POST[nm_ruang]'")) > 0)
			$msg_er="Kelas $_POST[nm_ruang] sudah ada";	
		else
		{	
			mysql_query("INSERT INTO ruang VALUES (default,'$_POST[nm_ruang]','$_SESSION[is_kelas]')");
			$msg=$converter->encode("Kelas $_POST[nm_ruang] telah disimpan");
			$_SESSION[tab]=1;
			header("Location: ./?to=$addruang&msg=$msg;");	
			exit;
		}	
		$_GET['to']=$addruang;
	}
	elseif ($_POST[updateruang])
	{
		$kd=$converter->decode($_POST[kd]);
		if (empty($_POST[nm_ruang]))
			$msg_er="Nama Kelas tidak boleh kosong!";	
		elseif (strlen($_POST[nm_ruang]) < 3)
			$msg_er="Nama Kelas minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_ruang FROM ruang WHERE nm_ruang='$_POST[nm_ruang]' and kd_ruang!='$kd'")) > 0)
			$msg_er="Kelas $_POST[nm_ruang] sudah ada";	
		else
		{			
			mysql_query("UPDATE ruang SET nm_ruang='$_POST[nm_ruang]' WHERE kd_ruang='$kd'");
			$msg="Kelas $_POST[nm_ruang] telah dirubah";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addruang&msg=$msg");	
			exit;
		}	
		$_GET['to']=$addruang;
	}	
	elseif ($_GET[ac]=='renruang')
	{
		$dt=mysql_fetch_row(mysql_query("SELECT nm_ruang FROM ruang WHERE kd_ruang='$ren'"));
		$_POST[nm_ruang]=$dt[0];
		$_GET['to']=$addruang;
	}
	elseif ($_GET[ac]=='delruang')
	{
		$dt=mysql_fetch_row(mysql_query("SELECT nm_ruang FROM ruang WHERE kd_ruang='$del'"));
		mysql_query("DELETE FROM ruang WHERE kd_ruang='$del'");
		mysql_query("DELETE FROM d_ruang WHERE kd_ruang='$del'");
		$_GET[msg]=$converter->encode("Kelas $dt[0] sudah dihapus"); 
		$_GET['to']=$addruang;
	}
	
	elseif ($_POST[submitmodul])
	{
		if (empty($_POST[nm_modul]))
			$msg_er="Nama modul tidak boleh kosong!";	
		elseif (strlen($_POST[nm_modul]) < 3)
			$msg_er="Nama modul minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_modul FROM modul WHERE nm_modul='$_POST[nm_modul]'")) > 0)
			$msg_er="Modul $_POST[nm_modul] sudah ada";	
		else
		{			
			if (empty($_POST[status])) $_POST[status]='Tdk Aktif';		
			mysql_query("INSERT INTO modul VALUES (default,'$_POST[nm_modul]','$_POST[status]')");
			$msg=$converter->encode("modul $_POST[nm_modul] telah disimpan");
			$_SESSION[tab]=1;
			header("Location: ./?to=$addmodul&msg=$msg;");	
			exit;
		}
		$_GET['to']=$addmodul;
	}	
	elseif ($_POST[updatemodul])
	{
		$kd=$converter->decode($_POST[kd]);
		if (empty($_POST[nm_modul]))
			$msg_er="Nama modul tidak boleh kosong!";	
		elseif (strlen($_POST[nm_modul]) < 3)
			$msg_er="Nama modul minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_modul FROM modul WHERE nm_modul='$_POST[nm_modul]' and kd_modul!='$kd'")) > 0)
			$msg_er="modul $_POST[nm_modul] sudah ada";	
		else
		{	
			if (empty($_POST[status])) $_POST[status]='Tdk Aktif';		
			mysql_query("UPDATE modul SET nm_modul='$_POST[nm_modul]', status='$_POST[status]' WHERE kd_modul='$kd'");
			$msg="modul $_POST[nm_modul] telah dirubah";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addmodul&msg=$msg");	
			exit;
		}	
		$_GET['to']=$addmodul;
	}	
	elseif ($_GET[ac]=='renmodul')
	{
		$dt=mysql_fetch_row(mysql_query("SELECT nm_modul, status FROM modul WHERE kd_modul='$ren'"));
		$_POST[nm_modul]=$dt[0];
		$_POST[status]=$dt[1];	
		$_GET['to']=$addmodul;
	}
	elseif ($_GET[ac]=='delmodul')
	{
		$dt=mysql_fetch_row(mysql_query("SELECT nm_modul FROM modul WHERE kd_modul='$del'"));
		mysql_query("DELETE FROM modul WHERE kd_modul='$del'");
		mysql_query("DELETE FROM d_modul WHERE kd_modul='$del'");
		$_GET[msg]=$converter->encode("modul $dt[0] sudah dihapus"); 
		$_GET['to']=$addmodul;
	}	
	elseif ($a[0]=='stsmodul')
	{
		if ($a[2]=='Aktif') $a[2]='Tdk Aktif';
		else $a[2]='Aktif'; 		
		mysql_query("UPDATE modul SET status='$a[2]' WHERE kd_modul='$a[1]'");
		$_GET['to']=$addmodul;
	}	
	
	elseif ($_POST[submituser])
	{
		if (mysql_query("SELECT user_id FROM users WHERE username='$_POST[username]'"))
			$ada=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE username='$_POST[username]'"));
		if (empty($_POST[username]))
			$msg_er="User name tidak boleh kosong!";	
		elseif (strlen($_POST[username]) < 3)
			$msg_er="User name minimal 3 digit";	
		elseif (empty($_POST[password1]))
			$msg_er="Password tidak boleh kosong";	
		elseif (strlen($_POST[password1]) < 3)
			$msg_er="Password minimal 3 digit";	
		elseif (empty($_POST[kode_sekolah]))
			$msg_er="Kode sekolah tidak boleh kosong";	
		elseif (empty($_POST[real_name]))
			$msg_er="Nama tidak boleh kosong";	
		elseif (strlen($_POST[real_name]) < 3)
			$msg_er="Nama minimal 3 digit";	
		elseif (empty($_POST[kd_kelas]))
			$msg_er="Kelas tidak boleh kosong";	
		elseif ($ada > 0)
			$msg_er="User Name $_POST[username] sudah ada";	
		else
		{			
			$join_date=date("Y-m-d H:i:s");
			$_POST[password1]=md5($_POST[password1]);			
			mysql_query("INSERT INTO users VALUES (default,'$_POST[username]','$_POST[password1]','$_POST[kode_sekolah]','$_POST[email]','$_POST[real_name]','$join_date','$_POST[kd_kelas]')");
			$msg="User $_POST[username] telah disimpan";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$adduser&msg=$msg;");	
			exit;
		}	
		$_GET['to']=$adduser;
	}
	elseif ($_POST[updateuser])
	{
		$kd=$converter->decode($_POST[kd]);
		if (empty($_POST[kode_sekolah]))
			$msg_er="Kode sekolah tidak boleh kosong";	
		elseif (empty($_POST[real_name]))
			$msg_er="Nama tidak boleh kosong";	
		elseif (strlen($_POST[real_name]) < 3)
			$msg_er="Nama minimal 3 digit";	
		elseif (empty($_POST[kd_kelas]))
			$msg_er="Kelas tidak boleh kosong";	
		else
		{			
			mysql_query("UPDATE users SET kode_sekolah='$_POST[kode_sekolah]', email='$_POST[email]', real_name='$_POST[real_name]', kd_kelas='$_POST[kd_kelas]' WHERE user_id='$kd'");
			$msg="Data User $_POST[username] telah diupdate";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			$_SESSION['list']="$_POST[a0]|$_POST[a1]|$_POST[a2]|$_POST[a3]|$_POST[a4]";
			$_GET['to']=$listq;
			$ok=true;
		}	
		if (!$ok) 
		{
			header("Location: ./?to=$adduser&kelas=$_POST[kelas]&sek=$_POST[sek]&hal=$_POST[hal]");
						 }
	}	
	elseif ($_GET[ac]=='renuser') 
	{
		$dt=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id='$ren'"));
		$_POST[username]=$dt[username];
		$_POST[email]=$dt[email];
		$_POST[kode_sekolah]=$dt[kode_sekolah];
		$_POST[real_name]=$dt[real_name];
		$_POST[kd_kelas]=$dt[kd_kelas];
		
		$_GET['to']=$adduser;
	}
	elseif ($_GET[ac]=='deluser')
	{
		mysql_query("UPDATE users SET kd_kelas='' WHERE user_id='$del'");
		$msg="User $del dihapus sementara! Anda bisa merecovery dengan akses tingkat lanjut!"; 
		$_GET[msg]=$converter->encode($msg);		
		$_GET[to]=$listq;
		$_GET[kelas]=$_POST[kelas];
		$_GET[sek]=$_POST[sek];
		$_GET[hal]=$_POST[hal];
	}
    elseif ($_POST[import_user]=="ok")
    {  
        require_once "./plugins/excel_reader.php";
        $target ="./upload/" . basename($_FILES['user']['name']);
        move_uploaded_file($_FILES['user']['tmp_name'], $target);
        $berhasil=0;
        $data = new Spreadsheet_Excel_Reader($target,false);    
        $baris = $data->rowcount($sheet_index=0);
        $kode_sekolah = $data->val(1, 2);
        if($kode_sekolah != "") 
        {
            if (mysql_num_rows(mysql_query("SELECT * FROM sekolah WHERE nm_sek='$kode_sekolah' "))>0)
            {
                $dt=mysql_fetch_array(mysql_query("SELECT * FROM sekolah WHERE nm_sek='$kode_sekolah' "));
            }
            else
            {
                mysql_query("INSERT INTO sekolah VALUES (default,'$kode-sekolah','',NULL)");
                $dt=mysql_fetch_array(mysql_query("SELECT * FROM sekolah WHERE nm_sek='$kode_sekolah' "));            
            }
            $kode_sekolah=$dt[nm_sek];    
        }
        $dta=mysql_fetch_array(mysql_query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1"));
        if ($dta[0]<1000) $user_id=1001;
        else $user_id="default";
        
        for ($i=3; $i<=$baris; $i++)
        {   
            $user_id    = $data->val($i, 1);
            $password   = md5($data->val($i, 3));
            $username   = $data->val($i, 2);
            $nm_kelas   = $data->val($i, 6);
            if($username != "" && $password != "")
            {
                if (mysql_num_rows(mysql_query("SELECT * FROM kelas WHERE nm_kelas='$nm_kelas' "))>0)
                {
                    $dt=mysql_fetch_array(mysql_query("SELECT * FROM kelas WHERE nm_kelas='$nm_kelas' "));
                }
                else
                {
                    mysql_query("INSERT INTO kelas VALUES (default,'$nm_kelas')");
                    $dt=mysql_fetch_array(mysql_query("SELECT * FROM kelas WHERE nm_kelas='$nm_kelas' "));            
                }
                $kd_kelas=$dt[kd_kelas];
                if($kd_kelas != "")
                {
                    $email      = $data->val($i, 4);
                    $real_name  = $data->val($i, 5);
                    $date_joined= date("Y-m-d H:i:s");
                    if (mysql_query("INSERT into users values($user_id,'$username','$password','$kode_sekolah','$email','$real_name','$date_joined','$kd_kelas')"))
                        $berhasil++;        
                    echo "INSERT into users values($user_id,'$username','$password','$kode_sekolah','$email','$real_name','$date_joined','$kd_kelas')";
                }
            }
        }
    
        if($berhasil==0)
        {
            die(mysql_error());
        } else {
            echo "Data berhasil diimpor.";
        }
    
        unlink($target);
        $msg=$converter->encode("$berhasil Soal berhasil diimport!"); 
        header("Location: ./?to=$importsoal&msg=$msg");
        exit;
    }

	elseif ($_POST[submitpetugas])
	{
		if (mysql_query("SELECT user_id FROM users WHERE username='$_POST[username]'"))
			$ada=mysql_num_rows(mysql_query("SELECT user_id FROM users WHERE username='$_POST[username]'"));
		if (empty($_POST[username]))
			$msg_er="User name tidak boleh kosong!";	
		elseif (strlen($_POST[username]) < 3)
			$msg_er="User name minimal 3 digit";	
		elseif (empty($_POST[password1]))
			$msg_er="Password tidak boleh kosong";	
		elseif (strlen($_POST[password1]) < 3)
			$msg_er="Password minimal 3 digit";	
		elseif (empty($_POST[real_name]))
			$msg_er="Nama tidak boleh kosong";	
		elseif (strlen($_POST[real_name]) < 3)
			$msg_er="Nama minimal 3 digit";	
		elseif (empty($_POST[kd_kelas]))
			$msg_er="Kelas tidak boleh kosong";	
		elseif ($ada > 0)
			$msg_er="User Name $_POST[username] sudah ada";	
		else
		{			
			$join_date=date("Y-m-d H:i:s");
			$_POST[password1]=md5($_POST[password1]);
			$dt=mysql_fetch_array(mysql_query("SELECT user_id FROM `users` WHERE user_id <1000 and user_id>100 ORDER BY user_id DESC LIMIT 1"));
			if (empty($dt[user_id])) $kode=101;
			else $kode=$dt[user_id]+1;
			
			mysql_query("INSERT INTO users VALUES ('$kode','$_POST[username]','$_POST[password1]','','','$_POST[real_name]','$join_date','$_POST[kd_kelas]')");
			$msg="User $_POST[username] telah disimpan";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addpetugas&msg=$msg;");	
			exit;
		}	
		$_GET['to']=$addpetugas;
	}
	elseif ($_POST[updatepetugas])
	{
		$kd=$converter->decode($_POST[kd]);
		if (empty($_POST[real_name]))
			$msg_er="Nama tidak boleh kosong";	
		elseif (strlen($_POST[real_name]) < 3)
			$msg_er="Nama minimal 3 digit";	
		elseif (empty($_POST[kd_kelas]))
			$msg_er="Kelas tidak boleh kosong";	
		else
		{			
			//echo "UPDATE users SET real_name='$_POST[real_name]', kd_kelas='$_POST[kd_kelas]', username='$_POST[username]'  WHERE user_id='$kd'"; exit;
			mysql_query("UPDATE users SET real_name='$_POST[real_name]', kd_kelas='$_POST[kd_kelas]', username='$_POST[username]'  WHERE user_id='$kd'");
			$msg="Data User $_POST[username] telah diupdate";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;			
			header("Location: ./?to=$addpetugas&msg=$msg");	
			exit;
			//$_SESSION['list']="$_POST[a0]|$_POST[a1]|$_POST[a2]|$_POST[a3]|$_POST[a4]";
			//$_GET['to']=$listq;
			//$ok=true;
		}	
		if (!$ok) $_GET['to']=$addpetugas;
	}	
	elseif ($_GET[ac]=='renpetugas')
	{
		$dt=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id='$ren'"));
		$_POST[username]=$dt[username];
		$_POST[real_name]=$dt[real_name];
		$_POST[kd_kelas]=$dt[kd_kelas];
		
		$_GET['to']=$addpetugas;
	}
	elseif ($_GET[ac]=='delpetugas')
	{
		mysql_query("UPDATE users SET kd_kelas='' WHERE user_id='$del'");
		$msg="User $del dihapus sementara! Anda bisa merecovery dengan akses tingkat lanjut!"; 
		$_GET[msg]=$converter->encode($msg);
		$_SESSION[tab]=1;
		$_GET['to']=$addpetugas;
	}

	elseif ($_POST[submitujian])
	{		
		$d=explode(' ',$_POST[datetimes]);
		$tgl_mulai=  $d[0]." ".$d[1];
		$tgl_selesai=$d[3]." ".$d[4];
		if (empty($_POST[nm_ujian]))
			$msg_er="Nama ujian tidak boleh kosong!";	
		elseif (strlen($_POST[nm_ujian]) < 3)
			$msg_er="Nama ujian minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian WHERE nm_ujian='$_POST[nm_ujian]'")) > 0)
			$msg_er="Ujian $_POST[nm_ujian] sudah ada";	
		elseif (empty($_POST[kd_modul]))
			$msg_er="Modul yang diujikan belum dipilih";	
		elseif (($_POST[jml_soal] < 5) and ($_POST[jml_soal] > 50))
			$msg_er="Jumlah soal yang diijinkan 5 s/d 50 soal";	
		elseif ($tgl_mulai > $tgl_selesai)
			$msg_er="Tanggal selesai ujian tidak valid";
		elseif (empty($_POST[panduan]))
			$msg_er="Panduan mengerjakan ujian tidak boleh kosong";	
		elseif (empty($_POST[lama])) 
			$msg_er="Lama ujian tidak boleh kosong";	
		else
		{			
			mysql_query("INSERT INTO ujian VALUES (default,'$_POST[nm_ujian]','$_POST[kd_modul]','$_POST[jml_soal]','$tgl_mulai','$tgl_selesai','$_POST[panduan]','$_POST[max]','$_POST[lama]','1','1','$_POST[acak]')");
			
			$query=mysql_query("SELECT kd_ujian FROM ujian WHERE nm_ujian='$_POST[nm_ujian]'");
			$dt=mysql_fetch_row($query);
			
		    $query1=mysql_query("SELECT kd_kelas FROM kelas ORDER BY nm_kelas");
		    while($dt1=mysql_fetch_row($query1))
		    {
				$i=$dt1[0];
				if ($_POST[alow][$i]==1) $query=mysql_query("INSERT INTO d_ujian VALUES ('$i','$dt[0]')");	
		    }
			$msg="Jadwal ujian $_POST[nm_ujian] telah disimpan";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addtest&msg=$msg;");	
			exit;
		}	
		$_GET['to']=$addtest;

	}
	elseif ($_POST[updateujian])
	{
		$kd=$converter->decode($_POST[kd]);
		$d=explode(' ',$_POST[datetimes]);
		$tgl_mulai=  $d[0]." ".$d[1];
		$tgl_selesai=$d[3]." ".$d[4];
		if (empty($_POST[nm_ujian]))
			$msg_er="Nama ujian tidak boleh kosong!";	
		elseif (strlen($_POST[nm_ujian]) < 3)
			$msg_er="Nama ujian minimal 3 digit";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_ujian FROM ujian WHERE nm_ujian='$_POST[nm_ujian]' and kd_ujian!='$kd'")) > 0)
			$msg_er="Ujian $_POST[nm_ujian] sudah ada";	
		elseif (empty($_POST[kd_modul]))
			$msg_er="Modul yang diujikan belum dipilih";	
		elseif (($_POST[jml_soal] < 5) and ($_POST[jml_soal] > 100))
			$msg_er="Jumlah soal yang diijinkan 5 s/d 100 soal";	
		elseif ($tgl_mulai > $tgl_selesai)
			$msg_er="Tanggal selesai ujian tidak valid";
		elseif (empty($_POST[panduan]))
			$msg_er="Panduan mengerjakan ujian tidak boleh kosong";	
		elseif (empty($_POST[lama]))
			$msg_er="Lama ujian tidak boleh kosong";	
		else
		{			
			mysql_query("UPDATE ujian SET nm_ujian='$_POST[nm_ujian]', kd_modul='$_POST[kd_modul]', jml_soal='$_POST[jml_soal]', tgl_mulai='$tgl_mulai', tgl_selesai='$tgl_selesai', panduan='$_POST[panduan]', max='$_POST[max]', lama='$_POST[lama]', acak='$_POST[acak]' WHERE kd_ujian='$kd'");
			
		    $query1=mysql_query("SELECT kd_kelas FROM kelas ORDER BY nm_kelas");
		    while($dt1=mysql_fetch_row($query1))
		    {
					$i=$dt1[0];
					$x=$_POST[alow][$i];
					mysql_query("DELETE FROM d_ujian WHERE kd_kelas='$i' and kd_ujian='$kd'");	
					if ($x==1)
					{
						mysql_query("INSERT INTO d_ujian VALUES ('$i','$kd')");	
					}
		    }
			$msg="Jadwal ujian $_POST[nm_ujian] telah diupdate";
			$msg=$converter->encode($msg);
			$_SESSION[tab]=1;
			header("Location: ./?to=$addtest&msg=$msg;");	
		}	
		$_GET['to']=$addtest;
		echo "error";
		exit;
	}
	elseif ($_GET[ac]=='rentest')
	{
		$dt=mysql_fetch_array(mysql_query("SELECT * FROM ujian WHERE kd_ujian='$ren'"));
		$_POST[nm_ujian]=$dt[1];
		$_POST[kd_modul]=$dt[2];
		$_POST[jml_soal]=$dt[3];
		$tgl1=$dt[tgl_mulai];
		$tgl2=$dt[tgl_selesai];
		$_POST[panduan]=$dt[panduan];
		$_POST['max']=$dt['max'];
		$_POST[lama]=$dt[lama];
		$_POST[acak]=$dt[acak];
		$_GET['to']=$addtest;
	}
	elseif ($_GET[ac]=='deltest')
	{
		$dt=mysql_fetch_row(mysql_query("SELECT nm_ujian FROM ujian WHERE kd_ujian='$del'"));
		mysql_query("DELETE FROM ujian WHERE kd_ujian='$del'");
		mysql_query("DELETE FROM d_ujian WHERE kd_ujian='$del'");
		$msg="Jadwal ujian $dt[0] sudah dihapus";
		$msg=$converter->encode($msg);
		$_GET['to']=$addtest;
		$_SESSION[tab]=1;
		if ($_GET[fr]==1)
		{
			header ("Location: ./?to=$viewtest&msg=$msg"); exit;
		}
	}	

	elseif ($_POST[submitsoal])
	{
		$_POST[q]=mysql_escape_string($_POST[q]);
		$_POST[a]=mysql_escape_string($_POST[a]);
		$_POST[alt_1]=mysql_escape_string($_POST[alt_1]);
		$_POST[alt_2]=mysql_escape_string($_POST[alt_2]);
		$_POST[alt_3]=mysql_escape_string($_POST[alt_3]);
		$_POST[alt_4]=mysql_escape_string($_POST[alt_4]);
		if (empty($_POST[kd_modul]))
			$msg_er="Modul belum dipilih";	
		elseif (empty($_POST[q]))
			$msg_er="Soal belum diisi";	
		elseif (empty($_POST[a]))
			$msg_er="Jawaban tidak boleh kosong";	
		elseif (empty($_POST[alt_1]))
			$msg_er="Pilihan 1 tidak boleh kosong";	
		elseif (empty($_POST[alt_2]) )
			$msg_er="Pilihan 2 tidak boleh kosong";	
		elseif (mysql_num_rows(mysql_query("SELECT kd_soal FROM soal WHERE q='$$_POST[q]' and kd_soal!='$_POST[kd]' and kd_modul='$_POST[kd_modul]'")) > 0)
			$msg_er="Soal tersebut sudah ada";	
		else
		{				
			$tm=time();
			if (empty($_POST[format])) $_POST[format]='default';			
			if (mysql_query("INSERT INTO soal VALUES (default,'$_POST[kd_modul]','$_POST[q]', '$_POST[a]', '$_POST[alt_1]', '$_POST[alt_2]', '$_POST[alt_3]', '$_POST[alt_4]', '$_POST[format]')"))
			{	
				$msg="Soal berhasil disimpan";
				$msg=$converter->encode($msg);				
				$_SESSION['kdm']=$_POST[kd_modul];
				$_SESSION['ack']=$_POST[format];
				header("Location: ./?to=$addsoal&msg=$msg");	
				
			}
			else $msg_er="Soal gagal disimpan";
		}	
		$_GET['to']=$addsoal;
	}	
	elseif ($_POST[updatesoal])
	{
		$_POST[q]=mysql_escape_string($_POST[q]);
		$_POST[a]=mysql_escape_string($_POST[a]);
		$_POST[alt_1]=mysql_escape_string($_POST[alt_1]);
		$_POST[alt_2]=mysql_escape_string($_POST[alt_2]);
		$_POST[alt_3]=mysql_escape_string($_POST[alt_3]);
		$_POST[alt_4]=mysql_escape_string($_POST[alt_4]);
		if (empty($_POST[kd_modul]))
			$msg_er="Modul belum dipilih";	
		elseif (empty($_POST[q]))
			$msg_er="Soal belum diisi";	
		elseif (strlen($_POST[q]) < 3)
			$msg_er="Soal minimal 3 digit";	
		elseif (empty($_POST[a]))
			$msg_er="Jawaban tidak boleh kosong";	
		elseif (empty($_POST[alt_1]))
			$msg_er="Pilihan 1 tidak boleh kosong";	
		elseif (empty($_POST[alt_2]))
			$msg_er="Pilihan 2 tidak boleh kosong";	
		else
		{			
			$kd=$converter->decode($_POST['kd']);
			if (empty($_POST[format])) $_POST[format]='default';
			$dt=mysql_fetch_array(mysql_query("SELECT * FROM soal WHERE kd_soal='$kd'"));
			$dt[a]=mysql_escape_string($dt[a]);
			$dt[alt_1]=mysql_escape_string($dt[alt_1]);
			$dt[alt_2]=mysql_escape_string($dt[alt_2]);
			$dt[alt_3]=mysql_escape_string($dt[alt_3]);
			$dt[alt_4]=mysql_escape_string($dt[alt_4]);
			
			//echo "UPDATE soal SET q='$_POST[q]', a='$_POST[a]', alt_1='$_POST[alt_1]', alt_2='$_POST[alt_2]', alt_3='$_POST[alt_3]', alt_4='$_POST[alt_4]', format='$_POST[format]', kd_modul='$_POST[kd_modul]' WHERE kd_soal='$kd'"; exit;
			
			///a
			mysql_query("UPDATE tempo SET jawaban='$_POST[a]' WHERE kd_soal='$kd' and jawaban='$dt[a]'");
			mysql_query("UPDATE tempo SET a1='$_POST[a]' WHERE kd_soal='$kd' and a1='$dt[a]'");
			mysql_query("UPDATE tempo SET a2='$_POST[a]' WHERE kd_soal='$kd' and a2='$dt[a]'");
			mysql_query("UPDATE tempo SET a3='$_POST[a]' WHERE kd_soal='$kd' and a3='$dt[a]'");
			mysql_query("UPDATE tempo SET a4='$_POST[a]' WHERE kd_soal='$kd' and a4='$dt[a]'");
			mysql_query("UPDATE tempo SET a5='$_POST[a]' WHERE kd_soal='$kd' and a5='$dt[a]'");
 
 			///alt_1
			mysql_query("UPDATE tempo SET jawaban='$_POST[alt_1]' WHERE kd_soal='$kd' and jawaban='$dt[alt_1]'");
			mysql_query("UPDATE tempo SET a1='$_POST[alt_1]' WHERE kd_soal='$kd' and a1='$dt[alt_1]'");
			mysql_query("UPDATE tempo SET a2='$_POST[alt_1]' WHERE kd_soal='$kd' and a2='$dt[alt_1]'");
			mysql_query("UPDATE tempo SET a3='$_POST[alt_1]' WHERE kd_soal='$kd' and a3='$dt[alt_1]'");
			mysql_query("UPDATE tempo SET a4='$_POST[alt_1]' WHERE kd_soal='$kd' and a4='$dt[alt_1]'");
			mysql_query("UPDATE tempo SET a5='$_POST[alt_1]' WHERE kd_soal='$kd' and a5='$dt[alt_1]'");
			
			///alt_2
			mysql_query("UPDATE tempo SET jawaban='$_POST[alt_2]' WHERE kd_soal='$kd' and jawaban='$dt[alt_2]'");
			mysql_query("UPDATE tempo SET a1='$_POST[alt_2]' WHERE kd_soal='$kd' and a1='$dt[alt_2]'");
			mysql_query("UPDATE tempo SET a2='$_POST[alt_2]' WHERE kd_soal='$kd' and a2='$dt[alt_2]'");
			mysql_query("UPDATE tempo SET a3='$_POST[alt_2]' WHERE kd_soal='$kd' and a3='$dt[alt_2]'");
			mysql_query("UPDATE tempo SET a4='$_POST[alt_2]' WHERE kd_soal='$kd' and a4='$dt[alt_2]'");
			mysql_query("UPDATE tempo SET a5='$_POST[alt_2]' WHERE kd_soal='$kd' and a5='$dt[alt_2]'");
			
			///alt_3
			mysql_query("UPDATE tempo SET jawaban='$_POST[alt_3]' WHERE kd_soal='$kd' and jawaban='$dt[alt_3]'");
			mysql_query("UPDATE tempo SET a1='$_POST[alt_3]' WHERE kd_soal='$kd' and a1='$dt[alt_3]'");
			mysql_query("UPDATE tempo SET a2='$_POST[alt_3]' WHERE kd_soal='$kd' and a2='$dt[alt_3]'");
			mysql_query("UPDATE tempo SET a3='$_POST[alt_3]' WHERE kd_soal='$kd' and a3='$dt[alt_3]'");
			mysql_query("UPDATE tempo SET a4='$_POST[alt_3]' WHERE kd_soal='$kd' and a4='$dt[alt_3]'");
			mysql_query("UPDATE tempo SET a5='$_POST[alt_3]' WHERE kd_soal='$kd' and a5='$dt[alt_3]'");
			
			///alt_4
			mysql_query("UPDATE tempo SET jawaban='$_POST[alt_4]' WHERE kd_soal='$kd' and jawaban='$dt[alt_4]'");
			mysql_query("UPDATE tempo SET a1='$_POST[alt_4]' WHERE kd_soal='$kd' and a1='$dt[alt_4]'");
			mysql_query("UPDATE tempo SET a2='$_POST[alt_4]' WHERE kd_soal='$kd' and a2='$dt[alt_4]'");
			mysql_query("UPDATE tempo SET a3='$_POST[alt_4]' WHERE kd_soal='$kd' and a3='$dt[alt_4]'");
			mysql_query("UPDATE tempo SET a4='$_POST[alt_4]' WHERE kd_soal='$kd' and a4='$dt[alt_4]'");
			mysql_query("UPDATE tempo SET a5='$_POST[alt_4]' WHERE kd_soal='$kd' and a5='$dt[alt_4]'");	
			
			mysql_query("UPDATE soal SET q='$_POST[q]', a='$_POST[a]', alt_1='$_POST[alt_1]', alt_2='$_POST[alt_2]', alt_3='$_POST[alt_3]', alt_4='$_POST[alt_4]', format='$_POST[format]', kd_modul='$_POST[kd_modul]' WHERE kd_soal='$kd'");
			
			$msg="Soal nomor $kd telah dirubah";
			$msg=$converter->encode($msg);
			$_SESSION['tab']=1;
			$_SESSION['kdm']=$_POST[kd_modul];
			$_SESSION['ack']=$_POST[format];
			header ("Location: ./?to=$listsoal&msg=$msg");
			exit;
		}	
		$_GET['to']=$addsoal;
	}
	elseif ($_GET[ac]=="rensoal")
	{
		$dt=mysql_fetch_row(mysql_query("SELECT * FROM soal WHERE kd_soal='$ren'"));
		$_POST[kd_modul]=$dt[1];
		$_POST[q]=$dt[2];
		$_POST[a]=$dt[3];
		$_POST[alt_1]=$dt[4];
		$_POST[alt_2]=$dt[5];
		$_POST[alt_3]=$dt[6];
		$_POST[alt_4]=$dt[7];
		$_POST[format]=$dt[8];
		
		$alt_1=htmlentities($alt_1);
		$alt_2=htmlentities($alt_2);
		$alt_3=htmlentities($alt_3);
		$alt_4=htmlentities($alt_4);		
		$_GET['to']=$addsoal;
	}
	elseif ($_GET[ac]=="delsoal")
	{
		mysql_query("DELETE FROM soal WHERE kd_soal='$del'");
		$msg="Soal nomor $del sudah dihapus"; 
		$msg=$converter->encode($msg);
		$_SESSION[tab]=1;
		$_SESSION['list']="$_POST[kelas]|$_POST[satu_hal]|$_POST[order]|$_POST[sort]|$_POST[hal]";
		header("Location: ./?to=$addsoal&msg=$msg");	
	}
    elseif ($_POST[import_soal]=="ok")
    {    
        require_once "./plugins/excel_reader.php";
        $target ="./upload/" . basename($_FILES['soal']['name']);
        move_uploaded_file($_FILES['soal']['tmp_name'], $target);
        $berhasil=0;
        $data = new Spreadsheet_Excel_Reader($target,false);    
        $baris = $data->rowcount($sheet_index=0);
        $nm_modul = $data->val(1, 2);
        if($nm_modul != "")
        {
            if (mysql_num_rows(mysql_query("SELECT * FROM modul WHERE nm_modul='$nm_modul' "))>0)
            {
                $dt=mysql_fetch_array(mysql_query("SELECT * FROM modul WHERE nm_modul='$nm_modul' "));
            }
            else
            {
                mysql_query("INSERT INTO modul VALUES (default,'$nm_modul','Aktif')");
                $dt=mysql_fetch_array(mysql_query("SELECT * FROM modul WHERE nm_modul='$nm_modul' "));            
            }
            $kd_modul=$dt[kd_modul];    
        }
        for ($i=4; $i<=$baris; $i++)
        {
            $q      = $data->val($i, 2);
            $a      = $data->val($i, 3);
            if($q != "" && $a != "" && $kd_modul != "")
            {
                $alt_1  = $data->val($i, 4);
                $alt_2  = $data->val($i, 5);
                $alt_3  = $data->val($i, 6);
                $alt_4  = $data->val($i, 7);
                $format = $data->val($i, 8);        
                if ($format=='Ya') $format="random";
                else $format="Default";
                if (mysql_query("INSERT into soal values(default,'$kd_modul','<p>$q</p>','<p>$a</p>','<p>$alt_1</p>','<p>$alt_2</p>','<p>$alt_3</p>','<p>$alt_4</p>','$format')"))
                    $berhasil++;        
            }
        }
    
        if($berhasil==0)
        {
            die(mysql_error());
        } else {
            echo "Data berhasil diimpor.";
        }
    
        unlink($target);
        $msg=$converter->encode("$berhasil Soal berhasil diimport!"); 
        header("Location: ./?to=$importsoal&msg=$msg");
        exit;
    }

		
	elseif ($_GET[ac]=="rst")
	{			
		$rst=$converter->decode($_GET[rst]);
		$dt=mysql_fetch_row(mysql_query("SELECT username FROM users WHERE user_id='$rst'"));
		$new_pass=md5("0000-00-00");
		if (mysql_query("UPDATE users SET password='$new_pass' WHERE user_id='$rst' LIMIT 1")) 
			$msg="Password $rst sudah diubah menjadi defaultnya(0000-00-00)";
		else 
			$msg="Password $rst GAGAL Reset! ";
		$_GET[msg]=$converter->encode($msg);
		$_GET['to']=$listq;
	}
	elseif ($_GET[ac]=="burn")
	{
		$burn=$converter->decode($_GET[burn]);
		$dt=mysql_fetch_row(mysql_query("SELECT username FROM users WHERE user_id='$burn'"));
		if (mysql_query("DELETE FROM tempo WHERE user_id='$burn'")) 
		{	
			mysql_query("UPDATE login set ip='' WHERE user_id='$burn'");
			$msg="Cache Memory User $burn sudah dihapus!";
		}
		else
			$msg="Cache Memory User $burn gagal dihapus!";
		$_GET[msg]=$converter->encode($msg);		
		$_GET['to']=$listq;
	}
	elseif ($_GET[ac]=="resetlogin")
	{		
		$reslog=$converter->decode($_GET[reslog]);
        $val=$converter->decode($_GET[val]);
		$dt=mysql_fetch_row(mysql_query("SELECT username FROM users WHERE user_id='$reslog'"));
        $d=mysql_fetch_row(mysql_query("SELECT * FROM login WHERE user_id='$reslog'"));            
        $tm=time();
        $sel = $d[waktu] - ($tm-$d[mulai]);
        if (!empty($val))
        {        
            if (mysql_query("UPDATE login SET sesi='' , waktu='', mulai='' WHERE user_id='$reslog'")) 
            {	            
                mysql_query("INSERT INTO kunci values('$reslog','$sel','$val')");
                $sel=floor($sel/60);
                $msg="Login User $dt[0] sudah direset! Sisa waktu : $sel menit";
            }
            else
                $msg="Login User $dt[0] gagal sudah direset!";
        }
        else
        {
            $msg="Login User $dt[0] gagal sudah direset!";
        }
        
        $_GET[msg]=$converter->encode($msg);		
		$_GET['to']=$resetlogin;
	}

//-------------------- on progres --->		
	elseif ($_GET[ac]=="pull")   //kumpulkan paksa ok
	{
		$pull=$converter->decode($_GET[pull]);
		$hasil=mysql_query("SELECT distinct(kd_ujian) FROM tempo WHERE user_id='$pull'");
		$dt9=mysql_fetch_array($hasil);
		
		$dt=mysql_fetch_array(mysql_query("SELECT kd_modul, jml_soal, jenis FROM ujian WHERE kd_ujian='$dt9[kd_ujian]'"));
		$kd_modul=$dt[0];
		if ($dt9[kd_ujian]==10) $sts='0'; else $sts='10';
		if ($query1=mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$pull'"))
		{
			while ($dt1=mysql_fetch_array($query1))
			{
				++$i;
				$id=$dt1[kd_soal];
				$dt2=mysql_fetch_array(mysql_query("SELECT jawaban FROM tempo WHERE kd_soal='$id' and user_id='$pull'"));
				$dt3=mysql_fetch_array(mysql_query("SELECT a FROM soal WHERE kd_soal='$id'"));
				if ($dt2[jawaban]===$dt3[a])
					$benar++;				
			}
			$nilai=ceil(($benar/$dt[1]) * 100);
			$tgl_test=time();
			$dt10=mysql_fetch_array(mysql_query("SELECT mulai FROM login WHERE user_id='$pull'"));
			$tgl_mulai=$dt10[mulai];	
			$time_now=microtime();
			$time_now=substr($time_now,11,10);		
			$sisawaktu= $_SESSION[waktupengerjaan]-($time_now - $_SESSION[waktumulaiujian]);
			
			
			$hapus_temp=mysql_query("INSERT INTO hasil VALUES (default,'$dt9[kd_ujian]','$pull','$nilai','$tgl_mulai','$tgl_test','$sisawaktu','$benar','$dt[1]','1')");
	
			mysql_query("INSERT INTO hasiltemp VALUES (default,'$dt9[kd_ujian]','$pull','$nilai','$tgl_mulai','$tgl_test','$sisawaktu','$benar','$dt[1]','$sts')");
					
			$query2=mysql_query("SELECT kd_hasil FROM hasil WHERE kd_ujian='$dt9[kd_ujian]' and user_id='$pull' and tgl_selesai='$tgl_test'");
			$dt2=mysql_fetch_array($query2);
			$kd_hasil=$dt2[0];
			mysql_query("UPDATE login SET mulai='', waktu='' WHERE user_id='$pull'");
			$query1=mysql_query("SELECT kd_soal FROM tempo WHERE user_id='$pull' ORDER BY kd_tempo ASC");
			while ($dt1=mysql_fetch_array($query1))
			{
				
				$dt2=mysql_fetch_array(mysql_query("SELECT * FROM tempo WHERE kd_soal='$dt1[kd_soal]' and user_id='$pull'"));
							
				if (mysql_query("INSERT INTO jawaban VALUES (default,'$kd_hasil','$pull','$dt1[kd_soal]','$dt2[jawaban]','$dt2[a1]','$dt2[a2]','$dt2[a3]','$dt2[a4]','$dt2[a5]','$dt2[opt]')"))
				{
					mysql_query("DELETE FROM tempo WHERE user_id='$pull' and kd_soal='$dt1[0]'");
				}
			}
			if($hapus_temp) 
			{ 
				mysql_query("DELETE FROM tempo WHERE user_id='$pull'"); 
				mysql_query("DELETE FROM login WHERE user_id='$pull'");
                mysql_query("DELETE FROM kunci WHERE user_id='$pull'");                
			}
		}
		$_GET[msg]=$converter->encode("Ujian $pull telah ditarik dan dikumpulkan!");		
		$_GET['to']=$viewujian;
	}
	elseif ($_GET[ac]=="testbad")    //hapus test ok
	{
		if ($query=mysql_query("DELETE FROM tempo WHERE user_id='$del'"))
		{
            mysql_query("DELETE FROM kunci WHERE  user_id='$del'");
            mysql_query("UPDATE login SET mulai='', waktu='' WHERE user_id='$del'");
			$msg="Proses ujian $del sudah dihapus!";
			$msg=$converter->encode($msg);
            header("Location: ./?to=$viewujian&filter=$_GET[filter]&value=$_GET[value]&msg=$msg");	
            exit;
        }
		else
		{
			$msg_er="Proses ujian $del gagal dihapus!";			
			$_GET['to']=$viewujian;
		}
	}
	elseif ($_GET[ac]=="locktest")   //kunci test ok
	{      
        $lock=$converter->decode($_GET[lock]);        
        $d=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$lock'")); 
        $new_login=microtime();
        $new_login=substr($new_login,11,10);
        if ($d[sesi]!='Lock') 	//kunci siswa
        {  
            $e=mysql_fetch_array(mysql_query("SELECT kd_ujian FROM tempo WHERE user_id='$lock' LIMIT 1"));

            $sisa=$d[waktu]-($new_login-$d[mulai]);
            if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$lock' and kd_ujian='$e[kd_ujian]'"))>0)
            {
                mysql_query("UPDATE kunci SET waktu='$sisa', kd_ujian='$e[kd_ujian]' WHERE user_id='$lock'");
            }             
            else
            {
                mysql_query("INSERT INTO kunci VALUES('$lock','$sisa','$e[kd_ujian]')");
            }

            if (mysql_query("UPDATE login SET sesi='Lock', mulai='', waktu='' WHERE user_id='$lock'"))
            {
                $msg="Data ujian $lock sudah dikunci!";
            }
            else
            {
                $msg="Data ujian $lock gagal dikunci!";
            }
        }
        else				//dibuka
        {
            $e=mysql_fetch_array(mysql_query("SELECT * FROM kunci WHERE user_id='$lock'"));

            if ($query=mysql_query("UPDATE login SET login ='$new_login',  mulai='$new_login', waktu='$e[waktu]', sesi='$sesid' WHERE  user_id='$lock'"))
            {
                $msg="Data ujian $lock sudah dibuka!";
            }
            else
            {
                $msg="Data ujian $lock gagal dibuka!";
            }
        }	
		$msg=$converter->encode($msg);		
        header("Location: ./?to=$viewujian&msg=$msg");	
        exit;
	}

//-------------------- test result --->			
    elseif ($_POST[loop])      //ujikan ulang ok
	{
		$loop=$converter->decode($_POST[kd_hasil]);		
        
		$dt=mysql_fetch_array(mysql_query("SELECT hasil.*, ujian.lama, ujian.kd_modul FROM hasil left join ujian on hasil.kd_ujian=ujian.kd_ujian WHERE kd_hasil='$loop'"));

        if (mysql_num_rows(mysql_query("SELECT * FROM tempo WHERE user_id='$dt[user_id]'"))>1)
        {
            $msg="Peserta $dt[user_id] sedang mengerjakan ujian! Restore ujian dibatalkan!";
            $_GET[msg]=$converter->encode($msg);
		    $_GET['to']=$viewujian;    
        }
        else
        {
            $qry=mysql_query("SELECT * FROM jawaban WHERE kd_hasil='$loop' ORDER BY kd_jawaban ASC ");		
            while ($dt1=mysql_fetch_array($qry))
            {
                mysql_query("INSERT INTO tempo VALUES (default,'$dt[user_id]','$dt[kd_ujian]','$dt1[kd_soal]','$dt1[jawaban]','$dt1[a1]','$dt1[a2]','$dt1[a3]','$dt1[a4]','$dt1[a5]','','$dt1[option]')");
            }        
            $sisa=$_POST[lama]*60;

            $is_login=microtime();
            $is_login=substr($is_login,11,10);

            if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$dt[user_id]'"))==0)
                mysql_query("INSERT INTO kunci VALUES ('$dt[user_id]','$sisa','$dt[kd_ujian]')");
            else
                mysql_query("UPDATE kunci SET waktu='$sisa', kd_ujian='$dt[kd_ujian]' WHERE user_id='$dt[user_id]'");
            mysql_query("DELETE FROM jawaban WHERE kd_hasil='$loop'");
            mysql_query("DELETE FROM hasil WHERE kd_hasil='$loop'");
            mysql_query("UPDATE login SET mulai='', eaktu='', sesi='', ruang='' WHERE user_id='$dt[user_id]'");

            $msg="ujian $dt[0] berhasil direstore dengan $sisa waktu pengerjaan";
            $_GET[msg]=$converter->encode($msg);
            $_GET['to']=$viewujian;
        }
    }
	elseif ($_GET[ac]=="badresult")     	//hapus hasil ujian
	{
		if ($query=mysql_query("DELETE FROM jawaban WHERE kd_hasil='$del'"))
		{
			if ($query=mysql_query("DELETE FROM hasil WHERE kd_hasil='$del'"))
			{
				$msg="Data ujian $del sudah dihapus!";
				$_GET[msg]=$converter->encode($msg);
				$_GET['to']=$viewresult;
			}
		}
		else
		{
			$msg="Data ujian $del gagal dihapus!";
			$_GET[msg]=$converter->encode($msg);
			$_GET['to']=$viewresult;
		}
	}
/*  elseif ($_GET[ac]=="delaja")    //hapus hasil ujian
	{
		if ($query=mysql_query("DELETE FROM jawaban WHERE kd_hasil='$a[5]'"))
		{
			if ($query=mysql_query("DELETE FROM hasil WHERE kd_hasil='$a[5]'"))
			{
				$msg="Data ujian $a[5] sudah dihapus!";
				$msg=$converter->encode($msg);
				$_SESSION[tab]=0;
				$_SESSION['list']="$a[0]|$a[1]|$a[2]|$a[3]|$a[4]";
				$_GET['to']=$korekdaftar;
			}
		}
		else
		{
			$msg="Data ujian $a[5] gagal dihapus!";
			$msg=$converter->encode($msg);
			$_GET['to']=$korekdaftar;
		}
	}
	elseif ($_POST['simpankoreksi'])
	{
		$kd_hasil=$_POST[kd_hasil];

		$query1=mysql_query("SELECT jawaban.kd_jawaban, hasil.soal, jawaban.jawaban, soal.kd_soal FROM hasil, jawaban, soal WHERE  hasil.kd_hasil='$kd_hasil' and jawaban.kd_hasil=hasil.kd_hasil and soal.kd_soal=jawaban.kd_soal");
		
		while ($dt=mysql_fetch_array($query1))
		{
			$kd_soal=$dt[kd_soal];
			$nilai=$_POST[nilai][$kd_soal];
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  kd_hasil='$kd_hasil'");
			$totalnilai+=$nilai;
			$jmlsoal=$dt[soal];
		}

		$totalnilai=$totalnilai / $jmlsoal;
		if (mysql_query("UPDATE hasil SET nilai='$totalnilai', status='10' WHERE kd_hasil='$kd_hasil'")) {
			$msg="Data koreksi $kd_hasil berhasil disimpan!";
		$msg=$converter->encode($msg);
		}
	}
	elseif ($_POST['simpankoreksisoal'])
	{
		$kd_soal=$_POST[kd_soal];
		if ($_POST[nil1]) { $nil1=$_POST[nil1]; $has1=$_POST[hasil1]; }
		if ($_POST[nil2]) { $nil2=$_POST[nil2]; $has2=$_POST[hasil2]; }
		if ($_POST[nil3]) { $nil3=$_POST[nil3]; $has3=$_POST[hasil3]; }
		if ($_POST[nil4]) { $nil4=$_POST[nil4]; $has4=$_POST[hasil4]; }
		if ($_POST[nil5]) { $nil5=$_POST[nil5]; $has5=$_POST[hasil5]; }
		if ($_POST[nil6]) { $nil6=$_POST[nil6]; $has6=$_POST[hasil6]; }
		if ($_POST[nil7]) { $nil7=$_POST[nil7]; $has7=$_POST[hasil7]; }
		if ($_POST[nil8]) { $nil8=$_POST[nil8]; $has8=$_POST[hasil8]; }
		if ($_POST[nil9]) { $nil9=$_POST[nil9]; $has9=$_POST[hasil9]; }
		if ($_POST[nil10]){ $nil10=$_POST[nil10]; $has10=$_POST[hasil10]; }
		//echo "$nil1-$nil2-$nil3-$nil4-$nil5-$nil6-$nil7-$nil8-$nil9-$nil10"; exit;
				
		if (!empty($nil1))
		{
			$nilai=$_POST[nilai][$nil1];			
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil1' and kd_hasil='$has1'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has1'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has1'");
		}
		if (!empty($nil2))
		{
			$nilai=$_POST[nilai][$nil2];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil2' and kd_hasil='$has2'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has2'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has2'");
		}
		if (!empty($nil3))
		{
			$nilai=$_POST[nilai][$nil3];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil3' and kd_hasil='$has3'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has3'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has3'");
		}
		if (!empty($nil4))
		{
			$nilai=$_POST[nilai][$nil4];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil4' and kd_hasil='$has4'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has4'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has4'");
		}
		if (!empty($nil5))
		{
			$nilai=$_POST[nilai][$nil5];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil5' and kd_hasil='$has5'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has5'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has5'");
		}
		if (!empty($nil6))
		{
			$nilai=$_POST[nilai][$nil6];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil6' and kd_hasil='$has6'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has6'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has6'");
		}
		if (!empty($nil7))
		{
			$nilai=$_POST[nilai][$nil7];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil7' and kd_hasil='$has7'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has7'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has7'");
		}
		if (!empty($nil8))
		{
			$nilai=$_POST[nilai][$nil8];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil8' and kd_hasil='$has8'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has8'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has8'");
		}
		if (!empty($nil9))
		{
			$nilai=$_POST[nilai][$nil9];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil9' and kd_hasil='$has9'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has9'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has9'");
		}
		if (!empty($nil10))
		{
			$nilai=$_POST[nilai][$nil10];						
			mysql_query("UPDATE jawaban SET a1='$nilai' WHERE kd_soal='$kd_soal' and  user_id='$nil10' and kd_hasil='$has10'");			
			$query1=mysql_query("SELECT avg(a1) FROM jawaban WHERE kd_hasil='$has10'");
			$data=mysql_fetch_array($query1);			
			mysql_query("UPDATE hasil SET nilai=$data[0], status=status+1 WHERE kd_hasil='$has10'");
		}		
	}*/
?>
