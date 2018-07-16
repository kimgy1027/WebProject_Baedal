<?php 
session_start();
$_SESSION['id'] = "een0422";

$id = $_SESSION['id'];

include "../common_lib/common.php";

$sql= "select * from order_list where id='$id' order by no desc";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css?v=2">
    <link rel="stylesheet" href="./css/user_order_list.css?v=3">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

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
    
    <div class="location">
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 주문내역</p>
      <hr>
   </div>
	
	<div class="order_info">
		<div class="order_list">
	<?php if(!$row=mysqli_fetch_array($result)){?> <!-- 주문내역이 없는 경우에 ~ -->
		<img id="no_order_img" alt="no_order" src="../common_img/주문내역없음.JPG">
	
	<?php }else{
	       while($row=mysqli_fetch_array($result)){
	        $business_license=$row['business_license'];
	        $order_date=$row['order_date'];
	        $order_time=$row['order_time'];
	        $state=$row['state'];
	        
	        $sql2= "select * from store_regi where business_license='$business_license'";
	        $result2= mysqli_query($con, $sql2) or die("실패원인2:".mysqli_error($con));
	        
	        $row2=mysqli_fetch_array($result2);
	        $store_name=$row2['store_name'];
	        ?>	    
    		<table>
    			<tr class="tr1"><td rowspan="2" class="td1">이미지<td class="td2"><?= $store_name ?><td rowspan="2" class="td3">
    			<?php if($state=="wait"){
    			     	echo "<p id='state'>접수 중</p>";
    			}else if($state=="ing"){
    			    echo "<p id='state'>배달 중</p>";
    			}else{
    			    echo "<p id='state'>배달 완료</p>";
    			}?>
    			
    			<tr><td class="td2">주문 일자 : <?=$order_date ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;주문 시간 <?= $order_time ?>
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