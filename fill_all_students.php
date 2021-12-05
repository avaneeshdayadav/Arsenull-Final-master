<?php
  session_start();
  if(isset($_POST['subBtn']))
  {
    include_once("DBConnect.php");
    $rollNo_s=$_POST['col1']; //Array of all columns with name col1.
    $names=$_POST['col2']; //Array of all columns with name col2.
    $emails=$_POST['col3']; //Array of all columns with name col3.
    $username=$_SESSION['profUsername'];
    $profId=$_SESSION['profId'];
    $tableName=$profId."_students";
    $division=$_SESSION['division'];
    $stdClassName=$_SESSION['className'];
    $subj=$_SESSION['subject'];
    $index=0;

    echo "$profId<br>";
    // Filling class database
      $res = mysqli_query($con, "INSERT INTO class (id,profId,className,subj,division,creatorClassId,isAdmin) VALUES(NULL,'$profId','$stdClassName','$subj','$division',0,0)");

      if($res)
      {
        $creatorClassId = (int)mysqli_insert_id($con);
        echo "Creator Class ID is $creatorClassId <br>";
        var_dump($creatorClassId);
        echo "<br>";
        $isAdmin=1;
        $updSql1="UPDATE class SET creatorClassId='$creatorClassId' WHERE id='$creatorClassId'";
        $updSql2="UPDATE class SET isAdmin='$isAdmin' WHERE id='$creatorClassId'";

        // $_SESSION['division']=$division;
        // $_SESSION['subject']=$subject;
        // $_SESSION['teacherName']=$teacherName;
        // $_SESSION['className']=$className;

        // Filling profId_students_database.
          foreach($names as $name)
          {
            echo "$creatorClassId<br>";
            $res = mysqli_query($con, "INSERT INTO $tableName (id,stdName,stdRoll,present_date_ids,stdEmail,stdClassId) VALUES(NULL,'$name','$rollNo_s[$index]','','$emails[$index]','$creatorClassId')");
            if($res);
            else
            echo "<script>alert('Registeration not Successfull for $index');</script>";

            $index=$index+1;
          }
        // Filling profId_students_database end.

        if(mysqli_query($con, $updSql1)&&mysqli_query($con, $updSql2))
        {
          unset($_SESSION['division']);
          unset($_SESSION['className']);
          unset($_SESSION['subject']);
          echo "<script>alert('Filled your class');</script><br>";
        }
        else
        {
          echo "Updation error ".mysqli_error($con);
        }
      }
      else
        echo "<script>alert('Failed ');</script>".mysqli_error($con);
    // Filling class datatable end


    echo"<script>window.location='newhomepage.php';</script><br>";

  }
?>

