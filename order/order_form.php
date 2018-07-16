<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달의신 - 결제하기</title>
    <link rel="stylesheet" href="../common_css/common.css?v=1">
    <link rel="stylesheet" href="./css/order_form.css?v=6">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    	$(function(){ 
    	  $('.bt_up').click(function(){ 
    	    var n = $('.bt_up').index(this);
    	    var num = $(".num:eq("+n+")").val();
    	    num = $(".num:eq("+n+")").val(num*1+1); 
    	  });
    	  $('.bt_down').click(function(){ 
    	    var n = $('.bt_down').index(this);
    	    if(n==1){
    	    	return;
    	    }
    	    var num = $(".num:eq("+n+")").val();    	    
    	    num = $(".num:eq("+n+")").val(num*1-1); 
    	  });
    	}) 
    	  
    	function orderOk(){
    		
    		
    	}
    </script>
    
</head>
<body>
	<header>
		<?php include "../common_lib/top_login1.php"; ?>
	</header>
	
	<div class="logo">
		<a href="../index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>
	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>
		
	<div class="location">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 홈 > 결제하기</p>
		<hr>
	</div>
	<form action="./order.php" name="order_form" method="post" enctype="multipart/form-data">
	<div class="order">
		<div class="address_info">
			<p>01 배달 정보
			<table>
			<tr><td class="td1">주소<td><input type="text" name="address" placeholder="주문받을 주소를 입력해주세요.">
			<tr><td class="td1">연락처<td><input type="text" name="phone" placeholder="전화번호를 입력해주세요.('-'제외)">
			<tr><td class="td1">요청사항<td><input type="text" name="request" placeholder="요청사항을 입력해주세요.(50자 이내)">
			</table>
		</div><!-- end of address_info -->
		<div class="order_info">
			<p>02 주문 정보
			<table>
			<tr class="tr1"><td class="td1">주문 메뉴<td class="td2">수량<td class="td3">결제금액<td class="td4">삭제
			<tr class="tr2"><td class="td1">메늉<?php ?><td class="td2"><input type="text" size=1 class="num"> <img src="../common_img/add.png" class=bt_up> <img src="../common_img/minus.png" class=bt_down><td class="td3">결제금액ㄱ<td class="td4"><img src="../common_img/cancel.png">
			</table>
		</div><!-- end of order_info -->
		<div class="pay_info">
			<p>03 결제수단 선택
			<table>
			<tr class="tr1"><td class="td1">지금 결제하기<td class="td2">배달원에게 직접 결제하기
			<tr class="tr2"><td class="td1">
              		<div class="container">
		            <ul>
                      <li>
                        <input type="radio" id="f-option" name="pay" value="now_cash">
                        <label for="f-option">현금 결제</label>
                        
                        <div class="check"></div>
                      </li>
                      
                      <li>
                        <input type="radio" id="s-option" name="pay" value="now_card">
                        <label for="s-option">카드 결제</label>
                        
                        <div class="check"><div class="inside"></div></div>
                      </li> 
                    </ul>
                    </div>
             		<td class="td2"><!-- 배달원 직접 결제하기 -->
             		<div class="container">
		            <ul>
                      <li>
                        <input type="radio" id="a-option" name="pay" value="after_cash">
                        <label for="a-option">현금 결제</label>
                        
                        <div class="check"></div>
                      </li>
                      
                      <li>
                        <input type="radio" id="b-option" name="pay" value="after_card">
                        <label for="b-option">카드 결제</label>
                        
                        <div class="check"><div class="inside"></div></div>
                      </li> 
                    </ul>
                    </div>
			</table>
		</div><!-- end of pay_info -->		
		<div class="pay_btn">
			<button id="pay_ok_btn" onclick="orderOk()">결 제 하 기</button><button id="pay_cancel_btn">취 소 하 기</button>
		</div>
		
	</div><!-- end of order -->		
	</form>
	
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>