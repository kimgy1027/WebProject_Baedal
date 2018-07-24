<?php
session_start();

include "../common_lib/common.php";
$id=$_SESSION['id'];

//order 테이블에 넣을 ㄷㅔ이터
//$business_license=$_GET['business_license']; // store_view 에서 GET으로 전달? // 가게 정보

$owner_num=$_POST['owner_num']; // store_view 에서 GET으로 전달? // 가게 정보
$order_date = date("Ymd"); //배달 날짜
$order_time = date("H:i:s"); //배달 시간
$address= $_POST['address']; // 주소
//$id=$_SESSION['id']; //배달자 아이디
$phone=$_POST['phone']; //번호
$request=$_POST['request']; //요청사항
$total=$_POST['total'];         // 총 계산 가격
$pay=$_POST['pay'];          // 계산방법
$state="wait";                  // 배달상태

//order 테이블에 주문정보를 넣음
$sql = "insert into order_list (owner_no , order_date, order_time, id, address, phone, request, total, pay, state) ";
$sql .="values ('$owner_num','$order_date', '$order_time', '$id', '$address', '$phone', '$request', '$total', '$pay', '$state');";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));





$row=mysqli_fetch_array($result);
$no = $row[0];

 //배달자 아이디
$menu_name=$_POST['mn_name'];
$menu_price=$_POST['mn_price']; //메뉴랑 카운트는 배열로 받아야할거같은데 하하하하
$menu_count=$_POST['mn_count'];


$menu_record = count($menu_name);
if(!$menu_record){
    echo "<script>alert('장바구니에 주문정보가 없습니다.!'); </script>";
    echo "<script> location.href='../index.php'; </script>";
}

for($i=0;$i<$menu_record;$i++){
    $sql = "insert into cart (cart_num, id , owner_no , menu_name, menu_price, menu_count) ";
    $sql .="values (LAST_INSERT_ID() ,'$id', '$owner_num', '$menu_name[$i]', '$menu_price[$i]', '$menu_count[$i]');";
    mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
}





//cart 테이블에  메뉴정보를 먼저 넣음





mysqli_close($con);

echo "<script> alert('주문 접수가 완료되었습니다.')</script>";
echo "<script> location.href='../index.php'; </script>";
?>
