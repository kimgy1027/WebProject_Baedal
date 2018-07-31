<?php 
session_start();

$id = $_SESSION['id'];

include "../common_lib/common.php";

$no = $_GET['no']; //order_list의 PK


$sql= "select * from order_list where no='$no'";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));

$row=mysqli_fetch_array($result);
//주문정보//
$owner_no=$row['owner_no']; //store_regi의 PK
$order_date=$row['order_date'];
$order_time=$row['order_time'];
$pay=$row['pay'];
$total=$row['total'];
$state=$row['state'];

//배달정보//
$phone=$row['phone'];
$address=$row['address'];
$request=$row['request'];

$sql="select store_name from store_regi where no=$owner_no";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
$row=mysqli_fetch_array($result);

$store_name=$row['store_name'];

//주문내역정보//
$sql2="select*from cart where cart_num='$no'";
$result2= mysqli_query($con, $sql2) or die("실패원인1:".mysqli_error($con));

//리뷰 정보
$sql3="select*from review where order_no='$no'";
$result3= mysqli_query($con, $sql3) or die("실패원인1:".mysqli_error($con));

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달내역 자세히보기</title>
    <link rel="stylesheet" href="./css/user_order_view.css?v=6">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
	 function popupFunc(a){
 		var no = a; //store_regi의 no
 		var screenW=screen.availWidth; //스크린 가로사이즈
 		var screenH=screen.availHeight; //스크린 세로사이즈
 		var popW=440; //띄울 창의 가로사이즈
 		var popH=450; //띄울 창의 세로사이즈
 		var posL=(screenW-popW)/2;
 		var posT=(screenH-popH)/2;

 		window.open('./review.php?no='+no,'리뷰 남기기', 'width='+popW+', height='+popH +',top='+posT+',left='+posL, 'location=no,status=no,scrollbars=no');
 	}
	 
	 function orderCancel(){
		 alert("주문을 취소하시겠습니까?");
		 window.close();
	 }
	 
	</script>
</head>
<body>
	<div class="order_info_view">
		<div class="store_info">
			<table>
			<tr class="tr1"><td class="td1"><?=$store_name?>
			<tr class="tr2"><td class="td1"><button id="order" type="button" onclick="location.href='../store/store_view.php?no=<?=$owner_no ?>'"><img  src="../common_img/주문하기.jpg"></button>
			<?php if($state=="wait"){?>
			<button id="cancel" type="button" onclick="orderCancel()"><img src="../common_img/주문취소.jpg"></button>
			<?php }else if(!mysqli_num_rows($result3)){?>
			<button id="review" type="button" onclick="popupFunc(<?= $owner_no?>)"><img src="../common_img/리뷰쓰기.jpg"></button>
			<?php }else{}?>
			</table>
		</div>
	
		<div class="order_info">
			<table>
			<tr class="tr1"><td class="td1">주문정보<td class="td2">
			<tr class="tr2"><td class="td1">주문번호<td class="td2"><?= $no ?>
			<tr class="tr3"><td class="td1">주문시간<td class="td2"><?= $order_date ?> <?= $order_time?>
			<tr class="tr4"><td class="td1">주문방법<td class="td2"><?php if($pay=="now_card"){?>카드 결제
			                                                    <?php }else if($pay=="after_cash"){?>만나서 현금 결제
			                                                    <?php }else{?>만나서 카드 결제<?php } ?>
			<tr class="tr5"><td class="td1">결제금액<td class="td2"><font color="red"><?= $total ?></font>
			</table>
		</div>
		
		<div class="delivery_info">
			<table>
			<tr class="tr1"><td class="td1">배달정보<td class="td2">
			<tr class="tr2"><td class="td1">연락처<td class="td2"><?= $phone ?>
			<tr class="tr3"><td class="td1">배달주소<td class="td2"><?= $address ?>
			<tr class="tr4"><td class="td1">요청사항<td class="td2"><?= $request ?>
			</table>
		</div>
		
		<div class="menu_info">
		 	<table>
			<tr class="tr1"><td class="td1">주문내역<td class="td2">
			<?php while($row=mysqli_fetch_array($result2)){
			         $menu_name=$row['menu_name'];
			         $menu_price=$row['menu_price'];
			         $menu_count=$row['menu_count']; ?>
			         
         			<tr class="tr2"><td class="td1"><?= $menu_name ?><td class="td2"><?= $menu_price?>
        			<tr class="tr3"><td class="td1">수 량<td class="td2"><?= $menu_count ?>        			
			<?php }?>
					<tr class="tr4"><td class="td1">주문금액<td class="td2"><?= $total ?>
			</table>
		</div>
		<div class="call_info">
			<small>배달의신 콜센터</small>
			<div style="font-size: 16pt">1644-0025</div>
			<small>(24시간 운영, 연중무휴)</small>
		</div>
	</div>

</body>
</html>