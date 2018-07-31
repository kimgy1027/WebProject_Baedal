<?php 
    session_start();
    include '../common_lib/common.php';
    
    if(isset($_SESSION[id])){
        $id = $_SESSION[id];
    }else{
        $id = "";
    }
    
    $mode = $_GET[mode];
    
    $sql = "select * from store_regi where owner_id = '$id' ";
    
    $result = mysqli_query($con, $sql);
    
    $num_record = mysqli_num_rows($result);
    
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="../common_css/common.css?v=1">
<link rel="stylesheet" href="./css/owner_store_list_style.css?v=6">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script >	
  /*   function a(){
        var items = ['item1', 'item2', 'item3'];
        var ab = ['a','b','c'];
        var copy = [];
    	var make = [];
        
        for(var i =0 ;i<3 ;i++){
        	make[i] = new Array();
        	
        	make[i][0] = items[i];
        	make[i][1] = ab[i];
        	
        }
   
        alert(make[0][1]);
     }
 */

		function select_store(n){
			
			$(".store_form:eq("+n+")").submit();
		}
		
		
		
		
		function clickedDelBtn(a){
			var mode = a;
       		var screenW=screen.availWidth; //스크린 가로사이즈
       		var screenH=screen.availHeight; //스크린 세로사이즈
       		var popW=600; //띄울 창의 가로사이즈
       		var popH=1000; //띄울 창의 세로사이즈
       		var posL=(screenW-popW)/2;
       		var posT=(screenH-popH)/2;
       		
       		window.open('owner_store_del.php','매장 삭제하기', 'width='+popW+', height='+popH +',top='+posT+',left='+posL+', location=no');			
		}

	</script>
