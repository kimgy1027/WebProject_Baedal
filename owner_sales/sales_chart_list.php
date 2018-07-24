<?php 

session_start();
$id = $_SESSION['id'];
$today = date("Y/m/d");

include "../common_lib/common.php";

$sql= "select * from store_regi where owner_id='$id'";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css?v=1">
    <link rel="stylesheet" href="./css/sales_chart_list.css?v=10">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    	var checkbox_view = "n";
    	var total_sales="y";
    	var menu_sales="y"
    	
    	function showCheckbox(){
         	if(checkbox_view == "n"){   
         		$('.click_contents1').css('background-color','#fedabc');
               $('.check_boxs').show();  
               checkbox_view = "y";
            } else {  
            	$('.click_contents1').css('background-color','#dddddd');
               $('.check_boxs').hide();
               checkbox_view = "n";
            }  
         }
    	
    	function selectedDate(){
    		var selected_date = $("#date_picker").val();
    		var business_license =[]; //배열초기화
     		$("input[id='check']:checked").each(function() { 
     			business_license.push($(this).val()); //체크된 것만 뽑아서 배열에 넣어준다
     	   });
			
    		$.ajax({
				type : "post",
				url : "./total_sales.php",
				data : { 'business_license' : business_license, 'selected_date' : selected_date },
				success : function(data){
					$(".total_sales").show();
					$(".total_sales_list").html(data);
				}
			});
    		$('.click_contents2').css('background-color','#fedabc');
    		
    		$.ajax({
				type : "post",
				url : "./week_sales_chart.php",
				data : { 'business_license' : business_license, 'selected_date' : selected_date },
				success : function(data){
					$(".total_sales_list2").html(data);
				}
			});

    	}
    	
    	function showTotalSales(){
    		if(total_sales == "n"){   
         		$('.click_contents2').css('background-color','#fedabc');
               $('.total_sales').show();  
               total_sales = "y";
            } else {  
            	$('.click_contents2').css('background-color','#dddddd');
               $('.total_sales').hide();
               total_sales = "n";
            }  
    	}
    	
     	
     	function getData1(){
     		var selected_date = $("#date_picker").val();
     		var owner_no =[]; //배열초기화
     		
     		$("input[id='check']:checked").each(function() { 
     			owner_no.push($(this).val()); //체크된 것만 뽑아서 배열에 넣어준다
     	   });
			
    		$.ajax({
				type : "post",
				url : "./total_sales.php",
				data : { 'owner_no' : owner_no, 'selected_date' : selected_date },
				success : function(data){
					$(".total_sales").show();
					$(".total_sales_list").html(data);
				}
			});
    		$('.click_contents2').css('background-color','#fedabc');
    		
    		$.ajax({
				type : "post",
				url : "./week_sales_chart.php",
				data : { 'owner_no' : owner_no, 'selected_date' : selected_date },
				success : function(data){
					$(".total_sales_list2").html(data);
				}
			});
    		
    		$.ajax({
				type : "post",
				url : "./menu_sales.php",
				data : { 'owner_no' : owner_no, 'selected_date' : selected_date },
				success : function(data){
					$(".menu_sales").show();
					$(".menu_sales_list").html(data);
				}
			});
    		$('.click_contents3').css('background-color','#fedabc');
    		
		}
     	
     	function showMenuSales(){
     		if(menu_sales == "n"){   
         		$('.click_contents3').css('background-color','#fedabc');
               $('.menu_sales').show();  
               menu_sales = "y";
            } else {  
            	$('.click_contents3').css('background-color','#dddddd');
               $('.menu_sales').hide();
               menu_sales = "n";
            }
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
	
	<div class="location">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 홈&nbsp; &nbsp; > &nbsp; &nbsp;매출현황</p>
		<hr>
	</div>
	
	<div class="sales_info">
	
	<?php if(!mysqli_num_rows($result)){?>
    		<div class="no_store_img">
    			<img src="../common_img/등록된매장이없습니다.jpg">
    		</div>			 		
		<?php }else{ ?>		
		
		<!-- 매장고르기 -->
		    <div class="click_contents1" onclick="showCheckbox()">매장선택하기 &nbsp; ▼</div>
		   	 <form name="check_boxs">
		   	 	<div class="check_boxs">
		   	 	<div class="select_date">
					<input id="date_picker" type="date" value="<?php echo date("Y-m-d");?>"><img src="../common_img/검색.jpg" onclick="selectedDate()"><!-- 날짜 선택 -->
				</div>
		<?php while($row=mysqli_fetch_array($result)){
		        $owner_no=$row['no']; //가게 pk
		        $store_name=$row['store_name'];        
	    ?>			
    	    	
        	    	<div class="check_box">
        		   		<input id="check" type="checkbox" name="store" value="<?=$owner_no?>"><?=$store_name?>
        			</div>
    							    
		    
		<?php } //end of while?>
    		 	<div class="check_box_btn"><button type="button" onclick="getData1()">확 인</button></div>
    			</div><!-- end of check_boxs -->
			</form>	
			
		  <!-- 매출액 탭 -->
			<div class="click_contents2" onclick="showTotalSales()">총 매출액 &nbsp;  &nbsp;  &nbsp;  &nbsp; ▼ </div>
			<div class="total_sales">			
				<div class="total_sales_list">
					<!-- Ajax -->
				</div>
				<div class="total_sales_list2">
					<!-- Ajax2 -->
				</div>		
			</div>
			
		  <!-- 차트 탭 -->
			<div class="click_contents3" onclick="showMenuSales()">메뉴별 판매량 &nbsp;  &nbsp;  &nbsp;  &nbsp; ▼</div>
			<div class="menu_sales">
				<div class="sales_menu_list">
					<!-- Ajax -->
				</div>		
			</div>
		
		
		
		
		
		<?php } // end of else ?>
	</div><!-- end of sales_info -->
	
    <footer>    
          <?php include "../common_lib/footer1.php";?>
    </footer>
</body>
</html>