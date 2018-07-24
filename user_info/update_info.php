<?php
session_start();
include "../common_lib/common.php";

$nick=$_POST['nick'];
$pass=$_POST['pass'];
$id=$_SESSION[id];


$sql="select * from membership where id='$id'";
$result=mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);
$db_nick=$row['nick'];
$db_pass=$row['pass'];


if($nick != $db_nick && $pass != $db_pass){
    $sql="update membership set nick='$nick', pass='$pass' where id='$id'";
}else if($nick == $db_nick && $pass == $db_pass){
    echo "<script>alert('장난질하지마라'); location.href='./user_info.php'; </script>";
  
}else if($nick == $db_nick && $pass != $db_pass){
    $sql="update membership set pass='$pass' where id='$id'";
}else if($nick != $db_nick && $pass == $db_pass){
    $sql="update membership set nick='$nick' where id='$id'";
}


$result=mysqli_query($con, $sql) or die("오류ㅋㅋㅋㅋ : " . mysqli_error($con));


mysqli_close($con);
echo "<script>alert('회원님의 정보가 변경되었습니다.')</script>";
echo "<script>location.href='./user_info.php';</script>"; 

var_dump(zzzzzzzzzzzzzzzzz.$nick);
var_dump($pass);



?>