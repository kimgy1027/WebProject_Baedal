<?php 
    session_start();
    
    include "../common_lib/common.php";
    
    
    if(!$_SESSION[user] || !$_SESSION[id]){
        echo "<script> 
                   alert('로그인후 이용하여 주세요~!');
                    history.go(-1);
                </script>";
    }else if(!$_GET[town]){
        echo "<script>
                   alert('읍면동을 입력하신후 이용해 주세요!');
                    history.go(-1);
                </script>";
    }else{
        $_SESSION[town] = str_replace("%20", " ", $_GET[town]);
        
        $town = $_SESSION[town];
      
         if(isset($_GET[tob])){
            $tob=$_GET[tob];
            
            $sql = "select * from store_regi where store_delivery_area like '%$town%' and store_type = '$tob'"; //수정 요망!
        }else{
            $sql = "select * from store_regi where store_delivery_area like '%$town%'";
            
        } 
       
        
    }
    
    
    
    $result = mysqli_query($con, $sql);
    
    
    $record_num = mysqli_num_rows($result);
    
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="../common_css/index_style.css?v=1">
<link rel="stylesheet" href="./css/store_list_style.css?v=8">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>	
		function tableClicked(elem){
			
		var value	= $(elem).find("input[name='owner_num']").val();
		
		
		var method = method || "post"; // 전송 방식 기본값을 POST로
		 
	    var params = {'owner_num':value};
	    
	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", "./store_view.php");
	 
	    //히든으로 값을 주입시킨다.
	    for(var key in params) {
	        var hiddenField = document.createElement("input");
	        hiddenField.setAttribute("type", "hidden");
	        hiddenField.setAttribute("name", key);
	        hiddenField.setAttribute("value", params[key]);
	 
	        form.appendChild(hiddenField);
	    }
	 
	    document.body.appendChild(form);
	    form.submit();
			
		}
		/* 
		function post_to_url(path, params, method) {
		    method = method || "post"; // 전송 방식 기본값을 POST로
		 
		    
		    var form = document.createElement("form");
		    form.setAttribute("method", method);
		    form.setAttribute("action", path);
		 
		    //히든으로 값을 주입시킨다.
		    for(var key in params) {
		        var hiddenField = document.createElement("input");
		        hiddenField.setAttribute("type", "hidden");
		        hiddenField.setAttribute("name", key);
		        hiddenField.setAttribute("value", params[key]);
		 
		        form.appendChild(hiddenField);
		    }
		 
		    document.body.appendChild(form);
		    form.submit();
		} */

		
		
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
		<div id="store_head"><?= $town ?> 주변 음식점 <?= $record_num?>곳을 찾았습니다!</div>
		
		
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
		
		<div id='search_window'>
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
	<!-- <form name="store_list_form" action="store_view.php" method="POST"> -->
	<div class="store_list">
	<?php 
	while( $row = mysqli_fetch_array($result)){
	    
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
	<div class="store_list_info1">
			
			<!-- DB에서 불러온 가게수에 따라서 div 생성하면댄다 >내부 내용도 써야함 -->
			<table onclick="tableClicked(this)">
				<tr>
					<td rowspan="4" id=store_list_img><img style="width:125px; height:125px;" src="../owner_store/Regi_logo_img_data/<?=$store_logo_img?>"> 		 			
					<td><?= $store_name?><input name="owner_num" type="hidden" value="<?=$owner_num ?>">		
					<td>쿠폰				
				<tr>
					<td>별점					
					<td>좋아요수
				<tr>
					<td>대표메뉴					
					<td>리뷰수				
				<tr>
					<td>최소주문금액					
					<td>			
			</table>
		</div> 
	 <?php
	    
	    
	    
	}
	
	
	
	
	?>
	
	
	
		
<!-- 		<div class="store_list_info2">     -->
			<!-- DB에서 불러온 가게수에 따라서 div 생성하면댄다 >내부 내용도 써야함    -->
<!-- 			<table onclick="tableClicked()">     -->
<!-- 				<tr> -->
<!-- 					<td rowspan="4" id=store_list_img>					 -->
<!-- 					<td>가게이름					   -->
<!-- 					<td>쿠폰				    -->
<!-- 				<tr> -->
<!-- 					<td>별점					    -->
<!-- 					<td>리뷰수 -->
<!-- 				<tr> -->
<!-- 					<td>대표메뉴					   -->
<!-- 				<tr> -->
<!-- 					<td>최소주문금액					 -->
<!-- 					<td>			 -->
<!-- 			</table> -->
<!-- 		</div> -->
		


			</div>
	<!-- </form> -->
	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>