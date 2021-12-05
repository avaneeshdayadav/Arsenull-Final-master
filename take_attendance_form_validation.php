<?php
    session_start();
    include_once('DBConnect.php');

    $stds_id=array();

	if (isset($_POST['attendSubmitBtn']))
	{
    // Working with data from previous page and setting required variables.
        $_SESSION['className']=$className=$_POST['classnameSearch'];
		$_SESSION['division']=$classDiv=$_POST['divSearch'];
		$_SESSION['subject']=$classSubject=$_POST['subjSearch'];
		$_SESSION['date']=$date=$_POST['attendenceDate'];
		$username=$_SESSION['profUsername'];
		$_SESSION['tableNameStd']=$tableNameStd=$username."_students";
        $_SESSION['tableNameCal']=$tableNameCal=$username."_calender";

		$sql = "SELECT * FROM $tableNameStd WHERE stdClassName='$className' AND stdDiv='$classDiv' AND subj='$classSubject' ORDER BY stdRoll ";
		$result=mysqli_query($con,$sql);

		if (mysqli_num_rows($result) > 0)
			;
		else
			echo "<script>alert('You have no such class');window.location='teachers_tool.php';</script>";
    // End of working on previous page's data.

    // Checking if attendence of this class with this subject is already taken or not.
        $get = "SELECT * FROM $tableNameCal WHERE dates='$date' AND className='$className' AND classDiv='$classDiv' AND classSubj='$classSubject' ";
        $gotDate=mysqli_query($con,$get);

        if (mysqli_num_rows($gotDate) > 0)
        {
            echo "<script>alert('You have already taken attendence on this date. Do you want to change it.');window.location='teachers_tool.php';</script>";

        }

        else
            $_SESSION['flag']=1;
    //checking finished.

    }

    if ($_SESSION['flag'])
    {
        // Working on this page's data
        if (isset($_POST['presenteeSaveBtn']))
        {
            $date=$_SESSION['date'];
            $stds_id=$_SESSION['stdIdArray'];
            print_r($stds_id);
            $tableNameCal=$_SESSION['tableNameCal'];
            $className=$_SESSION['className'];
            $classDiv=$_SESSION['division'];
            $classSubject=$_SESSION['subject'];
            $tableNameStd=$_SESSION['tableNameStd'];
            

            // Inserting date into teachers calender table and geting last id of date.
            $ins = "INSERT INTO $tableNameCal (id,dates,className,classDiv,classSubj,present_std_ids) VALUES (NULL,'$date','$className','$classDiv','$classSubject','')";

            // Getting last inserted date id.
            if (mysqli_query($con, $ins))
            {
                
                $date_id= mysqli_insert_id($con);
                echo "Inserted date of attendence at date id ".$date_id;
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
                            if (mysqli_query($con, $upd2))
                                echo "<script>alert('updated succesfully inside username_students table');</script>";
                            else
                                echo "Error updating record: " . mysqli_error($con);            
                        }
                    }
                    else
                        echo "0 results";
                }
                //filling inside username_std table done.


                if (mysqli_query($con, $upd))
                {
                    echo "<script>alert('Everything updated succesfully');window.location='teachers_tool.php';</script>";
                    // Unset all unnecessary variables.
                    unset($_SESSION['division']);
                    unset($_SESSION['subject']);
                    unset($_SESSION['date']);
                    unset($_SESSION['tableNameStd']);
                    unset($_SESSION['tableNameCal']);
                    unset($_SESSION['className']);                }
                else
                {
                    echo "Error updating record: " . mysqli_error($con);
                }                
            }
            else
            {
                echo "<script>alert('Everything updated succesfully');window.location='teachers_tool.php';</script>";
            }
        }
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


    <div class="container">
    <h4 style="text-align:center;margin-top:1%;"><span style="background-color:white;"><span class="shadow" style="background-color:white;">&nbsp Attendence</span><span class="shadow" style="color:white;background-color:#008ef2;">Marker &nbsp</span></span></h4>
    <p></p><p></p>

<form action="take_attendance_form_validation.php" method="post" accept-charset="utf-8">
    <table class="table">
    	<thead class="thead-dark">
    		<tr style="text-align:center">
    			<th scope="col">Roll.no</th>
    			<th scope="col">Full Name</th>
    			<th scope="col">Present / Absent</th>
    		</tr>
    	</thead>
    	   <tbody>    		
    			<?php while($row = mysqli_fetch_assoc($result))
    				{
    			?>
    				<tr style="text-align:center;">
		    			<td style="color:black;border: 1px solid grey;width:15%;"><?php echo $row["stdRoll"];?></td>
		    			<td style="border: 1px solid grey;width:70%;"><?php echo $row["stdName"];?></td>
		    			<td style="border: 1px solid grey;width:15%;"><input onkeypress="return ISpORa(event)" id="presentee" type="text" name="presenteeValue[]" style="width:100%;text-align: center;border:0;outline:0;display:inline-block;color:green;" value="P"></td>
		    		</tr>
            		<?php
                        $ids=$row["id"];
                        array_push($stds_id,"$ids");
                    }
                    $_SESSION['stdIdArray']=$stds_id;
                    ?>
    	   </tbody>
        </table>
        <button type="submit" class="btn btn-info" name="presenteeSaveBtn" style="margin-left:15%;width:70%;">Save</button>
    </form>


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
</div>
</body>
</html>
