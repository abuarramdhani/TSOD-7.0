<?php
session_start();
$_SESSION[curang]=time();
$_SESSION[pinalti]=$_SESSION[pinalti]+60;
header("Location: ./test.php");
exit;
?>