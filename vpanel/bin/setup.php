<?php
	if(!isset($_SESSION)) session_start();
	error_reporting(1);
	date_default_timezone_set('Asia/Jakarta'); 

	function datab($var1,$var2,$var3,$var4) { 
	$cone=mysql_connect($var1,$var2,$var3) or die("Gagal terhubung dengan database server $var1"); $cone=mysql_select_db($var4,$cone) or die("Gagal mengaktifkan database $var4"); }
	
	function tgl($tgl) {
		$t=substr($tgl,8,2);
		$b=substr($tgl,5,2);
		$h=substr($tgl,0,4);
		$tgl=$t.'-'.$b.'-'.$h;
		return ($tgl);
	}
	function baliktgl($tgl) {
		$h=substr($tgl,0,2);
		$b=substr($tgl,3,2);
		$t=substr($tgl,6,4);
		$tgl=$t.'-'.$b.'-'.$h;
		return ($tgl);
	}
	function logout() { session_destroy(); header("Location: ./");  exit; } 

    function Kdel($apa) {
        echo "return confirm('Yakin akan menghapus $apa?')";

    }
    $sesion_id=session_id();
	$server		=$_SERVER['SERVER_NAME'];
	$is_admin	=$_SESSION['is_admin'];
	$is_login	=$_SESSION['is_login'];
	$is_name	=$_SESSION['is_name'];
	$is_sekolah	=$_SESSION['is_sekolah'];
	$id_ujian	=$_SESSION['id_ujian'];	
	unset($_SESSION[darilogin]);
	$namaserver	="http://$server";
	$dblocation	="localhost";
    $server_pusat ="182.253.112.100";
	$dbusername	="root";
	$dbpassword	="el1n";
	$dbname		="ujian70";
    $tokek      ="SMKBWI";
    $pin='miofcvjiosedr8ertj';
	require_once "encclass.php";
	$converter = new Encryption;	
	datab($dblocation,$dbusername,$dbpassword,$dbname);
	
	$sudah_konek=true;
	$block		=$converter->encode('block');
	$warning	=$converter->encode('warning');
	$login		=$converter->encode('login');

?>