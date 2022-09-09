<?php
session_start();
include_once('DBConnect.php');
$stds_id=array();

$teacherName=$_SESSION['profUsername'];
$profId=$_SESSION['profId'];
$tableNameStd=$_SESSION['profId']."_students";
$tableNameCal=$_SESSION['profId']."_calender";
$className=$_GET['className'];
$classDiv=$_GET['division'];
include_once("take_attendance_search_field_creation_page.php");
		
// Get classId
if (!isset($_POST['presenteeSaveBtn']))
{
    $classSubject=$_POST['subjSearch'];

    $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND subj='$classSubject' AND profId='$profId' ";
    $classIdRes=mysqli_query($con,$classIdSql);
    if(mysqli_num_rows($classIdRes))
    {
        while($row = mysqli_fetch_assoc($classIdRes))
        {
            $classId=(int)$row['id'];
        }
        $subSql = "SELECT * FROM $tableNameStd WHERE stdClassId='$classId'  ORDER BY stdRoll ";
        $subSqlRes=mysqli_query($con,$subSql);

    }
    else
    {
        echo "<script>alert('You have no such class');window.location='newhomepage.php';</script>";
    }
}

// Get classId end.

if (isset($_POST['presenteeSaveBtn']))
{

	if(!empty($_POST['attendenceDate']))
	{
		$date=$_POST['attendenceDate'];
		$classSubject=$_POST['hiddenSubject'];

        // Get classId
            $classIdSql = "SELECT * FROM class WHERE className='$className' AND division='$classDiv' AND subj='$classSubject' AND profId='$profId' ";
            $classIdRes=mysqli_query($con,$classIdSql);
            if(mysqli_num_rows($classIdRes))
            {
                while($row = mysqli_fetch_assoc($classIdRes))
                {
                    $classId=(int)$row['id'];
                }
                $subSql = "SELECT * FROM $tableNameStd WHERE stdClassId='$classId'  ORDER BY stdRoll ";
                $subSqlRes=mysqli_query($con,$subSql);

            }
        // Get classId end.

	    // Checking if attendence of this class with this subject is already taken or not.
	    $get = "SELECT * FROM $tableNameCal WHERE dates='$date' AND stdClassId='$classId' ";
	    $gotDate=mysqli_query($con,$get);

	    if (mysqli_num_rows($gotDate) > 0)
	    {
	        echo "<script>alert('You have already taken attendence on this date. Do you want to change it.');</script>";
	        unset($_POST['take']);

	    }
	    else
	    {
    		$stds_id=$_SESSION['stdIdArray'];            

		    // Inserting date into teachers calender table and geting last id of date.
		    $ins = "INSERT INTO $tableNameCal (dates,stdClassId,present_std_ids) VALUES ('$date','$classId','')";

		    // Getting last inserted date id.
		    if (mysqli_query($con, $ins))
		    {
		        
		        $date_id= mysqli_insert_id($con);
		        echo "Inserted date of $tableNameCal at date id ".$date_id." with subject $classSubject";
		    }
		    else
		    {
		        echo "Error: ".$ins."<br>". mysqli_error($con);
		    }


		    // Geting all present student id's in presentStdIds array from input field of html table.
		    $presentStdIds=array();
		    $pres_abs_inputs=$_POST['presenteeValue'];
		    $i=0;

		    foreach ($pres_abs_inputs as $present_sir)
		    {
		        if($present_sir==='P')
		        {
		            array_push($presentStdIds,"$stds_id[$i]");
		        }
		        $i=$i+1;
		    }

		    // Check if we got some id's in presentStdIds array and if yes then update date present_std_ids field in database.
		    if(count($presentStdIds)>0)
		    {
		        // Split presentStdIds array into comma seperated text.
		        $final_present_ids_string = implode(',', $presentStdIds);

		        // Update present_std_ids field of teacher calender table at date_id row
		        $upd = "UPDATE $tableNameCal SET present_std_ids='$final_present_ids_string' WHERE id=$date_id";

		        // Fill present_date_ids field of username_students table.
		        foreach ($presentStdIds as $selectedId)
		        {
		            $sql2 = "SELECT * FROM $tableNameStd WHERE id='$selectedId' ORDER BY stdRoll ";
		            $result2=mysqli_query($con,$sql2);

		            if (mysqli_num_rows($result2) > 0)
		            {
		                while($row2 = mysqli_fetch_assoc($result2))
		                {
		                    $str_arr = explode(",",$row2["present_date_ids"]);
		                    array_push($str_arr,"$date_id");
		                    sort($str_arr);
		                    $commaText = implode(',', $str_arr);
		                    $upd2 = "UPDATE $tableNameStd SET present_date_ids='$commaText' WHERE id=$selectedId";
		                    if (!mysqli_query($con, $upd2))
		                        //echo "<script>alert('updated succesfully inside username_students table');</script>";
								echo "Error updating record: " . mysqli_error($con);  
		                    // else
		                    //     echo "Error updating record: " . mysqli_error($con);          
		                }
		            }
		            else
		                echo "0 results";
		        }
		        //filling inside username_std table done.


		        if (mysqli_query($con, $upd))
		        {
		            echo "<script>alert('Everything updated succesfully');window.location='go_to_class2.php?className=$className&division=$classDiv';</script>";
		            // Unset all unnecessary variables.
		            unset($_SESSION['subject']);
		            unset($_SESSION['date']);
		        }
		        else
		        {
		            echo "Error updating record: " . mysqli_error($con);
		        }                
		    }
		    else
		    {
		        echo "<script>alert('Everything updated succesfully');</script>";
		    }	
	    }	
	}
	else
		echo "Date field cannot be empty";
}


