<?php

session_start();
include_once('DBConnect.php');

$profId=$_SESSION['profId'];
$tableName=$profId."_test_individiual_qns";
$inpType=$_POST['inpType'];
$secIdentityNo=(int)$_POST['secIdentityNo'];
$testId=$_POST['testId'];
$classId=$_POST['classId'];

// Check if this qn and sec with this testid already present.
if($inpType!="U" && $inpType!="NQA" )
{
	$qnIdentityNo=(int)$_POST['qnIdentityNo'];

	$checkSql = "SELECT * FROM $tableName WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' " ;
	$checkRes = mysqli_query($con, $checkSql);

	if(mysqli_num_rows($checkRes)>0)
	{
		$isThereFlag=1;
	}
	else
	{
		$isThereFlag=0;
	}
}
else
{
	// We don't need qnIdentityNo while updating or inserting UnitName and noOfCumpQn so seperate sql.
	$checkSql = "SELECT * FROM $tableName WHERE testId='$testId' AND secIdentityNo='$secIdentityNo' " ;
	$checkRes = mysqli_query($con, $checkSql);

	if(mysqli_num_rows($checkRes)>0)
	{
		$isThereFlag=1;
	}
	else
	{
		$isThereFlag=0;
	}	
}
// Check if this qn and sec with this testid already present end.



