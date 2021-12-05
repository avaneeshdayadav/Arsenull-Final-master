<?php

session_start();
include_once('DBConnect.php');

if(!isset($_SESSION['profUsername']))
    echo "<script>window.location='prof_login.php';</script>";

$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$className=$_GET['className'];
$classDiv=$_GET['division'];
include_once("take_attendance_search_field_creation_page.php");

// Get subjects of this teacher of this class.
$sql = "SELECT subj FROM class WHERE profId='$profId' AND className='$className' AND  division='$classDiv' ";
$result = mysqli_query($con, $sql);
// Get subjects of this teacher of this class end.

$testNameErr="";
$startTimeErr="";

if(isset($_POST['go']))
{
	$testName=test_input($_POST['testName']);
	$testType=test_input($_POST['testType']);
	$testDuration=test_input($_POST['duration']);
	$subject=test_input($_POST['subInp']);
	$startTime=test_input($_POST['startTime']);
	$testDate=test_input($_POST['testDate']);
	$time_diff_btwn_UTC_and_local_time=((int)test_input($_SESSION['time_diff_btwn_UTC_and_local_time']))*(-1);
	$classId=0;
	$testDateErr="";
	$everythingOk=1;

	if($testType=="On Fixed time Fixed date" || $testType=="On Any time Fixed date")
	{
		if($testDate=="")
		{
			$everythingOk=0;
			$testDateErr="Test date field is empty.";
		}

	}


	if($testName=="")
	{
		$everythingOk=0;
		$testNameErr="Field cannot be empty or just cannot contain only whitespaces. TestName is : $testName";
	}

	// Get classId.
		$classIdSql = "SELECT id FROM class WHERE profId='$profId' AND className='$className' AND  division='$classDiv' AND subj='$subject' ";
		$classIdRes = mysqli_query($con, $classIdSql);
		if(mysqli_num_rows($classIdRes))
		{
			while($row=mysqli_fetch_assoc($classIdRes))
			{
				$classId=$row['id'];
			}
		}
	// Get classId end.

	// Check if same testName already exists.
		$testNameSql = "SELECT testName FROM allTests WHERE profId='$profId' AND classId='$classId' AND testName='$testName' ";
		$testNameResult = mysqli_query($con, $testNameSql);
		if(mysqli_num_rows($testNameResult)>0)
		{
			$testNameErr="Test name $testName already exists.";
			$everythingOk=0;
		}
	// Check if same testName already exists end.

	date_default_timezone_set("Asia/kolkata");
	$currentTimeInUserTimezone = strtotime('now')-(330*60)+(($time_diff_btwn_UTC_and_local_time)*60);
	$todayDate = date("m/d/Y",$currentTimeInUserTimezone);
	$currentTime = date("h:i:s A",$currentTimeInUserTimezone);

	if(($testDate!='' && $testDate!='NULL') && ($startTime!='' && $startTime!='NULL'))
	{
		if(strtotime($testDate)==strtotime($todayDate))
		{
			if(strtotime($currentTime)>strtotime($startTime))
			{
				$startTimeErr="This time on this date has past";
				$everythingOk=0;
			}
		}
	}

if($everythingOk==1)
{
	//Insert test data in allTests database with draft status.

		// status=0 : draft
		// status=1 : upcoming
		// status=2 : ongoing
		// status=3 : finished
		echo "$testName";
		$allTestsSql="INSERT INTO allTests(profId,classId,testName,testType,status,startTime,duration,testDate) VALUES('$profId','$classId','$testName','$testType',0,'$startTime','$testDuration','$testDate')";

		if (mysqli_query($con, $allTestsSql))
		{
			echo "Test Data inserted successfully";
		}
		else
		{
			echo "Error: " . $allTestsSql . "<br>" . mysqli_error($con);
		}

	//Insert test data in allTests database with draft status end.

	$url="prepare_test.php?className=".urlencode($className)."&division=".urlencode($classDiv)."&subjSearch=".urlencode($subject)."&testName=".urlencode($testName)."&testDate=".urlencode($testDate)."&testType=".urlencode($testType)."&startTime=".urlencode($startTime)."&testDuration=".urlencode($testDuration);
	echo "<script>window.location='$url';</script>";
}


}


