<?php
session_start();
include "../common_lib/common.php";

$search_value=$_POST['search_value'];
$search_value2=$_POST['search_value2'];
$kind=$_POST['kind'];

if(empty($search_value)){
    $sql = "select * from store_regi order by regi_ok desc";
    $sql2 = "select * from membership order by id";
}else if($kind=="owner_store_name"){
    $sql="select * from store_regi where owner_store_name like '%$search_value%' ";
    $sql2="select * from membership where user like '%$search_value%' ";
}else if($kind=="owner_name"){
    $sql="select * from store_regi where owner_name like '%$search_value%' ";
    $sql2="select * from membership where id like '%$search_value%' ";
}else if($search_value2){
    $sql = "select * from store_regi where regi_ok=N order by owner_id desc";
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>배달 홈페이지</title>
    <link rel="stylesheet" href="../common_css/common.css">
    <link rel="stylesheet" href="./css/admin_list.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
	<header>
		<?php include "../common_lib/top_login2.php"; ?>
	</header>
	
	<div class="logo">
		<a href="../index.php"><img alt="logo" src="../common_img/logo.JPG"></a>
	</div>
	
	<nav>
		<?php include "../common_lib/menu1_2.php"; ?>
	</nav>
	
	<script type="text/javascript">
	
	function Y_N_state(){
		
	}
	
	</script>
	
	
	
	
	
	
	<div style="border:1px solid black; height:auto; width:1200px; margin: auto auto;">
		
		<div id="head_list2">
		
		<h2>매장등록관리 리스트</h2>
        <form action="list.php" method="post" id="form1">
				<select class="" name="kind">
					<option value="">전체보기</option>
					<option value="owner_store_name">상호명</option>
					<option value="owner_name">대표자명</option>
				</select>
        <input type="text" name="search_value">
        <input type="submit" value="검색" id="form1">
        <input type="submit" style="margin-left: 630px;" value="전체보기" name="search_value2">
		</form>
		</div>	
		
		
		
		
		
		<hr>
		
		<table id="admin_list">
		
		<?php
        if (empty($page)) {
            $page = 1;
        }
        

                
            $members_per_page = 30;
   
            $result = mysqli_query($con, $sql);
            $total_members = mysqli_num_rows($result);
            $total_pages = ceil($total_members / $members_per_page);
            $start_per_page = $members_per_page * ($page - 1);
        
       
        

            echo "<tr class='list_tr'>
                    <td width='218'>신청일자</td>
                    <td width='154'>아이디</td>
                    <td width='119.2'>상호명</td>
                    <td width='119.2'>대표자명</td>
                    <td width='257.6'>사업자등록번호</td>
                    <td width='83.6'>상세보기</td>
                    <td width='83.6'>처리상태</td>
                    </tr>";
            
            $result2 = mysqli_query($con, $sql2);

        for ($i = $start_per_page; $i < $start_per_page + $members_per_page && $i < $total_members; $i ++) {
            mysqli_data_seek($result, $i);
            $row = mysqli_fetch_array($result);
            $row2 = mysqli_fetch_array($result2);
            
            $regi_date = $row['regi_date'];
            $owner_id = $row['owner_id'];
            $owner_store_name = $row['owner_store_name'];
            $owner_name = $row['owner_name'];
            $business_license = $row['business_license'];
            $regi_ok = $row['regi_ok'];
            $owner_num = $row['owner_num'];
            
            
   
            
            echo "<tr class='memberlist_tr2'>
                    <td>$regi_date</td>
                    <td>$owner_id</td>
                    <td>$owner_store_name</td>
                    <td>$owner_name</td>
                    <td>$business_license</td>
                    <td><a href='./view.php?business_license=$business_license&owner_id=$owner_id&page=$page'><button type='button' class='button'>상세보기</button></a></td>
                    <td>$regi_ok</td>
                    
                    </tr>";
          echo"  <tr class='gray' bgcolor='#cccccc'><td colspan='7'></td></tr>";
        }
       /*  <td><a href='./regi_ok_update.php?owner_num=$owner_num'><button type='button' class='button'>게시</button></a></td> */
        $block_per_page_num = 2;
        $total_blocks = ceil($total_pages / $block_per_page_num);
        $current_block = ceil($page / $block_per_page_num);
        $current_block_start_page = $block_per_page_num * ($current_block -1);
        $current_block_end_page = ($current_block == $total_blocks) ? $total_pages : $block_per_page_num * $current_block;
        $pre_page = $page > 1 ? $page - 1 : NULL;
        $next_page = $page < $total_members ? $page + 1 : NULL;
        
        ?>
        	<table id="bottom_page" >
					<tr>
						<td>
                <?php
                if ($page > 1) {
                    echo ("<a href='list.php?page=$pre_page'>[이전]&nbsp;&nbsp;&nbsp;</a>");
                }
                if(mysqli_num_rows($result)==0){
                    $i=1;
                    echo("<td class='for_td'>&nbsp;$i&nbsp;</td>");
                }else{
                for ($i = $current_block_start_page + 1; $i <= $current_block_end_page; $i ++) {
                    if ($i == $page) {
                        echo ("&nbsp;$i&nbsp;");
                    } else {
                        echo ("<a href='list.php?page=$i'>[$i]</a>");
                    }
                }
                }
                if ($current_block < $total_blocks) {
                    echo ("<a href='list.php?page=$next_page'>&nbsp;&nbsp;&nbsp;[다음]</a>");
                }
                ?>
              </td>
					</tr>
				</table>
        </table>
	
	
	
	
	</div>
	
	
	
	
	
	
	
	
	
	
	
<footer>
      <?php include "../common_lib/footer1.php"; ?>
	</footer>
</body>
</html>