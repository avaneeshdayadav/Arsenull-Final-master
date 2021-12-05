<?php
$firstname=$lastname=$username=$password=$confPassword=$email="";
$emailErr=$passErr=$cpErr="";
$flag1=$flag2=$flag3=$last_id=0;

if(isset($_POST['regBtn']))
{

  //Check if the username and email already exists.

  //Check if the username and email already exists end.

  include_once("DBConnect.php");

  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if(!empty($_POST["firstname"]))
    $firstname=test_input($_POST['firstname']);

    if(!empty($_POST["lastname"]))
    $lastname=test_input($_POST['lastname']);

    if(!empty($_POST["profUsername"]))
    $username=test_input($_POST['profUsername']);

    if(!empty($_POST["profEmail"]))
    {
      $email=test_input($_POST['profEmail']);
      //check if email is well formed.
      
      if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        $emailErr="Invalid email format";
      else {
        $flag1=1;
      }
    }

    if(!empty($_POST["profPassword"]))
    {
      $password=test_input($_POST['profPassword']);
      if(strlen($_POST["profPassword"])<=5)
        $passErr="Password is less than six characters<br>";
      if($passErr=="")
        $flag2=1;
    }


    if(!empty($_POST["confPass"]))
    {
      $clgConfirmPassword=test_input($_POST["confPass"]);
      if($_POST["profPassword"]!==$_POST["confPass"])
        $cpErr="Password didn't matched";
      if($cpErr=="")
        $flag3=1;
    }

    if($flag1==1 and $flag2==1 and $flag3==1)
    {

      //Filling Database
      $res = mysqli_query($con, "INSERT INTO teachers (firstname,lastname,profEmail,profUsername,profPassword) VALUES('$firstname','$lastname','$email','$username','$password')");
      if($res)
      {
        $last_id = mysqli_insert_id($con);
        echo "<script>alert('Registeration Successfull');</script>";
      }
      else
      echo "Registeration not Successfull". mysqli_error($con)."<br>";
      //Filling Database end.

      echo "$last_id<br>";


      // Table for this particular prof students
      $tableNameStd=$last_id."_students";
      $sql = "CREATE TABLE $tableNameStd(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        stdName VARCHAR(60) NOT NULL,
        stdRoll VARCHAR(100) NOT NULL,
        present_date_ids VARCHAR(10000) NOT NULL,
        stdEmail VARCHAR(70) NOT NULL,
        stdClassId INT(225) NOT NULL
      )";
      if(mysqli_query($con, $sql)){
        ;
      } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con)."<br>";
      }

      // Table for this particular prof attendence dates
      $tableNameCal=$last_id."_calender";
      $sql2 = "CREATE TABLE $tableNameCal(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dates DATETIME,
        stdClassId INT(225) NOT NULL,
        present_std_ids VARCHAR(5000) NOT NULL
      )";
      if(mysqli_query($con, $sql2)){
        ;
      } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con)."<br>";
      }

      //Creating username_individual_options test table.
      $individualTestOptTable=$last_id."_test_opts";
      $sql3 = "CREATE TABLE $individualTestOptTable(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        testId INT(225) NOT NULL,
        qnId INT(225) NOT NULL,
        optNo INT(225) NULL,
        optInp VARCHAR(2000) NULL,
        optImg VARCHAR(2000) NULL,
        correctFlag INT(2) NOT NULL
      )";
      if(mysqli_query($con, $sql3))
      {
        ;
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql3. " . mysqli_error($con);
      }

      //Creating username_individual_questions test table.
      $individualTestQnTable=$last_id."_test_qns";
      $sql3 = "CREATE TABLE $individualTestQnTable(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        qnNo INT(225) NOT NULL,
        question VARCHAR(4000) NOT NULL,
        qnImg VARCHAR(1000) NULL,
        testId INT(225) NULL,
        secId INT(225) NULL
      )";
      if(mysqli_query($con, $sql3))
      {
        ;
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql3. " . mysqli_error($con);
      }


      //Creating username_individual_sections test table.
      $individualTestSecTable=$last_id."_test_sections";
      $sql3 = "CREATE TABLE $individualTestSecTable(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        testId INT(225) NOT NULL,
        secNo INT(225) NOT NULL,
        unitName VARCHAR(150) NULL,
        cumpNoOfQn VARCHAR(2000) NULL
      )";

      if(mysqli_query($con, $sql3))
      {
        ;
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql3. " . mysqli_error($con);
      }
      echo "<script>window.location='prof_login.php';</script>";// To redirect to different paged like a href tag.


    }

  }
}

function test_input($data) {
     $data = trim($data);                 // removes whitespace and other predefined characters from both sides of a string.
     $data = stripslashes($data);         // removes backslashes in a string
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

  </head>

  <style>

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


<body style="/*background-image: linear-gradient(to bottom right,#5c9aff, #9ce5f7)*/background-image:url('img/nature.jpg');background-repeat:no-repeat;height: 100vh;">
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
 --><!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
 -->
</script>
<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
  <div class="container" style="margin-top:5%;">
      <div class="card shadow">
        <div class="card-body" style="padding:8%;">
          <h5 style="text-align: left;margin-top:3%;font-weight:600;"><span class="shadow">Arse</span><span class="shadow"  style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h5><br>
            <h5>Create your free ArseNULL account</h5><br>
              <form action="prof_reg.php" method="post">
                <div class="row">
                  <div class="colm-4">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">First Name</span>
                      <input type="text" name="firstname" value="<?php if(isset($_POST['regBtn']))echo $_POST['firstname']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                  </div>
                  <div class="colm-4">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Last Name</span>
                      <input type="text" name="lastname" value="<?php if(isset($_POST['regBtn']))echo $_POST['lastname']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                  </div>
                  <div class="colm-4">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Username</span>
                      <input type="text" name="profUsername" value="<?php if(isset($_POST['regBtn']))echo $_POST['profUsername']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                  </div>                  
                </div>

                <div class="row">
                  <div class="colm-12">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Email</span>
                      <span style="color:#ff5959;"><?php echo $emailErr;?></span>
                      <input type="email" name="profEmail" value="<?php if(isset($_POST['regBtn']))echo $_POST['profEmail']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
                    </div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="colm-5">
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocusPass(this)" style="height:20px;">Password</span>
                      <span style="color:#ff5959;"><?php echo $passErr;?></span>
                      <div style="display:flex;align-items:center;">                      
                        <input type="password" name="profPassword" required="" id="inpbox" onfocus="floatOnFocusPass(this)" onblur="floatOnBlurPass(this)" class="pass" placeholder="">
                        <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;left:8px;" src="img/hidePass.webp" id="hidePassMob">
                        <img style="height:30px;width:30px;text-align:center;border-radius:50%;position:relative;left:8px;" src="img/showPass.webp" id="showPassMob">
                      </div>
                    </div>
                  </div>
                  <div class="colm-5">                    
                    <div class="maindiv">
                      <span class="place" onclick="makeInpFocus(this)">Confirm Password</span>
                      <span style="color:#ff5959;"><?php echo $cpErr;?></span>
                      <input type="password" name="confPass" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" class="pass" placeholder="">
                    </div>
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
                  <button type="submit" class="shadow btn btn-primary" name="regBtn" style="border-radius:25px;">Register</button>
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
