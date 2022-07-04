<?php
session_start();
include_once('DBConnect.php');

$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$className=$_GET['className'];
$division=$_GET['division'];
$subject=$_GET['subjSearch'];
$testName=$_GET['testName'];
$testType=$_GET['testType'];
$testDuration=$_GET['testDuration'];
$startTime=$_GET['startTime'];
$testDate=$_GET['testDate'];
$classId=0;
$testId=0;


// Grab class id.
    $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$division' AND subj='$subject' AND profId='$profId' ";
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

// get testId from allTests.
	$testIdSql = "SELECT id FROM allTests WHERE profId='$profId' AND classId='$classId' AND testName='$testName' " ;
	$testIdRes = mysqli_query($con, $testIdSql);

	if(mysqli_num_rows($testIdRes)>0)
	{
		while($row=mysqli_fetch_assoc($testIdRes))
		{
			$testId=$row['id'];
		}
	}
// get testId from allTests end.    


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
    <style type="text/css">

	.autoresizing
	{ 
		width: 100%;
        display: block; 
        overflow: hidden; 
        resize: none;
    }

    .custom-width{
    	width:60%;
    }
    @media screen and (max-width:600px){
    	.custom-width{
    		width:100%;
    	}     
    }

    .card{
    	border-width: 1px;
    	transition-duration: 0.1s;
    	transition-timing-function: ease-in-out;
    	border-radius:8px;
    	border-color:white;
    }
/*    .card:hover{
    	border-left-width:8px;
    	border-left-color:#6db9fc;
    }
*/
    .chapterName input{
    	border-width:0 0 0px;
    	outline:0;
    	background-color:#4777d1;
    	color:white;
    	width:100%;
    	
    }
    .chapterName input:focus{
    	border-width:0 0 1px;
    	outline: 0;
    	color:white;
    }

    .imgBtn{
    	display: none;
    }

    .card-footer{
    	display: none;
    }

    .imgBtnProp{
    	border-radius:20px;
    	background-color:#f5f5f5;
    	padding:6px;

    }
    .imgBtnProp:hover{
        background-color:#bccaeb;
    }


    .insImgIcon{
    	text-align:center;width:18px;height:18px;
    }


    .editBtns{
    	transition-duration:0.5s;
    	background-color:white;
    	border-width: 0 0 0px;
    }
    .editBtns:hover{
    	background-color:#f0f0f0;
    }
    .editBtns:focus{
    	outline:0;

    }


    .threeDotBtn{
		border-radius:50%;
		background-color:#4777d1;
		border-width:0 0 0px;
		float:right;
		transition-duration:0.4s;
	}
    .threeDotBtn:hover{
    	background-color:white;
    }
    .threeDotBtn:focus{
    	outline:0;
    }
    .vl{
        border-left: 1px solid lightgrey;
        height:35px;
        align-self:flex-end;
    }

    textarea{
    	outline:0;border-width:0 0 0px;border-color:black;

    }
    textarea:focus{
    	outline:0;border-width:0 0 2px;border-color:black;

    }

    .correctOptDiv div span,#subDiv div span{
        padding:2%;
        margin-left:3%;
    }

    .correctOptDiv div,#subDiv div{
        padding: 3%;
    }
    .correctOptDiv div:hover,#durationDiv div:hover,#subDiv div:hover{
        background-color: lightgrey;
    }


    /* Options checkmark */
    .checkmark{
        display:inline-block;
        width: 22px;
        height:22px;
        -ms-transform: rotate(45deg); /* IE 9 */
        -webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
        transform: rotate(45deg);
    }

    .checkmark_circle {
        position: absolute;
        width:22px;
        height:22px;
        border-radius:11px;
        left:2px;
        top:0px;
    }


    #greyNow{
        background-color: grey;
    }
    #greenNow{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        background-color: #27c91e;
    }
    


    .checkmark_stem {
        position: absolute;
        width:3px;
        height:9px;
        background-color:#fff;
        left:13px;
        top:6px;
    }

    .checkmark_kick {
        position: absolute;
        width:3px;
        height:3px;
        background-color:#fff;
        left:10px;
        top:12px;
    }
    /* Options checkmark */


