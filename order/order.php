<?php
session_start();
$_SESSION['id'] = "een0422";

include "../common_lib/common.php";


$sql= "select cart_num from cart where id='$id' order by no desc";  //최신의 장바구니 번호를 가져온다.
$result= mysqli_query($con, $sql);
$row=mysqli_fetch_rows($result);
if(!$row['cart_num']){
    $cart_num=1;
}else{
    $cart_num=$row['cart_num']+1;
}

$id=$_SESSION['id']; //배달자 아이디
$business_license=$_GET['business_license']; // store_view 에서 GET으로 전달? // 가게 정보
$menu_name=$_POST['menu_name'];
$menu_price=$_POST['menu_price']; //메뉴랑 카운트는 배열로 받아야할거같은데 하하하하
$menu_count=$_POST['menu_count'];

//cart 테이블에  메뉴정보를 먼저 넣음
$sql = "insert into cart (cart_num, id , business_license , menu_name, menu_price, menu_count) ";
$sql .="values ('$cart_num','$id', '$business_license', '$menu_name', '$menu_price', '$menu_count');";
$result= mysqli_query($con, $sql);


//order 테이블에 넣을 ㄷㅔ이터
//$business_license=$_GET['business_license']; // store_view 에서 GET으로 전달? // 가게 정보
$order_date = date("Ymd"); //배달 날짜
$order_time = date("H:i:s"); //배달 시간
$address= $_POST['address']; // 주소
//$id=$_SESSION['id']; //배달자 아이디
$phone=$_POST['phone']; //번호
$request=$_POST['request']; //요청사항
$cart_num=                 //장바구니번호
$total=$_POST['total'];         // 총 계산 가격
$pay=$_POST['total'];          // 계산방법
$state="wait";                  // 배달상태

//order 테이블에 주문정보를 넣음
$sql = "insert into order_list (business_license , order_date, order_time, id, address, phone, request, cart_num, total, pay, state) ";
$sql .="values ('$business_license','$order_date', '$order_time', '$id', '$address', '$phone', '$request', '$cart_num', '$total', '$pay', '$state');";
$result= mysqli_query($con, $sql);

mysqli_close($con);

echo "<script>alert('주문 접수가 완료되었습니다.')</script>";
echo "<script> location.href='../index.php'; </script>";
?>
