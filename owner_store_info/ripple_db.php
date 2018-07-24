<meta charset=utf-8>
<?php
session_start();
include "../common_lib/common.php";

//이용자
$id = $_SESSION['id'];
$content = $_POST['content'];
$nick = $_SESSION['nick'];

if(empty($content)&&empty($nick)){
    echo "<script>
        alert('오류');
        </script>";
}else{
    $sql= "select * from membership where nick='$nick'";
    $result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
    $regist_day = date("Y-m-d (H:i)");
    
    
    $sql= "insert into ripple (id, score, nick, content, regist_day) ";
    $sql.= "values ('$id', '5', '$nick', '$content', '$regist_day')";
    
    
    mysqli_query($con, $sql) or die("실패원인2:".mysqli_error($con));
    $row = mysqli_fetch_array($result);
    $_SESSION['content']=$row['content'];
    
    
}


echo "<script>
        alert('db등록 완료');
        window.close();       
    </script>";

mysqli_close($con);



?>