function test_input($data) {
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
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/attendence.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" type="text/css" href="DataTables/Bootstrap-4-4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/sidenav.css">
    <link rel="stylesheet" type="text/css" href="css/timepicker.css">

    <style type="text/css" media="screen">

   	input[type="text"],input[type="email"],input[type="password"]{ padding: 10px 10px; line-height: 20px;outline:0;border-width:0 0 1px;width:100%;}
    .maindiv{
        position: relative;
    }
    .place{
        position: absolute;
        left:9px;
        top:7px;
        height:56%;
        font-size:100%;
        color:grey;
        transition-duration:0.2s;
        white-space:nowrap;
    }

	.card{
		width:100%;
	}
	#testTypeDiv div span,#subDiv div span{
		padding:2%;
		margin-left:3%;
	}
	#durationDiv div span{
		padding:2%;
		margin-left:3%;	
	}
	#testTypeDiv div,#subDiv div{
		padding: 3%;
	}
	#durationDiv div{
		padding: 3%;
	}
	#testTypeDiv div:hover,#durationDiv div:hover,#subDiv div:hover{
		background-color: lightgrey;
	}

	.colm-6{
		padding: 3%;
	}
	.lastRowCols{
		display: none;
	}

/*Mobile view*/
  @media only screen and (max-width: 800px) {
    .card{
      width:100%;margin-left:0%;
    }

    input[name="profPassword"],input[name="confPass"]{
      width:90%;
    }

  }
/*Mobile view end*/
    </style>
</head>
<body id="body">
   
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript"> var subjectSearch=""; </script>
<script src="gijgo-combined-1.9.13/gijgo.min.js" type="text/javascript"></script>
<script src="JS/timepicker.js" type="text/javascript"></script>

<div class="navDiv">
	<nav class="navbar navbar-expand-lg navbar-light shadow" style="background-color:white;color:black;position:fixed;top: 0;width:100%;z-index:2;">
	<a class="hamb mr-auto nav-link btn-sm" href="#"><img class="hambImg" src="img/bar-icon.png" style="height:5vh;width:9vw;"/></a>
	<a class="navbar-brand" href="#" style="position:absolute;left:45%;">
	  <h4 style="margin-top:1%;"><span>Arse</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
	</a>
	<a class="ml-auto nav-link" href="#">Help<span class="sr-only"></span></a>

	</nav>
</div>



<?php
include_once('prof_sidebar.php');
?>

