<?php
	include("DBConnect.php");
	$profId=$_SESSION['profId'];

	$sql = "SELECT className,subj,division FROM class WHERE profId='$profId' AND className='$className' AND division='$classDiv' ";
	$result = mysqli_query($con, $sql);
	$classNameArray = array();
	$divArray = array();
	$subjArray = array();
	
	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
        {
        	array_push($classNameArray,$row["className"]);
        	array_push($divArray,$row["division"]);
        	array_push($subjArray,$row["subj"]);
		}
	}
	else
	{
		echo "0 results";
	}
?>