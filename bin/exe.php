<?php
if ($_POST[updatepass])
{
	$pass1=md5((substr($_POST[password1],6,4)).'-'.(substr($_POST[password1],3,2)).'-'.(substr($_POST[password1],0,2)));
	$pass2=md5((substr($_POST[password2],6,4)).'-'.(substr($_POST[password2],3,2)).'-'.(substr($_POST[password2],0,2)));
	if (mysql_num_rows(mysql_query("SELECT password FROM users WHERE user_id='$_SESSION[user_id]' and password='$pass1'"))!=1) { $msg=1; }									
	else					
	{
		mysql_query("Update users SET password='$pass2' WHERE user_id='$_SESSION[user_id]' LIMIT 1");
		$msg=3;
	}
	$do=$converter->encode('changepass');
	$msg=$converter->encode($msg);
	header("Location: ./?do=$do&msg=$msg"); 
	exit;
}
?>