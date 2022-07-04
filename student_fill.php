<?php 
session_start();
include_once("DBConnect.php");

$num=1;
$stdNo=0;

$profName=$_SESSION['profUsername'];
$stdNo=$_GET['stdNumber'];
$profId=$_SESSION['profId'];

// $getrow=mysqli_query($con,"SELECT stdNumber FROM class WHERE teacherName='$profName'");
// if(mysqli_num_rows($getrow)>0)
// {
//   while ($row=mysqli_fetch_assoc($getrow)) {
//     $stdNo=$row["stdNumber"];
//   }
// }

$activeId=$stdNo;
$nextId=$stdNo+1;
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


<h4 style="text-align:center;margin-top:1%;"><span style="background-color:white;"><span class="shadow" style="background-color:white;">&nbsp Attendence</span><span class="shadow" style="color:white;background-color:#008ef2;">Marker &nbsp</span></span></h4>
<p></p>
<h2><?php echo $_SESSION['className']; ?> &nbsp &nbsp Division: &nbsp<?php echo $_SESSION['division'];?></h2>
<h2>Subject: &nbsp<?php echo $_SESSION['subject']; ?></h2>

<form action="fill_all_students.php" method="post">
    <div id="child1" class="table-responsive">
    <table class="table" id="sheetTable">
        <thead class="thead-dark">
            <tr style="text-align:center">
                <th scope="col">Roll.No</th>
                <th scope="col">Student Name</th>
                <th scope="col">Student Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            while($num<=$stdNo)
            {
            ?>
                <tr style="text-align:center;">
                    <td style="border: 1px solid grey;width:15%;"><input type="text" name="col1[]" value=<?php echo $num; ?> style='text-align: center;border:0;outline:0;display:inline-block;' required></td>
                    <td style="border: 1px solid grey;width:35%;"><input type="text" name="col2[]" style="width:100%;text-align: center;border:0;outline:0;display:inline-block;" required></td>
                    <td style="border: 1px solid grey;width:35%;"><input type="email" name="col3[]" style="width:100%;text-align: center;border:0;outline:0;display:inline-block;" required></td>
                    <td style="border: 1px solid grey;width:15%;"><input onclick="deleting(this)" type="submit" name="col4[]" class="btn btn-outline-danger" value="Remove" style="font-size:10px;" required></td>
                </tr>
            <?php
            $num=$num+1;
            }
            $nextId=$num;
            ?>
        </tbody>
    </table>
    </div>
    <button class="btn btn-info" style="float:right;" type="submit" name="subBtn">Submit</button>
</form>
    <button onclick="addToTable()" type="button" class="btn btn-outline-success" name="addBtn">Add</button>


    <script>
        function deleting(ctl)
        {
            $(ctl).parents("tr").remove();
        }


        // Function to add new row to the table on clicking add button.
        function addToTable() {
            var tableBody = document.getElementById("tableBody").insertRow(-1).innerHTML='<tr style="text-align:center;"><td style="border: 1px solid grey; padding: 0.5rem;width:15%;"><input placeholder="Roll.no" type="text" name="col1[]" id="newTag" style="text-align: center;border:0;outline:0;display:inline-block" required></td><td style="border: 1px solid grey; padding: 0.5rem;"><input type="text" name="col2[]" value="" style="width:100%;text-align: center;border:0;outline:0;display:inline-block" placeholder="Any roll.no that you missed" required></td><td style="border: 1px solid grey;width:35%;"><input type="email" name="col3[]" style="width:100%;text-align: center;border:0;outline:0;display:inline-block;" required></td><td style="border: 1px solid grey;padding: 0.5rem;width:15%;text-align:center;"><input id="del" onclick="deleting(this)" type="submit" name="col4[]" class="btn btn-outline-danger" value="Remove" style="font-size:10px;" required></td></tr>';
        }
    </script>


  </body>
</html>