<div class="row mainContent">
    <div class="colm-9">
      <div><h5  style="color:grey;font-weight:800;">Prepare and conduct test for your class.</h5></div><hr><br>
      <div class="card shadow">
        <div class="card-body" style="padding:4%;">
	        <form method="post">
	            <div class="row">
	            	<div class="colm-6">
	                	<div class="maindiv">
	                  		<span class="place" onclick="makeInpFocus(this)">Test Name</span>
	                  		<input type="text" class="testName" name="testName" value="<?php if(isset($_POST['go']))echo $_POST['testName']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="">
	                	</div>
	                	<div><small style="color:red;"><?php if(isset($_POST['go']))echo $testNameErr;?></small></div>
	              	</div>
	              	<div class="colm-6" style="position: relative;">
	                	<div class="maindiv">
	                  		<span class="place" onclick="makeInpFocus(this)" id="testTypePlace">Test Type</span>
	                  		<input class="testType" type="text" name="testType" value="<?php if(isset($_POST['go']))echo $_POST['testType']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" placeholder="" onkeydown="return false;">
	                	</div>
	                	<div class="card shadow" id="testTypeDiv" style="position:absolute;height:26vh;overflow-y:auto;display: none;color:grey;z-index:3;width:60%;">
		                	<div id="sub"><span>On Any time Any date</span></div>
		                	<div id="sub"><span>On Any time Fixed date</span></div>
		                	<div id="sub"><span>On Fixed time Any date</span></div>
		                	<div id="sub"><span>On Fixed time Fixed date</span></div><p></p>
	                	</div>
	              	</div>
	            </div>
	            <div class="row">	          	
	              	<div class="colm-6" style="position: relative;">
	                	<div class="maindiv">
	                  		<span class="place" onclick="makeInpFocus(this)" id="durationPlace">Test Duration</span>
	                  		<input class="duration" type="text" name="duration" value="<?php if(isset($_POST['go']))echo $_POST['duration']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" placeholder="" onkeydown="return false;">
	                	</div>
	                	<div class="card shadow" id="durationDiv" style="overflow-y:scroll;height:20vh;position:absolute;display: none;color:grey;z-index:3;width:60%;">
		                	<div id="lvl">0 hr 15 min<span></span></div>
		                	<div id="lvl">0 hr 30 min<span></span></div>
		                	<div id="lvl">0 hr 45 min<span></span></div>
		                	<div id="lvl">1 Hr 00 min<span></span></div>
		                	<div id="lvl">1 Hr 15 min<span></span></div>
		                	<div id="lvl">1 Hr 30 min<span></span></div>
		                	<div id="lvl">1 hr 45 min<span></span></div>
		                	<div id="lvl">2 hr 00 min<span></span></div>
		                	<div id="lvl">2 hr 15 min<span></span></div>
		                	<div id="lvl">2 Hr 30 min<span></span></div>
		                	<div id="lvl">2 Hr 45 min<span></span></div>
		                	<div id="lvl">3 Hr 00 min<span></span></div>
		                	<div id="lvl">3 hr 15 min<span></span></div>
		                	<div id="lvl">3 Hr 30 min<span></span></div>
		                	<div id="lvl">3 Hr 45 min<span></span></div>
		                	<div id="lvl">4 Hr 00 min<span></span></div>
		                	<div id="lvl">4 hr 15 min<span></span></div>
		                	<div id="lvl">4 Hr 30 min<span></span></div>
		                	<div id="lvl">4 Hr 45 min<span></span></div>
		                	<div id="lvl">5 Hr 00 min<span></span></div>
		                	<div id="lvl">5 hr 15 min<span></span></div>
		                	<div id="lvl">5 Hr 30 min<span></span></div>
		                	<div id="lvl">5 Hr 45 min<span></span></div>
		                	<div id="lvl">6 Hr 00 min<span></span></div>
	                	</div>
	              	</div>
	              	<div class="colm-6" style="position: relative;">
	                	<div class="maindiv">
	                  		<span class="place" onclick="makeInpFocus(this)" id="subPlace">Subject</span>
	                  		<input class="subInp" type="text" name="subInp" value="<?php if(isset($_POST['go']))echo $_POST['subInp']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" placeholder="" onkeydown="return false;">
	                	</div>
	                	<div class="card shadow" id="subDiv" style="position:absolute;display: none;color:grey;z-index:3;width:60%;">
	                		<?php
	                			if(mysqli_num_rows($result)>0)
	                			{
	                				while($row=mysqli_fetch_assoc($result))
	                				{
	                		?>
	                					<div id="subject"><span><?php echo $row['subj'];?></span></div>
	                		<?php
	                				}
	                			}
	                			else
	                			{
	                				echo "error:".mysqli_error($con);
	                			}
	                		?>

	                	</div>
	              	</div>		
              	</div>
              	<div class="row">
	              	<div class="colm-6 lastRowCols">
		                <div class="maindiv startTimeDiv">
		                  <span class="place" onclick="makeInpFocus(this)">Start Time</span>
		                  <input class="timepicker" type="text" name="startTime" value="<?php if(isset($_POST['go']))echo $_POST['startTime']; ?>" required="" id="inpbox" onfocus="floatOnFocus(this)" onblur="floatOnBlur(this)" placeholder="" onkeypress="return false">
	                	</div>
	                	<div><small style="color:red;"><?php if(isset($_POST['go']))echo $startTimeErr;?></small></div>
	              	</div>
	              	<div class="colm-6 lastRowCols">
						<div class="maindiv testDateDiv">
						    <span class="place" onclick="makeInpFocus(this)">Test Date</span>
						    <input style="outline:0;border-width:0 0 1px;border-color:lightgrey;" value="<?php if(isset($_POST['go']))echo $_POST['testDate']; ?>" class="datepicker" type="text" name="testDate" id="inpbox" onfocus="dateFocus(this)" onblur="floatOnBlur(this)" placeholder="">
						</div>
						<div><small style="color:red;"><?php if(isset($_POST['go']))echo $testDateErr;?></small></div>	              		
	              	</div>
            	</div>
	            <br>
	            <input type="text" id="timezoneOffset" name="time_diff_btwn_UTC_and_local_time" onkeydown="return false" style="display: none;">
	            <div>
	              <button type="submit" class="shadow btn btn-primary" name="go" style="border-radius:25px;">GO</button>
	            </div>
	        </form> 
	    </div>           
	</div>

        </div>
    	</div>
   	</div>
    <div class="colm-3 forAdds">

    </div>
