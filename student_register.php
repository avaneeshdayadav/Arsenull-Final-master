<?php

// These lines must always be at top while sending email.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$userNameErr=$emailErr=$passErr=$cpassErr="";


if(isset($_POST['signup']))
{
	include_once('DBConnect.php');
	$userNameErr=$emailErr=$passErr=$cpassErr="";

	$stdName=test_input($_POST['stdName']);
	$stdUserNameUp=test_input($_POST['stdUserNameUp']);
	$stdEmail=test_input($_POST['stdEmail']);
	$stdPassUp=test_input($_POST['stdPassUp']);
	$confPass=test_input($_POST['confPass']);

	$userNameCheckSql = "SELECT username FROM  allStudents WHERE username='$stdUserNameUp' ";
	$userNameCheckResult = mysqli_query($con, $userNameCheckSql);


	$emailCheckSql = "SELECT email FROM  allStudents WHERE email='$stdEmail' ";
	$emailCheckResult = mysqli_query($con, $emailCheckSql);

	if (mysqli_num_rows($userNameCheckResult) > 0)
	{
		$userNameErr="This username already exists.";
	}
	elseif (mysqli_num_rows($emailCheckResult) > 0)
	{
		$emailErr="Email already registered.";
	}
	else
	{
	      if(strlen($_POST["stdPassUp"])<=5)
        	$passErr="Password is less than six characters<br>";
        elseif(!preg_match("#[0-9]+#",$stdPassUp))
        	$passErr="Password must contain atleast one digit<br>";
        elseif(!preg_match("#[A-Z]+#",$stdPassUp))
        	$passErr="Password must contain atleast one uppercase<br>";
        elseif(!preg_match("#[a-z]+#",$stdPassUp))
        	$passErr="Password must contain atleast one lowercase<br>";
        elseif($stdPassUp!==$confPass)
        	$cpassErr="Password did't matched";
        else
        {
        	$hashedPass=password_hash($stdPassUp, PASSWORD_DEFAULT);
        	$expiryFlag=(string)strtotime("now");
        	// Insert in std_email_conf_pending table.
				$insSql = "INSERT INTO std_email_conf_pending (stdName, email, username, password,expiryFlag)
				VALUES ('$stdName', '$stdEmail', '$stdUserNameUp', '$hashedPass', '$expiryFlag')";

				if (mysqli_query($con, $insSql))
				{
				  $last_id = mysqli_insert_id($con);
				  $hashedInsId=password_hash($last_id, PASSWORD_DEFAULT);
				}
				else
				{
				  echo "Error inserting in confirmation email table ".$insSql."<br>".mysqli_error($con);
				}

			// Insert in std_email_conf_pending table end.


        	// Send Email.
			    // Load Composer's autoloader
				require 'PHPMAILER/vendor/autoload.php';

				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer(true);

				// "from" variable will be website official registered email address.
				$from = "testforwebsite24@gmail.com";
				$confirmationLink = "http://localhost/Arsenull-Final-master/confirming_student_email.php/confirming_student_email.php?user=".$hashedInsId."&name=".$stdUserNameUp;

				try {
				    //Server settings
				    $mail->SMTPDebug = 0;
				    $mail->isSMTP();
				    $mail->Host       = 'smtp.gmail.com';
				    $mail->SMTPAuth   = true;
				    $mail->Username   = $from;
				    $mail->Password   = 'forgoten';
				    $mail->SMTPSecure = 'tls';
				    $mail->Port       = 587;                                    

				    $mail->setFrom($from,'ArseNULL');
				    $mail->addAddress($stdEmail);

				    // Content
				    $mail->isHTML(true);
				    $mail->Subject = 'Hello '.$stdName.',, This is a confirmation email from team ArseNULL. ';
				    $mail->Body    = '<!DOCTYPE html>
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
			  			You are one step away from registering yourself with us. Click on the below link to confrim your email.<br>
			  			<a href="'.$confirmationLink.'">'.$confirmationLink.'</a>
			  			</body>
			  		</html>';

				    $mail->send();
            echo "<script>window.location='index.php';</script>";
				}
				catch (Exception $e)
				{
				    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			// Send Email end.
        }

	}

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    <link rel="stylesheet" type="text/css" href="css/sidenav.css">
  <style>

  	body{
  		background-image: linear-gradient(to bottom right,#5c9aff, #9ce5f7);
  		background-repeat:no-repeat;
  		height: 100vh;
  	}

    input[type="text"],input[type="email"],input[type="password"]{ padding: 10px 10px; line-height: 20px;border-radius:5px;border:1px solid grey;width:100%;}
    .maindiv{
        position: relative;
    }
    .place{
        position: absolute;
        left:12px;
        top:7px;
        height:56%;
        font-size:100%;
        color:grey;
        transition-duration:0.2s;
        white-space:nowrap;
    }
    .colm-4,.colm-6,.colm-12,.colm-5,.colm-2{
      padding:2%;
    }
  .card{
    width:60%;margin-left:20%;
  }
  #hidePassDesk{
    display: block;
  }
  #showPassDesk{
    display: none;
  }
  #showPassDesk:hover,#hidePassDesk:hover{
    background-color:#f5f5f5;
  }

  #showPassMob,#hidePassMob{
        display: none;
      }
