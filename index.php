<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="css/attendence.css">
  <link rel="stylesheet" type="text/css" href="DataTables/Bootstrap-4-4.1.1/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css" />
</head>

<body >
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
</script>
<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script> -->

<script type="text/javascript">
  
var d = new Date();
var time_diff_btwn_UTC_and_local_time = d.getTimezoneOffset();

$( document ).ready(function() {
  $.ajax({
    url:"timezone.php",
    type:'POST',
    data:{'time_diff_btwn_UTC_and_local_time':time_diff_btwn_UTC_and_local_time},
    async:true,

  });

});
</script>


  <nav class="navbar navbar-expand-lg sticky-top navbar-light shadow" style="background-color:white;color:black;">
    <a class="navbar-brand" href="#">
      <h4 style="text-align: center;margin-top:1%;"><span>Arse</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
      aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="prof_login.php">Login<span class="sr-only"></span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div style="background-image: linear-gradient(to bottom right,#3983cc, #a017bf);background-repeat:no-repeat;height:100%;">
  <p></p>


  <div style="width:90%;margin-left:5%">
    <div class="row" style="margin-top: -1%;">
      <!-- two cards -->
      <div class="colm-12">
        <div class="row" style="margin-top:4%">
          <div class=" colm-6">
            <h1 style="color:white;margin-left:3%"><b>Manage your class more efficiently with us.</b></h1>
          </div>
        </div>
        <div class="row" style="margin-top: 5%;">
          <div class="colm-3" style="margin-bottom:5%">
            <div style="width:90%; margin-left:5%">
              <div style="color:white;">
                <h4><b>Faculty Registeration</b></h4>
                <p>Register and experience a smooth management of your class.<br>
                  <span style="color:#dbd9db;"><small>We take care of all your headache.</small></span></p>
                <a href="prof_reg.php" class="btn btn-success shadow">Sign UP</a><hr>
              </div>
            </div>
          </div>
          <!-- </div> -->

          <div class="colm-3" style="margin-bottom:3%">
            <div style="width:90%; margin-left:5%">
              <div style="color:white;">
                <h4><b>Faculty Login</b></h4>
                <p>Already a member? Go ahead with your username and password.<br>
                  <span style="color: #dbd9db;"><small>Use our best tools for free.</small></span></p>
                <a href="prof_login.php" class="btn btn-success">Log in</a><hr>
              </div>
            </div>
          </div>
          <div class="colm-3" style="margin-bottom:3%">
            <div style="width:90%; margin-left:5%">
              <div style="color:white;">
                <h4><b>Student Registeration</b></h4>
                <p>Register as a student and join your tutors class and keep eye on your daily attendance and test results.<br>
                  <span style="color: #dbd9db;"></span></p>
                <a href="student_register.php" class="btn btn-success">Sign Up</a><hr>
              </div>
            </div>
          </div>
          <div class="colm-3" style="margin-bottom:3%">
            <div style="width:90%; margin-left:5%">
              <div style="color:white;">
                <h4><b>Student Login</b></h4>
                <p>Already a member? Go ahead with your username and password.<br>
                  <span style="color: #dbd9db;"><small>Use our best tools for free.</small></span></p>
                <a href="student_login.php" class="btn btn-success">Log in</a><hr>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- two cards end -->
  </div>
</div>

<div class="container" style="text-align:center;padding:35px;margin-top:3%;" >
<h3><b>FREE ARSENULL TOOLS FOR YOU.</b></h3>
<h6 style="color:grey;">We help you manage your work for free.</h6><br>
<div class="row">
  <div class="colm-6" style="padding:20px;">
    <div class="row">
      <div class="col-4">
        <img class="icon-circles" src="img/classroom_icon.png" alt="No img" style="padding:13px;">
      </div>
      <div class="col-8">
        <h5 style="text-align:left;"><b>Create Classrooms</b></h5>
        <h6 style="text-align:left;color:grey;">Create multiple virtual classes with us and add all your students and other teachers to one place and manage them all. </h6>
      </div>
    </div>
  </div>
  <div class="colm-6" style="padding:20px;">
    <div class="row">
      <div class="col-4">
        <img class="icon-circles" src="img/attendence.png" alt="No img">
      </div>
      <div class="col-8">
        <h5 style="text-align:left;" class="rel-icon"><b>Daily Attendence Sheet</b></h5>
        <h6 style="text-align:left;color:grey;">Get best attendence marker for your class. Calculate each student's percent attendence and analyze defaulter lists.</h6>
      </div>
    </div>
  </div>
  <div class="colm-6" style="padding:20px;">
    <div class="row">
      <div class="col-4">
        <img class="icon-circles" src="img/email.png" alt="No img">
      </div>
      <div class="col-8">
        <h5 style="text-align:left;" class="rel-icon"><b>Send Emails</b></h5>
        <h6 style="text-align:left;color:grey;">Send default warning emails to defaulter students and personal messages to your students or teachers by email.</h6>
      </div>
    </div>
  </div>   <div class="colm-6" style="padding:20px;">
    <div class="row">
      <div class="col-4">
        <img class="icon-circles" src="img/notice_board.png" alt="No img">
      </div>
      <div class="col-8">
        <h5 style="text-align:left;" class="rel-icon"><b>Announce on Notice Board</b></h5>
        <h6 style="text-align:left;color:grey;">Announce important notice, question banks, syllabus, pdf files and many more using notice board.</h6>
      </div>
    </div>
  </div>
  <div class="colm-6" style="padding:20px;">
    <div class="row">
      <div class="col-4">
        <img class="icon-circles" src="img/black_test_icon.png" alt="No img">
      </div>
      <div class="col-8">
        <h5 style="text-align:left;" class="rel-icon"><b>Conduct MCQ Tests</b></h5>
        <h6 style="text-align:left;color:grey;">Prepare tests on specific chapters and control number of questions asked from each chapter. Analyze each student performance.</h6>
      </div>
    </div>
  </div>
</div>

</div>
</body>

</html>