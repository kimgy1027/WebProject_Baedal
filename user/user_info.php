<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css">
    <link rel="stylesheet" href="./css/user_info.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</head>
<body>
	<header>
		<?php include "../common_lib/top_login1.php"; ?>
	</header>
	
	<div class="logo">
		<a href="./index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>

	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>
    
    <div class="location">
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 내정보</p>
      <hr>
   </div>
	
   <div class="my">
   	<div class="my_info">
    	<p>아이디 정보</p>
    	<table>
        <tr><td class="td1">아이디<td class="td2">id
        <tr><td class="td1">닉네임<td class="td2"><input type="text" value="nick"><button type="button">변 경</button>
        <tr><td class="td1">비밀번호<td class="td2"><input type="password" value="pass"><button type="button">변 경</button>
        </table>
    </div>

    <div class="like_store_info">
    	<p>즐겨찾기한 매장</p>
    	<table>
        
        </table>
    </div>
   </div>
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>