/* Placeholder edit for all browsers */
    .secInps::-webkit-input-placeholder {
        /* WebKit, Blink, Edge */
        color: lightgrey;
    }
    .secInps:-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        color: lightgrey;
        opacity: 1;
    }
    .secInps::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        color: lightgrey;
        opacity: 1;
    }
    .secInps:-ms-input-placeholder {
        /* Internet Explorer 10-11 */
        color: lightgrey;
    }
/* Placeholder edit for all browsers end */

</style>
</head>
<body style="background-color:#cbf2f7;">
	<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="JS/prepareTest.js"></script>
    <script type="text/javascript">testId=<?php echo $testId;?></script>
	<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
	 --><!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer></script>
	 -->
<!-- 	 <script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
 -->


<div style="display: none;">

    <!-- Section Sample Card -->
        <div class='section' id='section' name="">

            <!-- secion heading -->
                <div class="card shadow" id="unitCard">
                    <div class="card-title chapterName" style="padding:1%;background-color:#4777d1;border-radius:8px;">
                        <h4 class="he row">
                            <div class="col-5"><input class="chapterORunit secInps" type="text" name="unitName" placeholder="Chapter/Unit Name" value="" onblur="uplChapter($(this).parent().parent().parent().parent().parent())"></div>
                            <div class="col-5"><input class="noOfQnToAsk secInps" type="text" name="noOfQnToAsk" placeholder="Fixed question" onblur="uplNoOfQnToAsk($(this).parent().parent().parent().parent().parent())"></div>
                            <div class="col-2"><a class="btn-sm threeDotBtn" onclick=""><img class="imgIcon" src="img/threeDot.svg" style="height:15px;width:15px;"/></a>&nbsp;</div>
                        </h4>
                    </div><p></p>
                </div>
            <!-- secion heading end -->

            <!-- section qns -->
                <div class="secQns">
                    
                </div>
            <!-- section qns end -->

            <!-- Add qn big section Icon -->
                <div class="addquestion" style="margin-top:2%;">   
                    <div class="jumbotron" style="height:15vh;text-align:center;" onclick="createAndAddQn($(this).parent().parent())">
                        <a class="btn-sm" style="border-radius:25px;" id="plusBtn"><img src="img/plus.svg" style="height:22px;width:22px;" class="" /><span> ADD Question</span></a>&nbsp;
                    </div>
                </div>
            <!-- Add qn big section Icon end-->
        </div>
    <!-- Section Sample Card end -->