/*Mobile view*/
  @media only screen and (max-width: 800px) {
    .card{
      width:100%;margin-left:0%;
    }
    .colm-4,.colm-6,.colm-12,.colm-5,.colm-2{
      padding:4%;
    }
    input[name="profPassword"],input[name="confPass"]{
      width:90%;
    }
    #showPassMob{
      display: none;
    }
    #hidePassMob{
      display: block;
    }
    #showPassDesk,#hidePassDesk{
      display: none;
    }
    #showPassMob:hover,#hidePassMob:hover{
      background-color:#f5f5f5;
    }
  }
/*Mobile view end*/


</style>    
</head>
<body>

<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
 --><!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
 -->
  <div class="container" style="margin-top:5%;">
      <div class="card shadow">
        <div class="card-body" style="padding:8%;">
          <h5 style="text-align: left;margin-top:3%;font-weight:600;"><span class="shadow">Arse</span><span class="shadow"  style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h5><br>
            <h5>Create your free ArseNULL account</h5><br>
              <form action="" method="post">
                <div class="row">
                  <div class="colm-6">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Full Name</span>
                      <input type="text" name="stdName" value="<?php if(isset($_POST['signup']))echo $_POST['stdName']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                  </div>
                  <div class="colm-6">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Username</span>
                      <input type="text" name="stdUserNameUp" value="<?php if(isset($_POST['signup']))echo $_POST['stdUserNameUp']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                    <div><small style="color:red;"><?php if(isset($_POST['signup']))echo $userNameErr;?></small></div>
                  </div>                  
                </div>

                <div class="row">
                  <div class="colm-12">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Email</span>
                      <input type="email" name="stdEmail" value="<?php if(isset($_POST['signup']))echo $_POST['stdEmail']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                    <div><small style="color:red;"><?php if(isset($_POST['signup']))echo $emailErr;?></small></div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="colm-5">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocusPass(this)" style="height:20px;">Password</span>
                      <div style="display:flex;align-items:center;">                      
                        <input type="password" name="stdPassUp" required="" id="inpbox" onfocus="floatOnFocusPass(this)" onblur="floatOnBlurPass(this)" class="pass" placeholder="">
                        <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;left:8px;" src="img/hidePass.webp" id="hidePassMob">
                        <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;left:8px;" src="img/showPass.webp" id="showPassMob">
                      </div>
                    </div>
                    <small style="color:red;"><?php if(isset($_POST['signup']))echo $passErr;?></small>
                  </div>
                  <div class="colm-5">                    
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Confirm Password</span>
                      <input type="password" name="confPass" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" class="pass" placeholder="">
                    </div>
                    <div><small style="color:red;"><?php if(isset($_POST['signup']))echo $cpassErr;?></small></div>
                  </div>
                  <div colm-2>
                    <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;top:15px;left:15px;" src="img/hidePass.webp" id="hidePassDesk">
                    <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;top:15px;left:15px;" src="img/showPass.webp" id="showPassDesk">
                  </div>                 
                </div>
                <div class="row">
                  <div class="colm-12">
                    <small style="color:grey;">Password must contain atleast one digit, one uppercase and one lowercase.</small>
                  </div>
                </div>
                <br>
                <div>
                  <button type="submit" class="shadow btn btn-primary" name="signup" style="border-radius:25px;">Register</button>
                </div>
              </form> 
          </div>
        </div>
    </div>
    <hr>
