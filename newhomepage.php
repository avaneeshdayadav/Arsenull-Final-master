<?php
include_once('DBConnect.php');
session_start();
$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$sql = "SELECT className,subj,division FROM class WHERE profId='$profId'";
$result = mysqli_query($con, $sql);

$classNameAndDivArr=array("","");
$noRepeatAllClassArr=array();
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
 --><!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer></script>
 -->
<!--  <script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
 -->
  <nav class="navbar navbar-expand-lg sticky-top navbar-light shadow" style="background-color:white;color:black">
    <a class="navbar-brand" href="#">
      <h4 style="text-align: center;margin-top:1%;"><span>Arse</span><span style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
      aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="teachers_tool.php">Home<span class="sr-only">(current)</span></a>
      </li> -->
    </ul>
    <ul class="navbar-nav ml-auto" style="margin-right: 1%;">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $teacherName;?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item btn btn-primary" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
    </div>
  </nav>

<?php include_once('tools_modal.php');?>
<div class="container" style="margin-top:5%;">
<?php
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
    {
      // if($row['className']!=$classNameAndDivArr[0] && $row['division']!=$classNameAndDivArr[1])
      // {
        $classNameAndDivArr[0]=$row['className'];
        $classNameAndDivArr[1]=$row['division'];
        $subject=$row['subj'];
        if(in_array($classNameAndDivArr, $noRepeatAllClassArr))
        {
          ;
        }
        else
        {
          array_push($noRepeatAllClassArr,$classNameAndDivArr);
        }

    }

    foreach($noRepeatAllClassArr as $nameDiv)
    {


?>
        <div class="card shadow" style="margin-bottom: 3%;">
          <div class="card-body">
            <div style="display: flex;flex-direction:column;justify-content:center;">
              <h5 class="card-title"><?php echo $nameDiv[0];?></h5>
              <p class="card-text">This is division <?php echo $nameDiv[1];?></p>
              <div style="display: flex;flex-direction:row;width:100%;">
                <form action="go_to_class2.php?className=<?php echo $nameDiv[0];?>&division=<?php echo $nameDiv[1];?>" method="post">
                  <button type='submit' class="btn btn-sm btn-outline-primary">VIew</button>
                </form>&nbsp;
                <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-book-id="<?php echo $nameDiv[0].','.$nameDiv[1];?>" data-target="#invTeach">Invite teacher</button>&nbsp;
                <a href="" class="btn btn-sm btn-outline-danger">Delete</a>
              </div>
            </div>
          </div>
        </div>
<?php
      }
	
}
?>
<br>
<a href="create_new_class.php" style="text-align: center;width:100%;float: left;" class="btn btn-secondary" type="button">Create a new class</a><p></p><br><br>
</div>


<script type="text/javascript">
  $('#invTeach').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('input[name="bookId"]').val(bookId);
});
</script>
</body>
</html>
