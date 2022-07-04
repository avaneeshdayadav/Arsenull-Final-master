<?php
include_once('DBConnect.php');

$profId=$_POST['prof'];
$count=0;

$sql="SELECT * FROM invite_notification WHERE  receiver_id ='$profId ' AND status=0 ";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0)
{
	while($row=mysqli_fetch_assoc($res))
	{
		$count++;
	}
}
echo "$count";

?>