</head>
<body onload="a()">
	<header>
		<?php include "../common_lib/top_login2.php"; ?>
	</header>

	<div class="logo">
		<a href="../index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>

	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>

	<div class="store_top">
		<div id="store_head">총 <?= $num_record?> 개의 업체가 등록되어있습니다!</div>
		
		
		<!--  <div id="store_head_list">
			<select name="sort_list">
				<option value="">기 본</option>
				<option value="별점">별 점</option>
				<option value="리뷰">리뷰수</option>
				<option value="금액">최소주문금액</option>
				<option value="배달시간">배달시간</option>
			</select>
		</div> 
		<!-- end of head_list --> 

	<!--	<div id="search_window">
			<input id=text type="text" class='input_text' name="search"
				onkeydown="enterSearch()" />
		</div>
		<div id="store_search">
			<input type="button" class='store_search' value="검색"
				onclick="myFunction()" />
		</div> -->

	</div>
	<!-- end of menu_top -->
	<hr>

	<div class="store_list">
		<?php 
		   $i = 0;
		   while($row = mysqli_fetch_array($result)){
		      
		    $no = $row['no'];
		    $owner_id = $row['owner_id'];
		    $owner_name = $row['owner_name'];
		    $owner_store_name = $row['owner_store_name'];
		    $owner_address = $row['owner_address'];
		    $business_license = $row['business_license'];
		    $business_license_img = $row['business_license_img'];
		    $store_name = $row['store_name'];
		    $store_type = $row['store_type'];
		    
		    $store_logo_img=$row['store_logo_img'];
		    
		    $store_delivery_time = $row['store_delivery_time'];
		    $store_delivery=explode("~", $store_delivery_time);
		    $store_delivery_time_start=$store_delivery[0];
		    $store_delivery_time_end=$store_delivery[1];
		    
		    $store_min_price = $row[store_min_price];
		    
		    $store_day_off = $row['store_day_off'];
		    $store_origin = $row['store_origin'];
		    
		    $store_phone = $row['store_phone'];
		    $store_hp=explode("-", $store_phone);
		    $hp1=$store_hp[0];
		    $hp2=$store_hp[1];
		    $hp3=$store_hp[2];
		    
		    $store_delivery_area = $row['store_delivery_area'];
		    $regi_date = $row['regi_date'];
		    $regi_ok = $row['regi_ok'];
		    $menu_ok = $row['menu_ok'];
		?>
		<?php 
		if($mode == "info"){
		 ?>
		 <form class="store_form" action="../owner_store_info/manage_form.php" method="post" name="store_form">
		 <?php  
		    
		    
		}else if($mode == "order"){
		 ?>  
		  <form class="store_form" action="../owner_order/owner_order_list.php" method="post" name="store_form">
		 <?php    
		}
		?>
		
		
		<input name="owner_no" type="hidden" value="<?= $no ?>">
		<div class="store_list_info1"  id="store_table" >
			<!-- DB에서 불러온 가게수에 따라서 div 생성하면댄다 >내부 내용도 써야함 -->
		<!-- <input type="hidden" class="index_val" value="<?=$i?>" name="number"> -->
			<table >
			
				<tr>
					<td rowspan="4" id=store_list_img><img id="store_logo_img" src="./Regi_logo_img_data/<?=$store_logo_img ?>" >					
					<td><?=$store_name ?>				
					<td>쿠폰				
				<tr>
					<td>별점 테이블 필요				
					<td>???? 좋아요 ??
				<tr>
					<td>대표메뉴					
					<td>리뷰수				
				<tr>
					<td>최소주문금액 : <?=$store_min_price?>					
					<td>			
			</table>
		</div>
					
		<div class="store_list_info2">
			<?php 
			if($regi_ok =="N" && $mode== "info"){
			 ?>
			<table>
				<tr class="tr1"><td colspan="2" ><img style="width:240px;" src="../common_img/매장등록요청처리중.JPG"> 
			</table>		
			<?php   
			    
			}else if($regi_ok == "Y" && $menu_ok=="N" && $mode == "info"){
			?>
			 <table>
			    <tr class="tr1"><td colspan="2" ><img  style="width:240px;" src="../common_img/매장등록완료.JPG" >
			    <tr><td colspan="2"><button onclick="select_store(<?=$i?>)" type="button" id="menu_regi">메뉴등록</button>
			 </table>	
		    <?php 
			}else if($mode == "info" && $regi_ok == "D"){
			?>
		    <table>
			    <tr class="tr1"><td colspan="2" ><img  style="width:240px;" src="../common_img/매장수정요청처리중.JPG" >
			 </table>	
			<?php
			}else if($mode =="info" && $regi_ok == "Y"){
			?>
			 <table>
			    <tr class="tr1"><td colspan="2" ><img  style="width:240px;" src="../common_img/영업중.JPG" >
			    <tr><td colspan="2"><button onclick="select_store(<?=$i?>)" type="button" id="menu_regi">정보확인</button>
			 </table>	
			
			
			
			<?php 
			}else{
			?>
			 <table>
			    <tr class="tr1"><td colspan="2" ><button onclick="select_store(<?=$i?>)" type="button" id="menu_regi">주문내역확인</button>
			 </table>	
			<?php 
			}
			?>
			
			
		<!--	<table>
				<tr class="tr1"><td colspan="2" >영업상태
				<!-- <tr class="tr2"><td id="td1" colspan="2" rowspan="2">
				<tr class="tr2">
				<tr class="tr3"><td id="td1"><td>
				<tr class="tr4"><td id="td1"><td>
			</table>-->		
		</div><!-- end of store_list_info2 -->
		</form>
	<?php 
	   $i++;
		}
	?>	
		
	</div><!-- end of store_list -->
	<?php 
	if($mode == "info"){
	?>
	<div class="store_btn">
		<button id=store_regi onclick="location.href='owner_store_regi_form.php'">매장 등록</button><button id=store_del type="button" onclick="clickedDelBtn()">삭제 신청</button>
	</div>
	<?php 
	}
	?>
	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>