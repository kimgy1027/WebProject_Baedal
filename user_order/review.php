<?php
session_start();


include "../common_lib/common.php";

$no=$_GET['no']; //가게의 PK
$nick=$_SESSION['nick'];


$sql="select * from order_list where no=$no";
$result=mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);
$owner_no=$row['owner_no'];
$order_no=$row['no'];



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
     <script type="text/javascript">
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
		
			$("#review_img").attr("src", e.target.result);
			
		}
		reader.readAsDataURL(elem.files[0]);
	
	
}
    	
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
    	<input class="business_license" name="owner_no" type="hidden" value="<?=$owner_no?>">
    	<input class="no" name="order_no" type="hidden" value="<?=$order_no?>">
		<table>
		<tr class="tr1"><td class="td1">별점<td class="td2">
		<p class="star_rating">
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#">★</a>
            	<a href="#">★</a>
		<tr class="tr2"><td class="td1">닉네임<td><?=$nick?>
		<tr class="tr3"><td class="td1" colspan="2"><textarea placeholder="무분별한 비방글은 제재 당할 수 있습니다." name="user_content" style="resize: none;"></textarea>
		<tr class="tr4"><td class="td1" colspan="2"><input class="content" type="file" id="store_logo_img" name="review_img" onchange='handleImgFileSelect(this)'>
		<tr class="tr5"><td class="td1" colspan="2"><img id="review_img" style="max-width: 250px; max-height: 250px;"/>
		<tr class="tr5"><td class="td1" colspan="2"><button>완 료</button>
		</table>	
	</div>
</form>
</body>
</html>
