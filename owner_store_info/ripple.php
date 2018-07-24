<?php
session_start();

$nick=$_SESSION['nick'];

if(empty($id) && empty($nick)){
    echo "<script>
           alert('로그인 해주세요.');
           history.go(-1);
          </script>    

    ";
}

?>
<html>
<meta charset="utf-8">
<head>
<style type="text/css">
.total_votes {
    background: #eaeaea;
    top: 58px;
    left: 0;
    padding: 5px;
    position:   absolute;  
} 
.movie_choice {
    font: 10px verdana, sans-serif;
    margin: 0 auto 40px auto;
    width: 180px;
}
</style>
<link rel="stylesheet" href="./slide/css/slide.css?v=1">

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
<script type="text/javascript">
$('.ratings_stars').hover(
        // Handles the mouseover
        function() {
            $(this).prevAll().andSelf().addClass('ratings_over');
            $(this).nextAll().removeClass('ratings_vote'); 
        },
        // Handles the mouseout
        function() {
            $(this).prevAll().andSelf().removeClass('ratings_over');
            set_votes($(this).parent());
        }
    );

function input_check(){
    if(!document.ripple_form.content.value){
        alert("내용을 입력하세요.");
        return;
    }
    document.ripple_form.submit();
}
</script>
</head>
<body>
<div class="form">
<form name="ripple_form" action="ripple_db.php" method="post">
    <h1>
	<div class='movie_choice'>
            Rate: Raiders of the Lost Ark
            <div id="r1" class="rate_widget">
                <div class="star_1 ratings_stars"></div>
                <div class="star_2 ratings_stars"></div>
                <div class="star_3 ratings_stars"></div>
                <div class="star_4 ratings_stars"></div>
                <div class="star_5 ratings_stars"></div>
                <div class="total_votes">vote data</div>
            </div>
        </div>
	</h1>
 	  <div>닉네임 : <?php echo $nick;?></div>
      <textarea name="content" rows="20" cols="90"></textarea><br><br>
      
      <div id="wrapper" style="margin-left: 270px;">
      	<input type="button" value="등록" onclick="input_check()">
      	<input type="button" value="취소">
      </div>
    </form>
</div>
</body>
</html>