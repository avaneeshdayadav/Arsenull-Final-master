<?php
session_start();
include_once('DBConnect.php');

$allProf=$_POST['allProf'];
$allProfSubj=$_POST['allProfSubj'];
$refSubject=$allProfSubj[0];
$i=0;

// Fixed variables
$name=$_POST['name'];
$roll=$_POST['roll'];
$email=$_POST['email'];
$stdOldEmail=$_POST['stdOldEmail'];
$classDiv=$_GET['division'];
$className=$_GET['className'];
// Fixed variables end


foreach($allProf as $thisProfId)
{
	$thisClassId=0;
	$stdTableName=$thisProfId."_students";
	// echo "Update $stdTableName set stdName=$name stdRoll=$roll stdEmail=$email where stdClassName=$className and stdDiv=$division and subj=$allProfSubj[$i] and stdEmail=$stdOldEmail";


    // Grab class id.
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
    // Grab class id end.



	$updSql = "UPDATE $stdTableName SET stdName='$name', stdRoll='$roll', stdEmail='$email' WHERE stdClassId='$thisClassId' AND stdEmail='$stdOldEmail' ";
	if (mysqli_query($con, $updSql))
	{	
		echo "Updated successfully";;
	}
	else
	{
	  echo "Error updating record of $teacherName " . mysqli_error($con);
	}
	$i++;
}
?>
