<?php

include_once('DBConnect.php');

$invitorUsername=$_GET['invUsername']; // Teacher who invited to join their class.
$cardIdentity=$_POST['cardIdentity'];
$subject=$_POST['subject']; // subject that this invited teacher will teach.
$recieverUsername=$_GET['recieverUsername']; // Teacher's username who has been invited and needs to be authenticated during verification login.
$nameANDdivAndSub=explode (",", $cardIdentity);

$className=$nameANDdivAndSub[0];
$classDiv=$nameANDdivAndSub[1];
$invitorSubj=$nameANDdivAndSub[2];

$invitorIdSql="SELECT id FROM teachers WHERE profUsername='$invitorUsername' ";
$recieverIdSql="SELECT id FROM teachers WHERE profUsername='$recieverUsername' ";

$invitorIdRes=mysqli_query($con,$invitorIdSql);
$recieverIdRes=mysqli_query($con,$recieverIdSql);
if(mysqli_num_rows($invitorIdRes)>0)
{
	while($row=mysqli_fetch_assoc($invitorIdRes))
	{
		$invitorId=$row['id'];
	}
}
else
{
	echo "<script>alert('Error Occured: Might be either you or the invitor or both of you has changed your username recently. Ask invitor to send you a new invitation.');</script>";
}

if(mysqli_num_rows($recieverIdRes)>0)
{
	while($row=mysqli_fetch_assoc($recieverIdRes))
	{
		$recieverId=$row['id'];
	}
}
else
{
	echo "<script>alert('Error Occured: Might be either you or the invitor or both of you has changed your username recently. Ask invitor to send you a new invitation.');</script>";
}




$invitorTableNameStd=$invitorId."_students";// Table from where we will fetch student details.
$tableNameStd=$recieverId."_students"; // Table where fetched students should be pasted/filled.

$flag=0; // Flag that will tell when to show login page and when to add invitor's class to reciever's class.
$stdCount=0;

if(isset($_POST['login']))
{
  $username = trim(stripslashes(strip_tags($_POST['username_input'])));
  $pass=$_POST['password_input'];

  if($username!=$recieverUsername)
  	echo "<script>alert('Wrong Username, try again !');</script>";
  else
  {
	  //select all columns of the table where this username and password matches.
	  $check2=mysqli_query($con,"SELECT * FROM teachers WHERE profUsername='$username' AND profPassword='$pass'");
	  if(mysqli_num_rows($check2)>0)
	  {
	    while($row=mysqli_fetch_assoc($check2))
	    {
	      if($row['profUsername']===$username)
	      {
	        session_start();
	        $_SESSION['profUsername']=$username;
	        $_SESSION['profId']=$row['id'];
	        $flag=1;
	      }
	      else {
	        echo"<script>alert('Wrong Username');</script><br>";
	      }
	    }
	  }
	  else {
	    echo"<script>alert('Wrong password');</script><br>";
	  }
  }
}



if(isset($_POST['join']))
{
	session_start();
	$username=$_SESSION['profUsername'];
	$profId=$_SESSION['profId'];

	// Check if this reciever teacher already have such class.
	$sql="SELECT * FROM class WHERE profId='$profId' AND division='$classDiv' AND className='$className' AND subj='$subject' ";
	$res=mysqli_query($con,$sql);
	if(mysqli_num_rows($res)>0)
	{
		echo "<script>alert('You cannot join this class bcoz you already have a class with same name, div. Probably you are already a tutor of this class. If you still want to join this class try changing your current class name or divion or deleting your current class with this same name.')</script>";
	}
	else
	{
		// Get id of the class that this tutor will join.
		
		// Get all students of invitors class and copy it in invited teachers class.
		$selectStdSql="SELECT stdName,stdRoll,stdEmail FROM $invitorTableNameStd WHERE stdDiv='$classDiv' AND stdClassName='$className' AND subj='$invitorSubj' ";
		$selectStdRes=mysqli_query($con,$selectStdSql);
		if(mysqli_num_rows($selectStdRes)>0)
		{
		    while($row=mysqli_fetch_assoc($selectStdRes))
		    {
		    	$insStdName=$row['stdName'];
		    	$insStdDiv=$classDiv;
		    	$insStdRoll=$row['stdRoll'];
		    	$insStdClassName=$className;
		    	$insStdEmail=$row['stdEmail'];
		    	$insSubj=$subject;

		    	$copyStdSql="INSERT INTO $tableNameStd (id,stdName,stdDiv,stdRoll,stdClassName,present_date_ids,stdEmail,subj) VALUES(NULL,'$insStdName','$insStdDiv','$insStdRoll','$insStdClassName','','$insStdEmail','$insSubj')";
				if(mysqli_query($con,$copyStdSql))
				{
					$stdCount=$stdCount+1;
					echo "$stdCount<br>";
				}
				else
				{
					echo "Error in insertion of $tableNameStd tabel " . mysqli_error($con)."<br>";					
				}

			}
		}
		else
		{
			echo"<script>alert('No one is selected from invitor teacher's class');</script><br>";
		}


		// Insert this class details into class table.
		$isAdmin=0;
		
		echo "$classDiv $className $invitorSubj $invitorUsername<br>";
		$findSql="SELECT creatorClassId FROM class WHERE division='$classDiv' AND className='$className' AND subj='$invitorSubj' AND teacherName='$invitorUsername' ";
		$findRes=mysqli_query($con,$findSql);
		if(mysqli_num_rows($findRes))
		{
			while($row=mysqli_fetch_assoc($findRes))
		    {
		    	$creatorClassId=(int)$row['creatorClassId'];

				$insStdCount=strval($stdCount);
				$insClassDetailSql = mysqli_query($con, "INSERT INTO class (id,className,subj,division,teacherName,creatorClassId,isAdmin)VALUES(NULL,'$className','$subject','$classDiv','$username','$creatorClassId','$isAdmin')");
				if($insClassDetailSql)
				{
					echo"<script>alert('Everything done successfully');window.location='newhomepage.php';</script>";
				}
				else
				{
					echo "Error in insertion of class table : " . mysqli_error($con)."<br>";					
				}
			}
		}
		else
		{
			echo "<script>alert('No such teacher with such class found');</script>" . mysqli_error($con)."<br>";
		}
	}
	// echo "<script>window.location='newhomepage.php';</script>";

}


