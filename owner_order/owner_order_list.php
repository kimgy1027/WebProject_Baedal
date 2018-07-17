<?php 
    session_start();

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css">
    <link rel="stylesheet" href="./css/owner_order_list.css?v=3">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var $items = $('#vtab>ul>li');
            $items.mouseover(function() {
                $items.removeClass('selected');
                $(this).addClass('selected');

                var index = $items.index($(this));
                $('#vtab>div').hide().eq(index).show();
            }).eq(1).mouseover();
        });
       	//팝업창 가운데 띄우기
        function popupFunc(a){
       		var mode = a;
       		var screenW=screen.availWidth; //스크린 가로사이즈
       		var screenH=screen.availHeight; //스크린 세로사이즈
       		var popW=500; //띄울 창의 가로사이즈
       		var popH=600; //띄울 창의 세로사이즈
       		var posL=(screenW-popW)/2;
       		var posT=(screenH-popH)/2;
       		
       		window.open('owner_order_view.php?mode='+mode+'','주문 상세보기', 'width='+popW+', height='+popH +',top='+posT+',left='+posL+', location=no');
       	}
    </script>
    
    
    
</head>
<body>
	<header>
		<?php include "../common_lib/top_login1.php"; ?>
	</header>
	
	<div class="logo">
		<a href="../index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>
	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>
	
	 <div id="vtab">
        <ul>
            <li class="order_wait selected">접수대기<br><?php ?></li>
            <li class="order_ing">처리중<br><?php ?></li>
            <li class="order_end">완료<br><?php ?></li>
            <li class="total_order_list">주문내역<br><?php ?></li>
        </ul>
        <div class="tab_div"><!--접수대기 -->
        	<div class="wait_div">
        	
            <!-- 여기부터 데이터 변경시켜주면댐 -->
            	<div class="div1" onclick="popupFunc('wait')">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>접수대기</span><td><?php ?>주소
              		</table>
               </div><!-- end of div1 -->
            	<div class="div2" onclick="popupFunc('wait')">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>접수대기</span><td><?php ?>주소
              		</table>
               </div><!-- end of div2 -->
               
           </div><!-- end of wait_div -->           
        </div><!-- end of tab_div -->
        
        <div class="tab_div"><!--처리중 -->
        	<div class="ing_div">
        	
        		<!-- 여기부터 데이터 변경시켜주면댐 -->
               	<div class="div1" onclick="popupFunc('ing')">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>처리중</span><td><?php ?>주소
              		</table>
               </div><!-- end of div1 -->
            	<div class="div2"  onclick="popupFunc('ing')">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>처리중</span><td><?php ?>주소
              		</table>
               </div><!-- end of div2 -->  
               
           </div> <!-- end of ing_div -->
        </div><!-- end of tab_div -->
        
        <div class="tab_div"><!--완료 -->
            <div class="end_div">
        	
        		<!-- 여기부터 데이터 변경시켜주면댐 -->
               	<div class="div1" onclick="popupFunc('end')">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>완료</span><td><?php ?>주소
              		</table>
               </div><!-- end of div1 -->
            	<div class="div2">
               		<table><tr><td><?php ?>일 자<td><?php ?>매장이름
               		<tr><td rowspan="2" id="order_time"><?php ?>주문시간<td><?php ?>주문가격
               		<tr><td><?php ?>주문내역
               		<tr><td><span>완료</span><td><?php ?>주소
              		</table>
               </div><!-- end of div2 -->  
               
           </div> <!-- end of ing_div -->
        </div><!-- end of tab_div -->
        
        <div class="tab_div"><!--주문내역 -->
            <div class="total_order_div">
        
               
           </div> <!-- end of ing_div -->
        </div><!-- end of tab_div -->
    </div><!-- end of vtab -->
	
	
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>