if($inpType=="Q")
{
	$qnInpVal=$_POST['qnInpVal'];
	$unitName=$_POST['unitName'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET question='$qnInpVal' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);
	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,question,qnIdentityNo,secIdentityNo) VALUES('$testId', '$unitName','$qnInpVal','$qnIdentityNo','$secIdentityNo')");
	}
}
elseif($inpType=="opa")
{
	$opaVal=$_POST['opaVal'];
	$unitName=$_POST['unitName'];

	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET opa='$opaVal' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,opa,qnIdentityNo,secIdentityNo) VALUES('$testId', '$unitName', '$opaVal','$qnIdentityNo','$secIdentityNo')");
	}
}
elseif($inpType=="opb")
{
	$opbVal=$_POST['opbVal'];
	$unitName=$_POST['unitName'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET opb='$opbVal' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,opb,qnIdentityNo,secIdentityNo) VALUES('$testId','$unitName' ,'$opbVal','$qnIdentityNo','$secIdentityNo')");
	}
}
elseif($inpType=="opc")
{
	$opcVal=$_POST['opcVal'];
	$unitName=$_POST['unitName'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET opc='$opcVal' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,opc,qnIdentityNo,secIdentityNo) VALUES('$testId','$unitName' ,'$opcVal','$qnIdentityNo','$secIdentityNo')");
	}
}
elseif($inpType=="opd")
{
	$opdVal=$_POST['opdVal'];
	$unitName=$_POST['unitName'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET opd='$opdVal' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,opd,qnIdentityNo,secIdentityNo) VALUES('$testId','$unitName' ,'$opdVal','$qnIdentityNo','$secIdentityNo')");
	}
}
elseif($inpType=="U")
{
	$unitName=$_POST['unitName'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET unit='$unitName' WHERE testId='$testId' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}

}
elseif($inpType=="NQA")
{
	$noOfQnToAsk=(int)$_POST['noOfQnToAsk'];
	if($isThereFlag==1)
	{
		$updSql = "UPDATE $tableName SET noOfcumplQn ='$noOfQnToAsk' WHERE testId='$testId' AND secIdentityNo='$secIdentityNo' ";
		mysqli_query($con,$updSql);

	}
	elseif($isThereFlag==0)
	{
		$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,noOfcumplQn,secIdentityNo) VALUES('$testId','$noOfQnToAsk','$secIdentityNo')");
	}	

}
elseif($inpType=="qnImgFile")
{
	$qnImgInp=$_FILES["qnImgInp"]["name"];
	$unitName=$_POST['unitName'];
	$target_dir="user_imgs/".$profId;

	// Check if username directory exists if not then create it.
		if(is_dir($target_dir))
		{
		  ;
		} else
		{
			mkdir($target_dir);
			chmod($target_dir,0777);
		}
	// Check if username directory exists if not then create it end.

	// Upload Qn image on server.
		if(getimagesize($_FILES["qnImgInp"]["tmp_name"]) !==false)
		{
			$location = $target_dir.'/'.$_FILES["qnImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['qnImgInp']['tmp_name'], $location))
			   {
			   	// change name of uploaded image.
			   		$newQnImgInp=rename_names($qnImgInp,$testId,$secIdentityNo,$qnIdentityNo,"Q");
					rename($location,$target_dir.'/'.$newQnImgInp);
				// change name of uploaded image end.

			   	echo $newQnImgInp;
			   }
			   else
			   { 
			      echo "Error Uploading Image"; 
			   } 
		   /* Upload file end */
		}
	// Upload Qn image on server end.

	// Database Upload
		if($isThereFlag==1)
		{
			// Get old img name for deletion from server.
			while($row=mysqli_fetch_assoc($checkRes))
			{
				$oldQnImgData=$row['qnImg'];
			}

			$updSql = "UPDATE $tableName SET qnImg ='$newQnImgInp' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
			mysqli_query($con,$updSql);

		    // Delete previous image for same qn and sec if data is being updated.
		    unlink($target_dir.'/'.$oldQnImgData);

		}
		elseif($isThereFlag==0)
		{
			$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,qnImg,qnIdentityNo,secIdentityNo) VALUES('$testId', '$unitName', '$newQnImgInp','$qnIdentityNo','$secIdentityNo')");
		}	
	// Database Upload
}
elseif($inpType=="opAImgFile")
{
	$opAImgInp=$_FILES["opAImgInp"]["name"];
	$unitName=$_POST['unitName'];
	$target_dir="user_imgs/".$profId;

	// Check if username directory exists if not then create it.
		if(is_dir($target_dir))
		{
		  ;
		} else
		{
			mkdir($target_dir);
			chmod($target_dir,0777);
		}
	// Check if username directory exists if not then create it end.

	// Upload Qn image on server.
		if(getimagesize($_FILES["opAImgInp"]["tmp_name"]) !==false)
		{
			$location = $target_dir.'/'.$_FILES["opAImgInp"]["name"];

			if($isThereFlag==1)
			{
				
			}

			/* Upload file */
			   if(move_uploaded_file($_FILES['opAImgInp']['tmp_name'], $location))
			   {

			   	// change name of uploaded image.
			   		$newopnAImgInp=rename_names($opAImgInp,$testId,$secIdentityNo,$qnIdentityNo,"A");
					rename($location,$target_dir.'/'.$newopnAImgInp);
				// change name of uploaded image end.

			   	echo $newopnAImgInp;
			   }
			   else
			   { 
			      echo "Error Uploading Option A Image"; 
			   } 
		   /* Upload file end */
		}
	// Upload Qn image on server end.

	// Database Upload
		if($isThereFlag==1)
		{
			// Get old img name for deletion from server.
			while($row=mysqli_fetch_assoc($checkRes))
			{
				$oldOpAImgData=$row['opa_img'];
			}

			$updSql = "UPDATE $tableName SET opa_img ='$newopnAImgInp' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
			mysqli_query($con,$updSql);

		    // Delete previous image for same qn and sec if data is being updated.
			unlink($target_dir.'/'.$oldOpAImgData);

		}
		elseif($isThereFlag==0)
		{
			$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,unit,opa_img,qnIdentityNo,secIdentityNo) VALUES('$testId','$unitName', '$newopnAImgInp','$qnIdentityNo','$secIdentityNo')");
		}	
	// Database Upload

}
elseif($inpType=="opBImgFile")
{
	$opBImgInp=$_FILES["opBImgInp"]["name"];
	$target_dir="user_imgs/".$profId;

	// Check if username directory exists if not then create it.
		if(is_dir($target_dir))
		{
		  ;
		} else
		{
			mkdir($target_dir);
			chmod($target_dir,0777);
		}
	// Check if username directory exists if not then create it end.

	// Upload Qn image on server.
		if(getimagesize($_FILES["opBImgInp"]["tmp_name"]) !==false)
		{
			$location = $target_dir.'/'.$_FILES["opBImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opBImgInp']['tmp_name'], $location))
			   {
			   	// change name of uploaded image.
			   		$newopnBImgInp=rename_names($opBImgInp,$testId,$secIdentityNo,$qnIdentityNo,"B");
					rename($location,$target_dir.'/'.$newopnBImgInp);
				// change name of uploaded image end.

			   	echo $newopnBImgInp;
			   }
			   else
			   { 
			      echo "Error Uploading Option B Image";
			   } 
		   /* Upload file end */
		}
	// Upload Qn image on server end.

	// Database Upload
		if($isThereFlag==1)
		{
			// Get old img name for deletion from server.
			while($row=mysqli_fetch_assoc($checkRes))
			{
				$oldOpBImgData=$row['opb_img'];
			}

			$updSql = "UPDATE $tableName SET opb_img ='$newopnBImgInp' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
			mysqli_query($con,$updSql);

		    // Delete previous image for same qn and sec if data is being updated.
			unlink($target_dir.'/'.$oldOpBImgData);

		}
		elseif($isThereFlag==0)
		{
			$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,opb_img,qnIdentityNo,secIdentityNo) VALUES('$testId','$newopnBImgInp','$qnIdentityNo','$secIdentityNo')");
		}	
	// Database Upload

}
elseif($inpType=="opCImgFile")
{
	$opCImgInp=$_FILES["opCImgInp"]["name"];
	$target_dir="user_imgs/".$profId;

	// Check if username directory exists if not then create it.
		if(is_dir($target_dir))
		{
		  ;
		} else
		{
			mkdir($target_dir);
			chmod($target_dir,0777);
		}
	// Check if username directory exists if not then create it end.

	// Upload Qn image on server.
		if(getimagesize($_FILES["opCImgInp"]["tmp_name"]) !==false)
		{
			$location = $target_dir.'/'.$_FILES["opCImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opCImgInp']['tmp_name'], $location))
			   {
			   	// change name of uploaded image.
			   		$newopnCImgInp=rename_names($opCImgInp,$testId,$secIdentityNo,$qnIdentityNo,"C");
					rename($location,$target_dir.'/'.$newopnCImgInp);
				// change name of uploaded image end.

			   	echo $newopnCImgInp;
			   }
			   else
			   { 
			      echo "Error Uploading Option C Image"; 
			   } 
		   /* Upload file end */
		}
	// Upload Qn image on server end.

	// Database Upload
		if($isThereFlag==1)
		{
			// Get old img name for deletion from server.
			while($row=mysqli_fetch_assoc($checkRes))
			{
				$oldOpCImgData=$row['opc_img'];
			}

			$updSql = "UPDATE $tableName SET opc_img ='$newopnCImgInp' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
			mysqli_query($con,$updSql);

		    // Delete previous image from server folder for same qn and sec if data is being updated.
			unlink($target_dir.'/'.$oldOpCImgData);

		}
		elseif($isThereFlag==0)
		{
			$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,opc_img,qnIdentityNo,secIdentityNo) VALUES('$testId','$newopnCImgInp','$qnIdentityNo','$secIdentityNo')");
		}	
	// Database Upload

}
elseif($inpType=="opDImgFile")
{
	$opDImgInp=$_FILES["opDImgInp"]["name"];
	$target_dir="user_imgs/".$profId;

	// Check if username directory exists if not then create it.
		if(is_dir($target_dir))
		{
		  ;
		} else
		{
			mkdir($target_dir);
			chmod($target_dir,0777);
		}
	// Check if username directory exists if not then create it end.

	// Upload Qn image on server.
		if(getimagesize($_FILES["opDImgInp"]["tmp_name"]) !==false)
		{
			$location = $target_dir.'/'.$_FILES["opDImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opDImgInp']['tmp_name'], $location))
			   {
			   	// change name of uploaded image.
			   		$newopnDImgInp=rename_names($opDImgInp,$testId,$secIdentityNo,$qnIdentityNo,"D");
					rename($location,$target_dir.'/'.$newopnDImgInp);
				// change name of uploaded image end.

			   	echo $newopnDImgInp;
			   }
			   else
			   { 
			      echo "Error Uploading Option D Image"; 
			   } 
		   /* Upload file end */
		}
	// Upload Qn image on server end.

	// Database Upload
		if($isThereFlag==1)
		{
			// Get old img name for deletion from server.
			while($row=mysqli_fetch_assoc($checkRes))
			{
				$oldOpDImgData=$row['opd_img'];
			}

			$updSql = "UPDATE $tableName SET opd_img ='$newopnDImgInp' WHERE testId='$testId' AND qnIdentityNo='$qnIdentityNo' AND secIdentityNo='$secIdentityNo' ";
			mysqli_query($con,$updSql);

		    // Delete previous image from server folder for same qn and sec if data is being updated.
			unlink($target_dir.'/'.$oldOpDImgData);

		}
		elseif($isThereFlag==0)
		{
			$insRes= mysqli_query($con, "INSERT INTO $tableName (testId,opd_img,qnIdentityNo,secIdentityNo) VALUES('$testId','$newopnDImgInp','$qnIdentityNo','$secIdentityNo')");
		}	
	// Database Upload

}




//Function that renames actual file names.
	function rename_names($oldNameWithExt,$testId,$secIdentityNo,$qnIdentityNo,$alphabet)
	{
		if($alphabet=="Q")
		{
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testId.$secIdentityNo.$qnIdentityNo.".".$ext;
			return $newName;
			
		}
		if($alphabet=="A")
		{
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testId.$secIdentityNo.$qnIdentityNo."_0".".".$ext;
			return $newName;
		}
		if($alphabet=="B")
		{
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testId.$secIdentityNo.$qnIdentityNo."_1".".".$ext;
			return $newName;
		}
		if($alphabet=="C")
		{
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testId.$secIdentityNo.$qnIdentityNo."_2".".".$ext;
			return $newName;
		}
		if($alphabet=="D")
		{
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testId.$secIdentityNo.$qnIdentityNo."_3".".".$ext;
			return $newName;
		}
	}
//Function that renames actual file names end.

?>