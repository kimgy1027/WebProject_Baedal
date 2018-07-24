<?php
session_start();
include "../common_lib/common.php";

$id=$_SESSION['id'];
$my_pass=$_POST['my_pass'];
$pass=$_POST['pass'];

if(isset($_POST['pass']) && isset($_POST['my_pass'])){
    $my_pass = $_POST['my_pass'];
    $pass = $_POST['pass'];
    
}

if($db_pass == $pass){
    $now_pass = true;
}


$sql="select * from membership where id='$id'";
$result=mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);
$db_pass=$row['pass'];


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href="../membership/css/join.css?v=2" rel=stylesheet>
</head>


<script type="text/javascript">

function check_exp(elem, exp, msg){
	if(!elem.value.match(exp)){
		alert(msg);
		return true;
	}
}
function check_input(){
	
	
	
 	// 암호 검사
	 var exp_pass= /^[0-9a-zA-Z~!@#$%^&*()]{8,20}$/;
 if(!document.pass_modify_form.pass.value){
		alert("암호를 입력해주세요");
		document.pass_modify_form.pass.focus();
		return ;
	}	 	 
	
 
 
	if(check_exp(document.pass_modify_form.pass, exp_pass, "암호는 8~20자리 영문 또는 숫자만 입력해주세요!")){
		document.pass_modify_form.pass.focus();
		document.pass_modify_form.pass.select();
		return ;
	}	 	
	
	if(document.getElementById("pass").value != document.getElementById("db_pass").value){
		alert("사용가능");
	
		

	}else{
		alert("현재 설정된 패스워드와 같습니다! 새로운 패스워드를 입력하시거나 취소하여주세요");
		return;
		/* location.href="./user_info.php"; */
	}
	
	
	
	document.pass_modify_form.submit();
	
	// 암호 일치 확인
	/* if(document.pass_check_form.pass.value != document.pass_check_form.passcheck.value){
		alert("암호가 일치하지 않습니다. 다시 입력해주세요");
		document.pass_check_form.pass.focus();
		document.pass_check_form.pass.select();
		return ;
	} */
}



function pass_use(pass){
	opener.info_form.pass.value = pass;
	window.close();
	
	
}

</script>

<body>
	<div class="wrap">
		<div id=id_check_title>
			<div id=id_check_title1><h1>비밀번호 변경</h1></div>
			<hr>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			사용하고자 하는 패스워드를 입력하신 후 검색 버튼을 눌러주세요.<br>
			(암호는 6~12자리 영문 또는 숫자만 입력해주세요!)
		</div>
		<br>
		<form name=pass_modify_form method=post action="modify_pwd.php">
		<div align="center">
			<input type="text" name="pass" id="pass" placeholder="패스워드를 입력하시오"/> <img id="search" src="./images/검색.jpg" height="30px" onclick="check_input()"><br>
			<input type="hidden" name="db_pass" id="db_pass" value="<?=$db_pass?>" readonly>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
		<?php 
		
		
		if($now_pass){
		?>
			<div id=text2 align=center>
			<b>현재 설정된 패스워드와 같습니다! 새로운 패스워드를 입력하시거나 취소하여주세요</b><br><br>
		</div>
		<?php 
		}else{
		    ?>
		<div id=text2 align=center>
			<b> '<font color=red><?=$pass?></font>'는 사용하실 수 있습니다.<br>
				이 패스워드를 사용하시겠습니까?</b><br><br>
			<button type="button" style="font-weight:bold; background:#2ac1bc; color:#FFFFFF; width:70px; height: 30px;" onclick="pass_use('<?=$pass?>')">확 인</button>
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>