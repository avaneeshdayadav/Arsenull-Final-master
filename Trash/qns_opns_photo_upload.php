<?php


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


// Upload Qn image.
	if(getimagesize($_FILES["qnImgInp"]["tmp_name"]) !==false)
	{
			$location = $target_dir.'/'.$_FILES["qnImgInp"]["name"];
			/* Upload file */
			   if(move_uploaded_file($_FILES['qnImgInp']['tmp_name'], $location))
			   { 
				   	// change name of uploaded image.
				   		$newQnImgInp=rename_names($testName,$secName,$qno,"Q");
						rename($location,$target_dir.'/'.$newQnImgInp);
				   	// change name of uploaded image end.
			   }
			   else
			   { 
			      echo 0; 
			   } 
		   /* Upload file end */
	}
// Upload Qn image end.


// Upload opnA image.
	if(getimagesize($_FILES["opnAImgInp"]["tmp_name"]) !==false)
	{
			$location = $target_dir.'/'.$_FILES["opnAImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opnAImgInp']['tmp_name'], $location))
			   { 
				   	// change name of uploaded image.
				   		$newopnAImgInp=rename_names($testName,$secName,$qno,"A");
						rename($location,$target_dir.'/'.$newopnAImgInp);
				   	// change name of uploaded image end.
			   }
			   else
			   { 
			      echo "OpnA Img Not Uploaded"; 
			   } 
		   /* Upload file end */
	}
	else
	{
		echo "Some Error";
	}
// Upload opnA image end.


// Upload opnB image.
	if(getimagesize($_FILES["opnBImgInp"]["tmp_name"]) !==false)
	{
			$location = $target_dir.'/'.$_FILES["opnBImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opnBImgInp']['tmp_name'], $location))
			   { 
				   	// change name of uploaded image.
				   		$newopnBImgInp=rename_names($testName,$secName,$qno,"B");
						rename($location,$target_dir.'/'.$newopnBImgInp);
				   	// change name of uploaded image end.
			   }
			   else
			   { 
			      echo "OpnB Img Not Uploaded"; 
			   } 
		   /* Upload file end */
	}
	else
	{
		echo "Some Error";
	}
// Upload opnB image end.


// Upload opnC image.
	if(getimagesize($_FILES["opnCImgInp"]["tmp_name"]) !==false)
	{
			$location = $target_dir.'/'.$_FILES["opnCImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opnCImgInp']['tmp_name'], $location))
			   { 
				   	// change name of uploaded image.
				   		$newopnCImgInp=rename_names($testName,$secName,$qno,"C");
						rename($location,$target_dir.'/'.$newopnCImgInp);
				   	// change name of uploaded image end.
			   }
			   else
			   { 
			      echo "OpnA Img Not Uploaded"; 
			   } 
		   /* Upload file end */
	}
	else
	{
		echo "Some Error";
	}
// Upload opnC image end.


// Upload opnD image.
	if(getimagesize($_FILES["opnDImgInp"]["tmp_name"]) !==false)
	{
			$location = $target_dir.'/'.$_FILES["opnDImgInp"]["name"];

			/* Upload file */
			   if(move_uploaded_file($_FILES['opnDImgInp']['tmp_name'], $location))
			   { 
				   	// change name of uploaded image.
				   		$newopnDImgInp=rename_names($testName,$secName,$qno,"D");
						rename($location,$target_dir.'/'.$newopnDImgInp);
				   	// change name of uploaded image end.
			   }
			   else
			   { 
			      echo "OpnA Img Not Uploaded"; 
			   } 
		   /* Upload file end */
	}
	else
	{
		echo "Some Error";
	}
// Upload opnD image end.



// Function that renames actual file names.
	function rename_names($testName,$secName,$qno,$alphabet)
	{
		if($alphabet=="Q")
		{
			$oldNameWithExt=$_FILES['qnImgInp']['name'];
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testName."_secNO".$secName."_qno".$qno.".".$ext;
			return $newName;
			
		}
		if($alphabet=="A")
		{
			$oldNameWithExt=$_FILES['opnAImgInp']['name'];
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testName."_secNO".$secName."_qno".$qno."_opnA".".".$ext;
			return $newName;
		}
		if($alphabet=="B")
		{
			$oldNameWithExt=$_FILES['opnBImgInp']['name'];
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testName."_secNO".$secName."_qno".$qno."_opnB".".".$ext;
			return $newName;
		}
		if($alphabet=="C")
		{
			$oldNameWithExt=$_FILES['opnCImgInp']['name'];
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testName."_secNO".$secName."_qno".$qno."_opnC".".".$ext;
			return $newName;
		}
		if($alphabet=="D")
		{
			$oldNameWithExt=$_FILES['opnDImgInp']['name'];
			$oldName=explode('.',$oldNameWithExt)[0];
			$ext=explode('.',$oldNameWithExt)[1];
			$newName=$oldName."_".$testName."_secNO".$secName."_qno".$qno."_opnD".".".$ext;
			return $newName;
		}
	}
// Function that renames actual file names end.

?>