<?php 
    session_start();
    
    include "../common_lib/common.php";
    
    $owner_num = $_POST[owner_num];
    
    $sql = "select * from store_regi where no = '$owner_num'";
    
    $result = mysqli_query($con, $sql);
    
    $record_num = mysqli_num_rows($result);
    
    $row = mysqli_fetch_array($result);
    
    $store_delivery_area_str=$row[store_delivery_area];
    $store_delivery_area_array=explode("/", $store_delivery_area_str);
    $store_name = $row[store_name];
    $business_license = $row[business_license];
    $store_delivery_time = $row[store_delivery_time];
    
    $sql2 = "select distinct category_name from menu where registration_number = '$business_license' order by category_name";
    $category_num_result = mysqli_query($con, $sql2);
    
    $owner_num = $row['no'];
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

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/index_style.css?v=4">
    <link rel="stylesheet" href="css/store_view_style.css?v=4">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"> 
    var BASE = 0; // 스크롤 시작 위치    
    var LEFT = 0; // 왼쪽 여백    
    var TOP1 = 0; // 위쪽 여백    
    var TOP2 = 0; // 스크롤시 브라우저 위쪽과 떨어지는 거리    
    var ActiveSpeed = 35;    
    var ScrollSpeed = 20;    
    var Timer;      

    function RefreshM(){     
        var StartPoint, EndPoint;     
        StartPoint = parseInt(document.getElementById('cart_table').style.top, 10);    
        EndPoint = Math.max(document.documentElement.scrollTop, document.body.scrollTop) + TOP2;     

        if (EndPoint < TOP1) EndPoint = TOP1;     
        if (StartPoint != EndPoint)   {      
            ScrollAmount = Math.ceil( Math.abs( EndPoint - StartPoint ) / 15 );                                 
            document.getElementById('cart_table').style.top =  
            	parseInt(document.getElementById('cart_table').style.top, 10) +  ( ( EndPoint<StartPoint ) ? -ScrollAmount : ScrollAmount ) + "px";      
            RefreshTimer = ScrollSpeed;      
       }    
       
       Timer = setTimeout("RefreshM();", ActiveSpeed);    
     }    

    function InitializeM(){    
        document.getElementById('cart_table').style.left = LEFT + "px";                              
        document.getElementById('cart_table').style.top = 
        document.body.scrollTop + BASE + "px";     
        RefreshM(); 
	}
    
    function add_cart(elem){
    	var mn_name = $(elem).find(".mn_name").val();
   		var mn_price = $(elem).find(".mn_price").val();
    	var quantity = 1;
    	
    	
    	$(".cart").append("<table class='cart_menu'>"+
				"<tr><td colspan='2'><span class='name_mn'>"+mn_name+"</span><input name='menu_name[]' type='hidden' value ='"+mn_name+"'>"+
				"<button type='button' onclick='del_cart_table(this)' style='float:right;'>X</button>"+
				"<tr><td><span class='price_mn'>"+mn_price+" </span><input class='price' name='menu_price[]' type='hidden' value ='"+mn_price+"'>"+
				"<td id='c2_3_2'>수량 : <button type='button' onclick='control(this,0)'><</button> <span class='quantity_mn'>"+ quantity +"</span>"+
				"<input name='count[]' class='count' type='hidden' value='"+quantity+"'>  <button type='button' onclick='control(this,1)'>></button>"+
				"</table>");
   
    	 cal_sum(); 
    }
    
     function control(elem,updown){
    	var price = $(elem).closest(".cart_menu").find(".price").val();
    	var count = $(elem).closest(".cart_menu").find(".count").val();
    	var rs_val;
    	price = parseInt(price);

    	

    	
    	if(updown){
    		count++;
    		rs_val = price*count;
    		 $(elem).closest(".cart_menu").find(".count").val(count);
    		$(elem).closest(".cart_menu").find(".quantity_mn").text(count);
    		$(elem).closest(".cart_menu").find(".price_mn").text(rs_val+" ");
    	}else{
    		count--;
    		
    		if(count < 1){
        		return;
        	}
    		rs_val = price*count;
    		
    		 $(elem).closest(".cart_menu").find(".count").val(count);
    		$(elem).closest(".cart_menu").find(".quantity_mn").text(count);
    		$(elem).closest(".cart_menu").find(".price_mn").text(rs_val+" "); 
    	}
    	
    
    	
    	
    	 cal_sum(); 
    } 
     
     
     function del_cart_table(elem){
    	 $(elem).closest(".cart_menu").remove();
    	 cal_sum();
     }
     
     
     
      function cal_sum(){
    	
    	 var price_text = $("form[name=cart_form]").find(".price_mn").text();
    	 var sum =0;
    	 
    	 
         var price_array= price_text.split(' ');
    	  for(var i in price_array){
    		  
    		  if(price_array[i]){
    			  var con_num = price_array[i];
    	    		 
    	          sum = sum + parseInt(con_num);
    		  }
    		 
    		 
    	 } 
    	 
    	 $("#sum").text(sum);
     } 
     
     
    
    
 </script>
 
 
 <style>
	body{
		overflow: scroll;
	}
	
	div{
		border: 1px solid black;
		margin-top: 10px;
	}
	
	.category_area{
	width: 82%;
	   margin: 0 0 0 0;
	   padding: 0;
	}
	
	.img_area{
	   float: right;
	   display:inline-block;
	   margin: 10px;
	   width: 80px;
	   height: 80px;
	}
	
	.img_area img{
	   width: 80px;
	   height: 80px;
	}
	
	
	.mn_info_input{
	   height: 100px;
	   float: left;
	   display: inline-block;
	} 
	
	.menu_info{
		width: 80%;
	    height:100px;
		margin-left: 20px;
		border-radius: 10px;
		background-color: #F2E1B9;
	}
	
	
	.category_section{
	   width: 75%;
	   height: 50px;
	   border-radius: 10px;
	   background-color: #F36A4C; 
	   
	}
	
	.category_h1{
	   display: inline-block;
	   margin-left:20px;
	}
	
	.mn_name, .mn_price, .menu_name, .menu_price, .menu_insert_btn, .insert_input {
	   width: 300px;
	   height: 20px;
	   border-radius: 5px;
	   margin: 5px 5px;
	}
	
	.mn_comp, .menu_comp{
	   width: 300px;
	   height: 20px;
	   border-radius: 5px;
	   margin: 5px 5px;
	}
	</style>
	
