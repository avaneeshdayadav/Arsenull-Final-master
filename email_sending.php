<?php
include_once('DBConnect.php');
session_start();
$username=$_SESSION['profUsername'];
$tableNameCal=$_SESSION['tableNameCal'];
$tableNameStd=$_SESSION['tableNameStd'];
$classSubject=$_SESSION['subject'];
$classDiv=$_SESSION['division'];
$className=$_SESSION['className'];
$workingDates=$_SESSION['workingDates'];
$count=count($workingDates);
$index=$count-1;
print_r($workingDates);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMAILER/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

// "from" variable will be website official registered email address.
$from = "avaneeshdyadav@gmail.com";

// Geting from date from workingdates[0] id.
$sql1 = "SELECT * FROM $tableNameCal WHERE id='$workingDates[0]' ORDER BY dates";
$sqlRes1=mysqli_query($con,$sql1);
if (mysqli_num_rows($sqlRes1) > 0)
{
    // output data of each row
    while($row = mysqli_fetch_assoc($sqlRes1))
    {
    	$Date=date_create($row["dates"]);
    	$fromDate=date_format($Date,"d")." ".date_format($Date,"M")." ".date_format($Date,"Y");
    }
}
echo "$fromDate<br>";


// Geting from date from workingdates[0] id.
$sql2 = "SELECT * FROM $tableNameCal WHERE id='$workingDates[$index]' ORDER BY dates";
$sqlRes2=mysqli_query($con,$sql2);
if (mysqli_num_rows($sqlRes2) > 0)
{
    // output data of each row
    while($row = mysqli_fetch_assoc($sqlRes2))
    {
    	$Date2=date_create($row["dates"]);
    	$toDate=date_format($Date2,"d")." ".date_format($Date2,"M")." ".date_format($Date2,"Y");
    }
}
echo "$toDate<br>";

// Fetch First name and Last name of teacher.
$profFetch = "SELECT * FROM teachers WHERE profUsername='$username'";
$res1=mysqli_query($con,$profFetch);
if(mysqli_num_rows($res1)>0)
{
	while($row=mysqli_fetch_assoc($res1))
	{
	  $firstName=$row['firstName'];
	  $lastName=$row['lastName'];
	}
}

// Student fetch
$stdFetch="SELECT * FROM $tableNameStd WHERE stdClassName='$className' AND stdDiv='$classDiv' AND subj='$classSubject' ORDER BY stdRoll";
$stdResult=mysqli_query($con,$stdFetch);

if (mysqli_num_rows($stdResult) > 0)
{
  $redzone=$_SESSION['redzone'];
  $n=0;
  // output data of each row
  while($row = mysqli_fetch_assoc($stdResult))
  {
  	$MSflag=1;
  	if($row["id"]==$redzone[$n])
  	{

  		$to=$row['stdEmail'];
  		echo "to=$to<br>from=$from<br>";

		try {
		    //Server settings
		    $mail->SMTPDebug = 3;                                       // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = $from;             // SMTP username
		    $mail->Password   = '101293Dharmendra2024';                 // SMTP password
		    $mail->SMTPSecure = 'tls';         							// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom($from, 'Attendance warning from Attendance Marker');
		    $mail->addAddress($to);
		        									 		 // Add a recipient
		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Warning regarding your low attendence in '.$classSubject;
		    $mail->Body    = 'Dear student,<br>This is your '.$classSubject.' teacher '.$firstName.' '.$lastName.'. Your attendence in this subject is found to be less than the required criteria in the period of '.$fromDate.' to '.$toDate.'. Please try to be regular in the class or you may come under defaulter list.';
		    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    echo 'Message has been sent<br>';
		}
		catch (Exception $e)
		{
			$MSflag=0;
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
		}
		$n++;
		$to="";
  	}
  	if($MSflag==0)
  		echo "Message not sent to email id ".$row["stdEmail"].". Check this email once again and update it.<br>";

  }
}


?>