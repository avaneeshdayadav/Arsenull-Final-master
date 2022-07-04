<?php 
// include_once("take_attendance_search_field_creation_page.php");
include_once('DBConnect.php');
session_start();

if(isset($_POST['createBtn']))
{
  $_SESSION['teacherName']=$teacherName=$_SESSION['profUsername'];
  $_SESSION['subject']=$subject=test_input($_POST['subject']);
  $_SESSION['division']=$division=test_input($_POST['division']);
  $stdNumber=test_input($_POST['studentsNO']);
  $_SESSION['className']=$className=test_input($_POST['className']);
  $profId=$_SESSION['profId'];
  
  $sql="SELECT * FROM class WHERE className='$className' AND division='$division' AND profId='$profId' ";
  $res=mysqli_query($con,$sql);

  if(mysqli_num_rows($res))
  {
    echo "<script>alert('You already have this class');</script>";
  }
  else
  {
    echo "<script>alert('Going to student fill');window.location='student_fill.php?stdNumber=$stdNumber';</script>";
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
  </head>
  <body style="background: linear-gradient(to left, #93bff5, #d7c9ff);">
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer>
</script>
<script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
 -->
<div class="container shadow" id="create-class-form">
<h1 style="padding:10px;color: grey;">Class Details</h1>
<div class="container" style="padding:10px;">
	<form class="form-group" action="create_new_class.php" method="post" accept-charset="utf-8">
		<div class="form-group">
		  <input type="text" class="form-control" name="className" placeholder="Enter a class Name" required="" style="border:1px solid black;">
		</div>
		<div class="form-group">
		  <input type="text" class="form-control" name="division" placeholder="Enter a class division" required="" style="border:1px solid black;">
		</div>
		<div class="form-group">
		  <input type="text" class="form-control" name="subject" placeholder="Subject that you will teach" required=""style="border:1px solid black;">
		</div>
		<div class="form-group">
		  <input type="text" class="form-control" name="studentsNO" placeholder="Enter number of students in the class" required=""style="border:1px solid black;">
		</div>
		<div style="padding:20px;">
		<button class="btn btn-primary" type="submit" name="createBtn" style="width:100%;">NEXT</button>
		</div>
	</form>
</div>
</div>


<script>

// Function for creating and adding elements using javascript

// function addFieldFunction() {
//   var x = document.createElement("INPUT");
//   x.setAttribute("type", "text");
//   x.setAttribute("placeholder", "Enter teachers email");
//   // x.setAttribute("class", "form-control");
//   x.setAttribute("name", "teacherEmail");
//   x.setAttribute("style", "width:35%;margin-left:10%;border:1px solid black;");
//   var y = document.createElement("INPUT");
//   y.setAttribute("type", "text");
//   y.setAttribute("placeholder", "Subject this teacher will teach");
//   // y.setAttribute("class", "form-control");
//   y.setAttribute("name", "thisProfSubj");
//   y.setAttribute("style", "width:35%;margin-left:10%;border:1px solid black;");

//   document.getElementById("addhere").appendChild(x);
//   document.getElementById("addhere").appendChild(y);
// }
</script>
</body>
</html>
