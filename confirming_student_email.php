<?php
$hashUsrId=(string)$_GET['user'];
$stdUserNameUp=(string)$_GET['name'];
include_once('DBConnect.php');

echo $hashUsrId;
echo $stdUserNameUp;

$sql = "SELECT * FROM std_email_conf_pending WHERE username='$stdUserNameUp'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$checkId=$row['id'];
		echo $checkId;
		if (password_verify($checkId, $hashUsrId))
		{
			$stdName=$row['stdName'];
			$email=$row['email'];
			$username=$row['username'];
			$password=$row['password'];
			$expiryFlag=(int)$row['expiryFlag'];
			$currTime=strtotime("now");
			$timeDiff=$currTime-$expiryFlag;
			if($timeDiff<660)
			{

		    	$insSql = "INSERT INTO allStudents (stdName, classesJoined, eqvIdInProfTable,testTaken,email,username,password)VALUES ('$stdName','','','','$email','$username','$password')";

				if (mysqli_query($con, $insSql))
				{
					// sql to delete a record
					$delSql = "DELETE FROM std_email_conf_pending WHERE id='$checkId' ";

					if (mysqli_query($con, $delSql))
					{
						echo "<script>alert('You have registerd succesfully');window.location='student_login.php';</script>";
						break;
					}
					else
					{
					  echo "Error deleting record: " . mysqli_error($conn);
					}

				}
				else
				{
				  echo "Error: " . $insSql . "<br>" . mysqli_error($con);
				}

			}
			else
			{
				// sql to delete a record
				$delSql = "DELETE FROM std_email_conf_pending WHERE id='$checkId' ";

				if (mysqli_query($con, $delSql))
				{
				  ;
				}
				else
				{
				  echo "Error deleting record: " . mysqli_error($conn);
				}

		    	echo "<script>alert('Your registeration link is expired. You can try registering again.');window.location='student_register.php';</script>";
			}
		}
		else
		{
		    echo "<script>alert('May be your registeration link is expired. You can try registering again.')";
			window.location('student_register.php');
		}

  	}
}
else
{
	echo "<script>alert('May be you have already registered. You can try loging into our website.');window.location='student_login.php';</script>";
}

?>
