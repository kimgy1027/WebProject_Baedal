<?php 
session_start();
$id = $_SESSION['id'];

include "../common_lib/common.php";


$flag = "NO";
$sql = "show tables from web_baedal_DB";
$result = mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="review"){
        $flag ="OK";
        break;
    }
}

if($flag!=="OK"){
    $sql= "create table review (
        no int not null auto_increment,
        user_id char(15) not null,
        owner_no char(15) not null,
        order_no char(20) not null,
        user_nick  char(10) not null,
        user_content text not null,
        owner_content text,
        star int not null,
        regist_day char(20) not null,
        review_img char(50),
        love_it char(20),
        primary key(no)
        )default charset=utf8;";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('review 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인2:".mysqli_query($con);
    }
}






$sql= "select * from order_list where id='$id' order by no desc";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));







?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css?v=4">
    <link rel="stylesheet" href="./css/user_order_list.css?v=13">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
	 function popupFunc(a){
    		var no = a; //store_regi의 no
    		var screenW=screen.availWidth; //스크린 가로사이즈
    		var screenH=screen.availHeight; //스크린 세로사이즈
    		var popW=440; //띄울 창의 가로사이즈
    		var popH=450; //띄울 창의 세로사이즈
    		var posL=(screenW-popW)/2;
    		var posT=(screenH-popH)/2;

    		window.open('./review.php?no='+no,'리뷰 남기기', 'width='+popW+', height='+popH +',top='+posT+',left='+posL, 'location=no,status=no,scrollbars=no');
    	}
	 
	 function look_more(a){
		var no = a; //order_list의 no
		var screenW=screen.availWidth; //스크린 가로사이즈
 		var screenH=screen.availHeight; //스크린 세로사이즈
 		var popW=540; //띄울 창의 가로사이즈
 		var popH=820; //띄울 창의 세로사이즈
 		var posL=(screenW-popW)/2;
 		var posT=(screenH-popH)/2;
		window.open('./user_order_view.php?no='+no,'주문내역 자세히보기', 'width='+popW+', height='+popH +',top='+posT+',left='+posL, 'location=no,status=no,scrollbars=no');

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
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 홈&nbsp; &nbsp; > &nbsp; &nbsp;주문내역</p>
      <hr>
   </div>
	
	<div class="order_info">
		<div class="order_list">
	<?php if(!mysqli_num_rows($result)){?> <!-- 주문내역이 없는 경우에 ~ -->
		<img id="no_order_img" alt="no_order" src="../common_img/주문내역없음.JPG">
	
	<?php }else{
	       while($row=mysqli_fetch_array($result)){
	        $no=$row['no']; //주문번호는 자세히 보기창 구현에 쓰임
	        $owner_no=$row['owner_no'];
	        $order_no=$row['no'];
	        $order_date=$row['order_date'];
	        $order_time=$row['order_time'];
	        $total=$row['total'];
	        $pay=$row['pay'];
	        $state=$row['state'];
	        
	        $sql2= "select * from store_regi where no=$owner_no";
	        $result2= mysqli_query($con, $sql2) or die("실패원인2:".mysqli_error($con));
	        
	        $row2=mysqli_fetch_array($result2);
	        $store_no=$row2['no'];
	        $store_name=$row2['store_name'];
	        $store_logo_img=$row2['store_logo_img'];

	        ?>	    
    		<table>
    			<tr class="tr1"><td rowspan="3" class="td1"><img style="width:145px; height:145px;" src="../owner_store/Regi_logo_img_data/<?=$store_logo_img?>"><td class="td2"><?= $store_name ?><td class="td3"><img src="../common_img/자세히.jpg" onclick="look_more(<?=$no?>)" id="look"><td class="td4">
    			<?php if($state=="wait"){
    			     	echo "<img src='../common_img/접수중.JPG'>";
    			}else if($state=="ing"){
    			    echo "<img src='../common_img/배달중2.JPG'>";
    			}else if($state=="end"){
    			    echo "<img src='../common_img/배달완료.JPG'>";
    			}else if($state =='cancel'){
    			    echo "취소되었습니다.";
    			}?>
    			
    			
    			
    			<tr class="tr2"><td class="td2">[주문 일자] <?=$order_date ?><td class="td3">[주문 시간]  <?= $order_time ?>
    				<td class="td4"><button type="button" onclick="location.href='../store/store_view.php?no=<?=$owner_no?>'"><img src="../common_img/주문하기.jpg"></button>
    			<tr class="tr3"><td class="td2"><?php if($pay=="now-cash"){
    			                        echo "바로 결제";
                            			}else if($pay=="now-card"){
                            			    echo "카드 결제";
                            			}else if($pay=="after-cash"){
                            			    echo "만나서 현금 결제";
                            			}else{
                            			    echo "만나서 카드 결제";
                            			}   			                           
                            			?>  <td class="td3"><?= $total ?>원
    				<td class="td4"><?php //리뷰 정보
                            			     $sql2="select*from review where order_no='$order_no'";
                                            $result2= mysqli_query($con, $sql2) or die("실패원인1:".mysqli_error($con));
                                     				
    				                    if(!mysqli_num_rows($result2)){?>
    									<button type="button" onclick="popupFunc(<?=$no?>)"><img src="../common_img/리뷰쓰기.jpg"></button>
    								<?php }?>
    		</table> 
	<?php
	        } //end of while1
	    
	    }?> <!-- end of else -->
	    </div> 
	</div>
  
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>