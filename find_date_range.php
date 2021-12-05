<?php

    include_once('DBConnect.php');
    session_start();

    $workingDates=array();
    $fromDate=$_POST['fromDate'];
    $toDate=$_POST['toDate'];

    $className=$_GET['className'];
    $classDiv=$_GET['division'];
    $classSubject=$_POST['subjSearch'];

    $username=$_SESSION['profUsername'];
    $profId=$_SESSION['profId'];
    $tableNameStd=$profId."_students";
    $tableNameCal=$profId."_calender";
    $classId=0;

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


    $sql = "SELECT * FROM $tableNameCal WHERE stdClassId='$classId' ORDER BY dates";

    $result=mysqli_query($con,$sql);
    if (mysqli_num_rows($result) > 0)
    {
        // output data of each row
        while($row = mysqli_fetch_assoc($result))
        {
            if((strtotime($row["dates"])>=strtotime($fromDate)) && (strtotime($row["dates"])<=strtotime($toDate)))
            {
                array_push($workingDates,$row["id"]);
            }
        }
    // Creating session variable to store working dates in it.
    $_SESSION['workingDates']=$workingDates;

    //Redirecting to another page.
    $url="view_attendance_sheet.php?className=".urlencode($className)."&division=".urlencode($classDiv)."&subjSearch=".urlencode($classSubject);
    echo "<script>window.location='$url';</script>";
    //Redirecting to another page end.

    }
    else
    {
        // Unsetting variables
        echo "<script>alert('Either you have not taken attendance of this class or you have not created any such class');window.location='go_to_class2.php?className=$className&division=$classDiv';</script>";
    }


?>
<!-- <!DOCTYPE html>
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
<body>
<a href="<?php echo $url; ?>">Link label</a>
</body>
</html> -->