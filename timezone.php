<?php
session_start();
$val=$_POST['time_diff_btwn_UTC_and_local_time'];
$_SESSION['time_diff_btwn_UTC_and_local_time']=$val;

?>