<?php

session_start();
include_once('DBConnect.php');

$profId=$_SESSION['profId'];
$inpType=$_POST['inpType'];
$testId=$_POST['testId'];
$secTableName=$profId."_test_sections";
$qnTableName=$profId."_test_qns";
$optTableName=$profId."_test_opts";
$secNo = $_POST['secNo'];

if($inpType=="U")
{
	$unitName = $_POST['unitName'];
	$updSql = "UPDATE $secTableName SET unitName='$unitName' WHERE testId='$testId' AND secNo='$secNo' ";
	mysqli_query($con,$updSql);

}
elseif($inpType=="NQA")
{
	$cumpNoOfQn = $_POST['cumpNoOfQn'];
	$updSql = "UPDATE $secTableName SET cumpNoOfQn='$cumpNoOfQn' WHERE testId='$testId' AND secNo='$secNo' ";
	mysqli_query($con,$updSql);

}
elseif($inpType=="Q")
{
    $qnNo = $_POST['qnNo'];
    $question = $_POST['question'];
    
    // Get Section Id.
    $secIdSql = "SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
    $secIdRes = mysqli_query($con,$secIdSql);
    if(mysqli_num_rows($secIdRes))
    {
        while($row=mysqli_fetch_assoc($secIdRes))
        {
            $secId=$row['id'];
        }
    
    }
    // Get Section Id end.

	$updSql = "UPDATE $qnTableName SET question='$question' WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' ";
	mysqli_query($con,$updSql);

}
elseif($inpType=="O")
{
    $qnNo = $_POST['qnNo'];
    $optNo = $_POST['optNo'];    
    $optInp = $_POST['optInp'];
    
    // Get Section Id.
        $secIdSql = "SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
        $secIdRes = mysqli_query($con,$secIdSql);
        if(mysqli_num_rows($secIdRes))
        {
            while($row=mysqli_fetch_assoc($secIdRes))
            {
                $secId=$row['id'];
            }
        
        }
    // Get Section Id end.

    // Get Qn Id.
        $qnIdSql = "SELECT id FROM $qnTableName WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' " ;
        $qnIdRes = mysqli_query($con,$qnIdSql);
        if(mysqli_num_rows($qnIdRes))
        {
            while($row=mysqli_fetch_assoc($qnIdRes))
            {
                $qnId=$row['id'];
            }
        
        }
    // Get Qn Id end.

	$updSql = "UPDATE $optTableName SET optInp='$optInp' WHERE testId='$testId' AND qnId='$qnId' AND optNo='$optNo' ";
	mysqli_query($con,$updSql);

}
elseif($inpType=="CM")
{
    $correctFlag = $_POST['correctFlag'];
    $qnNo = $_POST['qnNo'];
    $optNo = $_POST['optNo'];    

    // Get Section Id.
        $secIdSql = "SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
        $secIdRes = mysqli_query($con,$secIdSql);
        if(mysqli_num_rows($secIdRes))
        {
            while($row=mysqli_fetch_assoc($secIdRes))
            {
                $secId=$row['id'];
            }
        
        }
    // Get Section Id end.

    // Get Qn Id.
        $qnIdSql = "SELECT id FROM $qnTableName WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' " ;
        $qnIdRes = mysqli_query($con,$qnIdSql);
        if(mysqli_num_rows($qnIdRes))
        {
            while($row=mysqli_fetch_assoc($qnIdRes))
            {
                $qnId=$row['id'];
            }
        
        }
    // Get Qn Id end.

	$updSql = "UPDATE $optTableName SET correctFlag='$correctFlag' WHERE testId='$testId' AND qnId='$qnId' AND optNo='$optNo' ";
	mysqli_query($con,$updSql);

}
elseif($inpType=="QI")
{
    $qnNo = $_POST['qnNo'];
    $qnImgInp=$_FILES["qnImgInp"]["tmp_name"];
    $target_dir="user_imgs/".$profId;

    // Get Section Id.
        $secIdSql = "SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
        $secIdRes = mysqli_query($con,$secIdSql);
        if(mysqli_num_rows($secIdRes))
        {
            while($row=mysqli_fetch_assoc($secIdRes))
            {
                $secId=$row['id'];
            }
        
        }
    // Get Section Id end.

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
                            $newQnImgInp=rename_names($testId,$secNo,$qno,"QI");
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


    // Function that renames actual file names.
    function rename_names($testId,$secNo,$qno,$alphabet)
    {
        if($alphabet=="QI")
        {
            $oldNameWithExt=$_FILES['qnImgInp']['name'];
            $oldName=explode('.',$oldNameWithExt)[0];
            $ext=explode('.',$oldNameWithExt)[1];
            $newName=$oldName."_".$testId."_secNO".$secNo."_qno".$qno.".".$ext;
            return $newName;
        }
    }
    // Function that renames actual file names end.

    // Database Table.
        $updSql = "UPDATE $qnTableName SET qnImg='$newQnImgInp' WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' ";
        mysqli_query($con,$updSql);
    // Database Table end.


}


?>