</div>


<script type="text/javascript">

$(document).ready(function(){
	var subText=$('.testType').val();
	if(subText=="On Any time Any date" || subText=="")
	{
		$(".testDateDiv").parent().css("display","none");
		$(".startTimeDiv").parent().css("display","none");
	}
	else if(subText=="On Any time Fixed date")
	{
		$(".testDateDiv").parent().css("display","block");
		$(".startTimeDiv").parent().css("display","none");
	}
	else if(subText=="On Fixed time Any date")
	{
		$(".testDateDiv").parent().css("display","none");
		$(".startTimeDiv").parent().css("display","block");
	}
	else if(subText=="On Fixed time Fixed date")
	{
		$(".testDateDiv").parent().css("display","block");
		$(".startTimeDiv").parent().css("display","block");
	}

	$('#testTypeDiv').slideUp(400);
	$('#durationDiv').slideUp(400);
	$('#subDiv').slideUp(400);


});



var d = new Date();
var time_diff_btwn_UTC_and_local_time = d.getTimezoneOffset();
$("#timezoneOffset").attr("value",time_diff_btwn_UTC_and_local_time);

	// Initial first link highlight
        $("#testDivDesk").css("background-color","white");
        $("#testDivDesk").css("color","grey");
        $("#testDivDesk").data('clicked', true);

    // Initial first link highlight

// function to fill input with clicked dropdown.
var lvl=document.querySelectorAll("#lvl");
var sub=document.querySelectorAll("#sub");

for(var i=0;i<lvl.length;i++)
{
	$(lvl[i]).click(function(){
  		var lvlText=$(this).text();
    	$(this).parent().parent().find("#inpbox").val(lvlText);
    	$(this).parent().slideUp(400);

	});
}

var subMenu=document.querySelectorAll('#subject');
for(var i=0;i<subMenu.length;i++)
{
	$(subMenu[i]).click(function(){
  		var subMenuText=$(this).text();
    	$(this).parent().parent().find("#inpbox").val(subMenuText);
    	$(this).parent().slideUp(400);

	});
}


for(var i=0;i<lvl.length;i++)
{
	$(sub[i]).click(function(){
  		var subText=$(this).text();
  		if(subText=="On Any time Any date" || subText=="")
  		{
  			$(".testDateDiv").parent().css("display","none");
  			$(".testDateDiv").find("#inpbox").val("NULL");
  			$(".startTimeDiv").parent().css("display","none");
  			$(".startTimeDiv").find("#inpbox").val("NULL");
  		}
  		else if(subText=="On Any time Fixed date")
  		{
  			$(".testDateDiv").parent().css("display","block");
  			$(".testDateDiv").find("#inpbox").val("");
  			$(".startTimeDiv").parent().css("display","none");
  			$(".startTimeDiv").find("#inpbox").val("NULL");
  		}
  		else if(subText=="On Fixed time Any date")
  		{
  			$(".testDateDiv").parent().css("display","none");
  			$(".testDateDiv").find("#inpbox").val("NULL");
  			$(".startTimeDiv").parent().css("display","block");
  			$(".startTimeDiv").find("#inpbox").val("");
  		}
  		else if(subText=="On Fixed time Fixed date")
  		{
  			$(".testDateDiv").parent().css("display","block");
  			$(".testDateDiv").find("#inpbox").val("");
  			$(".startTimeDiv").parent().css("display","block");
  			$(".startTimeDiv").find("#inpbox").val("");
  		}

    	$(this).parent().parent().find("#inpbox").val(subText);
    	$(this).parent().slideUp(400);
    	$(this).parent().parent().find("#inpbox").val(subText);
    	$(this).parent().slideUp(400);

	});
}
// function to fill input with clicked dropdown end.