<script type="text/javascript">

var h=1;
var s=0;
$("#hidePassDesk").click(function(){
    if(h==1 && s==0)
    {
      $("#hidePassDesk").css("display","none");
      $("#showPassDesk").css("display","block");
      $(".pass").attr("type","text");
      h=0;
      s=1;      
    }
});

$("#showPassDesk").click(function(){
    if(h==0 && s==1)
    {
      $("#hidePassDesk").css("display","block");
      $("#showPassDesk").css("display","none");
      $(".pass").attr("type","password");
      h=1;
      s=0;      
    }
});

$("#hidePassMob").click(function(){
    if(h==1 && s==0)
    {
      $("#hidePassMob").css("display","none");
      $("#showPassMob").css("display","block");
      $(".pass").attr("type","text");
      h=0;
      s=1;      
    }
});

$("#showPassMob").click(function(){
    if(h==0 && s==1)
    {
      $("#hidePassMob").css("display","block");
      $("#showPassMob").css("display","none");
      $(".pass").attr("type","password");
      h=1;
      s=0;      
    }
});



$( window ).resize(function() {
  if (document.documentElement.clientWidth < 600 )
  {
    $("#hidePassDesk").css("display","none");
    $("#showPassDesk").css("display","none");
    if(h==1 && s==0)
    {
      $("#hidePassMob").css("display","block");
      $("#showPassMob").css("display","none");
    }
    else if(h==0 && s==1)
    {
      $("#hidePassMob").css("display","none");
      $("#showPassMob").css("display","block");
    }    
  }
  else
  {
    $("#hidePassMob").css("display","none");
    $("#showPassMob").css("display","none");
    if(h==1 && s==0)
    {
      $("#hidePassDesk").css("display","block");
      $("#showPassDesk").css("display","none");
    }
    else if(h==0 && s==1)
    {
      $("#hidePassDesk").css("display","none");
      $("#showPassDesk").css("display","block");
    } 
  }

});

function floatOnFocus(evt){
    $(evt).parent().find('.place').css("font-size","88%");
    $(evt).parent().find('.place').css("top","-11px");
    $(evt).parent().find('.place').css("color","#1b75cf");
    $(evt).parent().find('.place').css("background-color","white");

}
function makeInpFocus(evt){
    $(evt).parent().find('#inpbox').focus();
}

function floatOnBlur(evt){
    if($(evt).val()=="")
    {
        $(evt).parent().find('.place').css("font-size","100%");
        $(evt).parent().find('.place').css("top","7px");
        $(evt).parent().find('.place').css("color","grey");
        $(evt).parent().find('.place').css("background-color","transparent");
    }
}


function floatOnFocusPass(evt){
    $(evt).parent().parent().find('.place').css("font-size","88%");
    $(evt).parent().parent().find('.place').css("top","-11px");
    $(evt).parent().parent().find('.place').css("color","#1b75cf");
    $(evt).parent().parent().find('.place').css("background-color","white");

}
function makeInpFocusPass(evt){
    $(evt).parent().parent().find('#inpbox').focus();
}

function floatOnBlurPass(evt){
    if($(evt).val()=="")
    {
        $(evt).parent().parent().find('.place').css("font-size","100%");
        $(evt).parent().parent().find('.place').css("top","7px");
        $(evt).parent().parent().find('.place').css("color","grey");
        $(evt).parent().parent().find('.place').css("background-color","transparent");
    }
}


var allInp=document.querySelectorAll('#inpbox');
for(var i=0;i<allInp.length;i++)
{
  if($(allInp[i]).val()!="")
  {
    floatOnFocus($(allInp[i]));
  }
}
</script>

</body>
</html>
