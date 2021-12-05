<?php
session_start();
include_once('DBConnect.php');

$classDiv=$_GET['division'];
$className=$_GET['className'];
$i=0;

$stdName=$_POST['name'];
$stdRoll=$_POST['roll'];
$stdEmail=$_POST['email'];

$allProfIds=$_POST['allProf'];
$allProfSubj=$_POST['allProfSubj'];

echo "<br>";
foreach($allProfIds as $thisProfId)
{
	$thisClassId=0;

	// Grab this prof's classID.
        $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND subj='$allProfSubj[$i]' AND profId='$thisProfId' ";
        $classIdRes=mysqli_query($con,$classIdSql);
        if(mysqli_num_rows($classIdRes))
        {
            while($row = mysqli_fetch_assoc($classIdRes))
            {
                $thisClassId=(int)$row['id'];
            }
        }
        else
        {
            echo "<script>alert('You have no such class');window.location='newhomepage.php';</script>";
        }
    // Grab this prof's classID end.

	$stdTableName=$thisProfId."_students";
	$sql = "INSERT INTO $stdTableName (stdName, stdRoll, present_date_ids, stdEmail,stdClassId) VALUES ('$stdName', '$stdRoll', '', '$stdEmail', '$thisClassId' ) ";
	if (mysqli_query($con, $sql))
	{
  		echo "New Student inserted";
	}
	else
	{
  		echo "Error in inserting new student: " . $sql . "<br>" . mysqli_error($con);
	}

	$i++;

}

?>