// Check if click is outside dropdown menu or outside input box.
	$('body').click(function(event) {
	        
	    if(!$(event.target).is('.testType') && !$(event.target).is('#testTypePlace'))
	    {
	    	$("#sub").parent().slideUp(400);
	    	floatOnBlur($("#sub").parent().parent().find("#inpbox"));
	    }
	    if(!$(event.target).is('.duration') && !$(event.target).is('#durationPlace'))
	    {
	    	$("#lvl").parent().slideUp(400);
	    	floatOnBlur($("#lvl").parent().parent().find("#inpbox"));
	    }
	    if(!$(event.target).is('.subInp') && !$(event.target).is('#subPlace'))
	    {
	    	$("#subject").parent().slideUp(400);
	    	floatOnBlur($("#subject").parent().parent().find("#inpbox"));
	    }
	});
// Check if click is outside dropdown menu or outside input box end.

function dateFocus(evt)
{
	$(evt).parent().parent().find('.place').css("font-size","88%");
    $(evt).parent().parent().find('.place').css("top","-11px");
    $(evt).parent().parent().find('.place').css("color","#1b75cf");
    $(evt).parent().parent().find('.place').css("background-color","white");
}

    // Highlight clicked links.
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
                if($(this).data("clicked"))
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
            else if($(this).attr("id")=="testDivDesk")
            {
                $(".takeAttSubMenuDesk").slideUp(400);
                $(".viewAttSubMenuDesk").slideUp(400);
            }


        });

        $(".DeskEachLink").hover(function(){if($(this).data("clicked"));else $(this).css("background-color","#7ea6f7");},function(){if($(this).data("clicked"));else $(this).css("background-color","#487ae0");})
    // Highlight clicked links end


function floatOnFocus(evt){
    $(evt).parent().find('.place').css("font-size","88%");
    $(evt).parent().find('.place').css("top","-11px");
    $(evt).parent().find('.place').css("color","#1b75cf");
    $(evt).parent().find('.place').css("background-color","white");
    if($(evt).attr("name")=="testType")
    {
    	$("#testTypeDiv").slideDown(400);
    }
    if($(evt).attr("name")=="duration")
    {
    	$("#durationDiv").slideDown(400);
    }
    if($(evt).attr("name")=="subInp")
    {
    	$("#subDiv").slideDown(400);
    }

}
function makeInpFocus(evt){
    $(evt).parent().find('#inpbox').focus();
}

function floatOnBlur(evt){
    if($(evt).val()=="")
    {
        $(evt).parent().find('.place').css("font-size","100%");
        $(evt).parent().find('.place').css("top","7px");
        $(evt).parent().find('.place').css("color","grey");
        $(evt).parent().find('.place').css("background-color","transparent");
    }
}


var allInp=document.querySelectorAll('#inpbox');
for(var i=0;i<allInp.length;i++)
{
  if($(allInp[i]).val()!="")
  {
    floatOnFocus($(allInp[i]));
  }
}

$('.datepicker').datepicker({showRightIcon: false, header: true, modal: true,format: 'dd mmm yyyy',
	disableDates:  function (date) {
    // allow for today
     const currentDate = new Date().setHours(0,0,0,0);
     return date.setHours(0,0,0,0) >= currentDate ? true : false;
    }

 });
$('.timepicker').timepicker({'timeFormat': 'h:i A'});
</script>

</body>

</html>



