<?php 
    session_start();
    
    include "../common_lib/common.php";
    
    if(isset($_GET[no])){
        $owner_no = $_GET[no];
    }else{
        $owner_no = $_POST[owner_num];
    }
    
    
    
    
    
    
    
    $sql = "select * from store_regi where no = '$owner_no'";
    
    
    
    $result = mysqli_query($con, $sql);
    
    $record_num = mysqli_num_rows($result);
    
    $row = mysqli_fetch_array($result);
    
    $store_delivery_area_str=$row[store_delivery_area];
    $store_delivery_area_array=explode("/", $store_delivery_area_str);
    $store_name = $row[store_name];
    $business_license = $row[business_license];
    $store_delivery_time = $row[store_delivery_time];
    
   
    
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
    
    $sql2 = "select distinct category_name from menu where owner_no = '$owner_no' order by category_name";
    $category_num_result = mysqli_query($con, $sql2);
    
    $sql3 = "select star from review where owner_no = $owner_no";
    $star_result = mysqli_query($con, $sql3);
    $star_count = mysqli_num_rows($star_result);
    
    while($row = mysqli_fetch_array($star_result)){
        $star_sum += $row[star];
    }
    
   $star_point = $star_sum/$star_count; 
   $star_point = round($star_point);
   
    
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/index_style.css?v=4">
    <link rel="stylesheet" href="./css/store_view_style.css?v=6">
    <link href="./css/review.css?v=2" rel="stylesheet" type="text/css" media="all">
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
   		var mn_no = $(elem).find(".mn_no").val();
    	var quantity = 1;
    	var flag = "no";
    	
    	
    	$(".menu_no").each(function(){
    		if($(this).val() == mn_no){
    			flag = "yes";
    			control(this,1);
    		} 
    	});
    	
    	if(flag == "yes"){
    		return;
    	}
    	
    	
    	$(".cart").append("<table class='cart_menu'>"+
				"<tr><td colspan='2'><span class='name_mn'>"+mn_name+"</span><input name='menu_name[]' type='hidden' value ='"+mn_name+"'>"+
				"<button type='button' onclick='del_cart_table(this)' style='float:right;'>X</button>"+
				"<tr><td><span class='price_mn'>"+mn_price+" </span><input class='price' name='menu_price[]' type='hidden' value ='"+mn_price+"'>"+
				"<td id='c2_3_2'>수량 : <button type='button' onclick='control(this,0)'><</button> <span class='quantity_mn'>"+ quantity +"</span>"+
				"<input name='count[]' class='count' type='hidden' value='"+quantity+"'>  <button type='button' onclick='control(this,1)'>></button>"+
				"<input type='hidden' class='menu_no' value='"+mn_no+"'>"+
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
     
     function order_request(){
    	 var store_min_price = <?=$store_min_price?>;
    	 var sum = $("#sum").text();
    	 
    	 if(store_min_price > sum){
    		 alert("최소주문 금액보다 적습니다.");
    		 return;
    	 }
    	 
    	 document.cart_form.submit();
    	 
     }
    
    
 </script>
 
 
 <style>
	body{
		overflow: scroll;
	}
	
	div{
		/* border: 1px solid black; */
		margin-top: 10px;
	}
	
	.category_area{
	   width: 100%;
	   margin: 0 0 0 0;
	   padding: 0;
	}
	
	.category_h1{
	   font-size: 22pt;
	   margin: 9px 20px;
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
	/* border : 1px solid blue; */
	   margin : 0 20px;
	   height: 100px;
	   float: left;
	   display: inline-block;
	} 
	
	.menu_info{
	     /*   border : 1px solid red; */
		width: 100%;
	    height:100px;
		margin-left: 20px;
		border-radius: 10px;
		background-color: #F2E1B9;
	}
	
	
	.category_section{
	   width: 95%;
	   height: 50px;
	   border-radius: 10px;
	   background-color: #2ac1bc; 
	   
	}
	
	.category_h1{
	   display: inline-block;
	   margin-left:20px;
	}
	
	.mn_name, .mn_price, .menu_name, .menu_price, .menu_insert_btn, .insert_input {
	   width: 400px;
	   height: 20px;
	   border-radius: 5px;
	   margin: 0px 0px;
	    background-color: #F2E1B9;
	    border:none;
	}
	
	
	
	.mn_name{
	   font-size:15pt;
	   font-weight: bold;
	}
	
	.mn_price{
	   font-size:12pt;
	   
	   font-weight:bold;
	}
	
	.mn_comp, .menu_comp{
	   width: 400px;
	   height: 40px;
	   border-radius: 5px;
	   margin: 5px 5px;
	   background-color: #F2E1B9;
	   border:none;
	   outline: none;
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
    			<tr><td id=s2>별점  :	<p style="display:inline;" class="star_rating">
                        	<?php
                        	for($j=0;$j<5;$j++){
                        	    if($j<$star_point){
                        	        echo "<a class='on'>★</a>";
                        	    }else{
                        	        echo "<a>★</a>";
                        	    }
                        	}
                        	?>
                            		</p>	
    			<tr><td id=s3>배달가능지역 : <?= $store_delivery_area ?>
    			<tr><td id=s4>배달 시간  : <?= $store_delivery_time?>
    		</table>
    		</div><!-- end of store_data -->
    		
    		<div class="store_menu" style="border:1px solid green">
                <!-- TAB CONTROLLERS -->
                <input id="panel-1-ctrl" class="panel-radios" type="radio" name="tab-radios">
                <input id="panel-2-ctrl" class="panel-radios" type="radio" name="tab-radios">
                <input id="panel-3-ctrl" class="panel-radios" type="radio" name="tab-radios"  checked> <!-- 리뷰등록시 확인할것! -->
                
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
                        				 <div class='category_section' >
                        					<h1 class='category_h1'><?= $category ?></h1>
                        				</div> 
  
                                   <?php 
                                   $sql = "select * from menu where owner_no = '$owner_no' and category_name = '$category' order by category_name";
                                   $result  = mysqli_query($con, $sql);
                                   for(;$row = mysqli_fetch_array($result);){
                                       $menu_no = $row[menu_no];
                                      
                                       $category_name = $row[category_name];
                                       $menu_name = $row[menu_name];
                                       $menu_comp = $row[menu_comp];
                                       $menu_price = $row[menu_price];
                                       $menu_img = $row[menu_img];
                                       $dir_menu_img = "../owner_store_info/menu_img_data/".$menu_img;
                                   ?>
                                    <div class='menu_info' onclick="add_cart(this)">
                        			<div class='mn_info_input'>
                            				<input class='mn_name'  type='text' value='<?= $menu_name ?>' readonly><br>
                            			    <textarea class='mn_comp'   readonly><?= $menu_comp ?></textarea><br>
                            			    <input class='mn_price'  type='text' value='<?= $menu_price ?>' readonly><br>
                            			    <input class='ctgr_name'  type='hidden' value='<?= $category_name ?>' readonly><br>
                            			    <input class='mn_no' type ='hidden' value='<?=$menu_no ?>' readonly>
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
                              <table style='border: 1px solid black;'>
                            	<tr>
                            		<td>업체정보</td>
                            	</tr>
                            	<tr>
                            		<td>영업시간 : <td><?= $store_delivery_time?>
                                </tr>
                                <tr>
                            		<td>결제정보</td> 
                            	</tr>
                            	<tr>
                            		<td>최소주문금액 :</td> <td><?=$store_min_price ?>
                            	</tr>
                            	<tr>
                            		<td>결제수단 :</td> <td><?=$store_payment ?>
                            	</tr>
                            	<tr>
                            		<td>사업자 정보</td> 
                            	</tr>
                            	<tr>
                            		<td>상호명 :</td> <td><?=$store_name ?>
                            	</tr>
                            	<tr>
                            		<td>사업자 등록번호 :</td> <td><?= $business_license ?>
                            	</tr>
                                <tr>
                            		<td>원산지 정보</td> 
                            	</tr>
                            	<tr>
                            		<td>사업자 등록번호 :</td> <td><?= $store_origin ?>
                            	</tr>                       	
                            </table>
                          </main>
                        </section>
                        <section id="panel-3">
                            <main><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// -->
								
									
								








<?php 

$scale = 5;

$sql = "select * from review where owner_no = '$owner_no' order by no desc";
$result = mysqli_query($con, $sql);    //$result 는 DB 테이블에 가리키고있는 첫번째 레코드 포인터

$total_record = mysqli_num_rows($result); // 전체 글 수

// 전체 페이지 수($total_page) 계산
/* if ($total_record % $scale == 0)
    $total_page = floor($total_record/$scale); 
else
    $total_page = floor($total_record/$scale) + 1; 

    if(!empty($_GET['page'])){
        $page = $_GET['page'];   //페이지 값 설정(페이지값이 없으면)
    }
    if (!$page){                
        $page = 1;              
    }
    
    //표시할 페이지에 시작 레코드 $start    (전체레코드갯수에서 해당되는 갯수번호만 보여주는 역할)
    $start = ($page - 1) * $scale;
    
    //페이지별 시작할 인덱스넘버 ==> 보여줄 리스트번호
    $number = $total_record - $start; */
    
    
    
    

?> 


    <?php
/* $start+$scale는 $start 보다 무조건 5가 크다 어떻게 계산하든 */
    for (; $row=mysqli_fetch_array($result);)                    
   {                                    //$i < $total_record는 제일 마지막 페이지를 확인하는 것이다.     
      //$i번째의 레코드값을 포함하여 for문의 조건에 맞게 쭈르르륵 읽는다.
	
       $no=$row['no'];
       $user_id=$row['user_id'];
       $owner_no=$row['owner_no'];
       $order_no=$row['order_no'];
       $user_nick=$row['user_nick'];
       $user_content=$row['user_content'];
       $owner_content=$row['owner_content'];
       $star=$row['star'];
       $regist_day=$row['regist_day'];
       $love_it=$row['love_it'];
       $review_img=$row['review_img'];
	  
	  
       $memo_content = str_replace("\n", "<br>", $user_content);
	  $memo_content = str_replace(" ", "&nbsp;", $memo_content);
	 ?>
	  <div id="memo_writer_title" style="border: 1px solid black; width: 100%; height:220px;">
	  
	  <ul style="border: 1px solid black;">
		<li id="writer_title2"><?php echo  "$user_nick" ?></li>
		<li id="writer_title3"><?php echo  "$regist_day" ?></li>
		<li>&nbsp;&nbsp;&nbsp;
			<p style="display:inline;" class="star_rating">
	<?php
	for($j=0;$j<5;$j++){
	    if($j<$star){
	        echo "<a class='on'>★</a>";
	    }else{
	        echo "<a>★</a>";
	    }
	}
	?>
    		</p>	
    		
		</li>
		</ul>
           <div id="memo_content" style='border: 1px solid black; float: left;'><?= $memo_content ?></div> 
           <div id="img_div" style='border: 1px solid black; float: right;'><img style='width:120px; heignt:120px;' <?php if($review_img){?> src='../user_order/review_img_data/<?=$review_img?>'<?php }?>> </div>
		
		
		</div>  
		<?php 
		if(!empty($owner_content)){
		    ?>
    		    <div id="owner_content_div">
    		    	<div>사장님</div>
    		    	<?= $owner_content?>
    		    
    		     </div>
    		     
    		    
        <?php
    		}
		
		?>

<?php
	 } //end of for==========================================================
	 mysqli_close($con);
?>              
      
                          
     
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          
                          </main><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// --><!-- ////// -->
                        </section>
                      </div>
                    </article>      		
    		
    		</div><!-- end of store_menu -->
    		    		
		</div><!-- end of store_data -->
		
		<div class="cart_view" >
		<form name="cart_form" method="post" action="../order/order_form.php">
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
				
				<tr><td id=c3>최소주문금액 <?=$store_min_price?> 원 이상
				<tr><td id=c4>합계 <span id="sum"></span>원
				<tr><td id=c5><button type='button' onclick='order_request()'>주 문 하 기</button>
			</table>
		</div>
		
		</form>
		</div><!-- end of cart_view -->		
		
		
	</div><!-- end of store_view -->
		
	
	

	<!-- <footer>
      <?php //include "../common_lib/footer1.php"; ?>
	</footer> -->ㄴ
</body>
</html>