<?php
include '../common_lib/common.php';

$search=$_POST["search"];

$sql= "select concat(city,' ',borough,' ',town) from region where town like '%$search%'";

$result= mysqli_query($con, $sql) or die(mysqli_error($con));
$count=10;

while($row= mysqli_fetch_array($result)){
    $search_value = $row[0];
    $trim_search_value = str_replace(" ", "", $search_value);
    
    
    
    echo "<input class='search_val' onclick='insert_textarea(this)' type='button' value='".$search_value."'>";
    
    $count--;
    if(!$count){
        break;
    }
}

?>