<?php
$name=$_POST['name'];
$roll=$_POST['roll'];
$updatedPresentee=$_POST['updatedPresentee']; // Update in presentee that teacher has made passed by that page to here in form of 1 and 0.
$newPresentDateIds=array();// Updated presentee in the form of date id's by converting them from 1/0 form of updatedPresentee array.
$presentIdsToBeInserted=array();// Final presentee id array that will be inserted in database.

// Index variables initialization.
$i=0;
$j=0;

// Geting database connection.
include_once('DBConnect.php');
session_start();


// geting session variables for future use.
$username=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$tableNameCal=$profId."_calender";
$tableNameStd=$profId."_students";

$classSubject=$_GET['subjSearch'];
$classDiv=$_GET['division'];
$className=$_GET['className'];

$workingDates=$_SESSION['workingDates'];
$totalWD=count($workingDates);
$classId=0;

// Grab class id.
    $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND subj='$classSubject' AND profId='$profId' ";
    $classIdRes=mysqli_query($con,$classIdSql);
    if(mysqli_num_rows($classIdRes))
    {
        while($row = mysqli_fetch_assoc($classIdRes))
        {
            $classId=(int)$row['id'];
        }
    }
    else
    {
        echo "<script>alert('You have no such class');window.location='newhomepage.php';</script>";
    }
// Grab class id end.

// Making new present date ids of student by using working dates and updatedPresentee data. And storing -1 at place of Absentee.
foreach ($workingDates as $dateId)
{
	if($updatedPresentee[$j]=="1")
	{
		array_push($newPresentDateIds,$dateId);
	}
	else
	{
		array_push($newPresentDateIds,-1);
	}
	$j++;
}



// Grabing current student's id from database.
$stdSql="SELECT * FROM $tableNameStd WHERE stdClassId='$classId' AND stdRoll='$roll' AND stdName='$name'";
$stdSqlResult=mysqli_query($con,$stdSql);
if(mysqli_num_rows($stdSqlResult))
{
	while($row = mysqli_fetch_assoc($stdSqlResult))
	{
		$thisStdId=$row['id'];
	}
}


foreach($workingDates as $wd)
{
	if($wd == $newPresentDateIds[$i])
	{
		// Go to this date's id in calender database and get all students id present on thid date in an array.
		$dateSql="SELECT * FROM $tableNameCal WHERE stdClassId='$classId' AND id='$wd'";
		$dateSqlResult=mysqli_query($con,$dateSql);
		if(mysqli_num_rows($dateSqlResult))
		{
			while($row = mysqli_fetch_assoc($dateSqlResult))
			{
				$studentIdCommaText=$row['present_std_ids'];
			}
		}
		$studentPresentIdsArr=explode(",",$studentIdCommaText); // Breaks a string to an array.


		// Appending this std id in present std id array and converting array to comma seperated string.
		if(!(in_array($thisStdId, $studentPresentIdsArr)))
		{
			array_push($studentPresentIdsArr,$thisStdId);
			sort($studentPresentIdsArr);
			$studentPresentIdStr=implode(",",$studentPresentIdsArr);

			// Updating modified studentPresenteeIdsArr into calender table.
			$updSql = "UPDATE $tableNameCal SET present_std_ids='$studentPresentIdStr' WHERE id='$wd' ";
			if (!(mysqli_query($con, $updSql)))
			{
			  echo "Error updating student id = $thisStdId in calendar table : " . mysqli_error($con);
			}

			// Get std table and get present date id field in an array.
			$stdIdSql = "SELECT * FROM $tableNameStd WHERE id='$thisStdId' ";
			$stdIdSqlResult=mysqli_query($con,$stdIdSql);
			if(mysqli_num_rows($stdIdSqlResult))
			{
				while($row = mysqli_fetch_assoc($stdIdSqlResult))
				{
					$presentDateIdsText=$row['present_date_ids'];
				}
			}
			$presentDateIdsArr=explode(",",$presentDateIdsText);

			// Appending this date id $wd in present date id array.
			array_push($presentDateIdsArr,$wd);
			sort($presentDateIdsArr);
			$presentDateIdStr=implode(",",$presentDateIdsArr);


			// Updating modified $presentDateIdArr into student table table.
			$updSql = "UPDATE $tableNameStd SET present_date_ids='$presentDateIdStr' WHERE id='$thisStdId' ";
			if (!(mysqli_query($con, $updSql)))
			{
			  echo "Error updating student id = $thisStdId in student table : " . mysqli_error($con);
			}			
		}
	}
	if($newPresentDateIds[$i] == -1)
	{
		// Go to this date's id in calender database and get all students id present on thid date in an array.
		$dateSql="SELECT * FROM $tableNameCal WHERE stdClassId='$classId' AND id='$wd'";
		$dateSqlResult=mysqli_query($con,$dateSql);
		if(mysqli_num_rows($dateSqlResult))
		{
			while($row = mysqli_fetch_assoc($dateSqlResult))
			{
				$studentIdCommaText=$row['present_std_ids'];
			}
		}
		$studentPresentIdsArr=explode(",",$studentIdCommaText); // Breaks a string to an array.

		if(in_array($thisStdId, $studentPresentIdsArr))
		{
			// Deleting not required stdId from array of present std ids brought from calender table and converting that new modified arr to comma seperated string.
			$index1=search_index($studentPresentIdsArr,$thisStdId);
			if($index1 != -1)
			{
				unset($studentPresentIdsArr[$index1]);
				$studentPresentIdStr=implode(",",$studentPresentIdsArr);

				// Updating calender table present_std_ids field of calendar table.
				$updSql = "UPDATE $tableNameCal SET present_std_ids='$studentPresentIdStr' WHERE id='$wd' ";
				if (!(mysqli_query($con, $updSql)))
				{
				  echo "Error updating student id = $thisStdId in calendar table : " . mysqli_error($con);
				}

			}
			else
				echo "something went wrong as index1 returned is -1<br>";

			// Grab Std Table and get present_date_id field in array.
			$stdIdSql = "SELECT * FROM $tableNameStd WHERE id='$thisStdId' ";
			$stdIdSqlResult=mysqli_query($con,$stdIdSql);
			if(mysqli_num_rows($stdIdSqlResult))
			{
				while($row = mysqli_fetch_assoc($stdIdSqlResult))
				{
					$presentDateIdsText=$row['present_date_ids'];
				}
			}
			$presentDateIdsArr=explode(",",$presentDateIdsText);

			// Deleting not required date id from array of present date ids brought from student table and converting that new modified arr to comma seperated string then updating to database.
			$index2=search_index($presentDateIdsArr,$wd);
			if($index1 != -1)
			{
				unset($presentDateIdsArr[$index2]);
				$presentDateIdStr=implode(",",$presentDateIdsArr);

				$updSql = "UPDATE $tableNameStd SET present_date_ids='$presentDateIdStr' WHERE id='$thisStdId' ";
				if (!(mysqli_query($con, $updSql)))
				{
				  echo "Error updating student id = $thisStdId in student table : " . mysqli_error($con);
				}

			}
			else
				echo "something went wrong as index2 returned is -1<br>";

		}

	}// else if -1 condition
	$i++;
}

function search_index($arr,$key)
{
	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i]==$key)
			break;
	}

	if($i<count($arr))
		return $i;
	else
		return -1;
}



?>
