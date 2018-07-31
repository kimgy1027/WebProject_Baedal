<?php
session_start();
?>

<?php 

include "../common_lib/common.php";         // dbconn.php 파일을 불러옴
$page=$_GET['page'];
$owner_id=$_GET['owner_id'];
$owner_num=$_GET['owner_num'];
/* $pass=$_POST['new_pass']; */

$sql="update store_regi set regi_ok='Y' where no='$owner_num' order by regi_ok desc"; 
/* $sql="update find set pass='$new_pass'"; */

$result=mysqli_query($con, $sql) or die("에러: " . mysqli_error($con));



mysqli_close($con);
echo"<script>location.href='./list.php';</script>";
?>