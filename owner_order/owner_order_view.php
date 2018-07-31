<?php 
    session_start();    
    $mode=$_GET["mode"];
    $no = $_GET["order_no"];
    
    include "../common_lib/common.php";
    
    
    $sql= "select * from order_list where no = '$no'";  //배달상태가 wait인 주문내역을 불러온다
    $result= mysqli_query($con, $sql) or die("실패원인 : ".mysqli_error($con));
    
   $row = mysqli_fetch_array($result);
    
    $owner_no = $row[owner_no];
    $order_date = $row[order_date];
    $order_time = $row[order_time];
    $id = $row[id];
    $address = $row[address];
    $phone = $row[phone];
    $request = $row[request];
    $total = $row[total];
    $pay = $row[pay];
    $state = $row[state];
    
    $sql2 = "select * from cart where cart_num = '$no'";
    $result2= mysqli_query($con, $sql2) or die("실패원인 : ".mysqli_error($con));
    
   
    
    
   
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>주문 상세보기</title>
     <link rel="stylesheet" href="./css/owner_order_view.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    	function receipt_order(order_no, mode){
    		
    		try{
        		window.opener.receipt_order(order_no, mode);
        		self.close();
    		}catch(e){
    			alert("에러발생 : "+e);
    		}
    	}
    	
    	function cancel_order(order_no){
    		try{
        		window.opener.cancel_order(order_no);
        		self.close();
    		}catch(e){
    			alert("에러발생 : "+e);
    		}
    	}
    	
    
    
    </script>
    
    
</head>
<body>
	<div class="order_info">
		<p>배달 정보</p>
		<table><tr><td class="td1">연락처<td class="td2"><?=$phone?>
		<tr><td class="td1">배달 주소<td class="td2"><?=$address?></table>
	</div>
	<?php if($mode=="wait"){?>
	<div class="wait_btn">
		<button type='button' onclick="receipt_order(<?=$no?>,'<?=$mode?>')" id="order_ok_btn">주문 접수</button><button type='button' onclick="cancel_order('<?=$no?>')" id="order_cancel_btn">주문 취소</button>
	</div>
	<?php }else if($mode=="ing"){?>
	<div class="ing_btn">
		<button  type='button' onclick="receipt_order(<?=$no?>,'<?=$mode?>')" id="delivery_ok_btn">배달 완료</button><!-- <button type='button' id="order_cancel_btn">접수 취소</button> -->
	</div>	
	<?php }else{}?>
	<div class="menu_info">
		<p>메뉴 정보</p>
		<table><tr><td class="td1">메뉴<td class="td1">수량<td class="td1">금액
		
		 <?php 
		  for($i=0;$row2 = mysqli_fetch_array($result2);$i++){
		      
		      $cart_num = $row2[cart_num];
		      $menu_name = $row2[menu_name];
		      $menu_price = $row2[menu_price];
		      $menu_count = $row2[menu_count];
		  ?>
		<tr><td class="td2"><?=$menu_name ?><td class="td2"><?=$menu_count ?><td class="td2"><?=$menu_price ?>
		<?php 
		  }
		?>
		<tr><td class="td3">총 금액<td class="td3" colspan="2"><?=$total ?></table>
	</div>
	<div class="request_info">
		<table>
		<tr><td class="td1">요청사항
		<tr><td><?=$request?>
		</table>
	</div>
</body>
</html>

<?php
?>
