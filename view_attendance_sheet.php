<?php
include_once('DBConnect.php');
session_start();

$username=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$tableNameCal=$profId."_calender";
$tableNameStd=$profId."_students";

$classSubject=$_GET['subjSearch'];
$classDiv=$_GET['division'];
$className=$_GET['className'];

$workingDates=$_SESSION['workingDates'];
$totalWD=count($workingDates);
$redzone = array();
$classId=0;

if($totalWD==0)
{
  echo "<script>alert('You have no attendance data on this date range.');window.location='go_to_class2.php?className=$className&division=$classDiv';</script>";
}

// Grab class id.
    $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND subj='$classSubject' AND profId='$profId' ";
    $classIdRes=mysqli_query($con,$classIdSql);
    if(mysqli_num_rows($classIdRes))
    {
        while($row = mysqli_fetch_assoc($classIdRes))
        {
            $classId=(int)$row['id'];
        }
    }
    else
    {
        echo "<script>alert('You have no such class');window.location='newhomepage.php';</script>";
    }
// Grab class id end.


//Update attendence page url.
$updateUrl="update_attendance.php?className=".urlencode($className)."&division=".urlencode($classDiv)."&subjSearch=".urlencode($classSubject);

$classCheckSql = "SELECT * FROM $tableNameCal WHERE stdClassId='$classId' ORDER BY dates";

