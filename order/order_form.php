 <?php
       session_start();
       $id = $_SESSION['id'];
    
    	
       $town = $_SESSION[town];
       
       $owner_num = $_POST[owner_num];
       $menu_name = $_POST[menu_name];
       $menu_price = $_POST[menu_price];
       $menu_count = $_POST[count];
       
       $menu_record = count($menu_name);
       
       include "../common_lib/common.php";
         
      
       
      $flag = "NO";
      $sql = "show tables from web_baedal_DB";
      $result = mysqli_query($con, $sql) or die("실패원인: ".mysqli_error($con));
      while($row=mysqli_fetch_row($result)){
        if($row[0]==="order_list"){
          $flag = "OK";
          break;
        }
      }
      
      if($flag !=="OK"){
          $sql = "create table order_list(
            	no int not null AUTO_INCREMENT,
                owner_no varchar(50) not null,
            	order_date varchar(10) not null,
            	order_time varchar(10) not null,
            	id varchar(10) not null,
            	address varchar(100) not null,
            	phone varchar(15) not null,
            	request varchar(10) not null,
            	total varchar(10) not null,
            	pay varchar(15) not null,
            	state varchar(5) not null,
                primary key(no)              
                )";
    
        if(mysqli_query($con, $sql)){
          echo "<script>
            alert('order_list 테이블이 생성되었습니다!');
          </script>";
        }else{
          echo "<script>
            alert('order_list 테이블 생성실패');
          </script>";
        }
      } 
      
      $flag = "NO";
      $sql = "show tables from web_baedal_DB";
      $result = mysqli_query($con, $sql) or die("실패원인: ".mysqli_error($con));
      while($row=mysqli_fetch_row($result)){
          if($row[0]==="cart"){
              $flag = "OK";
              break;
          }
      }
      
      if($flag !=="OK"){
          $sql = "create table cart(
    	  no int(255) not null AUTO_INCREMENT,
    	  cart_num int(255) not null,
          id varchar(10) not null,
          owner_no varchar(50) not null,
          menu_no varchar(50),
          menu_name varchar(20) not null,
    	  menu_price varchar(10) not null,
    	  menu_count varchar(5) not null,
          primary key(no),
          constraint fk_cart_num foreign key(cart_num) references order_list(no) on delete cascade
    )";
          if(mysqli_query($con, $sql)){
              echo "<script>
            alert('cart 테이블이 생성되었습니다!');
          </script>";
          }else{
              echo "<script>
            alert('cart 테이블 생성실패');
          </script>";
          }
      }
    
      $sql= "select * from order_list where id='$id' order by no desc";  
      $result= mysqli_query($con, $sql);  
      
      if($row=mysqli_fetch_row($result)){
         $address=$row['address'];
         $phone=$row['phone'];
      }  
      mysqli_close($con);
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달의신 - 결제하기</title>
    <link rel="stylesheet" href="../common_css/common.css?v=1">
    <link rel="stylesheet" href="./css/order_form.css?v=8">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    <script type="text/javascript">
    var IMP = window.IMP; // 생략가능
    IMP.init('iamport'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용

   
	function del_menu(){
		var ok = confirm("해당메뉴를 정말로 삭제하시겠습니까?");
		if(!ok){return;}
		var n = $(this).index(this);
		$(".tr2:eq("+n+")").remove();
		cal_total();
	}
	
	
    
     /* function loadData(){
		if(isset($address)){
			document.order_form.address.value=$address;
		}
		if(isset($phone)){
			document.order_form.phone.value=$phone;
		}
	} */

    	 $(function(){ 
    	  $('.bt_up').click(function(){ 
    	    var n = $('.bt_up').index(this);
    	    var num = $(".num:eq("+n+")").val();
    	    num = num*1+1;
    	    var hidden_price = $(".hidden_price:eq("+n+")").val();
    	    hidden_price = (hidden_price*1) *num;
    	    $(".price_count:eq("+n+")").text(hidden_price);
    	    
    	    $(".num:eq("+n+")").val(num); 
    	    cal_total();
    	  });
    	  $('.bt_down').click(function(){ 
    	    var n = $('.bt_down').index(this);
    	    var num = $(".num:eq("+n+")").val();
    	   
    	    num = num*1-1;
    	    var hidden_price = $(".hidden_price:eq("+n+")").val();
    	    hidden_price = (hidden_price*1) *num;
    	    
    	    if(num<1){
    	    	return;
    	    }
    	    $(".price_count:eq("+n+")").text(hidden_price);
    	    $(".num:eq("+n+")").val(num); 
    	    cal_total();
    	  });
    	}) 
    	
    	function cal_total(){
		var i = 0;
		var length= $(".price_count").length;
		var sum = 0;
		var val;
		for(i;i<length;i++){
			val = $(".price_count:eq("+i+")").text();
			sum += val*1;
		}
		
		$("#sum").text(sum+" 원");
		$("input[name=total]").val(sum);
		
		}
    	  
    	function orderOk(){
  
    		if(!document.order_form.address.value){
             	 alert("배달 받으실 주소를 입력해주세요!");
              	  document.order_form.address.focus();
              	return ;
 		}
		if(!document.order_form.phone.value){
             	 alert("배달시 연락받을 전화번호를 입력해주세요!");
              	  document.order_form.phone.focus();
              	return ;
 		} 
		
		if(!$('input:radio[name=pay]').is(':checked')){
			alert("결제수단을 선택해 주세요!");
			return ;
			
		}
		
		if($('#s-option').is(':checked')){
			 IMP.request_pay({
			        pg : 'kakao', // version 1.1.0부터 지원.
			        pay_method : 'card',
			        merchant_uid : 'merchant_' + new Date().getTime(),
			        name : '주문명:결제테스트',
			        amount : $("#sum").text().split(' 원')[0],
			        buyer_email : 'iamport@siot.do',
			        buyer_name : '구매자이름',
			        buyer_tel : '010-1234-5678',
			        buyer_addr : '서울특별시 강남구 삼성동',
			        buyer_postcode : '123-456',
			        m_redirect_url : 'https://www.yourdomain.com/payments/complete'
			    }, function(rsp) {
			        if ( rsp.success ) {
			            var msg = '결제가 완료되었습니다.';
			            msg += '고유ID : ' + rsp.imp_uid;
			            msg += '상점 거래ID : ' + rsp.merchant_uid;
			            msg += '결제 금액 : ' + rsp.paid_amount;
			            msg += '카드 승인번호 : ' + rsp.apply_num;
			        	document.order_form.submit();	
			        } else {
			            var msg = '결제에 실패하였습니다.';
			            msg += '에러내용 : ' + rsp.error_msg;
			        }
			        alert(msg);
			    });
		}else{
			document.order_form.submit();	
		}
		
		
		
					   		
    	} 
    	 
    	
    	
    	
    </script>
    
</head>
<body onload="cal_total()">
	<header>
		<?php include "../common_lib/top_login2.php"; ?>
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
	<input type="hidden" name="owner_num" value="<?=$owner_num?>">
	<div class="order">
		<div class="address_info">
			<p>01 배달 정보
			<table>
			<tr><td class="td1">주소<td><input type="text" name="address" placeholder="주문받을 주소를 입력해주세요." value="<?=$town?>">
			<tr><td class="td1">연락처<td><input type="text" name="phone" placeholder="전화번호를 입력해주세요.('-'제외)">
			<tr><td class="td1">요청사항<td><input type="text" name="request" placeholder="요청사항을 입력해주세요.(50자 이내)">
			</table>
		</div><!-- end of address_info -->
		<div class="order_info">
			<p>02 주문 정보
			<table>
			<tr class="tr1"><td class="td1">주문 메뉴<td class="td2">수량<td class="td3">결제금액<td class="td4">삭제
			<?php 
    			for($i = 0 ; $i < $menu_record ; $i++){
    			     
    			    
    	    ?>
			<tr class="tr2"><td class="td1"><input type="hidden" name="mn_name[]" value="<?=$menu_name[$i]?>"><?=$menu_name[$i]?><td class="td2"><input name="mn_count[]" type="text" size=1 class="num" value="<?=$menu_count[$i]?>"> <img src="../common_img/add.png" class=bt_up> <img src="../common_img/minus.png" class=bt_down><td class="td3"><input class="hidden_price" name="mn_price[]" type="hidden" value="<?= $menu_price[$i]?>"><span class='price_count'><?=($menu_price[$i] * $menu_count[$i])?> </span><td class="td4"><img class="del_menu_img" src="../common_img/cancel.png" onclick="del_menu()">
    			    
    		<?php	
    			}
    	    ?>
			
			<tr class="tr_total"><td class="td1">총&nbsp; &nbsp; 금 액<td  class="td2" colspan="4"><input type="hidden" name="total"><span id="sum"></span>
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
			<button id="pay_ok_btn" type="button" onclick="orderOk()">결 제 하 기</button><button id="pay_cancel_btn" type="button" onclick="javascript:history.go(-1)">취 소 하 기</button>
		</div>
		
	</div><!-- end of order -->		
	</form>
	
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>