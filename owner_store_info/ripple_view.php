<?php
session_start();
include "../common_lib/common.php";
$id=$_SESSION['id'];
$nick=$_SESSION['nick'];

$sql= "select * from ripple where nick='$nick'";
$result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
$row = mysqli_fetch_array($result);
$num = mysqli_fetch_row($result);
$content = $row['content'];

$total = mysqli_num_rows($result);
?>
<html>
<meta charset="utf-8">
<head>
<link rel="stylesheet" href="./slide/css/slide.css?v=1">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
<script type="text/javascript">

         

</script>
</head>
<body>
<input type="button" value="리뷰를 남겨주세요" onclick="winOpen()">
<div id="review">총 <?php echo $total?>개의 리뷰가 있어요</div>

<?php 
 for ($i=0; $i<$total; $i++)                    
   {    
      mysqli_data_seek($result, $i);   //db의 위치를 저장
      $row = mysqli_fetch_array($result);
      $content = $row['content'];
      $nick = $row['nick'];
      $score = $row['score'];
?>
<div>닉네임 : <?php echo $nick;?> <input type="button" value="삭제" style="margin-left: 100" oncick="delete()"> <br>
	 점수 : <?php echo $score;?>
<div><?php echo $content;?></div></div>
<?php }?>
      
</body>
</html>