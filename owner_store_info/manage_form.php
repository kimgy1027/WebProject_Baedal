<?php 
    session_start();
    
    include '../common_lib/common.php';
    
    $flag = "NO";
    $sql = "show tables from web_baedal_DB";
    $result = mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
    while($row=mysqli_fetch_row($result)){
        if($row[0]==="menu"){
            $flag ="OK";
            break;
        }
    }
    
    if($flag!=="OK"){
        $sql= "create table menu (
                  owner_no int not null,
                  menu_no int not null,
                  category_name char(50) not null,
                  menu_name char(50) not null,
                  menu_comp char(50) not null,
                  menu_price char(50) not null,
                  menu_img char(50) not null
               )default charset=utf8;";
        if(mysqli_query($con,$sql)){
            echo "<script>alert('menu 테이블이 생성되었습니다.')</script>";
        }else{
            echo "실패원인2:".mysqli_query($con);
        }
    }
    
    
    
    if(isset($_SESSION[id])){
        $id = $_SESSION[id];
    }
    
    if(isset($_POST[owner_no])){
        
        $owner_no =$_POST[owner_no];
    }
    
    
    $sql = "select * from store_regi where no='$owner_no'" ;
   $result  = mysqli_query($con, $sql);
   
  $row  = mysqli_fetch_array($result);
  
  $store_delivery_area_str=$row[store_delivery_area];
  $store_delivery_area_array=explode("/", $store_delivery_area_str);
  $store_name = $row[store_name];
  $business_license = $row[business_license];
  $store_delivery_time = $row[store_delivery_time];
  $store_origin = $row[store_origin];
  $store_min_price = $row[store_min_price];
  $store_payment = $row[store_payment];
  
 
  
  
  $sql2 = "select distinct category_name from menu where owner_no = '$owner_no' order by category_name desc";
  $category_num_result = mysqli_query($con, $sql2);
   
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css?v=4">
    <link rel="stylesheet" href="./css/manage_form_style.css?v=5">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"> 
    var sel_files = []; 
