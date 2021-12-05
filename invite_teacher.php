<?php
include_once('DBConnect.php');
session_start();
$username=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];

// To get classname and division of the card clicked.
$cardIdentity=$_POST['bookId'];
$cardIdentityArr=explode(",",$cardIdentity);
$className=$cardIdentityArr[0];
$classDiv=$cardIdentityArr[1];
$creatorClassId=0;

// reciever email
$email=test_input($_POST['invitedEmail']);

$reciever_subject=test_input($_POST['InvSubject']);



// Check if given email is registered or not.
$sql="SELECT id  FROM teachers WHERE profEmail='$email' ";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res))
{	
	// Get id of reciever.
	while ($row=mysqli_fetch_assoc($res))
	{
		$recieverId=$row['id'];

		// Find Creator Class Id.
			$findClassSql="SELECT creatorClassId  FROM class WHERE profId='$profId' AND className='$className' AND division='$classDiv' ";
			$findClassRes=mysqli_query($con,$findClassSql);
			if(mysqli_num_rows($findClassRes))
			{	
				while ($row=mysqli_fetch_assoc($findClassRes))
				{
					$creatorClassId=$row['creatorClassId'];
				}
			}
			else
			{
				echo "Error: " . $findClassSql . "<br>" . mysqli_error($con);
			}
		//Find Creator Class Id end.

		// Check if this same request is already sent.
			$checkSql="SELECT * FROM invite_notification WHERE sender_id='$profId' AND receiver_id='$recieverId' AND creator_class_id='$creatorClassId' AND reciever_subj='$reciever_subject' ";
			$checkRes2=mysqli_query($con,$checkSql);
			if(mysqli_num_rows($checkRes2))
			{
				echo "Your class Join request has been already sent.";
			}
			else
			{
			// Insert request in notification table.
				if($recieverId!=$profId)
				{
					$insNotificationSql="INSERT INTO invite_notification (sender_id, receiver_id, status,creator_class_id,reciever_subj) VALUES ('$profId', '$recieverId',0,'$creatorClassId','$reciever_subject')";

					if(mysqli_query($con, $insNotificationSql))
					{
					  echo "<script>alert('Class Join request sent.');</script>";
					}
					else
					{
					  echo "Error: " . $insNotificationSql . "<br>" . mysqli_error($con);
					}

				}
				else
				{
					echo "You cannot invite yourself.";
				}
			// Insert request in notification table end.
			}
		// Check if this same request is already sent end.

	}


}
else
{
	echo "<script>alert('There is no such teacher's email registered with us);</script>";
}

// echo"<script>window.location='newhomepage.php';</script>";




function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
