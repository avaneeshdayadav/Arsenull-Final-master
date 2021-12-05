<?php

include_once('DBConnect.php');
session_start();

$profId=$_SESSION['profId'];
$testId=$_POST['testId'];
$secTableName=$profId."_test_sections";
$qnTableName=$profId."_test_qns";
$optTableName=$profId."_test_opts";
$ultra=array();
$checkSecSql="SELECT * FROM $secTableName WHERE testId='$testId' ORDER BY secNo " ;
$checkSecRes=mysqli_query($con,$checkSecSql);
if(mysqli_num_rows($checkSecRes))
{
	$ultra['status']="ok";
	$sec=array();
	while($row1=mysqli_fetch_assoc($checkSecRes))
	{
		$thisSecId=$row1['id'];
		$checkQnSql="SELECT * FROM $qnTableName WHERE testId='$testId' AND secId='$thisSecId' ORDER BY qnNo " ;
		$checkQnRes=mysqli_query($con,$checkQnSql);
		if(mysqli_num_rows($checkQnRes))
		{
			$qn=array();
			while($row2=mysqli_fetch_assoc($checkQnRes))
			{
				$thisqnId=$row2['id'];
				$checkOptSql="SELECT * FROM $optTableName WHERE testId='$testId' AND qnId='$thisqnId' ORDER BY optNo " ;
				$checkOptRes=mysqli_query($con,$checkOptSql);

				// Get all options of this question.
					if(mysqli_num_rows($checkOptRes))
					{
						$opt=array();
						while($row3=mysqli_fetch_assoc($checkOptRes))
						{
							array_push($opt,$row3);
						}
					}
				// Get all options of this question end.
				$row2['allOpt']=$opt;
				array_push($qn,$row2);
			}
		}
		$row1['allQn']=$qn;
		array_push($sec,$row1);
	}
	$ultra['sec']=$sec;
}
else
{
	$ultra['status']="Not Ok";
}
echo json_encode($ultra);

?>




