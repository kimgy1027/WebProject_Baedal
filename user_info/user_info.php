﻿<?php 
session_start();

 include "../common_lib/common.php";
$id = $_SESSION['id'];
$nick = $_SESSION['nick'];


 $sql= "select * from membership where id='$id'";
 $result= mysqli_query($con, $sql) or die("실패원인ㅋㅋ:".mysqli_error($con));
 $row=mysqli_fetch_array($result);
 $id=$row['id'];
 $pass=$row['pass'];
 $nick=$row['nick'];  
 $email=$row['email'];  

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css?v=3">
    <link rel="stylesheet" href="./css/user_info.css?v=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"> </script>
   <script type="text/javascript">
  
    function change_nick_check(a){
    	var mode = a;
        var screenW=screen.availWidth; //스크린 가로사이즈
        var screenH=screen.availHeight; //스크린 세로사이즈
        var popW=500; //띄울 창의 가로사이즈
        var popH=300; //띄울 창의 세로사이즈
        var posL=(screenW-popW)/2;
        var posT=(screenH-popH)/2;
   /*  	
		window.open("./modify_info.php?","닉네임변경창",
		          "left=200,top=200,width=500,height=300,scrollbars=no,resizable=yes");  */
		
		 window.open('./modify_nick.php?mode='+mode+'','닉네임 변경창', 'width='+popW+', height='+popH +',top='+posT+',left='+posL+', location=no'); 
    }
    
    function change_pwd_check(a){
    	var mode = a;
        var screenW=screen.availWidth; //스크린 가로사이즈
        var screenH=screen.availHeight; //스크린 세로사이즈
        var popW=500; //띄울 창의 가로사이즈
        var popH=300; //띄울 창의 세로사이즈
        var posL=(screenW-popW)/2;
        var posT=(screenH-popH)/2;
   /*  	
		window.open("./modify_info.php?","닉네임변경창",
		          "left=200,top=200,width=500,height=300,scrollbars=no,resizable=yes");  */
		
		 window.open('./modify_pwd.php?mode='+mode+'','비밀번호 변경창', 'width='+popW+', height='+popH +',top='+posT+',left='+posL+', location=no'); 
    }
    
  //팝업창 가운데 띄우기
    function popupFunc(a){
         var mode = a;
         var screenW=screen.availWidth; //스크린 가로사이즈
         var screenH=screen.availHeight; //스크린 세로사이즈
         var popW=300; //띄울 창의 가로사이즈
         var popH=300; //띄울 창의 세로사이즈
         var posL=(screenW-popW)/2;
         var posT=(screenH-popH)/2;
         
         window.open('./modify_pwd.php?mode='+mode+'','비번변경창', 'width='+popW+', height='+popH +', top='+posT+', left='+posL+', location=no');
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
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 내정보</p>
      <hr>
   </div>
	
   <div class="my">
       	<form class="form" name="info_form" action="./update_info.php" method="post">
           	<div class="my_info">
            	<p>아이디 정보</p>
            	<table>
                <tr><td class="td1">아이디<td class="td2"><input type="text" name="id" value="<?= $id ?>" disabled>
                <tr><td class="td1">닉네임<td class="td2"><input type="text" name="nick" value="<?= $nick ?>"  readonly><button type="button" onclick="change_nick_check()">변 경</button>
                <tr><td class="td1">비밀번호<td class="td2"><input type="password" name="pass" value="<?= $pass ?>" readonly><button type="button" onclick="change_pwd_check()">변 경</button>
                <tr><td class="td1">이메일<td class="td2"><input type="text" name="email" value="<?= $email ?>" disabled>
                <tr><td class="td2"><label>　　　　</label><td><button type="submit" style="width: 100%">업데이트</button></td>
                
                
                </table>
            </div>
    	</form>
    <div class="like_store_info">
    	<p>즐겨찾기한 매장</p>
    	<table>
        
        </table>
    </div>
    <div class="review_info">
    	<p>리뷰 관리</p>
    
    </div>
   </div>
	<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>