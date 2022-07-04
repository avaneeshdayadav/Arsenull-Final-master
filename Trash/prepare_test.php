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

	#autoresizing
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
    	background-color:#034efc;
    	color:white;
    	width:25%;
    	margin-left:5%;
    	
    }
    .chapterName input:focus{
    	border-width:0 0 1px;
    	outline: 0;
    	color:white;
    	width:50%;
    	margin-left:5%;    	
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
    	padding:8px;

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
		background-color:#034efc;
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



    .hasImgInp{
    	padding:8px;
    }


    textarea{
    	outline:0;border-width:0 0 0px;border-color:black;

    }
    textarea:focus{
    	outline:0;border-width:0 0 1px;border-color:black;

    }
    textarea:focus{
    	transition-timing-function: ease-in-out;
    	transition-duration: 0.2s;
    	outline:0;
    	border-width:0 0 3px;
    	border-color:#a19d9d;
    }

</style>
</head>
<body style="background-color:#c5e3d0;">
	<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>
	<!-- <script type="text/javascript" src="DataTables/html2canvas/html2canvas.js"></script>
	 --><!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" type="text/javascript" charset="utf-8" async defer></script>
	 -->
<!-- 	 <script src="https://kit.fontawesome.com/b5f9813c1e.js" crossorigin="anonymous"></script>
 -->	
<script type="text/javascript">var sectionCount=1;</script>
<script type="text/javascript">

var testId="<?php echo $testId;?>";
var classId="<?php echo $classId;?>";

function getName(evt)
{
	alert($(evt).attr("name"));
}

function nameSecAndQn()
{
	var getAllSec=document.querySelectorAll("#section");	
	for(var i=1;i<getAllSec.length;i++)
	{
		$(getAllSec[i]).attr("name",i);
		var getAllQnOfThisSec=getAllSec[i].querySelectorAll('#qncard');
		for(var j=0;j<getAllQnOfThisSec.length;j++)
		{
			$(getAllQnOfThisSec[j]).attr("name",j+1);
		}
	}
}

function showImg(evt)
{
	var allImgInp=document.querySelectorAll(".hasImgInp");
	for(var i=0;i<allImgInp.length;i++)
	{
		$(allImgInp[i]).children(".imgBtn").css("display","none");
	}
	var imgIcon=$(evt).children(".imgBtn");
	imgIcon.css( "display", "block" );

}

// Cloning and adding new section.
function cloning()
{
	var newSection=$("#section").clone().appendTo( ".main" );
	newSection.css("display","block");
	newSection.children("#qncard").css("display","block");

	// Scroll to newly created section card element.
	$([document.documentElement, document.body]).animate({
    scrollTop: $(newSection).offset().top
	}, 200);

	nameSecAndQn();
	textareaHandle();
	return newSection;
}


function allQusestion(evt)
{
	var questions=document.querySelectorAll("#qncard");
	for(var i=0;i<questions.length;i++)
	{
		$(questions[i]).css("border-left-width","0");
		$(questions[i]).children().next(".card-footer").css("display","none");
	}
	$(evt).children().next(".card-footer").css("display","block");
	$(evt).css("border-left-width","8px");
	$(evt).css("border-left-color","#689ff7");
	textareaHandle();
}


function createQn(evt)
{
	var section=$(evt).parent().parent().parent();
	var qncard=document.querySelector("#qncard");
	var clonedone=$(qncard).css("display","block").clone().appendTo(section);

	// Scroll to newly created qn card element.
	$([document.documentElement, document.body]).animate({
    scrollTop: $(clonedone).offset().top
	}, 200);

	nameSecAndQn();
	textareaHandle();
}

function deleteQnCard(evt)
{
	$(evt).parent().parent().parent().remove();
	nameSecAndQn();
}

function addImg(evt)
{
	$(evt).parent().find("#imgInp").trigger('click');

	// To ge image preview
    function readURL(input)
    {
		if (input.files && input.files[0])
		{
			var reader = new FileReader();
		    
	    	reader.onload = function(e)
	    	{
	    		var imgToShow=$(evt).parent().parent().parent().parent().find("#imgShow");
		    	$(imgToShow).attr('src', e.target.result);
		    }
		    
		    reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	var input=$(evt).parent().find("#imgInp");
	$(input).change(function()
	{
	  readURL(this);
	  $(evt).parent().parent().parent().parent().children(".imgSec").css("display","block");
	});


	// To ge image preview is end here.	
}

function addOpt(evt)
{
	if($(evt).parent().find(".opnImgInp").attr('name')=="opAImg")
		$(evt).parent().find("input[name='opAImg']").trigger('click');
	else if($(evt).parent().find(".opnImgInp").attr('name')=="opBImg")
		$(evt).parent().find("input[name='opBImg']").trigger('click');
	else if($(evt).parent().find(".opnImgInp").attr('name')=="opCImg")
		$(evt).parent().find("input[name='opCImg']").trigger('click');
	else if($(evt).parent().find(".opnImgInp").attr('name')=="opDImg")
		$(evt).parent().find("input[name='opDImg']").trigger('click');


	// To ge image preview
    function readURL(input)
    {
		if (input.files && input.files[0])
		{
			var reader = new FileReader();
		    
	    	reader.onload = function(e)
	    	{
	    		var imgToShow=$(evt).parent().parent().find(".optImg");
		    	$(imgToShow).attr('src', e.target.result);
		    }
		    
		    reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}


	if($(evt).parent().find(".opnImgInp").attr("name")=="opAImg")
			var input=$(evt).parent().find("input[name='opAImg']");
		else if($(evt).parent().find(".opnImgInp").attr("name")=="opBImg")
			var input=$(evt).parent().find("input[name='opBImg']");
		else if($(evt).parent().find(".opnImgInp").attr("name")=="opCImg")
			var input=$(evt).parent().find("input[name='opCImg']");
		else
			var input=$(evt).parent().find("input[name='opDImg']");


	$(input).change(function()
	{
		readURL(this);
		$(evt).parent().parent().find(".optImgDiv").css("display","block");
	});
	// To ge image preview is end here.
}

</script>


  
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

		<div class="container custom-width">
			<div class="main">

				<!-- Section Start -->
				<div id="section" style="display: none;" name="">

					<!-- Unit name card -->
					<div class="card shadow" id="unitCard" style="margin-top:10%;">
						<div class="card-title chapterName" style="padding:1%;background-color:#034efc;border-radius:8px;">
							<h4 class="he">
								<input class="chapterORunit" type="text" name="unitName" placeholder="Chapter/Unit Name" value="" onblur="uplUnitName(this)">
								<input class="noOfQnToAsk" type="text" name="noOfQnToAsk" placeholder="Fixed question" onblur="uplNoOfCumpQn(this)">
								<a class="btn-sm threeDotBtn" onclick="cloning()"><img class="imgIcon" src="img/threeDot.svg" style="height:15px;width:15px;"/></a>&nbsp;
							</h4>
						</div><p></p>
					</div>
					<!-- Unit name card end -->


					<!-- Question Card -->
					<div class="card shadow" style="margin-top:2%;display:none;" name="" id="qncard" onclick="allQusestion(this)">

						<!-- Actuall qn field -->
						<div class="card-title qnFieldDiv" style="margin-top:2%;padding:1%;">
							<div class="row hasImgInp" style="margin-left:4%;" onclick="showImg(this)">
								<div class="col-10">
					            	<textarea class="question" rows="1" id="autoresizing" name="question" placeholder="QUESTION" onblur="uplQn(this)"></textarea>
								</div>
								<div class="col-2 imgBtn" style="padding:0.5%;">
			    					<form method="post" action="" enctype="multipart/form-data" id="fileInpForm">
			    						<input name="qnImg" type="file" id="imgInp" style="display:none;" oninput="uplQnImg(this)" />
			    					</form>
				    				<a class="btn btn-sm imgBtnProp" name="qnImgAnchor" onclick="addImg(this)">
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
									<img id="imgShow" src="" alt="" style="height:400px;width:95%;">
								</div>
							</div>
							<br>
						</div>
						<!-- Image upload section end -->

						
						<!-- Options -->
						<div class="card-body" id="allOptions" style="margin-top:-4%;">
							<div class="row hasImgInp opnAdiv" onclick="showImg(this)">
								<div class="col-2" style="text-align: center;">
									(a)&nbsp;
								</div>
								<div class="col-8" id="opnAtextField">
									<textarea rows="1" id="autoresizing" name="opa" class="opa" placeholder="Option (a)" onblur="uplOpa(this)"></textarea>
								</div>
								<div class="col-2 imgBtn" style="padding:0.5%;">
									<form method="post" action="" enctype="multipart/form-data">
			    						<input name="opAImg" type="file" class="opnImgInp" style="display:none" oninput="uplOpaImg(this)"/>
			    					</form>
				    				<a class="btn btn-sm imgBtnProp" onclick="addOpt(this)">
				    					<img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
				    				</a>
								</div>
								<!-- Image opA upload section -->
								<div class="container optImgDiv" id="opAImgDiv" style="display:none;margin-top:-2%;">
									<div class="imgDiv row">
										<div class="col-2"></div>
										<div class="colm-8" style="text-align: left;padding:2%;">
											<img class="optImg" id="opAShow" src="" alt="" style="height:30vh;width:40vh;">
										</div>
									</div>
									<br>
								</div>
								<!-- Image opA upload section end -->
							</div>
							<div class="row hasImgInp opnBdiv" onclick="showImg(this)">
								<div class="col-2" style="text-align: center;">
									(b)&nbsp;
								</div>
								<div class="col-8" id="opnBtextField">
									<textarea rows="1" id="autoresizing" name="opb" class="opb" placeholder="Option (b)" onblur="uplOpb(this)"></textarea>
								</div>
								<div class="col-2 imgBtn" style="padding:0.5%;">
									<form method="post" action="" enctype="multipart/form-data">
			    						<input name="opBImg" class="opnImgInp" type="file" style="display:none" oninput="uplOpbImg(this)"/>
			    					</form>
				    				<a class="btn btn-sm imgBtnProp" onclick="addOpt(this)">
				    					<img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
				    				</a>
								</div>
								<!-- Image opB upload section -->
								<div class="container optImgDiv" id="opBImgDiv" style="display:none;margin-top:-2%;">
									<div class="imgDiv row">
										<div class="col-2"></div>
										<div class="colm-8" style="text-align: left;padding:2%;">
											<img class="optImg" id="opBShow" src="" alt="" style="height:30vh;width:40vh;">
										</div>
									</div>
									<br>
								</div>
								<!-- Image opB upload section end -->
							</div>
							<div class="row hasImgInp opnCdiv" onclick="showImg(this)">
								<div class="col-2" style="text-align: center;">
									(c)&nbsp;
								</div>
								<div class="col-8" id="opnCtextField">
									<textarea rows="1" id="autoresizing" class="opc" name="opc" placeholder="Option (c)" onblur="uplOpc(this)"></textarea>
								</div>
								<div class="col-2 imgBtn" style="padding:0.5%;">
									<form method="post" action="" enctype="multipart/form-data">
			    						<input name="opCImg" class="opnImgInp" type="file" style="display:none" oninput="uplOpcImg(this)"/>
			    					</form>
				    				<a class="btn btn-sm imgBtnProp" onclick="addOpt(this)">
				    					<img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
				    				</a>
								</div>
								<!-- Image opC upload section -->
								<div class="container optImgDiv" id="opCImgDiv" style="display:none;margin-top:-2%;">
									<div class="imgDiv row">
										<div class="col-2"></div>
										<div class="colm-8" style="text-align: left;padding:2%;">
											<img class="optImg" id="opCShow" src="" alt="" style="height:30vh;width:40vh;">
										</div>
									</div>
									<br>
								</div>
								<!-- Image opC upload section end -->
							</div>
							<div class="row hasImgInp opnDdiv" onclick="showImg(this)">
								<div class="col-2" style="text-align: center;">
									(d)&nbsp;
								</div>
								<div class="col-8" id="opnDtextField">
									<textarea rows="1" id="autoresizing" name="opd" class="opd" placeholder="Option (d)" onblur="uplOpd(this)"></textarea>
								</div>
								<div class="col-2 imgBtn" style="padding:0.5%;">
									<form method="post" action="" enctype="multipart/form-data">
			    						<input name="opDImg" class="opnImgInp" type="file" style="display:none" oninput="uplOpdImg(this)"/>
			    					</form> 
				    				<a class="btn btn-sm imgBtnProp" onclick="addOpt(this)">
				    					<img class="insImgIcon" src="img/photo.svg" alt="NO SVG">
				    				</a>
								</div>
								<!-- Image opD upload section -->
								<div class="container optImgDiv" id="opDImgDiv" style="display:none;margin-top:-2%;">
									<div class="imgDiv row">
										<div class="col-2"></div>
										<div class="colm-8" style="text-align: left;padding:2%;">
											<img class="optImg" id="opDShow" src="" alt="" style="height:30vh;width:40vh;">
										</div>
									</div>
									<br>
								</div>
								<!-- Image opD upload section end -->
							</div><br>
						</div>
						<!-- Options end -->

						<!-- qn card edit -->
						<div class="card-footer" style="padding:1%;text-align:center;">
							<div>
								Correct options<br>
								(a)&nbsp;<input type="checkbox" name="correctA">&nbsp;(b)&nbsp;<input type="checkbox" name="correctB">&nbsp;(c)&nbsp;<input type="checkbox" name="correctC">&nbsp;(d)&nbsp;<input type="checkbox" name="correctD">&nbsp;
							</div><hr>
							<a class="btn-sm editBtns" style="border-radius:25px;" onclick="createQn(this)" id="plusBtn"><img src="img/plus.svg" style="height:20px;width:20px;"class="imgIcon" /></a>&nbsp;
							<a class="btn-sm editBtns" style="border-radius:25px;"><img class="imgIcon" src="img/delete.svg" style="height:20px;width:20px;" onclick="deleteQnCard(this)"/></a>&nbsp;
						</div>
						<!-- qn card edit end -->


					</div>
					<!-- Question card end -->


				</div>
				<!-- Section End --><p></p>

			</div><p><br></p>
			<button class="btn btn-success" name="finish" style="float:right;" onclick="submiting_each_section()">Finish</button>
		</div>

<!-- For auto height of textarea -->
<script type="text/javascript"> 
    	function textareaHandle()
    	{
	    	textarea = document.querySelectorAll("#autoresizing"); 
	        for(var i=0;i<textarea.length;i++)
	        textarea[i].addEventListener('input', autoResize, false); 
      
    	}
      
        function autoResize() { 
            this.style.height = 'auto'; 
            this.style.height = this.scrollHeight + 'px'; 
        } 

        function createQnForDraftUpd(evt)
        {
			var section=$(evt).parent().parent().parent();
			var qncard=document.querySelector("#qncard");
			var clonedone=$(qncard).css("display","block").clone().appendTo(section);
			nameSecAndQn();
			textareaHandle();
			return clonedone;
        }

        function fillPrevDataInQncard(evt,row)
        {
			evt.find("textarea[name='question']").val(row['question']);
			evt.find("textarea[name='opa']").val(row['opa']);
			evt.find("textarea[name='opb']").val(row['opb']);
			evt.find("textarea[name='opc']").val(row['opc']);
			evt.find("textarea[name='opd']").val(row['opd']);
			evt.find(".chapterORunit").val(row['unit']);
			evt.find(".noOfQnToAsk").val(row['noOfcumplQn']);

			if(row['qnImg']!="" && row['qnImg']!=null)
			{
				src="user_imgs/".concat("<?php echo $profId; ?>").concat("/").concat(row['qnImg']);
				evt.find(".imgSec").css("display","block");
				evt.find("#imgShow").attr("src",src);
			}
			if(row['opa_img']!="" && row['opa_img']!=null)
			{
				src="user_imgs/".concat("<?php echo $profId; ?>").concat("/").concat(row['opa_img']);
				evt.find("#opAImgDiv").css("display","block");
				evt.find("#opAShow").attr("src",src);
			}
			if(row['opb_img']!="" && row['opb_img']!=null)
			{
				src="user_imgs/".concat("<?php echo $profId; ?>").concat("/").concat(row['opb_img']);
				evt.find("#opBImgDiv").css("display","block");
				evt.find("#opBShow").attr("src",src);
			}
			if(row['opc_img']!="" && row['opc_img']!=null)
			{
				src="user_imgs/".concat("<?php echo $profId; ?>").concat("/").concat(row['opc_img']);
				evt.find("#opCImgDiv").css("display","block");
				evt.find("#opCShow").attr("src",src);
			}
			if(row['opd_img']!="" && row['opd_img']!=null)
			{
				src="user_imgs/".concat("<?php echo $profId; ?>").concat("/").concat(row['opd_img']);
				evt.find("#opDImgDiv").css("display","block");
				evt.find("#opDShow").attr("src",src);
			}
        }

        $(document).ready(function(){

			$.ajax({
				url: "test_draft_data.php",
	            type: 'POST',
	            data: {'testId':testId},
	            dataType: "json",
	            async:true,
				success:function(ultra)
				{
					if(ultra.status == 'ok')
					{
						var allSec=ultra.allSec;
						$.each(allSec, function(secNo, oneSec){
							var newSection=cloning();
							$.each(oneSec,function(qnNo,row){
								if(qnNo==0)
								{
									fillPrevDataInQncard(newSection,row);
								}
								else
								{
									// Creating new qncard.
										var refQnCard=document.querySelector("#qncard");
										var qncard=$(refQnCard).css("display","block").clone().appendTo(newSection);
										nameSecAndQn();
										textareaHandle();
									// Creating new qncard end.

									fillPrevDataInQncard(qncard,row);
								}
							});
						});
					}
					else
					{
						var newSec=$("#section").clone().appendTo( ".main" );
			        	newSec.css("display","block");
			        	newSec.children("#qncard").css("display","block");
			        	nameSecAndQn();
			        	textareaHandle();				
					}
				},
				error: function (jqXhr, textStatus, errorMessage)
				{ // error callback 
					alert(errorMessage);
				}
			});
        });

        function uplQn(evt)
        {
    		var qnIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var secIdentityNo=$(evt).parent().parent().parent().parent().parent().attr("name");
    		var qnInpVal=$(evt).val();
    		var unitName=$(evt).parent().parent().parent().parent().parent().find(".chapterORunit").val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'unitName':unitName,'qnIdentityNo': qnIdentityNo,'secIdentityNo': secIdentityNo, 'inpType':"Q", 'qnInpVal':qnInpVal,'testId':testId, 'classId':classId },
				async: true,
			});
        }

        function uplOpa(evt)
        {
    		var qnIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var secIdentityNo=$(evt).parent().parent().parent().parent().parent().attr("name");
    		var opaVal=$(evt).val();
    		var unitName=$(evt).parent().parent().parent().parent().parent().find(".chapterORunit").val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'unitName':unitName,'qnIdentityNo': qnIdentityNo,'secIdentityNo': secIdentityNo, 'inpType':"opa", 'opaVal':opaVal,'testId':testId, 'classId':classId },
				async: true,

			});
        }

        function uplOpb(evt)
        {
    		var qnIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var secIdentityNo=$(evt).parent().parent().parent().parent().parent().attr("name");
    		var opbVal=$(evt).val();
    		var unitName=$(evt).parent().parent().parent().parent().parent().find(".chapterORunit").val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'unitName':unitName,'qnIdentityNo': qnIdentityNo,'secIdentityNo': secIdentityNo, 'inpType':"opb", 'opbVal':opbVal,'testId':testId, 'classId':classId },
				async: true,
			});
        }

        function uplOpc(evt)
        {
    		var qnIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var secIdentityNo=$(evt).parent().parent().parent().parent().parent().attr("name");
    		var opcVal=$(evt).val();
    		var unitName=$(evt).parent().parent().parent().parent().parent().find(".chapterORunit").val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'unitName':unitName,'qnIdentityNo': qnIdentityNo,'secIdentityNo': secIdentityNo, 'inpType':"opc", 'opcVal':opcVal,'testId':testId, 'classId':classId },
				async: true,
			});
        }

        function uplOpd(evt)
        {
    		var qnIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var secIdentityNo=$(evt).parent().parent().parent().parent().parent().attr("name");
    		var opdVal=$(evt).val();
    		var unitName=$(evt).parent().parent().parent().parent().parent().find(".chapterORunit").val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'unitName':unitName,'qnIdentityNo': qnIdentityNo,'secIdentityNo': secIdentityNo, 'inpType':"opd", 'opdVal':opdVal,'testId':testId, 'classId':classId },
				async: true,
			});
        }

        function uplUnitName(evt)
        {
    		var secIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var unitName=$(evt).val();
			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'secIdentityNo': secIdentityNo, 'inpType':"U", 'unitName':unitName,'testId':testId, 'classId':classId },
				async: true,
			});
        }

        function uplNoOfCumpQn(evt)
        {
    		var secIdentityNo=$(evt).parent().parent().parent().parent().attr("name");
    		var noOfQnToAsk=$(evt).val();

			$.ajax({
				url: "dyanamic_upload.php",
				type: 'POST',
				data: {'secIdentityNo': secIdentityNo, 'inpType':"NQA", 'noOfQnToAsk':noOfQnToAsk,'testId':testId, 'classId':classId },
				async: true
			});
        }

        function uplQnImg(evt)
        {
    		var thisQnCard=$(evt).parent().parent().parent().parent().parent();
    		var qnIdentityNo=thisQnCard.attr("name");
    		var secIdentityNo=thisQnCard.parent().attr("name");
    		var unitName=thisQnCard.parent().find('.chapterORunit').val();

			// check if not empty.
        	if(thisQnCard.find("input[name='qnImg']").val()!="")
			{
				var qnImgInp=thisQnCard.find("input[name='qnImg']")[0].files[0];
				const fileType = qnImgInp['type'];
				const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];

				// Check if input file is image file.
				if (!validImageTypes.includes(fileType))
				{
				    alert("File is not an image.");
				}
				else
				{
					var fd = new FormData();
			            fd.append('qnIdentityNo',qnIdentityNo);
			   			fd.append('secIdentityNo',secIdentityNo);
			   			fd.append('inpType',"qnImgFile");
			   			fd.append('qnImgInp',qnImgInp);
			   			fd.append('testId',testId);
			   			fd.append('classId',classId);
			   			fd.append('unitName',unitName);

    				//Ajax claa send img file.
	        			$.ajax({
	        				url: "dyanamic_upload.php",
	        				type: 'POST',
	        				data: fd,
	        				contentType: false,
 							processData: false,
	        			});
	        		//Ajax claa send img file end.
				}
			}
        }

        function uplOpaImg(evt)
        {
    		var thisQnCard=$(evt).parent().parent().parent().parent().parent();
    		var qnIdentityNo=thisQnCard.attr("name");
    		var secIdentityNo=thisQnCard.parent().attr("name");
    		var unitName=thisQnCard.parent().find('.chapterORunit').val();

			// check if not empty.
        	if(thisQnCard.find("input[name='opAImg']").val()!="")
			{
				var opAImgInp=thisQnCard.find("input[name='opAImg']")[0].files[0];
				const fileType = opAImgInp['type'];
				const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];

				// Check if input file is image file.
				if (!validImageTypes.includes(fileType))
				{
				    alert("File is not an image.");
				}
				else
				{
					var fd = new FormData();
			            fd.append('qnIdentityNo',qnIdentityNo);
			   			fd.append('secIdentityNo',secIdentityNo);
			   			fd.append('inpType',"opAImgFile");
			   			fd.append('opAImgInp',opAImgInp);
			   			fd.append('testId',testId);
			   			fd.append('classId',classId);
			   			fd.append('unitName',unitName);

    				//Ajax claa send img file.
	        			$.ajax({
	        				url: "dyanamic_upload.php",
	        				type: 'POST',
	        				data: fd,
	        				contentType: false,
 							processData: false,
	        			});
	        		//Ajax claa send img file.
				}
			}
        }

        function uplOpbImg(evt)
        {
    		var thisQnCard=$(evt).parent().parent().parent().parent().parent();
    		var qnIdentityNo=thisQnCard.attr("name");
    		var secIdentityNo=thisQnCard.parent().attr("name");

			// check if not empty.
        	if(thisQnCard.find("input[name='opBImg']").val()!="")
			{
				var opBImgInp=thisQnCard.find("input[name='opBImg']")[0].files[0];
				const fileType = opBImgInp['type'];
				const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];

				// Check if input file is image file.
				if (!validImageTypes.includes(fileType))
				{
				    alert("File is not an image.");
				}
				else
				{
					var fd = new FormData();
			            fd.append('qnIdentityNo',qnIdentityNo);
			   			fd.append('secIdentityNo',secIdentityNo);
			   			fd.append('inpType',"opBImgFile");
			   			fd.append('opBImgInp',opBImgInp);
			   			fd.append('testId',testId);
			   			fd.append('classId',classId);

    				//Ajax claa send img file.
	        			$.ajax({
	        				url: "dyanamic_upload.php",
	        				type: 'POST',
	        				data: fd,
	        				contentType: false,
 							processData: false,
	        			});
	        		//Ajax claa send img file.
				}
			}
        }

        function uplOpcImg(evt)
        {
    		var thisQnCard=$(evt).parent().parent().parent().parent().parent();
    		var qnIdentityNo=thisQnCard.attr("name");
    		var secIdentityNo=thisQnCard.parent().attr("name");

			// check if not empty.
        	if(thisQnCard.find("input[name='opCImg']").val()!="")
			{
				var opCImgInp=thisQnCard.find("input[name='opCImg']")[0].files[0];
				const fileType = opCImgInp['type'];
				const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];

				// Check if input file is image file.
				if (!validImageTypes.includes(fileType))
				{
				    alert("File is not an image.");
				}
				else
				{
					var fd = new FormData();
			            fd.append('qnIdentityNo',qnIdentityNo);
			   			fd.append('secIdentityNo',secIdentityNo);
			   			fd.append('inpType',"opCImgFile");
			   			fd.append('opCImgInp',opCImgInp);
			   			fd.append('testId',testId);
			   			fd.append('classId',classId);

    				//Ajax claa send img file.
	        			$.ajax({
	        				url: "dyanamic_upload.php",
	        				type: 'POST',
	        				data: fd,
	        				contentType: false,
 							processData: false,
	        			});
	        		//Ajax claa send img file.
				}
			}
        }

        function uplOpdImg(evt)
        {
    		var thisQnCard=$(evt).parent().parent().parent().parent().parent();
    		var qnIdentityNo=thisQnCard.attr("name");
    		var secIdentityNo=thisQnCard.parent().attr("name");

			// check if not empty.
        	if(thisQnCard.find("input[name='opDImg']").val()!="")
			{
				var opDImgInp=thisQnCard.find("input[name='opDImg']")[0].files[0];
				const fileType = opDImgInp['type'];
				const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];

				// Check if input file is image file.
				if (!validImageTypes.includes(fileType))
				{
				    alert("File is not an image.");
				}
				else
				{
					var fd = new FormData();
			            fd.append('qnIdentityNo',qnIdentityNo);
			   			fd.append('secIdentityNo',secIdentityNo);
			   			fd.append('inpType',"opDImgFile");
			   			fd.append('opDImgInp',opDImgInp);
			   			fd.append('testId',testId);
			   			fd.append('classId',classId);

    				//Ajax claa send img file.
	        			$.ajax({
	        				url: "dyanamic_upload.php",
	        				type: 'POST',
	        				data: fd,
	        				contentType: false,
 							processData: false,
	        			});
	        		//Ajax claa send img file.
				}
			}
        }

    </script> 



<a target="_blank" href="https://icons8.com/icons/set/delete">Trash Can icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
<div>Icons made by <a href="https://www.flaticon.com/free-icon/add_992651" title="dmitri13">dmitri13</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
<div>Icons made by <a href="https://www.flaticon.com/authors/pixel-perfect" title="Pixel perfect">Pixel perfect</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>



</body>
</html>

