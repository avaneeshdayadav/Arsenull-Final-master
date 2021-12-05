<?php

session_start();
include_once('DBConnect.php');

$testId=$_POST['testId'];
$inpType=$_POST['inpType'];
$profId=$_SESSION['profId'];
$secNo=(int)$_POST['secNo'];
$secTableName=$profId."_test_sections";

$secNoSql="SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
$secNoRes=mysqli_query($con,$secNoSql);
if(mysqli_num_rows($secNoRes))
{
	while($row=mysqli_fetch_assoc($secNoRes))
	{
		$secId=$row['id'];
	}
}


if($inpType=='S')
{
	$tableName=$profId.'_test_sections';
	$insSecSql="INSERT INTO $tableName (testId,secNo,unitName,cumpNoOfQn) VALUES('$testId','$secNo','',0 )";
	if(mysqli_query($con,$insSecSql));
	else echo "Error :$insSecSql ".mysqli_error($con);

}

if($inpType=='Q')
{
	$qnNo=(int)$_POST['qnNo'];
	$tableName=$profId.'_test_qns';
	$insQnSql="INSERT INTO $tableName (qnNo,question,qnImg,testId,secId) VALUES('$qnNo','','','$testId','$secId' )";
	if(mysqli_query($con,$insQnSql));
	else echo "Error: ".mysqli_error($con);

}

if($inpType=='NQ')
{
	$qnNo=(int)$_POST['qnNo'];
	$tableName=$profId.'_test_qns';

	$selSql="SELECT * FROM $tableName WHERE testId='$testId' AND secId='$secId' ORDER BY qnNo " ;
	$selSqlRes=mysqli_query($con,$selSql);

	if(mysqli_num_rows($selSqlRes))
	{
		while($row=mysqli_fetch_assoc($selSqlRes))
		{
			if($row['qnNo']>=$qnNo)
			{
				$oldQno= $row['qnNo'];
				$newQnNo = $oldQno + 1;
				$id=$row['id'];
				// echo "$oldQno,$newQnNo  ";
				mysqli_query($con,"UPDATE $tableName SET qnNo='$newQnNo' WHERE testId='$testId' AND secId='$secId' AND qnNo='$oldQno' AND id='$id' ");
			}
		}
	}
	else
	{
		echo "ERROR: ".mysqli_error($con);
	}

	$insQnSql="INSERT INTO $tableName (qnNo,question,qnImg,testId,secId) VALUES('$qnNo','','','$testId','$secId' )";
	mysqli_query($con,$insQnSql);

}

if($inpType=='O')
{
	$qnNo=(int)$_POST['qnNo'];
	$optNo=(int)$_POST['optNo'];
	$tableName=$profId.'_test_opts';
	$qnsTableName=$profId.'_test_qns';

	$qnNoSql="SELECT * FROM $qnsTableName WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' " ;
	$qnNoRes=mysqli_query($con,$qnNoSql);
	if(mysqli_num_rows($qnNoRes))
	{
		while($row=mysqli_fetch_assoc($qnNoRes))
		{
			$qnId=$row['id'];
		}
	}
	else
	{
		echo "Some Error: ".mysqli_error($con);
	}

	$insOptSql="INSERT INTO $tableName (testId,qnId,optNo,optInp,optImg,correctFlag) VALUES('$testId','$qnId','$optNo','','',0 )";
	if(mysqli_query($con,$insOptSql));
	else echo "Error opts: ".mysqli_error($con);
}


?>