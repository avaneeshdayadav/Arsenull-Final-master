<?php

include_once('DBConnect.php');
session_start();

$profId=$_SESSION['profId'];
$testId=$_POST['testId'];
$tableName=$profId."_test_individiual_qns";
$allSec=array();
$ultra=array();

$testIdSql="SELECT * FROM $tableName WHERE testId='$testId' " ;
$testIdRes=mysqli_query($con,$testIdSql);

if(mysqli_num_rows($testIdRes)>0)
{
	$ultra['status'] = 'ok';
	for($secNo=1;;$secNo++)
	{
		$secSelectSql="SELECT * FROM $tableName WHERE testId='$testId' AND secNo='$secNo' ORDER BY qnIdentityNo " ;
		$secSelectRes=mysqli_query($con,$secSelectSql);
		if(mysqli_num_rows($secSelectRes)>0)
		{
			$oneSec=array();
			while($row=mysqli_fetch_assoc($secSelectRes))
			{
				array_push($oneSec,$row);
			}
			array_push($allSec,$oneSec);

		}
		else
		{
			break;
		}
	}
	$ultra['allSec']=$allSec;
}
else
{
	$ultra['status'] = 'err';
}

echo json_encode($ultra);

?>
