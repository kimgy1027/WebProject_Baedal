<?php 
    session_start();
    include '../common_lib/common.php';
    
    if(isset($_SESSION[id])){
        $id = $_SESSION[id];
    }else{
        $id = "";
    }
    
    $sql = "select * from store_regi where owner_id = '$id'";
    
    $result = mysqli_query($con, $sql);
    
    
    
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="../common_css/common.css?v=1">
<link rel="stylesheet" href="./css/owner_store_list_style.css?v=5">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>	
		function tableClicked(){
			document.store_form.submit();
		}

	</script>
</head>
<body>
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
		<div id="store_head">총<?php ?>  <?php ?>개의 업체가 등록되어있습니다!</div>
		
		
		<div id="store_head_list">
			<select name="sort_list">
				<option value="">기 본</option>
				<option value="별점">별 점</option>
				<option value="리뷰">리뷰수</option>
				<option value="금액">최소주문금액</option>
				<option value="배달시간">배달시간</option>
			</select>
		</div>
		<!-- end of head_list -->

		<div id="search_window">
			<input id=text type="text" class='input_text' name="search"
				onkeydown="enterSearch()" />
		</div>
		<div id="store_search">
			<input type="button" class='store_search' value="검색"
				onclick="myFunction()" />
		</div>

	</div>
	<!-- end of menu_top -->
	<hr>

	<div class="store_list">
		<?php while($row = mysqli_fetch_array($result)){
		   
		    $owner_num = $row['owner_num'];
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
		
		<form action="../owner_store_info/menu_manage_form.php" method="post" name="store_form">
		<input name="business_license" type="hidden" value="<?= $business_license ?>">
		<div class="store_list_info1">
			<!-- DB에서 불러온 가게수에 따라서 div 생성하면댄다 >내부 내용도 써야함 -->
		
			<table onclick="tableClicked()" id="store_table">
			
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
					<td>최소주문금액					
					<td>			
			</table>
		</div>
					
		<div class="store_list_info2">
			<!--<table>
				<tr class="tr1"><td colspan="2" >영 업 상 태
				<tr class="tr2"><td id="td1" colspan="2" rowspan="2">영 업 종 료
				<tr class="tr2">
				<tr class="tr3"><td id="td1"><?= $store_delivery_time_start ?>/<?= $store_delivery_time_end ?><td>13:00:00
				<tr class="tr4"><td id="td1">총 주문 수<td>17
			</table>	 -->	
		</div><!-- end of store_list_info2 -->
		</form>
	<?php 
		}
	?>	
		
	</div><!-- end of store_list -->
	<div class="store_btn">
		<button id=store_regi onclick="location.href='owner_store_regi_form.php'">매장 등록</button><button id=store_del>삭제 신청</button>
	</div>

	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>