///////////////////////////////////////
	
	
	
	function add_category(){
		if($(".insert_input").val().length <= 0){
			alert("카테고리 명을 입력해 주셔야 합니다!");
			return;
		}
		
		$(".a").before( //추가 div 앞쪽에 원하는 컨텐츠를 추가시킨다.
			"<div class='category_area'>"+
				"<div class='category_section'>"+
					"<h1 class='category_h1'>"+$(".insert_input").val()+"</h1>"+
					"<input class='del_category_btn' type='button' onclick='del_category(this)' value='카테고리 전체 삭제'>"+
				"</div>"+
					"<div class='add_menu'>"+
						"<input class='category_name' type='text' value='"+$(".insert_input").val()+"'> <br>"+
						"<input class='menu_name' type='text' placeholder='메뉴명'><br>"+
					    "<textarea class='menu_comp' placeholder='메뉴구성'></textarea><br>" +
					    "<input class='menu_price' type='number' placeholder='가격'><br>"+
					    "<input class='menu_insert_btn' type='button' value='메뉴추가' onclick='add_menu(this)'>*메뉴추가 이후에 이미지를 설정해 줄 수 있습니다! "+
			    	"</div>"+
			 "</div>"
		);
		
		$(".insert_input").val(""); // 값 초기화
	}
	
	function add_menu(element){
		if($(element).siblings(".menu_name").val().length <= 0 || $(element).siblings(".menu_comp").val().length <= 0 || $(element).siblings(".menu_price").val().length <= 0){
			alert("모든 항목을 입력해 주세요!");
			return;
		}
		
		
		$(element).parent().before(
			"<div class='menu_info'>"+
				"<div class='mn_info_input'>"+
    			    "<input class='ctgr_name' name='category_name[]' type='text' value='"+$(element).siblings(".category_name").val()+"' readonly><br>"+
    				"<input class='mn_name' name='menu_name[]' type='text' value='"+$(element).siblings(".menu_name").val()+"' readonly><br>"+
    			    "<textarea class='mn_comp' name='menu_comp[]' readonly>"+$(element).siblings(".menu_comp").val()+"</textarea><br>" +
    			    "<input class='mn_price' name='menu_price[]' type='text' value='"+$(element).siblings(".menu_price").val()+"' readonly><br>"+
			    "</div>"+
			    	"<div class='img_area'> "+
			    		"<input class='mn_img' name='menu_img[]' type='file' onchange='handleImgFileSelect(this)'><br>"+
			    		" <img class='sel_img' src='../common_img/사진없음.JPG' accept='image/gif,image/jpeg,image/png' />"+
			   	 	"</div>"+
			    "<input class='nw_del_btn' type='button' onclick='del_menu(this)' value='현재 메뉴 삭제'>"+
	   		"</div>"		
		);
	
		$(".menu_name").val("");
		$(".menu_comp").val("");
		$(".menu_price").val("");
		
	}
	
	function del_menu(element){
		
		
		var menu_no = $(element).closest(".menu_info").find(".db_menu_no").val();
		var owner_no = <?=json_encode($owner_no)?> ;
		
		if(menu_no){
			var ok = confirm("현재메뉴를 정말 삭제하시겠습니까?");
			if(ok){
				$.ajax({
					type : "post",
					url : "./menu_del.php",
					data : "menu_no="+menu_no+"&owner_no="+owner_no,
					success : function(data){
						$(element).parent().remove(); //부모요소(이경우 div)를 삭제한다.
					}
				});
			}else{
				return;
			}
			
		
		}else{
			
			$(element).parent().remove();
		}
	}
	
	function del_category(element){
		
		
			$(element).closest(".category_area").remove(); //부모요소중 선택자를 사용해 조작할 수 있는 closest;
	}
	
	
	
	
	
	
	function handleImgFileSelect(elem){
			fileNm = $(elem).val();	
		
			if(fileNm != ""){
				var ext = fileNm.slice(fileNm.lastIndexOf(".") +1).toLowerCase();
				if(!(ext == "gif" || ext == "jpg" || ext == "png")){
					alert("이미지파일 (.jpg, .png, .gif) 만 업로드 가능합니다.");
					$(elem).val("");
					
					return;
				}
				
			}
		
			var reader = new FileReader();
			reader.onload = function(e){
			
				$(elem).siblings(".sel_img").attr("src", e.target.result);
				
			}
			reader.readAsDataURL(elem.files[0]);
		
		
	}
	
	function check_menu(){
		var is_img = "yes";
		
		$("input[class=mn_img]").each(function(idx){
			
			if(!$(this).val()){
				is_img = "no";
				var category_name = $(this).closest(".menu_info").children(".mn_info_input").children(".ctgr_name").val();
				var menu_name = $(this).closest(".menu_info").children(".mn_info_input").children(".mn_name").val();
				alert(category_name+" 카테고리의 "+menu_name+"의 이미지가 설정되어 있지 않습니다.!");
				return;
			}
		});
		
		if(is_img=="no"){
			return;
		}
		
		document.insert_form.submit();
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
	
	
	
	.img_area{
	   float: left;
	   display:inline-block;
	   width: 200px;
	   height: 230px;
	}
	
	.img_area img{
	   width: 200px;
	   height: 200px;
	}
	
	
	.mn_info_input{
	   float: left;
	   display: inline-block;
	} 
	
	.menu_info{
		width: 95%;
	    height:250px;
		margin-left: 20px;
		border-radius: 10px;
		background-color: #F2E1B9;
	}
	
	
	
	.add_menu{
	    width: 95%;
	   margin-left: 20px;
	   border-radius: 10px;
	   
	}
	
	.category_section{
	   width: 95%;
	   height: 50px;
	   border-radius: 10px;
	   background-color: #F36A4C; 
	   
	}
	
	
	.insert_form{
	   width: 84%;
	   
	   
	   display: inline-block;
		border: 1px solid black;
	}
	
	.del_category_btn{
	   float: right;
	   margin: 10px 20px;
	   
	}
	
	.category_h1{
	   display: inline-block;
	   margin-left:20px;
	}
	
	.a{
	   width: 95%;
	   height: 50px;
	   border-radius: 10px;
	   background-color: #F36A4C;
	}
	
	.mn_name, .mn_price, .menu_name, .menu_price, .menu_insert_btn, .insert_input {
	   width: 400px;
	   height: 30px;
	   border-radius: 5px;
	   margin: 5px 5px;
	}
	
	.mn_comp, .menu_comp{
	   width: 400px;
	   height: 100px;
	   border-radius: 5px;
	   margin: 5px 5px;
	}
	
	
	
	
	
</style>
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
	
	<div class="store_view" style="border:1px solid green">  
		<div class="store_data" style="border:1px solid green">		
    		<div class="store_outline" style="border:1px solid green">
    		<table>
    			<tr><td colspan="2" id=s1><?=$store_name ?>
    			<tr><td id=s2>별점
    			<tr><td id=s3>배달 가능 지역 : <?=$store_delivery_area_str ?>
    			<tr><td id=s4>배달 시간 : <?=$store_delivery_time ?>
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
                      <div class="container">
                        <section id="panel-1" style="border:1px solid green;">
                          <main>
                          <form class='insert_form' name="insert_form" method="post" action="./menu_insert.php"  enctype="multipart/form-data">
							<input name="owner_no" type="hidden" value="<?=$owner_no?>">	
                              	<?php 
                              	for(;$category_row = mysqli_fetch_array($category_num_result);){
                              	    
                              	    $category=$category_row[category_name];
                              	   
                              	  

                              ?>
                              	     <div class='category_area'>
                        				 <div class='category_section'>
                        					<h1 class='category_h1'><?= $category ?></h1>
                        					<input class='del_category_btn' type='button' onclick='del_category(this)' value='카테고리 전체 삭제'>
                        				</div> 
  
                                   <?php 
                                   $sql = "select * from menu where owner_no = '$owner_no' and category_name = '$category' order by menu_no desc";
                                   $result  = mysqli_query($con, $sql);
                                   for(;$row = mysqli_fetch_array($result);){
                                       $owner_no = $row[owner_no];
                                       $menu_no = $row[menu_no];
                                       $category_name = $row[category_name];
                                       $menu_name = $row[menu_name];
                                       $menu_comp = $row[menu_comp];
                                       $menu_price = $row[menu_price];
                                       $menu_img = $row[menu_img];
                                       $dir_menu_img = "./menu_img_data/".$menu_img;
                                   ?>
                                    <div class='menu_info'>
                        			<div class='mn_info_input'>
                        			        <input class='db_menu_no' type="text" name="db_menu_no[]" value="<?= $menu_no?>">
                            			    <input class='ctgr_name' name='db_category_name[]' type='text' value='<?= $category_name ?>' readonly><br>
                            				<input class='mn_name' name='db_menu_name[]' type='text' value='<?= $menu_name ?>' readonly><br>
                            			    <textarea class='mn_comp' name='db_menu_comp[]' readonly><?= $menu_comp ?></textarea><br>
                            			    <input class='mn_price' name='db_menu_price[]' type='text' value='<?= $menu_price ?>' readonly><br>
                        			    </div>
                        			    	<div class='img_area'>
                        			    		 <img class='sel_img' src='<?= $dir_menu_img?>' accept='image/gif,image/jpeg,image/png' />
                        			   	 	</div>
                        			    <input class='del_btn' type='button' onclick='del_menu(this)' value='현재 메뉴 삭제'>
                        	   		</div>	
                                   			
                                   
                                   
                                   <?php     
                                       
                                   }
                                  	    
                                   ?>
                              	            <div class='add_menu'>
                        						<input class='category_name' type='text' value='<?= $category_name ?>'> <br>
                        						<input class='menu_name' type='text' placeholder='메뉴명'><br>
                        					    <textarea class='menu_comp' placeholder='메뉴구성'></textarea><br>
                        					    <input class='menu_price' type='number' placeholder='가격'><br>
                        					    <input class='menu_insert_btn' type='button' value='메뉴추가' onclick='add_menu(this)'>*메뉴추가 이후에 이미지를 설정해 줄 수 있습니다!
                        			    	</div>
                        				</div>    
                              	    <?php
							
                         }
                              	    ?> 
                
                            
								<div class="a">
								<input class="insert_input" type="text" placeholder="추가시킬 카테고리명을 입력하세요!"> <input class="ctgr_insert_btn" type="button" value="추가" onclick='add_category()'>
								</div>
								<div>
									<button type='button' onclick='check_menu()'>등록</button>
								</div>
							</form>
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
                          <main>
                            <?php include "./ripple_view.php"?>
                          </main>
                        </section>
                      </div>
                    </article>      		
    		
    		</div><!-- end of store_menu -->
    		    		
		</div><!-- end of store_data -->
		
<!-- 		<div class="cart_view" > -->
		<!--<div style="position:relative; width:100%; height:1200px; border:1px solid black">--> <!--div 기준으로 table의 위치가 선정된다  -->
<!-- 			<table id=cart_table> -->
				<!--   <tr><td id=c1>장바구니<div></div><img onclick="delCart()" src="../common_img/waste-bin.png"> -->
<!-- 				<tr><td class=cart> -->
				<?php ?> <!--이벤트 결과에 따라 테이블 생성 -->
<!-- 				<table><tr><td colspan="2" id=c2_1>상호명 -->
<!-- 				<tr><td colspan="2" >메뉴정보 -->
<!-- 				<tr><td>가격<td id=c2_3_2>수량조절버튼 -->
<!-- 				</table> -->
				
	<!--			<tr><td id=c3>최소주문금액 <?php ?>원 이상
				<tr><td id=c4>합계 <?php ?>원
<!-- 				<tr><td id=c5><button>주 문 하 기</button> -->
<!-- 			</table> -->
<!-- 		</div> -->
	<!--	</div><!-- end of cart_view -->		
		
		
	</div><!-- end of store_view -->
		
	
	

	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer> 
</body>
</html>