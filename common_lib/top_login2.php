<?php 
    

if(isset($_SESSION[user]) && $_SESSION[user] == "admin"){
?>
<ul class="login">
       <li> <a href="../login/logout.php" >로그아웃</a> </li>
      <li><a href="../admin_store_list/list.php" class="menu__link hover2">매장등록관리</a> &nbsp;&nbsp;|</li> 
      <li><a href="../memberlist/memberlist.php" class="menu__link hover2">회원관리 </a> &nbsp;&nbsp;|</li>
        <li><?=$_SESSION[nick]?>님 안녕하세요!</li> 
    </ul>

<?php
}elseif (isset($_SESSION[user]) && $_SESSION[user]== "owner"){
?>

<ul class="login">
       <li> <a href="../login/logout.php" >로그아웃</a> </li>
      <li><a href="../owner_store/owner_store_list.php?mode=info" class="menu__link hover2">매장정보</a> &nbsp;&nbsp;|</li> 
      <li><a href="../owner_store/owner_store_list.php?mode=order" class="menu__link hover2">주문내역</a> &nbsp;&nbsp;|</li>
      <li><a href="../owner_sales/sales_chart_list.php" class="menu__link hover2">매출관리</a> &nbsp;&nbsp;|</li>
      <li><a href="../user_info/confirm_pw.php" class="menu__link hover2">내정보</a> &nbsp;&nbsp;|</li>
        <li><?=$_SESSION[nick]?>님 안녕하세요!</li> 
     
    </ul>

<?php    
}elseif (isset($_SESSION[user]) && $_SESSION[user] == "user"){
?>
	<ul class="login">
  <li> <a href="../login/logout.php">로그아웃</a></li>
  <li> <a href="#" >주문내역</a> &nbsp;&nbsp;|</li>
  <li> <a href="../user_info/confirm_pw.php">내정보</a> &nbsp;&nbsp;|</li>
  <li> <?=$_SESSION[nick]?>님 안녕하세요! </li> 
</ul>


<?php 
}else{
    ?>
 <ul class="login">
  <li> <a href="./membership/source/browsewrap.php">회원가입</a></li>
  <li> <a href="#" onclick="show_login_window()">로그인</a> &nbsp;&nbsp;|</li>
</ul>
  
<?php
}
?>
