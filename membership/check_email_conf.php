<?php
session_start();

$email=$_GET['email'];
$code=$_SESSION['code'];

if(!isset($_SESSION['code'])){
    echo "<script> alert('접근 제한'); history.back(); </script>";
    exit;
}else{
    $code= $_SESSION['code'];
}

?>
<html>
<head>
<title>이메일 인증</title>
<meta charset="utf-8">
<link href="../css/check_email.css?ver1" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
		
		
		var myVar;
		var count=180;
		
		function check_email_conf(a,b){
			if(document.getElementById("email_code").value!=a){
				alert("인증번호가 틀립니다.\n 다시 입력해주세요!");
				return ;
			}
			alert("인증 되었습니다.");
			opener.join_form.email.value=b;
			
			window.close();
		}
		
		
		document.addEventListener('keydown', function(event) {
	    	if (event.keyCode === 116) {
	      		  event.preventDefault();
	    	}
				}, true);
		
		
		$(document).ready(function(){
			myFunction();
			
		});
		
		function closer(){													   	
			window.close();
		}
		
		
		function myFunction() {
    	    var min= parseInt(count/60);
    	    var sec= count%60;
    	    /* document.getElementById("#conf_time").innerHTML="("+min+":"+sec+")"; */
    	    $("#conf_time").html("("+min+":"+sec+")");
    	    
    	    if(!count){
    	       alert('시간초과');
    	       location.href="check_email.php?mode=unset";
    	       return ;
    	    }
 	   	    count--;
    	    myVar = setTimeout(myFunction, 1000);
    	}
		
</script>
</head>
<body>
	<div id="frame">
		<b>이메일 인증</b>
		<button id="close" onclick="closer()">CLOSE X</button>
		<hr>
		<div id="message2">
			이메일 인증이 필요합니다.<br> 입력하신 이메일 주소로 인증번호를 요청합니다.
		</div>
		<div id="check">
		
		 <?=$email;?> 로 인증번호 전송!
		
			
		</div>
		<hr>
		<div id="accept">
		<input id="email_code" type="text"><input type="button" onclick="check_email_conf('<?=$code?>','<?=$email?>')"
		 value="인증확인">
		<div id="conf_time" style="color : blue"></div>
		
		</div>

	</div>
</body>
</html>