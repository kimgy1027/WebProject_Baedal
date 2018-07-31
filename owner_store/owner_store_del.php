<?php 
    session_start();
    include '../common_lib/common.php';
    if(isset($_SESSION[id])){
        $id = $_SESSION[id];
    }else{
        $id = "";
    }
    
    $sql = "select * from store_regi where not regi_ok = 'D' and owner_id = '$id' ";
    
    $result = mysqli_query($con, $sql);
    
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="../common_css/common.css?v=1">
<link rel="stylesheet" href="./css/owner_store_list_style.css?v=1">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>	
	
	function del_store(){
		
		var array = [];
		
		$("#select_store:checked").each(function(){
			array.push($(this).val());
			
		});
		
	
		
		$.ajax({
			type : "post",
			url : "./del_store.php",
			data : { 'checked' : array },
			success : function(data){
				alert("선택하신 매장이 삭제신청 처리 되었습니다.");
				self.close();
			}
		});
		
		
	}
</script>
</head>
<body>
<div class="store_list">
<?php while($row = mysqli_fetch_array($result)){
    
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
		
		
		
		<input name="owner_no" type="hidden" value="<?= $no ?>">
		<div class="store_list_info1">
			<!-- DB에서 불러온 가게수에 따라서 div 생성하면댄다 >내부 내용도 써야함 -->
		
			<table id="store_table">
			
				<tr>
				    <td rowspan="4"><input type="checkbox" name="select_store" id="select_store" value="<?= $no?>">
					<td rowspan="4" id=store_list_img><img id="store_logo_img" src="./Regi_logo_img_data/<?=$store_logo_img ?>" >					
					<td><?=$store_name ?>				
					<!-- <td>쿠폰				
				<tr>
					<td>별점 테이블 필요				
					<td>???? 좋아요 ??
				<tr>
					<td>대표메뉴					
					<td>리뷰수				
				<tr>
					<td>최소주문금액					
					<td>	 -->		
			</table>
		</div>
					
		<!--<div class="store_list_info2">
			<table>
				<tr class="tr1"><td colspan="2" >영 업 상 태
				<tr class="tr2"><td id="td1" colspan="2" rowspan="2">영 업 종 료
				<tr class="tr2">
				<tr class="tr3"><td id="td1"><td>13:00:00
				<tr class="tr4"><td id="td1">총 주문 수<td>17
			</table>		
		</div><!-- end of store_list_info2 -->
	<?php 
}
	?>
	<div class="store_btn">
		<button id=store_regi type ="button" onclick="del_store()">삭제 요청</button>
	</div>
	</div><!-- end of store_list -->
	</body>
</html>