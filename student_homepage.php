<?php
session_start();
$stdName=$_SESSION['stdUsername'];
$stdId=$_SESSION['stdId'];
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
<!--     <link rel="stylesheet" type="text/css" href="css/sidenav.css">
 -->
    <style type="text/css" media="screen">

    	.closeBtnDiv,.hamb{
    		display: none;
    	}

    	.deskSidenav{
            background-color:#487ae0;
            color: white;
            position:fixed;
            height:100vh;
            overflow-y:auto;
            overflow-x: hidden;
            width:16vw;
            z-index:2;
        }
		.DeskEachLink{
            color:white;
            padding:1.2vh;
            text-align: left;
            transition-duration:0.5s;
            display: flex;
            cursor:pointer;
            white-space: nowrap;
            
        }

		.sideLinks{
            transition-duration:0.5s;
        }

        .sideLinks a{
            text-decoration: none;
        }

        .transparent{
            background-color: rgba(0,0,0,0.5);
            position: fixed;
            right:0;
            top:9%;
            width:100%;
            height:100%;
            display: none;
            z-index:1;
        }
        .brand{
			font-size:1.8vw;
			padding:3%;
			margin-top:6vh;
        }
        .brandSpanText{
        	margin-left:3vw;
        }
        .textInLink{
        	margin-left:2.1vw;
        	font-size:1.3vw;
        }
        .mainContent{
            width:64.5%;
            margin-left:16%;
            padding:0.5%;
            margin-top:5%;
            z-index:0;
        }
    	@media only screen and (max-width: 800px) {
         	.closeBtnDiv,.hamb{
                display:block;
            }
            .deskSidenav{
            	width:0%;
            }
            .brand{
            	font-size:5vw;
            }
            .textInLink{
            	margin-left:6.3vw;
            	font-size:4vw;
            }
            .brandSpanText{
        		margin-left:10vw;
        	}
        	.mainContent{
                margin-left:0%;
                padding:6%;
                width:100%;
                margin-top:11%;
            }

        }


    </style>
</head>
<body>
    
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>

<div class="navDiv">
<nav class="navbar navbar-expand-lg navbar-light shadow" style="background-color:white;color:black;position:fixed;top: 0;width:100%;z-index:2;">
<a class="hamb mr-auto nav-link btn-sm" href="#" ><img class="hambImg" src="img/bar-icon.png" style="height:5vh;width:9vw;"/></a>
<a class="navbar-brand" href="#" style="position:absolute;left:45%;">
  <h4 style="margin-top:1%;"><span>Arse</span><span class="shadow" style="color:white;background-color:#008ef2;border-radius:20%;">NULL</span></h4>
</a>
<a class="ml-auto nav-link" href="#">Help<span class="sr-only"></span></a>

</nav>
</div>

<div class="deskSidenav shadow">
   <div class="sideLinks">
        <div class="row" style="">
            <div class="col-8 brand">
                <span class="brandSpanText"><b>Arse</b><b style="color:black;">NULL</b></span>
            </div>
            <div class="col-4 closeBtnDiv" style="font-size:4vh;width:100%;padding:3%;margin-top:12%;">
                <a class="btn closeBtn"><img src="img/closeIconImg.png" style="height:20px;width:20px;"/></a>
            </div>
        </div><hr>
        <div class="DeskEachLink" id="classesDiv">
            <h6 class="textInLink">Classes</h6>
        </div>
        <div class="DeskEachLink" id="testDiv">
            <h6 class="textInLink">Test Zone</h6>
        </div>  
        <div class="DeskEachLink" style="margin-top:90%;" onclick="window.location='logout.php'">
            <h6 class="textInLink"><b>Hello, <?php echo $stdName;?></b></h6>
        </div>
        <p><br></p>
    </div>
</div>


<div class="mainContent">
	<div class="row">
		<div class="col-12">
			<div class="container" style="margin-top:1.5%;">
				<span style="color:grey;">Classed Joined.<hr></span>
			</div>
		</div>
	</div>
</div>


<div class="transparent col-12"></div>

<script>
    $(document).ready(function(){

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
	  			$(".deskSidenav").css("width","16vw");
	  			$(".transparent").css("display","none");
	  		}
	  		else if (document.documentElement.clientWidth < 800 )
	  		{
	  			$(".deskSidenav").css("width","0vw");
	  		}

	  	});
	//Sidebar handling end.    

    // Initial first link highlight
        $("#classesDiv").css("background-color","white");
        $("#classesDiv").css("color","grey");
        $("#classesDiv").data('clicked', true);
    // Initial first link highlight

    // Highlight clicked links.
        $(".DeskEachLink").click(function(){
            $(".DeskEachLink").css("background-color","#487ae0");
            $(".DeskEachLink").css("color","white");
            $(".DeskEachLink").data('clicked', false);

            $(this).css("background-color","white");
            $(this).css("color","grey");
            $(this).data('clicked', true);// To give signal to hover function.

        });
    // Highlight clicked links end.


    $(".DeskEachLink").hover(function(){if($(this).data("clicked"));else $(this).css("background-color","#7ea6f7");},function(){if($(this).data("clicked"));else $(this).css("background-color","#487ae0");})


    });
</script>



</body>
</html>