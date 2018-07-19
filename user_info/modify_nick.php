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

function nick_check(){
	
	var exp_id= /^[0-9a-zA-Z]{2,10}$/;
	var id_val= document.id_check_form.nick.value;
	if(!id_val){
		alert("닉네임을 입력해주세요");
		return ;
	}
	
	if(check_exp(document.id_check_form.nick, exp_id, "닉네임 2~10자리 영문 또는 숫자만 입력해주세요!")){
		document.id_check_form.nick.focus();
		document.id_check_form.nick.select();
		return ;
	}
	
	document.id_check_form.submit();
}


function nick_use(nick){
	opener.info_form.nick.value = nick;
	window.close();
	
	
}

</script>

<body>
	<div class="wrap">
		<div id=id_check_title>
			<div id=id_check_title1><h1>닉네임 중복확인</h1></div>
			<hr>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			사용하고자 하는 닉네임을 입력하신 후 검색 버튼을 눌러주세요.<br>
			(닉네임 2~10자리 영문 또는 숫자만 입력해주세요)
		</div>
		<br>
		<form name=id_check_form method=post action="modify_nick.php">
		<div align="center">
			<input type="text" name="nick" id="nick" placeholder="닉네임을 입력하시오"/> <img id="search" src="./images/검색.jpg" height="30px" onclick="nick_check()">
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
			<b>현재 설정된 닉네임과 같습니다! 새로운 닉네임을 입력하시거나 취소하여주세요</b><br><br>
		</div>
		<?php 
		}else if($num_record){
		    ?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 <font color=red>사용할 수 없는</font> 닉네임입니다.<br>
				새로운 닉넹로 선택해 주십시오.</b>
		</div>
		<?php 
		
		}else{
		    ?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$nick?></font>'는 사용하실 수 있습니다.<br>
				이 닉네임을 사용하시겠습니까?</b><br><br>
			<img src="../image/use.gif" onclick="nick_use('<?=$nick?>')">
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>