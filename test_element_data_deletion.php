<?php

session_start();
include_once('DBConnect.php');

$testId=$_POST['testId'];
$inpType=$_POST['inpType'];
$profId=$_SESSION['profId'];
$secNo=(int)$_POST['secNo'];

$secTableName=$profId."_test_sections";
$qnTableName=$profId.'_test_qns';
$optTableName=$profId.'_test_opts';


$secNoSql="SELECT id FROM $secTableName WHERE testId='$testId' AND secNo='$secNo' " ;
$secNoRes=mysqli_query($con,$secNoSql);
if(mysqli_num_rows($secNoRes))
{
	while($row=mysqli_fetch_assoc($secNoRes))
	{
		$secId=$row['id'];
	}
}


if($inpType=='O')
{
    $optNo=$_POST['optNo'];
    $qnNo=$_POST['qnNo'];

    // Get qnId from qntable.
        $qnIdSql="SELECT id FROM $qnTableName WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' " ;

        $qnIdRes=mysqli_query($con,$qnIdSql);
        if(mysqli_num_rows($qnIdRes))
        {
            while($row=mysqli_fetch_assoc($qnIdRes))
            {
                $qnId=$row['id'];
            }
        }
    // Get qnId from qntable end.

    
    // Delete the option.
        $delOptSql = "DELETE FROM $optTableName WHERE testId='$testId' AND qnId='$qnId' AND optNo='$optNo' ";

        if(mysqli_query($con, $delOptSql))
        {
            ;
        }
        else
        {
            echo "Error deleting option no $optNo : " . mysqli_error($con);
        }
    // Delete the option end.

    // Select and update all other options.
        $selOptSql="SELECT * FROM $optTableName WHERE testId='$testId' AND qnId='$qnId' " ;
        $selOptRes=mysqli_query($con, $selOptSql);
        if(mysqli_num_rows($selOptRes))
        {
            while($row=mysqli_fetch_assoc($selOptRes))
            {
                if($row['optNo']>$optNo)
                {
                    $newOptNo=$row['optNo']-1;
                    $optId=$row['id'];
                    $updOptSql="UPDATE $optTableName SET optNo='$newOptNo' WHERE id='$optId' ";
                    if(mysqli_query($con, $updOptSql));
                    else echo "Error updating other options $updOptSql : " . mysqli_error($con);
                }
            }
        }
        else
        {
            echo "Error selecting other options $selOptSql : " . mysqli_error($con);
        }
    // Select and update all other options end.

}

if($inpType=='Q')
{
    $qnNo=$_POST['qnNo'];
    $qnTableName=$profId.'_test_qns';

    // Get qnId from qntable.
        $qnIdSql="SELECT id FROM $qnTableName WHERE testId='$testId' AND secId='$secId' AND qnNo='$qnNo' " ;

        $qnIdRes=mysqli_query($con,$qnIdSql);
        if(mysqli_num_rows($qnIdRes))
        {
            while($row=mysqli_fetch_assoc($qnIdRes))
            {
                $qnId=$row['id'];
            }
        }
    // Get qnId from qntable end.


    // Delete all options of this qn.
        $delOptSql = "DELETE FROM $optTableName WHERE testId='$testId' AND qnId='$qnId'  ";
        if(mysqli_query($con, $delOptSql))
        {
            ;
        }
        else
        {
            echo "Error deleting options of question number $qnNo : " . mysqli_error($con);
        }
    // Delete all options of this qn end.


    // Delete question.
        $delQnSql = "DELETE FROM $qnTableName WHERE testId='$testId' AND id='$qnId'  ";
        if(mysqli_query($con, $delQnSql))
        {
            ;
        }
        else
        {
            echo "Error deleting question number $qnNo : " . mysqli_error($con);
        }
    // Delete question end.

    // Select and update all other questions.
        $selQnSql="SELECT * FROM $qnTableName WHERE testId='$testId' AND secId='$secId' " ;
        $selQnRes=mysqli_query($con, $selQnSql);
        if(mysqli_num_rows($selQnRes))
        {
            while($row=mysqli_fetch_assoc($selQnRes))
            {
                if($row['qnNo']>$qnNo)
                {
                    $newQnNo=$row['qnNo']-1;
                    $qnId=$row['id'];
                    $updQnSql="UPDATE $qnTableName SET qnNo='$newQnNo' WHERE id='$qnId' ";
                    if(mysqli_query($con, $updQnSql));
                    else echo "Error updating other options $updQnSql : " . mysqli_error($con);
                }
            }
        }
        else
        {
            echo "Error selecting other options $selQnSql : " . mysqli_error($con);
        }
    // Select and update all other questions end.
    
}


?>