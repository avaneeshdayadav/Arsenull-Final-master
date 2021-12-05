<?php
session_start();
include_once('DBConnect.php');

$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$className=$_GET['className'];
$subject=$_POST['subjSearch'];
$division=$_GET['division'];
$testName=$_GET['testName'];
$qnType=1;
$classId=0;

$qno=$_POST['qno'];
$secName=$_POST['secName'];

$unitName=$_POST['unitName'];
$cumplNoOfQns=(int)$_POST['cumplNoOfQns'];

$qnTextInp=$_POST['qnTextInp'];
$qnImgInp=$_FILES["qnImgInp"]["tmp_name"];

$opnAtextInp=$_POST['opnAtextInp'];
$opnBtextInp=$_POST['opnBtextInp'];
$opnCtextInp=$_POST['opnCtextInp'];
$opnDtextInp=$_POST['opnDtextInp'];

$opnAImgInp=$_FILES["opnAImgInp"]["tmp_name"];
$opnBImgInp=$_FILES["opnBImgInp"]["tmp_name"];
$opnCImgInp=$_FILES["opnCImgInp"]["tmp_name"];
$opnDImgInp=$_FILES["opnDImgInp"]["tmp_name"];

$Acorrect=$_POST['Acorrect'];
$Bcorrect=$_POST['Bcorrect'];
$Ccorrect=$_POST['Ccorrect'];
$Dcorrect=$_POST['Dcorrect'];



// Page that uploads images on server.

	include_once('qns_opns_photo_upload.php');

// Page that uploads images on server end.

// Get classId.
	$classIdSql = "SELECT id FROM class WHERE profId='$profId' AND className='$className' AND  division='$division' AND subj='$subject' ";
	$classIdRes = mysqli_query($con, $classIdSql);
	if(mysqli_num_rows($classIdRes))
	{
		while($row=mysqli_fetch_assoc($classIdRes))
		{
			$classId=$row['id'];
		}
	}
// Get classId end.



// Database Upload.
	if($qnTextInp!=""||$qnImgInp!=""||$opnAtextInp!=""||$opnBtextInp!=""||$opnCtextInp!=""||$opnDtextInp!=""||$opnAImgInp!=""||$opnBImgInp!=""||$opnCImgInp!=""||$opnDImgInp!="")
	{
		// Geting TestName id from allTests table.
			$testIdSql = "SELECT id FROM allTests WHERE profId='$profId' AND classId='$classId' AND testName='$testName' " ;
			$result = mysqli_query($con, $testIdSql);
		// Geting TestName id from allTests table end.

			if (mysqli_num_rows($result) > 0)
			{
				// output data of each row
				while($row = mysqli_fetch_assoc($result))
				{
    				$TestNameId=$row["id"];
  				}

			// teacherName_test_individiual_qns Table upload.
				$individualTestQnTableName=$profId."_test_individiual_qns";
				$opnTextCommaSep=$opnAtextInp.'{%,,%}'.$opnBtextInp.'{%,,%}'.$opnCtextInp.'{%,,%}'.$opnDtextInp;
				$correctAnsCommaSep=$Acorrect.','.$Bcorrect.','.$Ccorrect.','.$Dcorrect;
				$opnImgCommaSep=$newopnAImgInp.','.$newopnBImgInp.','.$newopnCImgInp.','.$newopnDImgInp;

				
				$individualTestQnSql="INSERT INTO $individualTestQnTableName(TestNameId,unit,question,options,correctAnswers,qnImg,option_Imgs,qnType,noOfcumplQn) VALUES('$TestNameId','$unitName','$qnTextInp','$opnTextCommaSep','$correctAnsCommaSep','$newQnImgInp','$opnImgCommaSep','$qnType','$cumplNoOfQns')";

				if (mysqli_query($con, $individualTestQnSql))
				{
					echo "New record created successfully in individualqn table";
				}
				else
				{
					echo "Error: " . $individualTestQnSql . "<br>" . mysqli_error($con);
				}
			// teacherName_test_individiual_qns Table upload end.
			}
  			else
  			{
  				echo "Error in selecting id";
  			}


	}
// Database Upload end.


?>