function findCreatorClassId($username,$classDiv,$className,$invitorSubj,$invitorUsername,$con)
{
	
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Best Attendace manager 2020</title>
    <link rel="stylesheet" href="css/attendence.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" type="text/css" href="DataTables/Bootstrap-4-4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css"/>
  </head>
  <body>
	<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
	<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
	 -->


<?php
if($flag==0)
{
	?>

    <div class="container">
      <h4 style="text-align: center;margin-top:8%;"><span class="shadow">Arse</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
      <p></p><p></p>
      <h3 style="text-align: center;"><b>We need to identify that it's you.</b></h3>
      <h6 style="color:grey;text-align:center;">Log in and join the class invitation.</h6>
      <p></p><p></p><br>
      <form action="confirm_invite.php?invUsername=<?php echo $invitorUsername; ?>&recieverUsername=<?php echo $recieverUsername; ?>" method="post">
      <!-- Username input box -->
      <div class="input-square input-on-hover" style="margin-top:1%;">
        <div style="margin-left:2%;margin-right:2%;margin-bottom:1%;">
          <label for="username_input"><span style="color:#5f6263;">Username</label><br>
          <input class="login-input-box" type="text" name="username_input" required>
          <input type="hidden" name="subject" value="<?php echo $subject; ?>" required>
          <input type="hidden" name="cardIdentity" value="<?php echo $cardIdentity; ?>" required>
        </div>
      </div>
      <!-- Username input box end -->

      <!-- Password input box -->
      <div class="input-square input-on-hover" style="margin-top:1%;">
        <div style="margin-left:2%;margin-right:2%;margin-bottom:1%;">
          <label for="password_input"><span style="color:#5f6263;">Password</label><br>
          <input type="password" name="password_input" value="" class="login-input-box" required>
        </div>
      </div>
      <!-- Password input end -->

    <!-- Login button -->
    <div class="makefull">
    	<button type="submit" class="btn btn-primary" style="width:100%;margin-top:3%;" name="login"><h5>Log in</h5></button>
    </div><br>
    <!-- Login button end -->
  	</form>

    <!-- forgot password link -->
    <div style="text-align:center;"><a href="#"><span style="font-size:1.2rem;">forgot password?</span></a></div><br>
    <!-- forgot password link end -->

    <div class="makefull"><h6 style="text-align:center;">Don't have a account? <a href="#">Click here.</a></h6></div>
    </div>
    <hr>
<?php
}
?>

<?php if($flag==1)
{
	?>
<div class="container">
	<div class="card shadow1" style="width:50%;margin-left:25%;margin-top:12%;margin-bottom: 8%;">
	  <div class="card-body">
	    <p class="card-text">Once you join others teacher class then you are able to manage the assigned subject and you can find that class in your class list too.</p>
	    <div style="text-align: center;">
	    	<form action="confirm_invite.php?invUsername=<?php echo $invitorUsername; ?>&recieverUsername=<?php echo $recieverUsername; ?>" method="post" accept-charset="utf-8">
	    		<input type="hidden" name="subject" value="<?php echo $subject; ?>" required>
          		<input type="hidden" name="cardIdentity" value="<?php echo $cardIdentity; ?>" required>
			    <a href="newhomepage.php" class="btn btn-outline-info" style="margin-right:3%;">Cancel</a>
			    <button type="submit" class="btn btn-outline-info" name="join">Join</button>
	    	</form>
	    </div>
	  </div>
	</div>
</div>
<?php
}
?>

</body>
</html>
