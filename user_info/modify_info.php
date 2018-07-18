<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href="./css/join.css?v=2" rel=stylesheet>
</head>

<body>
	<div class="wrap">
		<div id=id_check_title>
			<div id=id_check_title1><img src="./images/아이디중복확인.jpg" height="30px"></div>
			<hr>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			사용하고자 하는 아이디를 입력하신 후 중복검색 버튼을 눌러주세요.<br>
			(6자 이상 12자 이내의 영문 또는 영문과 숫자를 조합, 한글 및 특수문자 제외)
		</div>
		<br>
		<form name=id_check_form method=get action="check_id.php">
		<div align="center">
			<input type="text" name="id" value="<?=$id?>"> <a href="#"><img id="search" src="./images/검색.jpg" height="30px" onclick="id_check()"></a>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
		<?php 
		if($num_record){
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$id?></font>'는 <font color=red>사용할 수 없는</font> 아이디입니다.<br>
				새로운 아이디로 선택해 주십시오.</b>
		</div>
		<?php 
		}else{
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$id?></font>'는 사용하실 수 있습니다.<br>
				이 아이디를 사용하시겠습니까?</b><br><br>
			<a href="#"><img src="../image/use.gif" onclick="id_use('<?=$id?>')"></a>
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>