// Check if such class, div, subj exists.
    $classCheckResult=mysqli_query($con,$classCheckSql);
    if (mysqli_num_rows($classCheckResult) > 0)
    {
// Geting all colms of calendar table for displaying heading of dates on which attendendce was taken.
      $sql = "SELECT * FROM $tableNameCal WHERE stdClassId='$classId' ORDER BY dates";
      $result=mysqli_query($con,$sql);

      // Getting colms of student table for displaying all rows of students
      $std = "SELECT * FROM $tableNameStd WHERE stdClassId='$classId' ORDER BY stdRoll";
      $stdResult=mysqli_query($con,$std);

      // Function that search required date id from present_date_id string of database.
      function searching($wd,$present_date_ids)
      {
        $flag=0;

        for($i=1;$i<count($present_date_ids);$i++)
        {
          if($wd==$present_date_ids[$i])
          {
            $flag=1;
            break;
          }
        }

        if($flag==1)
          return 1;
        else
          return 0;
      }


      if(isset($_POST['clickableLinkBtn']))
      {
        include_once('email_sending.php');
      }

    }
    else
    {
        // Unsetting variables
        echo "<script>alert('Either you have not taken attendance of this class or you have not created any such class');window.location='go_to_class2.php?className=$className&division=$classDiv';</script>";
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
  <body style="background-color:white;">
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
 -->
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer></script>
 --><script type="text/javascript">var j=0;</script>


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
        <a class="nav-link" href="go_to_class2.php?className=<?php echo $className ?>&division=<?php echo $classDiv ?>">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tools
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal1">Create Class</a>
          <a class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal2">Take Attendance</a>
          <a class="dropdown-item btn btn-primary"data-toggle="modal" data-target="#exampleModal3">View Attendence sheet</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="" onclick="display()">Print<span class="sr-only">(current)</span></a>
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
  </nav><p><br></p>

<?php include_once('tools_modal.php');?>


<!--     <input type="search" id="searchField" placeholder="Filter by Student Name" onkeyup="filteration()">
 -->
<div class="container card shadow1" id="pdfPrint">
    <div class="table-responsive" style="margin-top:4%;">
    <table class="table" style="border: 3px solid grey;" id="tableji">
        <thead class="thead-dark">
          <tr style="text-align:center">
            <th scope="col" style="text-align:center;border: 1px solid grey;">Roll.No</th>
            <th scope="col" style="text-align:center;border: 1px solid grey;">Full Name</th>
            <?php
              if (mysqli_num_rows($result) > 0)
              {
                $i=0;
                // output data of each row
                while($row = mysqli_fetch_assoc($result))
                {
                  if($i<count($workingDates) && $workingDates[$i]==$row["id"])
                  {
                    $date=date_create($row["dates"]);
            ?>
                    <th scope="col" style="text-align:center;border: 1px solid grey;width:10%;"><?php echo date_format($date,"d")." ".date_format($date,"M")."<br>".date_format($date,"D");?></th>
            <?php
                    $i++;
                  }
                }
              }
            ?>
            <th scope="col" style="text-align:center;border: 1px solid grey;" class="beRemoved">Percentage<br>Attendence %</th>
          </tr>
        </thead>
        <tbody class="highlight" id="bo">
          <?php
            if (mysqli_num_rows($stdResult) > 0)
            {
              // output data of each row
              while($row = mysqli_fetch_assoc($stdResult))
              {
                $present_date_ids=explode(",",$row["present_date_ids"]);
                $totalPresentee=0;
          ?>
            <tr id="rowsList">
              <td style="text-align:center;border: 1px solid grey;" id="rollNo"><?php echo $row["stdRoll"]; ?></td>
              <td style="text-align:center;border: 1px solid grey;" id="studentName"><?php echo $row["stdName"]; ?></td>
          <?php
            $j=0;
            foreach($workingDates as $wd)// This loop iterates through all date colms.
            {
              $flag=searching($wd,$present_date_ids);
              if($flag==1)
              {
                $totalPresentee++;
          ?>
              <td style="text-align:center;border: 1px solid grey;" id="tdcolm">P</td>
          <?php
              }
              else
              {
          ?>
              <td style="text-align:center;border: 1px solid grey;" id="tdcolm">A</td>
          <?php
              }
            }
            $percentAttended=($totalPresentee/$totalWD)*100;
          ?>
          <!-- Converting upto 2 decimal places and showing -->
              <td style="text-align:center;border: 1px solid grey;" class="beRemoved" id="percentCell"><b><?php echo number_format((float)$percentAttended, 2, '.', '');?></b></td>
          </tr>
          <?php
              if($percentAttended>=75)
                echo "<script>var cell=document.querySelectorAll('#percentCell');cell[j].style.background ='#53c960';j++;</script>";
              else
              {
                array_push($redzone,$row["id"]);
                echo "<script>var cell=document.querySelectorAll('#percentCell');cell[j].style.background ='#ff4747';j++;</script>";
              }

              }

            }
            $_SESSION['redzone']=$redzone;
          ?>
        </tbody>
      </table>
        <div style="text-align:center;">
      <form action="email_sending.php" method="post" accept-charset="utf-8">
        <button href="javascript:void(0);" type="submit" name="clickableLinkBtn" class="btn btn-link beRemoved">Send a default warning message to all the students having attendance in red zone.</button>
      </form>
      </div>
    <br>
      <button class="btn btn-primary btn-sm" id="showIt" style="margin-bottom:4%;">Submit</button>
       <button type="button" class="btn btn-outline-success btn-sm beRemoved" onclick="updating()" style="float: right;margin-bottom:4%;">Update</button>
    </div>
  </div><br><p><br></p>

<!-- Printing option -->
  <script>
    function display()
    {
      window.print();
    }
  </script>


    <script type="text/javascript">
      var tds=document.querySelectorAll("#tdcolm");
      var getRem=document.querySelectorAll(".beRemoved");
      var getShow=document.querySelector("#showIt");
      var totalWD=<?php echo "$totalWD";?>;

      // hide submit button till update button is not clicked.
      getShow.style.display="none";


      // To provide search filteration by name not used but for any future use
      function filteration()
      {
        var allStudentName=document.querySelectorAll("#studentName");
        var alltrs=document.querySelectorAll("#rowsList");
        var input = document.getElementById("searchField");
        filter = input.value.toUpperCase();
        for(var z=0;z<allStudentName.length;z++)
        {
          var strToSearch=allStudentName[z].innerHTML;

          if(strToSearch.toUpperCase().indexOf(filter)>-1)
          {

            alltrs[z].style.display="table-row";
          }
          else
            alltrs[z].style.display="none";
        }
      }


    // Function that updates P/A and show changes in different color.
    function callit()
    {
      if(this.innerHTML=="P")
      {
        this.innerHTML="A";
        this.style.color="orange";
      }
      else
      {
        this.innerHTML="P";
        this.style.color="orange";
      }

    }

    for(var i=0;i<tds.length;i++)
    {
      if(tds[i].innerHTML=="P")
      {
        tds[i].style.color="green";
      }
      else if(tds[i].innerHTML=="A")
      {
        tds[i].style.color="red";
      }
    }

    function updating()
    {
      for(var i=0;i<tds.length;i++)
        tds[i].addEventListener("click",callit);

      // Removing unwanted elements
      for(var i=0;i<getRem.length;i++)
        getRem[i].style.display="none";

      //Showing submit button
      getShow.style.display="block";


    }


// Ajax content
  $(document).ready(function(){
    // save comment to database

    $(document).on('click', '#showIt', function(){
      var name = document.querySelectorAll("#studentName");
      var roll = document.querySelectorAll("#rollNo");
      var totalWD = Number(<?php echo $totalWD;?>);

      for(var i=0;i<name.length;i++)
      {
        var arr=[];
        for(var j=2;j<=totalWD+1;j++)
        {
          var PorA=document.getElementById("bo").rows[i].cells[j];
          if(PorA.innerHTML=="P")
            arr.push("1");
          else if(PorA.innerHTML=="A")
          {
            arr.push("0");
          }
        }

        $.ajax({
          url: "<?php echo $updateUrl;?>",
          type: 'POST',
          data: {'name': name[i].innerHTML,'roll': roll[i].innerHTML,'updatedPresentee':arr},
          async: true,
          success: function(data)
          {
            // alert(data);
            location.reload();
          }
      });
      }
    });
  })

  // html2canvas(document.body).then(function(canvas) {
  //  document.body.appendChild(canvas);
  // });

  // Used for readymade table features.
  $(document).ready( function () {
      $('#tableji').DataTable();
  } );

// Ajax Content End
    </script>

  </body>
</html>