// Fill present date ids field of username_students table
function upd_tableNameStd_present_date_ids($date_id,$presentStdIds,$tableNameStd)
{
    foreach ($presentStdIds as $selectedId)
    {
        include_once('DBConnect.php');
        $sql = "SELECT * FROM $tableNameStd WHERE id='$selectedId' ORDER BY stdRoll ";
        $result=mysqli_query($con,$sql);

        if (mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $str_arr = explode(",",$row["present_date_ids"]);
                array_push($str_arr,"$date_id");
                $commaText = implode(',', $str_arr);
                $upd = "UPDATE $tableNameStd SET present_date_ids='$commaText' WHERE id=$selectedId";
                if (mysqli_query($con, $upd))
                    echo "<script>alert('updated succesfully inside username_students table');</script>";
                else
                    echo "Error updating record: " . mysqli_error($con);            
            }
        }
        else
            echo "0 results";
    }
}


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
</head>
<body>
    
</style>
<script type="text/javascript" src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="DataTables/Bootstrap-4-4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="DataTables/ColReorder-1.5.2/js/dataTables.colReorder.min.js"></script>


<div class="navDiv">
<nav class="navbar navbar-expand-lg navbar-light shadow" style="background-color:white;color:black;position:fixed;top: 0;width:100%;z-index:2;">
<a class="hamb mr-auto nav-link btn-sm" href="#" onclick="on()"><img class="hambImg" src="img/bar-icon.png" style="height:5vh;width:9vw;"/></a>
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
	<div class="colm-9" style="display:flex;flex-direction:column;justify-content:center;font-size:0.9rem;">
		<div>
			<h5 style="text-align:center;color:grey;font-weight:900;"><?php echo "$className, Division $classDiv, Subject $classSubject";?></h5>
		</div>
		<div class="card-body shadow">
			<form action="" method="post" accept-charset="utf-8" style="overflow-x: scroll;">
			    <table class="table">
			    	<thead style="background-color:#666666;color:white;">
			    		<tr style="text-align:center;">
			    			<th scope="col">Roll.no</th>
			    			<th scope="col">Full Name</th>
			    			<th scope="col" style="white-space:nowrap;">P / A</th>
			    		</tr>
			    	</thead>
		    	   	<tbody>    		
						<?php
						if(mysqli_num_rows($subSqlRes))
						{
							while($row = mysqli_fetch_assoc($subSqlRes))
							{
						?>
		    				<tr style="text-align:center;">
				    			<td style="width:15%;"><?php echo $row["stdRoll"];?></td>
				    			<td style="width:70%;"><?php echo $row["stdName"];?></td>
				    			<td style="width:15%;"><input onkeypress="return ISpORa(event)" id="presentee" type="text" name="presenteeValue[]" style="width:100%;text-align: center;border:0;outline:0;display:inline-block;color:green;" value="P"></td>
				    		</tr>
			            <?php
                    		$ids=$row["id"];
                    		array_push($stds_id,"$ids");
                			}
                			$_SESSION['stdIdArray']=$stds_id;
                		}
                		else
                			echo "<script>alert('No such subject');window.location='go_to_class2.php?className=$className&division=$classDiv';</script>".mysqli_error($con);
                		?>
		    	   	</tbody>
		        </table>
		        <div class="row">
		        	<div class="col-9">
						<input type="date" class="calendar form-control" name="attendenceDate" style="border-radius: 25px;border:1px solid grey;outline:0;" required=""><br>		
		        	</div>
		        	<div class="col-3">
				        <input type="text" name="hiddenSubject" value="<?php echo $classSubject;?>" style="display:none;">
				        <button type="submit" class="btn btn-info" name="presenteeSaveBtn" style="margin-left:15%;width:70%;">Save</button>	
		        	</div>
				</div>
		    </form>

		</div>
	</div>
    <div class="colm-3 forAdds">
        
    </div>
</div>     	

<script>

    // Initial first link highlight
        $("#takeAttDivDesk").css("background-color","white");
        $("#takeAttDivDesk").css("color","grey");
        $("#takeAttDivDesk").data('clicked', true);

        $("#takeAttDivMob").css("background-color","white");
        $("#takeAttDivMob").css("color","grey");
        $("#takeAttDivMob").data('clicked', true);
    // Initial first link highlight

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
                if(($(this).data("clicked")))
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
            else if($(this).attr("id")=="testDivDesk")
            {
                $(".takeAttSubMenuDesk").slideUp(400);//testDivDesk
                $(".viewAttSubMenuDesk").slideUp(400);
                if($(this).data("clicked"))
                {
                    $("#testDivDesk").css("background-color","white");
                    $("#testDivDesk").css("color","grey");
                    $("#testDivDesk").data('clicked', true);
                    window.location="test_details.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>";
                }
            }
        });

        $(".DeskEachLink").hover(function(){if($(this).data("clicked"));else $(this).css("background-color","#7ea6f7");},function(){if($(this).data("clicked"));else $(this).css("background-color","#487ae0");})

    // Highlight clicked links end

</script>
<script type="text/javascript">
    	
        var colms = document.querySelectorAll("#presentee");

        // Function to prevent user to write anything inside the present absent box on their own.
        function ISpORa(evt)
        {
                return false;
        }
  
        function changeMarker()
    	{
    		if(this.value==='A')
    		{
    			this.value='P';
    			this.style.color = "green";
    		}
    		else if(this.value==='P')
    		{
    			this.value='A';
    			this.style.color = "red";
    		}
    		else
    		{
    			this.value='P';
    			this.style.color="green";
    		}
    		// else
    		// {
    		// 	this.value='';
    		// 	this.style.color = "grey";
    		// }
    	}

    	for(var i=0; i < colms.length ;i++)
    	{
    		colms[i].addEventListener('click',changeMarker);
    	}

    </script>


</script>
</body>
</html>
