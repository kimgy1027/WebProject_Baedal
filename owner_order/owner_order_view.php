<?php 
    session_start();    
    $mode=$_GET["mode"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>주문 상세보기</title>
     <link rel="stylesheet" href="./css/owner_order_view.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
	<div class="order_info">
		<p>배달 정보</p>
		<table><tr><td class="td1">연락처<td class="td2">전번<?php ?>
		<tr><td class="td1">배달 주소<td class="td2">주소<?php ?></table>
	</div>
	<?php if($mode=="wait"){?>
	<div class="wait_btn">
		<button id="order_ok_btn">주문 접수</button><button id="order_cancel_btn">주문 취소</button>
	</div>
	<?php }else if($mode=="ing"){?>
	<div class="ing_btn">
		<button id="delivery_ok_btn">배달 완료</button><button id="order_cancel_btn">접수 취소</button>
	</div>	
	<?php }else{}?>
	<div class="menu_info">
		<p>메뉴 정보</p>
		<table><tr><td class="td1">메뉴<td class="td1">수량<td class="td1">금액
		<tr><td class="td2">메뉴이름<?php ?><td class="td2">1<?php ?><td class="td2">1000<?php ?>
		
		<tr><td class="td3">총 금액<td class="td3">1<td class="td3">1000<?php ?></table>
	</div>
	<div class="request_info">
		<table>
		<tr><td class="td1">요청사항
		<tr><td>
		</table>
	</div>
</body>
</html>

<?php
?>
