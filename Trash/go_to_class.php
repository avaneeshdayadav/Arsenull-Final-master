<?php
session_start();
include_once('DBConnect.php');

if(!isset($_SESSION['profUsername']))
    echo "<script>window.location='prof_login.php';</script>";
$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$allTeachers=array();
$tableNameStd=$profId."_students";
$className=$_GET['className'];
$classDiv=$_GET['division'];

$classId=0; // A variable that has a id to any of the classes of this prof with this division and className to grab students of this class.

include_once("take_attendance_search_field_creation_page.php");

$noRepeatCheckByEmail=""; // Variable to take care that we don't show a single student in the same class more than 1 time in stdList with the help of their unique email.

$creatorClassId=0;


// Grabbing all students of this class.
    $selectClassSql="SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND profId='$profId' ";
    $selectClassRes=mysqli_query($con,$selectClassSql);
    if(mysqli_num_rows($selectClassRes))
    {
        while($row = mysqli_fetch_assoc($selectClassRes))
        {
            $classId=(int)$row['id'];
        }
    }
    else
    {
        echo "<script>alert('You have no such class');window.location='newhomepage.php';</script>";
    }
    $std = "SELECT * FROM $tableNameStd WHERE stdClassId='$classId' ORDER BY stdRoll";
    $stdResult=mysqli_query($con,$std);
// Grabbing all students of this class.

// Grab creator class id
    $creatorClassIdSql="SELECT creatorClassId FROM class WHERE className='$className' AND division='$classDiv' AND profId='$profId' ";
    $creatorClassIdRes=mysqli_query($con,$creatorClassIdSql);
    if (mysqli_num_rows($creatorClassIdRes) > 0)
    {
        while($row = mysqli_fetch_assoc($creatorClassIdRes))
        {
            $creatorClassId=(int)$row['creatorClassId'];
        }
    }
    else
    {
        echo "Some error in getting creator's class id ".mysqli_error($con);
    }
// Grab creator class id end.


// Grabing all subject teachers of this class.
    $profSql="SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND  creatorClassId='$creatorClassId' ";
    $profRes=mysqli_query($con,$profSql);

