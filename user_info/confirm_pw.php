<?php
session_start();
$id = $_SESSION['id'];

include "../common_lib/common.php";
if(isset($id)){
    $sql = "select * from membership where id='$id'";
    $result = mysqli_query($con, $sql) or die("실패원인 : ".mysqli_error($con));
   
        $row = mysqli_fetch_array($result);
        $pass = $row['pass'];
    
}else{
    echo "<script>
            alert('잘못된 접근입니다.');
            history.go(-1);
        </script>";
}
?>             
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>김윤준이만짐</title>
<link rel="stylesheet" href="./css/confirm_pw.css?v=2"> 

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	function find_pw(){
		
		
		if(document.getElementById("password").value != document.getElementById("db_pass").value){

			alert(document.getElementById('password').value);
		}else{
			location.href="./user_info.php";
		}

	}

</script>


</head>
<body>

    <form class="form" method="post" action="./user_info.php">
      <input id="password" type="password" name="pass" placeholder="비밀번호를 입력하시오"/>
      <div style="text-align: left">
        <div style="display:inline-block;">
     		 내 정보 설정을 위해 비밀번호 입력 후, 확인을 눌러주세요.
        </div>
      </div>  
      <button type="button" onclick="find_pw()">확 인</button>
      <input id = "db_pass" type='hidden' value="<?= $pass?>">
      <p class="message">우리팀화이팅<br><a href="#">(주) 배달의 신</a></p>
    </form>
</body>


</html>