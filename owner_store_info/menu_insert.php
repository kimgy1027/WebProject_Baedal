<?php

    //세션스따뜨!
    include "../common_lib/common.php";
    
    
    
    
    //이미지까지 모두 등록해 주어야만 한다!(유효성 실시해줄것)
    //사업자 등록번호는 프라이머리키로 반드시 받아줘야한다.!
    
    

    function test_input($data){
        $data = trim($data); //공백 제거
        $data = stripslashes($data); //\를 값으로 변경
        $data = htmlspecialchars($data); // HTML 코드를 문자 그대로 출력
        return $data;
    }
    
    $registration_number = $_POST[registration_number];
    
    $category_name = $_POST[category_name];
    $menu_name = $_POST[menu_name];
    $menu_comp = $_POST[menu_comp];
    $menu_price = $_POST[menu_price];
    $menu_img = $_FILES[menu_img];
    
    $count = count($menu_name);
    $upload_dir = './menu_img_data/';
    
    
    
    for ($i=0; $i<$count; $i++)
    {
        $upfile_name[$i]     = $menu_img["name"][$i];
        $upfile_tmp_name[$i] = $menu_img["tmp_name"][$i];
        $upfile_type[$i]     = $menu_img["type"][$i];
        $upfile_size[$i]     = $menu_img["size"][$i];
        $upfile_error[$i]    = $menu_img["error"][$i];
        
        $file = explode(".", $upfile_name[$i]);
        $file_name = $file[0];
        $file_ext  = $file[1];
        
        if (!$upfile_error[$i])
        {   
            $micro_date = microtime();
            $date_array = explode(" ", $micro_date);
            $new_file_name = date("Y_m_d_H_i_s", $date_array[1]);
            $new_file_name = $new_file_name."_".$date_array[0]."_".$i;
           
            
            $copied_file_name[$i] = $new_file_name.".".$file_ext;
            $uploaded_file[$i] = $upload_dir.$copied_file_name[$i];
            
//             if( $upfile_size[$i]  > 5000000 ) {
//                 echo("
// 				<script>
// 				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
// 				history.go(-1)
// 				</script>
// 				");
//                 exit;
//             }
        }
        
        if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) )
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
    
    
    for($i = 0; $i<$count ; $i++){
        $sql = "insert into menu (registration_number, category_name, menu_name, menu_comp,";
        $sql .= " menu_price, menu_img)";
        $sql .= " values('$registration_number', '$category_name[$i]', '$menu_name[$i]', '$menu_comp[$i]', '$menu_price[$i]', ";
        $sql .= " '$copied_file_name[$i]')";
        mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    }
    
   
    
    mysqli_close($con);  
    
    echo "
	   <script>
	    location.href = './menu_manage_form.php';
	   </script>
	";
    
    
    

?>