// Grabing all subject teachers of this class end.



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

    <style type="text/css">
        th,td{
            text-align: center;
        }
        .bodyTr:hover{
            background-color:#f0f0f0;
            font-weight:800;
            transition-duration:0.6s;
        }

        .editImg{
            width:20px;height:20px;background-color:white;
        }
        .editImg:hover{
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
</head>
<body>
    
</style>
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript"> var subjectSearch=""; </script>

<div class="navDiv">
<nav class="navbar navbar-expand-lg navbar-light shadow" style="background-color:white;color:black;position:fixed;top: 0;width:100%;z-index:2;">
<a class="hamb mr-auto nav-link btn-sm" href="#"><img class="hambImg" src="img/bar-icon.png" style="height:5vh;width:9vw;"/></a>
<a class="navbar-brand" href="#" style="position:absolute;left:45%;">
  <h4 style="margin-top:1%;"><span>Arse</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
</a>
<a class="ml-auto nav-link" href="#">Help<span class="sr-only"></span></a>

</nav>
</div>

<div class="row">
   <div class="transparent col-12"></div>
    <div class="deskSidenav shadow">
       <div class="sideLinks">
        <div class="row" style="">
            <div class="col-8 brand">
                <span class="brandSpanText"><b>Arse</b><b style="color:black;">NULL</b></span>
            </div>
            <div class="col-4 closeBtnDiv" style="font-size:4vh;width:100%;padding:3%;margin-top:12%;">
                <a class="btn closeBtn"><img src="img/closeIconImg.png" style="height:20px;width:20px;"/></a>
            </div>
        </div><br>
            <div class="DeskEachLink" id="classDetDivDesk">
                <h6>Class Details</h6>
            </div>
            <div class="DeskEachLink" id="takeAttDivDesk">
                <h6>Take Attendance</h6>
            </div>

            <div class="takeAttSubMenuDesk">
                <form method="post" action="take_attendance.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>" style="display:none;">
                            <input type="text" id="takeAttSubj" name="subjSearch" value="" style="display: none;">
                            <button type="submit" id="takeAttSubjBtn" style="display:none;"></button>
                </form>
                <?php
                    foreach($subjArray as $subjFromArray)
                    {
                ?>   
                        <div class="takeAttSubMenuLinksDesk"  onclick="goTakeAtt(this)" id="">
                            <h6 id="subName"><?php echo $subjFromArray;?></h6>
                        </div>
                <?php
                    }
                ?>
            </div>

            <div class="DeskEachLink" id="viewAttDivDesk">
                <h6>Attendance Sheet</h6>
            </div>
            <div class="viewAttSubMenuDesk">
                <form method="post" action="find_date_range.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>" style="display:none;">
                            <input type="text" id="viewAttSubj" name="subjSearch" value="" style="display: none;">
                            <input type="text" name="fromDate" value="<?php echo date('m/1/Y');?>" style="display: none;"/>
                            <input type="text" name="toDate" value="<?php echo date('m/t/Y');?>" style="display: none;"/>
                            <button type="submit" id="viewAttSubjBtn" style="display:none;"></button>
                </form>
                <?php
                    foreach($subjArray as $subjFromArray)
                    {
                ?>      
                        <div class="viewAttSubMenuLinksDesk" onclick="view_att_sheet(this)">
                            <h6 id="subName"><?php echo $subjFromArray;?></h6>
                        </div>
                <?php
                    }
                ?>
            </div>
            <div class="DeskEachLink" id="defaulterDivDesk">
                <h6>Defaulter List</h6>
            </div>
            <div class="DeskEachLink" id="testDivDesk">
                <h6>Test Zone</h6>
            </div>
            <div class="DeskEachLink" id="homeDivDesk">
                <h6>All Classes</h6>
            </div>
            <div class="DeskEachLink" id="notDivDesk">
                <h6>Notifications<span class="notBadge" id="notBadge"></span></h6>
            </div>            
            <div class="DeskEachLink" style="margin-top:70%;" onclick="window.location='logout.php'">
                <h6><b>Hello, <?php echo $teacherName;?></b></h6>
            </div>
            <p><br></p>
        </div>
    </div>
    <div class="row mainContent">
        <div class="colm-9">
            <div class="eachContent" id="classDetails">
                <div class="row" style="color:grey;">
                    <div class="col-6">
                        <h5 style="text-align:center;font-weight:900;"><?php echo "$className Division $classDiv";?></h5>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-sm btn-primary" style="float:right;" id='addSubjBtn'>Add Subject</button>
                        <input type="text" placeholder="Add new subject" id="addSubjInp" style="float:right;">
                    </div>
              </div><br>
                <div style="color:grey;">
                    <h6 style="margin-left:2%;">Tutor Details</h6>
                </div><hr>
                <div id="classDetContDiv" style="font-size:0.9rem;">
                    <div class="card-body shadow">
                        <div class="table-responsive">
                            <table class="table" id="profListTable">
                                <thead style="background-color:#666666;color:white;">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Subject</th>                                 
                                        <th scope="col">Email</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col" style="display:none;">userame</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($profRes) > 0)
                                    {
                                        while($row = mysqli_fetch_assoc($profRes))
                                        {
                                            $searchProf=$row['profId'];
                                            $selProfSql="SELECT * FROM teachers WHERE id='$profId' ";
                                            $selProfRes=mysqli_query($con,$selProfSql);
                                            if(mysqli_num_rows($selProfRes) > 0)
                                            {
                                                while($eachProfData=mysqli_fetch_assoc($selProfRes))
                                                {
                                                    $firstName=$eachProfData['firstName'];
                                                    $lastName=$eachProfData['lastName'];
                                                    $profEmail=$eachProfData['profEmail'];
                                                }
                                            }
                                            
                                    ?>
                                            <tr class="bodyTr">
                                                <td id="tutorName"><?php echo "$firstName $lastName";?></td>
                                                <td id="tutorSubj"><?php echo $row['subj'];?></td>
                                                <td id="tutorEmail"><?php echo $profEmail;?></td>
                                                <td><a data-toggle="modal" data-target="#exampleModal0" onclick="setModal(this)"><img class="editImg" src="img/editIcon.png" style="padding:1%;border-radius:50%;"></a></td>
                                                    <td><a id="deleteStd"><img class="editImg" src="img/redCrossIcon.png" style="padding:1%;border-radius:50%;"></a></td>
                                                <td style="display:none;" id="hiddenProf"><?php echo $searchProf;?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "eroor in getting tutors of this class ".mysqli_error($con);
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><p><br><br></p>
                <div style="color:grey;">
                    <h6 style="margin-left:2%;">Student Details</h6>
                </div><hr>
                <div id="classDetContDiv" style="font-size:0.9rem;">
                    <div class="card-body shadow">
                        <div class="table-responsive">
                            <table class="table" id="stdListTable">
                                <thead style="background-color:#666666;color:white;">
                                    <tr>
                                        <th scope="col">Roll.No</th>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Student Email</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col" style="display: none;">id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($stdResult) > 0)
                                    {
                                        while($row = mysqli_fetch_assoc($stdResult))
                                        {
                                            if($noRepeatCheckByEmail!=$row['stdEmail'])
                                            {
                                                $noRepeatCheckByEmail=$row['stdEmail'];
                                            
                                    ?>
                                                <tr class="bodyTr">
                                                    <td id="stdRollTd"><?php echo $row["stdRoll"];?></td>
                                                    <td id="stdNameTd"><?php echo $row["stdName"];?></td>
                                                    <td id="stdEmailTd"><?php echo $row["stdEmail"];?></td>
                                                    <td><a data-toggle="modal" data-target="#exampleModal0" onclick="setModal(this)"><img class="editImg" src="img/editIcon.png" style="padding:1%;border-radius:50%;"></a></td>
                                                    <td><a id="deleteStd"><img class="editImg" src="img/redCrossIcon.png" style="padding:1%;border-radius:50%;"></a></td>
                                                    <td id="stdIdTd" style="display: none;"><?php echo $row["id"];?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        echo "eroor in getting students ".mysqli_error($con);
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div><p></p>
                        <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#addStdModal">Add Student</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="colm-3 forAdds">
            
        </div>

    </div>

</div>

  <!-- Modal edit-->
  <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel0" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 15px;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel0" style="color:grey;"><b>Edit Student Details</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Roll No:
            <input type="text" class="form-control" id="rollNo" name="rollNo" placeholder="Roll No" style="width:" required="" /><br>
            Name:
            <input type="text" class="form-control" id="stdName" name="stdName" placeholder="Student Name" required="" /><br>
            Email:
            <input type="email" class="form-control" id="email" name="email" placeholder="Student email" required="" /><br>
            <p></p>
            <button type="submit" class="btn btn-sm" style="background-color:blue;color:white;border-radius:20px;" id="editSubmitBtn" name="editSubmitBtn">Submit</button>
            <input type="text" class="form-control" id="stdOldEmail" name="stdOldEmail"/ style="display:none;">

        </div>
          <hr>
      </div>
    </div>
  </div><p></p>
  <!-- Modal edit end -->

<!-- Modal add-->
<div class="modal fade" id="addStdModal" tabindex="-1" role="dialog" aria-labelledby="addStdModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 15px;">
        <div class="modal-header">
          <h5 class="modal-title" id="addStdModalLabel" style="color:grey;"><b>Add Student to this class</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" id="addRollNo" name="addRollNo" placeholder="Roll No" style="width:" required=""/><br>
            <input type="text" class="form-control" id="addStdName" name="addStdName" placeholder="Student Name" required=""/><br>
            <input type="email" class="form-control" id="addEmail" name="addEmail" placeholder="Student email" required=""/><br>
            <p></p>
            <button type="submit" class="btn btn-sm" style="background-color:blue;color:white;border-radius:20px;" id="addStdBtn" name="addStdBtn">Submit</button>
        </div>
          <hr>
      </div>
    </div>
</div><p></p>
<!-- Modal add end -->

<script>

    //Sidebar handling.    
        $(".hamb").click(function(){
            $(".deskSidenav").animate({
                width: "60%"
            });
            $('.transparent').css("display","block");

        });

        $(".closeBtn").click(function(){
            $(".deskSidenav").animate({
                width: 0
            });
            $('.transparent').css("display","none");

        });

        $(".transparent").click(function(){
            $(".deskSidenav").animate({
                width: 0
            });
            $('.transparent').css("display","none");

        });
        $( window ).resize(function() {
            if (document.documentElement.clientWidth > 800 )
            {
                $(".deskSidenav").css("width","19vw");
                $(".transparent").css("display","none");
            }
            else if (document.documentElement.clientWidth < 800 )
            {
                $(".deskSidenav").css("width","0vw");
            }

        });
    //Sidebar handling end.    








    // Grab values of student list table for modal data
        function setModal(evt)
        {
            var stdNameTd=$(evt).parent().parent().find('#stdNameTd').html();
            var stdRollTd=$(evt).parent().parent().find('#stdRollTd').html();
            var stdEmailTd=$(evt).parent().parent().find("#stdEmailTd").html();

            var modalNameInp=$(".modal-body").find("#stdName").attr("value",""+stdNameTd);
            var modalRollInp=$(".modal-body").find("#rollNo").attr("value",""+stdRollTd);
            var modalEmailInp=$(".modal-body").find("#email").attr("value",""+stdEmailTd);
            var stdOldEmail=$(".modal-body").find("#stdOldEmail").attr("value",""+stdEmailTd);
        }    
    // Grab values of student list table for modal data end.

    // Initial first link highlight
        $("#classDetDivDesk").css("background-color","white");
        $("#classDetDivDesk").css("color","grey");
        $("#classDetDivDesk").data('clicked', true);

    // Initial first link highlight

    // Highlight clicked links  in desktop mode.
        $(".DeskEachLink").click(function(){
            $(".DeskEachLink").css("background-color","#487ae0");
            $(".DeskEachLink").css("color","white");
            $(".DeskEachLink").data('clicked', false);

            $(this).css("background-color","white");
            $(this).css("color","grey");
            $(this).data('clicked', true);// To give signal to hover function.
            if($(this).attr("id")=="classDetDivDesk")
            {
                $(".takeAttSubMenuDesk").slideUp(400);
                $(".viewAttSubMenuDesk").slideUp(400);
                if(!($(this).data("clicked")))
                {
                    window.location="go_to_class2.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>";
                }
            }
            else if ($(this).attr("id")=="takeAttDivDesk")
            {
                $(".takeAttSubMenuDesk").slideDown(400);
                $(".viewAttSubMenuDesk").slideUp(400);
            }
            else if($(this).attr("id")=="viewAttDivDesk")
            {
                $(".viewAttSubMenuDesk").slideDown(400);
                $(".takeAttSubMenuDesk").slideUp(400);
            }
            else if($(this).attr("id")=="homeDivDesk")
            {
                $(".takeAttSubMenuDesk").slideUp(400);
                $(".viewAttSubMenuDesk").slideUp(400);
                if($(this).data("clicked"))
                {
                    $("#homeDivDesk").css("background-color","white");
                    $("#homeDivDesk").css("color","grey");
                    $("#homeDivDesk").data('clicked', true);
                    window.location="newhomepage.php";
                }
            }
        });

        $(".DeskEachLink").hover(function(){if($(this).data("clicked"));else $(this).css("background-color","#7ea6f7");},function(){if($(this).data("clicked"));else $(this).css("background-color","#487ae0");})

    // Highlight clicked links in desktop mode end


    // Navigating to pages function
        function goTakeAtt(evt)
        {
            var subject=$(evt).find("#subName").html();
            $(evt).parent().find("#takeAttSubj").attr("value",subject);
            $(evt).parent().find("#takeAttSubjBtn").click();


        }

        function view_att_sheet(evt)
        {
            subject=$(evt).find("#subName").html();
            $(evt).parent().find("#viewAttSubj").attr("value",subject);
            $(evt).parent().find("#viewAttSubjBtn").click();
        }
    // Navigating to pages function end.

    // Ajax content
        $(document).ready(function(){

        // Notification Update.
            var prof=<?php echo $profId;?>;
            setInterval(scanNotf, 10000); //time in milliseconds

            function scanNotf()
            {
                $.ajax({
                    url:"scan_notification.php",
                    type:'POST',
                    data:{'prof':prof},
                    async:true,
                    
                    success:function(data)
                    {
                        var count=parseInt(data, 10); // to convert string to integer.
                        if(count==0)
                        {
                            $('#notBadge').html(count);
                            $('#notBadge').css("display","inline-block");
                        }
                    }
                });
            }
        // Notification Update.


        // Edit students
          $(document).on('click', '#editSubmitBtn', function(){
            var stdNameTd=$(this).parent().find('#stdName').val();
            var stdRollTd=$(this).parent().parent().find('#rollNo').val();
            var stdEmailTd=$(this).parent().parent().find("#email").val();
            var stdOldEmail=$(this).parent().parent().find("#stdOldEmail").val();


            // Get all teachers username and their subject and all students email.
                var allProfObj=profTable.column(5).data();
                var allProfSubjObj=profTable.column(1).data();
                var allProf=[];
                var allProfSubj=[];
                for(var i=0;i<allProfSubjObj.length;i++)
                {
                    allProf.push(allProfObj[i]);
                    allProfSubj.push(allProfSubjObj[i]);
                }
            // Get all teachers username and their subject and all students email end.            

            if(stdNameTd!="" && stdRollTd!="" && stdEmailTd!="")
            {
              $.ajax({
                url: "upd_std_details.php?division=<?php echo $classDiv;?>&className=<?php echo $className;?>",
                type: 'POST',
                data: {'name': stdNameTd,'roll': stdRollTd,'email':stdEmailTd,'stdOldEmail': stdOldEmail,'allProf':allProf,'allProfSubj':allProfSubj },
                async: true,
                success: function(data)
                {
                    alert(data);
                    window.location="go_to_class2.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>";
                }
                });
            }
            else
            {
                alert('Any of these fields cannot be empty');
            }
            });


        // Delete a student
            $(document).on('click', '#deleteStd', function(){

            var stdNameTd=$(this).parent().parent().find('#stdNameTd').html();
            var stdEmailTd=$(this).parent().parent().find('#stdEmailTd').html();

            // Get all teachers username and their subject and all students email.
                var allProfObj=profTable.column(5).data();
                var allProfSubjObj=profTable.column(1).data();
                var allProf=[];
                var allProfSubj=[];
                for(var i=0;i<allProfSubjObj.length;i++)
                {
                    allProf.push(allProfObj[i]);
                    allProfSubj.push(allProfSubjObj[i]);
                }
            // Get all teachers username and their subject and all students email end.

            if(confirm("This will permanently delete student named "+stdNameTd+". Do you want to delete it ?"))
            {
                $.ajax({
                    url: "del_std.php?division=<?php echo $classDiv;?>&className=<?php echo $className;?>",
                    type: 'POST',
                    data: {'email':stdEmailTd ,'allProf':allProf,'allProfSubj':allProfSubj},
                    async: true,
                    });
                $(this).parent().parent().css("display","none");
            }
            });


        // Add a student
          $(document).on('click', '#addStdBtn', function(){
            var addStdName=$("#addStdBtn").parent().find('#addStdName').val();
            var addStdRoll=$("#addStdBtn").parent().parent().find('#addRollNo').val();
            var addStdEmail=$("#addStdBtn").parent().parent().find("#addEmail").val();
            
            // Get all teachers username and their subject and all students email.
                var allProfObj=profTable.column(5).data();
                var allProfSubjObj=profTable.column(1).data();
                var allProf=[];
                var allProfSubj=[];
                for(var i=0;i<allProfSubjObj.length;i++)
                {
                    allProf.push(allProfObj[i]);
                    allProfSubj.push(allProfSubjObj[i]);
                }
            // Get all teachers username and their subject and all students email end.            

            if(addStdName!="" && addStdRoll!="" && addStdEmail!="")
            {
              $.ajax({
                url: "add_new_std_to_class.php?division=<?php echo $classDiv;?>&className=<?php echo $className;?>",
                type: 'POST',
                data: {'name': addStdName,'roll': addStdRoll,'email':addStdEmail,'allProf':allProf,'allProfSubj':allProfSubj },
                async: true,
                success: function(data)
                {
                    alert(data);
                    window.location="go_to_class2.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>";
                }
                });
            }
            else
            {
                alert('Any of these fields cannot be empty');
            }
            });


        });

        // Add a subject to class
            $(document).on('click', '#addSubjBtn', function(){
                var allStudentRollNoObj=stdTable.column(0).data();
                var allStudentNameObj=stdTable.column(1).data();
                var allStudentEmailObj=stdTable.column(2).data();
                var creatorClassId=<?php echo "$creatorClassId"; ?>;
               
                var allStudentName=[];
                var allStudentEmail=[];
                var allStudentRollNo=[];

                for(var i=0;i<allStudentNameObj.length;i++)
                {
                    allStudentName.push(allStudentNameObj[i]);
                    allStudentEmail.push(allStudentEmailObj[i]);
                    allStudentRollNo.push(allStudentRollNoObj[i]);
                    
                }
                var addSubj=$('#addSubjInp').val();
                if(addSubj!="")
                {
                    $.ajax({
                    url: "add_subject_to_class.php?division=<?php echo $classDiv;?>&className=<?php echo $className;?>",
                    type: 'POST',
                    data: {'allStudentName': allStudentName,'allStudentRollNo': allStudentRollNo,'allStudentEmail':allStudentEmail,'addSubj':addSubj,'creatorClassId':creatorClassId},
                    async: true,
                    success: function(data)
                    {
                        alert(data);
                        window.location="go_to_class2.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>";
                    }
                    });
                }
                else
                {
                    alert('Field cannot be empty');
                }

            });

    // Ajax content End



// Used for readymade table features.
$(document).ready( function () {
    stdTable=$('#stdListTable').DataTable();
    profTable=$('#profListTable').DataTable();
} );


</script>


</body>
</html>