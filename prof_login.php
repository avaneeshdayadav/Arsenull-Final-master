<?php

if(isset($_POST['login']))
{
  include_once("DBConnect.php");
  $username = trim(stripslashes(strip_tags($_POST['username_input'])));
  $pass=$_POST['password_input'];

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
        echo"<script>alert('Successfull Login');window.location='newhomepage.php';</script><br>";
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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Best Attendace manager 2020</title>
    <link rel="stylesheet" href="css/attendence.css">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
</script>
<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
 -->
    <div class="container">
      <h4 style="text-align: center;margin-top:8%;"><span class="shadow">Attendace</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">Marker</span></h4>
      <p></p><p></p>
      <h3 style="text-align: center;"><b>Welcome</b></h3>
      <h6 style="color:grey;text-align:center;">Manage and analyze your class attendence sheet more efficiently with us.</h6>
      <p></p><p></p><br>
      <form action="prof_login.php" method="post">
      <!-- Username input box -->
      <div class="input-square input-on-hover" style="margin-top:1%;">
        <div style="margin-left:2%;margin-right:2%;margin-bottom:1%;">
          <label for="username_input"><span style="color:#5f6263;">Username</label><br>
          <input class="login-input-box" type="text" name="username_input" required>
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
    <div class="makefull"><button type="submit" class="btn btn-primary" style="width:100%;margin-top:3%;" name="login"><h5>Log in</h5></button></div><br>
    <!-- Login button end -->
  </form>

    <!-- forgot password link -->
    <div style="text-align:center;"><a href="#"><span style="font-size:1.2rem;">forgot password?</span></a></div><br>
    <!-- forgot password link end -->

    <div class="makefull"><h6 style="text-align:center;">Don't have a account? <a href="#">Click here.</a></h6></div>
    </div>
    <hr>

  </body>
</html>