<!-- -x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x--x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x -->


    <!-- Sample qncard -->
        <div class="card shadow qncard "style="margin-top:2%;" id="qncard" onclick="highlight(this)">
            <div class="qnFieldAndImgDiv">
                <!-- Actuall qn field -->
                    <div class="card-title" style="padding:2%">
                        <div class="row inpFieldRow" style="padding:3%;" onclick="showImgIcon(this)">
                            <div class="shadow1" style="background-color:#69a7e0;border-radius:25px;color:white;text-align: center;height:25px;width:10%;"><span class="qnNoSpan" style="padding:1%;white-space: nowrap;text-align:center;"></span></div>
                            <div class="" style="width:70%;padding-left:2%;">
                                <textarea class="autoresizing question" rows="1" name="question" placeholder="QUESTION" onblur="uplQn($(this).parent().parent().parent().parent().parent())"></textarea>
                            </div>
                            <div class=" imgBtn" style="padding:0.5%;width:20%;text-align:center;">
                                <form method="post" action="" enctype="multipart/form-data" id="fileInpForm">
                                    <input name="qnImg" type="file" class="imgInp qnImg" style="display:none;" oninput="uplQnImg(this)" />
                                </form>
                                <a class="btn btn-sm imgBtnProp" onclick="addImg(this)">
                                    <img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
                                </a>
                            </div>
                        </div>
                    </div>
                <!-- Actual qn field end -->
                <!-- Image upload section -->
                    <div class="container imgSec" style="display:none;margin-top:-2%;">
                        <div class="imgDiv row">
                            <div class="colm-12" style="text-align: center;">
                                <img id="imgShow" class="qnImgShow" src="" alt="" style="height:400px;width:95%;">
                            </div>
                        </div>
                        <br>
                    </div>
                <!-- Image upload section end -->
            </div>
            <!-- all options for qn -->
                <div class="container qnOptns">
                    
                </div><p></p>
            <!-- all options for qn -->

            <!-- Link for adding option -->
                <div class="container qnLinkBtns" style="display: none;align-items: baseline;position: relative;">
                    <div><button class="btn btn-link" style="margin-left:4%;" onclick="createAndAddOpt($(this).parent().parent().parent())">Add Option</button></div>&nbsp;&nbsp;

                    <div style="margin-left:auto;">
                        <a class="btn-sm editBtns" style="border-radius:25px;" onclick="createNextQn($(this).parent().parent())" id="plusBtn">
                            <img src="img/plus.svg" style="height:20px;width:20px;"class="imgIcon" />
                        </a>
                    </div>&nbsp;
                    <div class="vl"></div>&nbsp;
                    <div onclick="delQn($(this).parent().parent())"><a class="btn-sm editBtns" style="border-radius:25px;"><img class="imgIcon" src="img/delete.svg" style="height:20px;width:20px;"/></a></div>
                </div><p></p>
            <!-- Link for adding option end -->
        </div>
    <!-- Sample qncard -->

<!-- -x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x--x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x -->


    <!-- Sample option Inputs -->
    <div class="container option" id="option">

        <!-- Actuall option field -->
            <div class="card-title">
                <div class="row inpFieldRow" style="display: flex;flex-wrap: nowrap;" onclick="showImgIcon(this)">
                    <div class="sub" id="" style="text-align:center;width:10%" onclick="toggleCheckmarkColor(this)">     
                        <span class="checkmark">
                            <div class="checkmark_circle" id="greyNow"></div>
                            <div class="checkmark_stem"></div>
                            <div class="checkmark_kick"></div>
                        </span>
                    </div>             
                    <div class="" style="width:70%;">
                        <textarea class="autoresizing optInp" rows="1" placeholder="Option" onblur="uplOpt($(this).parent().parent().parent().parent())"></textarea>
                    </div>
                    <div class="imgBtn" style="padding:0.5%;width:20%;">
                        <form method="post" action="" enctype="multipart/form-data" id="fileInpForm">
                            <input name="optImg" type="file" class="imgInp" style="display:none;" oninput="uplOptImg(this)" />
                        </form>
                        <a class="btn btn-sm imgBtnProp" onclick="addImg(this)">
                            <img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
                        </a>
                        <a class="btn btn-sm imgBtnProp cutBtn" onclick="delOpt($(this).parent().parent().parent().parent())">
                            <img class="insImgIcon" src="img/closeIconImg.png" alt="NO SVG">
                        </a>
                    </div>
                </div>
            </div>
        <!-- Actual opt field end -->
        <!-- Image upload section -->
            <div class="container imgSec" style="display:none;margin-top:-2%;padding:1%">
                <div class="imgDiv row">
                    <div class="colm-12" style="text-align: center;">
                        <img id="imgShow" src="" alt="" style="height:200px;width:200px;">
                    </div>
                </div>
                <br>
            </div>
        <!-- Image upload section end -->

    </div>
    <!-- Sample option Inputs end -->

<!-- -x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x--x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x -->




</div>


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
      <li class="nav-item active">
        <a class="nav-link" href="teachers_tool.php">Home<span class="sr-only">(current)</span></a>
      </li>
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

    <div class="row" style="margin-top:4vh;padding:4.5%">
        <div class="colm-2">
            
        </div>
        <div class="colm-8" id="main">


        </div>
        <div class="colm-2">
            
        </div>
    </div>


</body>
</html>