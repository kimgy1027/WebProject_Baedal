<?php 
include "../common_lib/common.php";
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function mail(){
	location.href="./PHPMailer/webemail_index.php";
}
</script>
<meta charset="UTF-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="./css/pw_find.css?v=1"> 

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


</head>
<body>
    <form class="form" method="post" action="./PHPMailer/webemail_index.php">
      <input type="text" name="email" placeholder="이메일 주소 입력(필수)"/>
      <div style="text-align: left">
        <div style="display:inline-block; font-size: 11pt;">
     		 비밀번호 설정을 위해 가입하신 이메일 주소를 입력 후, 이메일 발송 버튼을 눌러주세요.
        </div>
      </div>  
      <button id="email_go">이메일 발송</button>
      <p class="message">우리팀화이팅<br><a href="#">(주) 배달의신</a></p>
    </form>
</body>


</html>