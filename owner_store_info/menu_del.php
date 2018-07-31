<?php

include '../common_lib/common.php';

$menu_no = $_POST[menu_no];
$owner_no = $_POST[owner_no];

$sql = "select menu_img from menu where owner_no = '$owner_no' and menu_no = '$menu_no'";
$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);

$img_Route = "./menu_img_data/".$row[menu_img];
unlink($img_Route);


$sql = "delete from menu where owner_no = '$owner_no' and menu_no ='$menu_no'";
mysqli_query($con, $sql);


?>