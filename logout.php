<?php
	require "./bin/setup.php";
    //echo "SELECT * FROM login WHERE user_id='$_SESSION[user_id]' <br/>"; exit;
    $d=mysql_fetch_array(mysql_query("SELECT * FROM login WHERE user_id='$_SESSION[user_id]'"));
    if ($d[waktu]>0)
    {
        $now=microtime();
        $now=substr($now,11,10);        
        $selisih=$now-$d[mulai];
        $sisa=$d[waktu]-$selisih;        
        if (mysql_num_rows(mysql_query("SELECT * FROM kunci WHERE user_id='$_SESSION[user_id]'"))>0)
        {            
            mysql_query("UPDATE kunci SET waktu='$sisa', kd_ujian='$_SESSION[id_ujian]' WHERE user_id='$_SESSION[user_id]'");
        }
        else
        {            
            mysql_query("INSERT INTO kunci VALUES('$_SESSION[user_id]','$sisa','$_SESSION[id_ujian]')");
            echo "INSERT INTO kunci VALUES('$_SESSION[user_id]','$sisa','$_SESSION[id_ujian]')"; exit;
        }
        mysql_query("UPDATE login SET login='', mulai='', waktu='', sesi='' WHERE user_id='$_SESSION[user_id]'");
    }
    mysql_query("UPDATE login SET sesi='' WHERE user_id='$_SESSION[user_id]'");
    
    $sesi=$_SESSION[p];
    session_destroy();    
    if (!empty($sesi)) header("Location: ./?p=$pin");
    else header("Location: ./");
	exit;
?>