<?php
session_start();
include "../common_lib/common.php";

$id=$_SESSION['id'];

if(isset($_POST['my_nick']) && isset($_POST['nick'])){
    $my_nick = $_POST['my_nick'];
    $nick = $_POST['nick'];
    
    var_dump($my_nick.$nick);
    
    if($my_nick == $nick){
        $now_nick = true;
    }else{
        $sql = "select * from membership where nick='$nick' and not id='$id'";
        $result = mysqli_query($con, $sql);
        $num_record = mysqli_num_rows($result);
    }
    
  
   
    
}else{
    
    $sql = "select * from membership where id='$id'" ;
    
    $result = mysqli_query($con, $sql);
    
    $row = mysqli_fetch_array($result);
    
    $my_nick = $row['nick'];
    
    $num_record = true;
}





 

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
	if(!document.join_form.user.value){
		alert("회원종류를 선택해주세요");
		return;
	}
	
	// 아이디 검사
	var exp_id= /^[0-9a-zA-Z]{6,12}$/;
	if(check_exp(document.join_form.id, exp_id, "ID는 6~12자리 영문 또는 숫자만 입력해주세요!")){
		document.join_form.id.focus();
		document.join_form.id.select();
		return ;
	}
	
	
	var exp_nick= /^[0-9a-zA-Z가-하]{2,10}$/;
	if(!document.join_form.nick.value){
		alert("닉네임을 입력 해주세요");
		document.join_form.nick.focus();
		return ;
	}			
	if(check_exp(document.join_form.nick, exp_nick, "닉네임 올바르게 입력해주세요")){
		document.join_form.nick.focus();
		document.join_form.nick.select();
		return ;
	}	
	
	 if(email_pass === "N"){
			alert("이메일을 인증해주세요 !!");
			return;
		}
	
 	// 암호 검사
	var exp_pass= /^[0-9a-zA-Z~!@#$%^&*()]{10,16}$/;
	if(!document.join_form.pass.value){
		alert("암호를 입력해주세요");
		document.join_form.pass.focus();
		return ;
	}			
	if(check_exp(document.join_form.pass, exp_pass, "암호는 6~12자리 영문 또는 숫자만 입력해주세요!")){
		document.join_form.pass.focus();
		document.join_form.pass.select();
		return ;
	}		
	
	// 암호 일치 확인
	if(document.join_form.pass.value != document.join_form.passcheck.value){
		alert("암호가 일치하지 않습니다. 다시 입력해주세요");
		document.join_form.pass.focus();
		document.join_form.pass.select();
		return ;
	}
	

	
	
	document.join_form.submit();
}


function pwd_use(pwd){
	opener.info_form.nick.value = pwd;
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
		<form name=id_check_form method=post action="modify_nick.php">
		<div align="center">
			<input type="text" name="nick" id="nick" placeholder="패스워드를 입력하시오"/> <img id="search" src="./images/검색.jpg" height="30px" onclick="check_input()">
			<input type="text" name="my_nick" id="db_nick" value="<?=$my_nick?>" readonly>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
		<?php 
		
		
		if($now_nick){
		?>
			<div id=text2 align=center>
			<b>현재 설정된 패스워드와 같습니다! 새로운 패스워드를 입력하시거나 취소하여주세요</b><br><br>
		</div>
		<?php 
		}else if($num_record){
		    ?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 <font color=red>사용할 수 없는</font> 패스워드입니다.<br>
				새로운 패스워드로 하십시오.</b>
		</div>
		<?php 
		
		}else{
		    ?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 사용하실 수 있습니다.<br>
				이 패스워드를 사용하시겠습니까?</b><br><br>
			<img src="../image/use.gif" onclick="nick_use('<?=$nick?>')">
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>