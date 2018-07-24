<?php
session_start();

include "../common_lib/common.php";
$owner_id=$_SESSION['id'];
$owner_name = $_POST['owner_name']; //대표자명
$owner_store_name= $_POST['owner_store_name']; //상호명
$owner_address = $_POST['owner_address']; //사업자주소
$business_license= $_POST['business_license']; //사업자등록번호
$business_license_img = $_FILES['business_license_img']; //사업자등록증사본

$store_name = $_POST['store_name']; //가게명
$store_type = $_POST['store_type']; //업종
$store_origin = $_POST['store_origin']; //원산지
$store_delivery_time = $_POST['store_delivery_time_start']."~".$_POST['store_delivery_time_end']; //배달시간
$store_day_off = $_POST['store_day_off']; //휴무일
$store_phone = $_POST['store_phone1']."-".$_POST['store_phone2']."-".$_POST['store_phone3']; //전화번호
$store_delivery_area = $_POST['store_delivery_area']; //배달지역
$store_min_price = $_POST['min_price']; //최소주문 가격
$store_payment = $_POST['payment']; //결제수단
$store_logo_img = $_FILES['store_logo_img'];




$upload_dir = './Regi_logo_img_data/';


$business_upfile_name     = $business_license_img["name"];
$business_upfile_tmp_name = $business_license_img["tmp_name"];
$business_upfile_type     = $business_license_img["type"];
$business_upfile_size     = $business_license_img["size"];
$business_upfile_error    = $business_license_img["error"];

$store_logo_name         = $store_logo_img["name"];
$store_logo_tmp_name     = $store_logo_img["tmp_name"];
$store_logo_type         = $store_logo_img["type"];
$store_logo_size         = $store_logo_img["size"];
$store_logo_error        = $store_logo_img["error"];

$business_file = explode(".", $business_upfile_name);
$business_file_name = $business_file[0];
$business_file_ext  = $business_file[1];

$store_logo_file = explode(".", $store_logo_name);
$store_file_name = $store_logo_file[0];
$store_file_ext  = $store_logo_file[1];

if (!$store_logo_error && !$business_upfile_error)
{
    $micro_date = microtime();
    $date_array = explode(" ", $micro_date);
    $new_file_name = date("Y_m_d_H_i_s", $date_array[1]);
    
    
    $new_business_file_name = $new_file_name."_".$date_array[0]."_1";
    $new_store_file_name = $new_file_name."_".$date_array[0]."_2";
    
    
    $copied_business_file_name = $new_business_file_name.".".$business_file_ext;
    $copied_store_file_name = $new_store_file_name.".".$store_file_ext;
    
    $uploaded_business_file = $upload_dir.$copied_business_file_name;
    $uploaded_store_file = $upload_dir.$copied_store_file_name;
    if( $business_upfile_size  > 5000000 ) {
           echo("
     		     <script>
     				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
     				history.go(-1)
     		     </script>
    	       ");
           exit;
        }
        if( $store_logo_size  > 5000000 ) {
            echo("
     		     <script>
     				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
     				history.go(-1)
     		     </script>
    	       ");
            exit;
    }
        
        if (!move_uploaded_file($business_upfile_tmp_name, $uploaded_business_file) )
    {
            echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
            exit;
    }
        
    if (!move_uploaded_file($store_logo_tmp_name, $uploaded_store_file) )
   {
            echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
            exit;
   }
        
    
        
}

  
  $today = date("Y/m/d");
  
  
  
  $sql= "select * from store_regi where business_license='$business_license'";  
  $result= mysqli_query($con, $sql);  
  
  if(mysqli_num_rows($result)){
      echo "<script> window.alert('해당 업체가 이미 등록되어있습니다.'); history.go(-1); </script>";
      exit();
  }else{
      $sql = "insert into store_regi (owner_id, owner_name, owner_store_name, owner_address, ";
      $sql .= "business_license, business_license_img, store_name, store_type, store_origin, store_delivery_time, ";
      $sql .= "store_day_off, store_phone, store_min_price, store_payment, store_delivery_area, store_logo_img, regi_date) ";
      $sql .= "values ('$owner_id', '$owner_name', '$owner_store_name', '$owner_address', ";
      $sql .= "'$business_license', '$copied_business_file_name', '$store_name', '$store_type', '$store_origin', '$store_delivery_time', ";
      $sql .= "'$store_day_off', '$store_phone', '$store_min_price', '$store_payment', '$store_delivery_area', '$copied_store_file_name', '$today')";
 
             mysqli_query($con, $sql) or die("실패원인: ".mysqli_error($con));
  }
  
  mysqli_close($con);
  
  echo "<script>alert('매장 등록 신청이 완료되었습니다.')</script>";
  echo "<script> location.href='../owner_store/owner_store_list.php?mode=info'; </script>";
  


?>