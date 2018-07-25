<?php
session_start();

$no=$_GET['no']; //가게의 PK
$nick=$_SESSION['nick'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>리뷰 남기기</title>
    <link rel="stylesheet" href="../common_css/common.css?v=1">
    <link rel="stylesheet" href="./css/review.css?v=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready(function(){
    	$( ".star_rating a" ).click(function() {
    	     $(this).parent().children("a").removeClass("on");
    	     $(this).addClass("on").prevAll("a").addClass("on");
    	     $(".star").val($(".on").length);
    	     return;
    	});




    });
    </script>
    <style>
        
.star_rating {font-size:0; letter-spacing:-4px;}
.star_rating a {
    font-size:22px;
    letter-spacing:0;
    display:inline-block;
    margin-left:5px;
    color: #D0CDB6;
    text-decoration:none;
}
.star_rating a:first-child {margin-left:0;}
.star_rating a.on {color: #FFE400;}
    </style>
</head>
<body>
	<form action="./review_insert.php" name="review_info" method="post" enctype="multipart/form-data">
	<div class="review_info">
    	<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;리뷰 남기기</p>
    	<hr>
    	
    	<input class="star" name="star" type="hidden" value="3">
		<table>
		<tr class="tr1"><td class="td1">별점<td class="td2">
		<p class="star_rating">
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#">★</a>
            	<a href="#">★</a>
            	
    		</p>	
		<tr class="tr2"><td class="td1">닉네임<td><?=$nick?>
		<tr class="tr3"><td class="td1" colspan="2"><textarea placeholder="무분별한 비방글은 제재 당할 수 있습니다."></textarea>
		<tr class="tr4"><td class="td1" colspan="2"><input class="content" type="file" id="store_logo_img" name="store_logo_img">
		<tr class="tr5"><td class="td1" colspan="2"><>
		<tr class="tr6"><td class="td1" colspan="2"><button>완 료</button>
		</table>
		
	</div>
</form>
</body>
</html>
