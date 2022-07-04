<?php
session_start();
include_once('DBConnect.php');

$className=$_GET['className'];
$division=$_GET['division'];
$emailOfStdToDel=$_POST['email'];
$allProf=$_POST['allProf'];
$allProfSubj=$_POST['allProfSubj'];


foreach($allProf as $thsProfId)
{
	$stdTableName=$thsProfId."_students";
	$sql = "DELETE FROM $stdTableName WHERE stdEmail='$emailOfStdToDel' ";
	if (mysqli_query($con, $sql)) {
	  echo "Deleted student successfully";
	} else {
	  echo "Error deleting student: " . mysqli_error($con);
	}
}


?>