</head>
<body onload="InitializeM();">
	<header>
		<?php include "../common_lib/top_login2.php"; ?>
	</header>
	
	<div class="logo">
		<a href="../index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>
	
	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>
	
	
	<div class="store_view" style="border:1px solid green">  
		<div class="store_data" style="border:1px solid green">		
    		<div class="store_outline" style="border:1px solid green">
    		<table>
    			<tr><td colspan="2" id=s1><?= $store_name ?>
    			<tr><td id=s2>별점
    			<tr><td id=s3>배달가능지역 : <?= $store_delivery_area ?>
    			<tr><td id=s4>배달 시간  : <?= $store_delivery_time?>
    		</table>
    		</div><!-- end of store_data -->
    		
    		<div class="store_menu" style="border:1px solid green">
                <!-- TAB CONTROLLERS -->
                <input id="panel-1-ctrl" class="panel-radios" type="radio" name="tab-radios" checked>
                <input id="panel-2-ctrl" class="panel-radios" type="radio" name="tab-radios">
                <input id="panel-3-ctrl" class="panel-radios" type="radio" name="tab-radios">
                
                <!-- TABS LIST -->
                    <ul id="tabs-list">
                        <!-- MENU TOGGLE -->
                        <li id="li-for-panel-1">
                          <label class="panel-label" for="panel-1-ctrl">메 뉴</label>
                        </li>
                        <li id="li-for-panel-2">
                          <label class="panel-label" for="panel-2-ctrl">가게 정보</label>
                        </li>
                        <li id="li-for-panel-3">
                          <label class="panel-label" for="panel-3-ctrl">리 뷰</label>
                        </li>
                    </ul>
                     
                    <!-- THE PANELS -->
                    <article id="panels" style="border:1px solid green">
                      <div class="container" >
                        <section id="panel-1" >
                          <main>
                            	<?php 
                              	for(;$category_row = mysqli_fetch_array($category_num_result);){
                              	    
                              	    $category=$category_row[category_name];
                              	   
                              	  

                              ?>
                              	     <div class='category_area' >
                        				 <div class='category_section'>
                        					<h1 class='category_h1'><?= $category ?></h1>
                        				</div> 
  
                                   <?php 
                                   $sql = "select * from menu where registration_number = '$business_license' and category_name = '$category' order by category_name";
                                   $result  = mysqli_query($con, $sql);
                                   for(;$row = mysqli_fetch_array($result);){
                                       
                                       $category_name = $row[category_name];
                                       $menu_name = $row[menu_name];
                                       $menu_comp = $row[menu_comp];
                                       $menu_price = $row[menu_price];
                                       $menu_img = $row[menu_img];
                                       $dir_menu_img = "../owner_store_info/menu_img_data/".$menu_img;
                                   ?>
                                    <div class='menu_info' onclick="add_cart(this)">
                        			<div class='mn_info_input'>
                            			    <input class='ctgr_name' name='category_name[]' type='hidden' value='<?= $category_name ?>' readonly><br>
                            				<input class='mn_name' name='menu_name[]' type='text' value='<?= $menu_name ?>' readonly><br>
                            			    <textarea class='mn_comp' name='menu_comp[]' readonly><?= $menu_comp ?></textarea><br>
                            			    <input class='mn_price' name='menu_price[]' type='text' value='<?= $menu_price ?>' readonly><br>
                        			    </div>
                        			    	<div class='img_area'>
                        			    		 <img class='sel_img' src='<?= $dir_menu_img?>'/>
                        			   	 	</div>
                        	   		</div>	
                                   			
                                   
                                   
                                   <?php     
                                       
                                   }
                                  	    
                                   ?>
                              	            
                        	</div>    
                              	    <?php
							
                         }
                              	    ?> 
                          </main>
                        </section>
                        <section id="panel-2">
                          <main>
                            <p>Content2</p>
                          </main>
                        </section>
                        <section id="panel-3">
                          <main>
                            <p>Content3</p>
                          </main>
                        </section>
                      </div>
                    </article>      		
    		
    		</div><!-- end of store_menu -->
    		    		
		</div><!-- end of store_data -->
		
		<div class="cart_view" >
		<form name="cart_form" action="../order/order_form.php">
		<input name="owner_num" type='hidden' value='<?=$owner_num?>'>
		<div style="position:relative; width:100%; height:1200px; border:1px solid black"> <!--div 기준으로 table의 위치가 선정된다  -->
			<table id=cart_table>
				<tr><td id=c1>장바구니<div></div><img onclick="delCart()" src="../common_img/waste-bin.png">
				<tr><td class=cart>
				<?php ?> <!--이벤트 결과에 따라 테이블 생성 -->
				<!--  <table><tr><td colspan="2" id=c2_1>상호명
				<tr><td colspan="2" >메뉴정보
				<tr><td>가격<td id=c2_3_2>수량조절버튼
				</table> -->
				
				<tr><td id=c3>최소주문금액 <?php ?> 원 이상
				<tr><td id=c4>합계 <span id="sum"></span>원
				<tr><td id=c5><button>주 문 하 기</button>
			</table>
		</div>
		
		</form>
		</div><!-- end of cart_view -->		
		
		
	</div><!-- end of store_view -->
		
	
	

	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>