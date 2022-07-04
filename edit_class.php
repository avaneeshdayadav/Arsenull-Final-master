<?php

include_once('DBConnect.php');
session_start();
$username=$_SESSION['profUsername'];
$className=test_input($_POST['classnameSearch5']);
$classDiv=test_input($_POST['divSearch5']);
$classSubject=test_input($_POST['subjSearch5']);
$tableNameStd=$username."_students";
$tableNameCal=$username."_calender";


$std = "SELECT * FROM $tableNameStd WHERE stdClassName='$className' AND stdDiv='$classDiv' AND subj='$classSubject' ORDER BY stdRoll";
$stdResult=mysqli_query($con,$std);


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
    <link rel="stylesheet" type="text/css" href="DataTables/Bootstrap-4-4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css"/>
  </head>
<body>
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
</script>
<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-lg sticky-top navbar-light shadow" style="background-color:white;color:black">
    <a class="navbar-brand" href="#">
      <h4 style="text-align: center;margin-top:1%;"><span>Attendace</span><span style="color:white;background-color:#008ef2;border-radius:20%;">Marker</span></h4>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
      aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="teachers_tool.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tools
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal1">Create Class</a>
          <a class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal2">Take Attendance</a>
          <a class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal3">View Attendence sheet</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto" style="margin-right: 1%;">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $username;?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item btn btn-primary" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
    </div>
  </nav>

<?php include_once('tools_modal.php');?>



<div class="jumbotron" style="color:white;background-color:#3c1e7d;">
  <div class="row">
    <div class="colm-8">
      <div class="row">
        <div class="colm-12" style="margin-left:5%;width:90%;">
          <h2>Saved something wrong about your class? Replace it with your new information about the class.</h2><br>
          <h6>Don't worry if you have created a class with wrong name, division, or subject. No need to create the whole class again.</h6>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container center">
	<h5 style="text-align: center;"><span style="padding:5px;border-radius:25px;background-color:#0d9bb8;color:white;"><b>YOUR CLASS DETAILS</b></span></h5><br>
	<div class="center" style="border:1px solid grey;">
		<button class="btn btn-outline-info btn-sm" style="float:right;border-radius:50%;" onclick="shower3()"><i class='fas fa-pencil-alt'></i></button><br>
		<center style="margin-top:3%;"><?php echo $className;?></center><br>
		<center><?php echo $classDiv; ?> Division</center><br>
		<span><center><?php echo $classSubject; ?></center>
		<button class="btn btn-outline-info btn-sm" style="border-radius:50%;" onclick="shower3()">Python<i class='fas fa-plus'></i></button></span>

	</div>


</div>



<script type="text/javascript">

	var inp1=document.querySelector("#inp1");
	inp1.style.display='none';
	var inp1Ref1=document.querySelector("#inp1Ref");

	var inp2=document.querySelector("#inp2");
	inp2.style.display='none';
	var inp1Ref2=document.querySelector("#inp2Ref");

	var inp3=document.querySelector("#inp3");
	inp3.style.display='none';
	var inp1Ref3=document.querySelector("#inp3Ref");

	function shower1()
	{
		inp1Ref1.style.display='none';
		inp1.style.display='block';

	}

	function shower2()
	{
		inp1Ref2.style.display='none';
		inp2.style.display='block';

	}

	function shower3()
	{
		inp1Ref3.style.display='none';
		inp3.style.display='block';

	}

</script>

</body>
</html>