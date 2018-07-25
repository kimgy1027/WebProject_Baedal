

<?php 
include "./common_lib/common.php";


$scale = 5;


//review 테이블 생성
$flag = "NO";
$sql = "show tables from web_baedal_db";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con)); //or die = try catch
while($row=mysqli_fetch_row($result)){
    if($row[0]==="review"){
        $flag ="OK";
        break;
    }
}

if($flag !=="OK"){
    $sql= "create table review (
                    no int not null auto_increment,
                    user_id char(15) not null,
                    owner_no char(15) not null,
                    order_no char(20) not null,
                    user_nick  char(10) not null,
                    user_content text not null,
                    owner_content text,
                    star int not null,
                    regist_day char(20) not null,
                    love_it char(20),
                    primary key(num)
                    )";
    if(mysqli_query($con,$sql)){   //
        echo "<script>alert('review 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인:".mysqli_query($con);
    }
}





$sql="select * from membership where id=$user_id";
$result = mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);

$usernick = $row['nick'];       //유저 닉네임~~~~~~~~~~


$sql = "select * from review order by num desc";
$result = mysqli_query($con, $sql);    //$result 는 DB 테이블에 가리키고있는 첫번째 레코드 포인터
$total_record = mysqli_num_rows($result); // 전체 글 수

// 전체 페이지 수($total_page) 계산
if ($total_record % $scale == 0)
    $total_page = floor($total_record/$scale); 
else
    $total_page = floor($total_record/$scale) + 1; 

    if(!empty($_GET['page'])){
        $page = $_GET['page'];   //페이지 값 설정(페이지값이 없으면)
    }
    if (!$page){                
        $page = 1;              
    }
    
    //표시할 페이지에 시작 레코드 $start    (전체레코드갯수에서 해당되는 갯수번호만 보여주는 역할)
    $start = ($page - 1) * $scale;
    
    //페이지별 시작할 인덱스넘버 ==> 보여줄 리스트번호
    $number = $total_record - $start;

?>


<div style="width: 80%">
       	<form  name="memo_form" method="post" action="insert.php"> 
			<span>▷ <?= $user_nick ?></span>
			<div id="memo1" style="float:left;margin-top: 0px;"><textarea  name="content" style="width: 632px; height : 100px; resize: none;"></textarea></div>
			<div id="memo2" style="float:right; margin-top: 5px; margin-left: 5px; margin-bottom: 10px;""><input type="submit" value="입  력" style="width: 70px; border: none; background-color: #DEE1DD;"></div>
		</form>	
</div>
    
    
    <?php
/* $start+$scale는 $start 보다 무조건 5가 크다 어떻게 계산하든 */
   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)                    
   {                                    //$i < $total_record는 제일 마지막 페이지를 확인하는 것이다.
      mysqli_data_seek($result, $i); 
      //쉽게 이해하자면 데이터 베이스에 저장되있는 값들중 컴퓨터가 데이터를 읽을 위치를 $i번째에 옮기기만하는 과정.
      $row = mysqli_fetch_array($result);       
      //$i번째의 레코드값을 포함하여 for문의 조건에 맞게 쭈르르륵 읽는다.
	
	  $memo_id      = $row[id];
	  $memo_num     = $row[num];
      $memo_date    = $row[regist_day];
	  $memo_nick    = $row[nick];

	  $memo_content = str_replace("\n", "<br>", $row[content]);
	  $memo_content = str_replace(" ", "&nbsp;", $memo_content);
	 ?>
	  
	  <div id="memo_writer_title" style="border-top: 1px solid black; border-bottom : 1px solid dotted; border-right : none; border-left: none; display: table; width: 632px; height: 20px;">
	  
	  <ul style="margin-top: 0px; margin-bottom: 0px;">
	  <li id="writer_title1"><?php echo  "$number" ?></li>
		<li id="writer_title2"><?php echo  "$memo_nick" ?></li>
		<li id="writer_title3"><?php echo  "$memo_date" ?></li>
		<li><p class="star_rating">
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#" class="on">★</a>
            	<a href="#">★</a>
            	<a href="#">★</a>
    		</p>	
		</li>
		<li id="writer_title4"> 
		      <?php
		      if($_SESSION['id']=="admin" || $_SESSION['id']==$memo_id)
			          echo "<a href='delete.php?num=$memo_num'>[삭제]</a>"; 
			  ?>
		</li>
		</ul>
		</div>              
           <div id="memo_content" style="width: 632px; margin-left: 0px; height: 60px;"><?= $memo_content ?></div>      
           <div style="width: 632px; background-color: #E9E9E9; text-align: center;"><b style="float: left;margin-left: 13px; margin-top: 5px;">덧글</b><br>
           <div><textarea style="width: 500px; height: 80px;resize: none;"></textarea><input type="button" value="댓글입력" style="width: 70px; height: 30px; border-radius: 5px; background-color: lightgray; margin-left: 1px; margin-bottom: 30px; display: inline-block; float: right; margin-right: 3px; margin-top: 47px;"><br></div>
           </div>    	<!-- //////////////////////////////// -->  
                          
		
<?php
	    $sql = "select * from review_ripple where parent='$memo_num'"; //덧글
	    $ripple_result = mysqli_query($con, $sql);

		while ($row_ripple = mysqli_fetch_array($ripple_result))
		{
			$ripple_num     = $row_ripple[num];
			$ripple_id      = $row_ripple[id];
			$ripple_nick    = $row_ripple[nick];
			$ripple_content = str_replace("\n", "<br>", $row_ripple[content]);
			$ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
			$ripple_date    = $row_ripple[regist_day];
?>
	
	
	
	
	
				
<?php
		}
?>
				



<?php
		$number--;
	 } //end of for==========================================================
	 mysqli_close($con);
?>              

<div id="page_num" style="float:center; width:632px;"> ◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp; 
<?php
   // 게시판 목록 하단에 페이지 링크 번호 출력
   for ($i=1; $i<=$total_page; $i++)
   {
		if ($page == $i)     // 현재 페이지 번호 링크 안함
		{
			echo "<b> $i </b>";
		}
		else
		{ 
		    echo "<a href='store_view.php?page=$i'> $i </a>";
		}      
   }
?>			
			&nbsp;&nbsp;&nbsp;&nbsp;다음 ▶</div>                 
                          
     
                          
                          
                          
                          
                          
                          
                          
                          
                          