<?php
session_start();
include_once('DBConnect.php');

$classId=0;
$className=$_GET['className'];
$classDiv=$_GET['division'];

$addSubj=$_POST['addSubj'];

$allStudentName=$_POST['allStudentName'];
$allStudentRollNo=$_POST['allStudentRollNo'];
$allStudentEmail=$_POST['allStudentEmail'];

$creatorClassId=$_POST['creatorClassId'];

$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$stdTableName=$profId."_students";
$isAdmin=1;

$classAlreadyPresentFlag=1;

// Check if this teacher already teaches that subject to this class.
$checkSubSql = "SELECT * FROM class WHERE className='$className' AND subj='$addSubj' AND division='$classDiv' AND profId='$profId' ";
$checkSubRes = mysqli_query($con, $checkSubSql);

if (mysqli_num_rows($checkSubRes) > 0)
{
  // output data of each row
  while($row = mysqli_fetch_assoc($checkSubRes))
  {
    $classAlreadyPresentFlag=1;
  }
}
else
{
	$classAlreadyPresentFlag=0;
}
// Check if this teacher already teaches that subject to this class end.


if($addSubj!="" && $classAlreadyPresentFlag==0)
{
	// Add into class table.
	$sql="INSERT INTO class (profId,className,subj,division,creatorClassId,isAdmin) VALUES('$profId','$className','$addSubj','$classDiv',$creatorClassId,$isAdmin)";
	if (mysqli_query($con, $sql))
	{
		$classId=mysqli_insert_id($con);
  		echo "Succesfully added subject $addSubj to your class.";
	}
	else
	{
  		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
	// Add into class table end.



	// Add into username_students table.
    $sql2 = "INSERT INTO $stdTableName(stdName,stdRoll,present_date_ids,stdEmail,stdClassId) VALUES('$allStudentName[0]','$allStudentRollNo[0]','','$allStudentEmail[0]','$classId');";

    for($i=1;$i<count($allStudentName);$i++)
    {
	    $sql2 .= "INSERT INTO $stdTableName (stdName,stdRoll,present_date_ids,stdEmail,stdClassId) VALUES('$allStudentName[$i]','$allStudentRollNo[$i]','','$allStudentEmail[$i]','$classId');";
    }

	if (mysqli_multi_query($con, $sql2))
	{
  		;
	}
	else
	{
  		echo "Error: " . $sql2 . "<br>" . mysqli_error($con);
	}
	// Add into username_students table end.
}
else
{
	echo "You are already teaching same subject to this class.";
}

?>