<?php
include '../common_lib/common.php';

$town=$_POST["town"];

$sql= "select concat(city,' ',borough,' ',town) from region where town like '%$town%'";

$result= mysqli_query($con, $sql) or die(mysqli_error($con));
$count=10;

while($row= mysqli_fetch_array($result)){
    $search_value = $row[0];
    $trim_search_value = str_replace(" ", "", $search_value);
    
    
    $rs_href = "store/store_list.php?town=".$trim_search_value;
    
    
    echo "<a href='$rs_href'><div style='padding : 5px 5px; border-bottom : 1px solid #dddddd; background-color: white;'>".$search_value."</div></a>";
    
    $count--;
    if(!$count){
        break;
    }
}

?>