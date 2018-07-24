


<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href=./css/check_id.css?v=2 rel=stylesheet>
</head>
	<script>
    	function check_exp(elem, exp, msg){
    		if(!elem.value.match(exp)){
    			alert(msg);
    			return true;
    		}
    	}
		// 이메일 검사
		function check_email_conf(){
			var exp_email1= /^[0-9a-zA-Z~!@#$%^&*()]+$/;
			var exp_email2= /^[a-z]+\.[a-z]+$/;
			if(!document.email_check_form.email1.value){
				alert("이메일을 정확히입력해주세요");
				document.email_check_form.email1.focus();
				return ;
			}
			if(!document.email_check_form.email2.value){
				alert("이메일을 정확히입력해주세요");
				document.email_check_form.email2.focus();
				return ;
			}
			if(check_exp(document.email_check_form.email1,exp_email1, "이메일을 정확히 입력해주세요!")){
				document.email_check_form.email1.focus();
				document.email_check_form.email1.select();
				return ;
			}
			if(check_exp(document.email_check_form.email2,exp_email2, "이메일을 정확히 입력해주세요!")){
				document.email_check_form.email2.focus();
				document.email_check_form.email2.select();
				return ;
			}
			document.email_check_form.submit();
		}
		
    	function closer(){
    		window.close();
    	}
	</script>
<body>
	<div class="wrap">
		<div id=id_check_title>
			<div id=id_check_title1><img src="./images/이메일인증하기.jpg" height="30px"></div>
			<hr>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			이메일 인증이 필요합니다.<br>
			입력하신 이메일 주소로 인증번호를 요청합니다.
		</div>
		<br>
		<form name=email_check_form method="post" action="./phpmailer/send_email.php">
		<div align=center id="input_email">
			<input type="text" name="email1" size="10"> @
			<input type="text" name="email2" size="10"> 
			<a href="#"><img src="./images/보내기.jpg" onclick="check_email_conf()" height="33px" id="search"></a>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
	</div>
</body>
</html>