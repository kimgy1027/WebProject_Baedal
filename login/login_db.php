 <?php 
  session_start();
  include "../common_lib/common.php";
  
  $id=mysqli_real_escape_string($con,$_POST['id']);
  $pass=mysqli_real_escape_string($con,$_POST['pass']);
  
  if(empty($id)){
      echo "<script>
      alert('아이디를 입력하세요.');
      history.go(-1);
    </script>";
      exit();
  }
  
  if(empty($pass)){
      echo "<script>
      alert('비밀번호를 입력하세요.');
      history.go(-1);
    </script>";
      exit();
  }

  $sql= "select * from membership where id='$id'";
  $result= mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
  $num = mysqli_num_rows($result); 
  
  if(!$num){
    echo "<script>
      alert('등록되지 않은 회원입니다.');
      history.go(-1);
    </script>";
    exit();
  }else{
    $row = mysqli_fetch_array($result);
    if($pass!==$row['pass']){
      echo "<script>
        alert('비밀번호가 틀립니다.');
        history.go(-1);
      </script>";
      exit();
    }else{
        if($row['id']=="admin"){
            $_SESSION['user']="admin";        
        }
        else if($row['user']=="owner"){
            $_SESSION['user']="owner";
        }
        else if($row['user']=="user"){
            $_SESSION['user']="user";
        }
        
        $_SESSION['id']=$row['id'];
        $_SESSION['nick']=$row['nick'];
    }
        echo "<script>
        alert('로그인 되었습니다.');
      </script>";
    } 
    echo "<script> location.href='../index.php'; </script>";
  
?>