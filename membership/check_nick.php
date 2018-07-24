<?php
include './common_lib/common.php';

if(isset($_GET['nick'])){
    $nick= $_GET['nick'];
}else{
    $nick="";
}

$sql="select * from membership where nick='$nick'";

$result= mysqli_query($con, $sql);
$row= mysqli_fetch_array($result);
if(strlen($nick) >= 2 && strlen($nick) <= 10){
    $num_record= mysqli_num_rows($result);
}else{
    $num_record=1;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href="./css/check_id.css?v=1" rel=stylesheet>
</head>
<script>
	// 요소 검사 함수
	function check_exp(elem, exp, msg){
		if(!elem.value.match(exp)){
			alert(msg);
			return true;
		}
	}
	//아이디 검사
	function nick_check(){
    	var exp_id= /^[0-9a-zA-Z가-힣]{2,10}$/;
    	var id_val= document.id_check_form.nick.value;
		if(!id_val){
			alert("닉네임을 입력해주세요");
			return ;
		}
    	if(check_exp(document.id_check_form.nick, exp_id, "특수문자는 사용이 불가능합니다!")){
    		document.id_check_form.nick.focus();
    		document.id_check_form.nick.select();
    		return ;
    	}
    	document.id_check_form.submit();
	}
	
	function id_use(a){
		opener.join_form.nick.value=a;///
		window.close();
	}
	
	function closer(){
		window.close();
	}

</script>
<body>
	<div class="wrap">
		<div id=id_check_title>
			<div id=id_check_title1><img src="./images/닉네임중복확인.jpg" height="30px"></div>
			<hr>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			사용하고자 하는 닉네임 입력하신 후 중복검색 버튼을 눌러주세요.<br>
			(2자 이상 10자 이내의 영문 또는 영문과 숫자를 조합, 한글 및 특수문자 제외)
		</div>
		<br>
		<form name=id_check_form method=get action="./check_nick.php">
		<div align=center>
			<input type="text" name="nick" value="<?=$nick?>"> <a href="#"><img id="search" src="./images/검색.jpg" height="30px" onclick="nick_check()"></a>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
		<?php 
		if($num_record){
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 <font color=red>사용할 수 없는</font> 닉네임입니다.<br>
				새로운 닉네임을 입력해 주십시오.</b>
		</div>
		<?php 
		}else{
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 사용하실 수 있습니다.<br>
				이 닉네임을 사용하시겠습니까?</b><br><br>
			<a href="#"><img src="./images/네.jpg"  height="35px"  onclick="id_use('<?=$nick?>')"></a>
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>
<?php

mysqli_close($con);
?>

