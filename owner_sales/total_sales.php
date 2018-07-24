<?php 
session_start();

include "../common_lib/common.php";

if(isset($_POST['owner_no'])){
    //날짜 데이터 처리
    $selected_date = $_POST['selected_date'];
    $today = str_replace("-", "/", $selected_date);  
    
    $owner_no = $_POST['owner_no']; //배열 값으로 받아온당 체크박스의 값을!
    $store_count=count($owner_no); //체크된 전체 매장의 개수

    $mk_date = strtotime($today); //선택된 날짜의 주수 구하기
    $weeks = date("W", $mk_date);
    $year = substr($today, 0, 4);

    $week=getStartAndEndDate($weeks, $year);//주수와 년도를 통해 날짜의 시작 끝을 배열로 받아오는 함수
    $week_start=$week['week_start'];//현재 일자의 시작 날짜
    $ws=substr($week_start, 6, 11);
    $week_end=$week['week_end'];//현재 일자의 종료 날짜
    $we=substr($week_end, 6, 11);
    
    $month=getStartAndEndDate2(substr($today, 5, 2), $year);
    $month_start=$month['month_start'];//현재 일자의 시작 날짜
    $month_end=$month['month_end'];//현재 일자의 종료 날짜
    $m=substr($today, 5, 2)."월";
    
    $today_total=0;
    $week_total=0;
    $month_total=0;    
      
    $i=0;
    while(isset($owner_no[$i])){
        //일 매출 구하기
        $sql= "select * from order_list where owner_no = '$owner_no[$i]' and state='end' and order_date='$today'"; //일간 총매출 구하기
        $result = mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
        if(!mysqli_num_rows($result)){
            $total=0;
            $today_total= $today_total + $total;
            
        }else{
            while($row=mysqli_fetch_array($result)){ 
                $total=$row['total'];            
                $today_total= $today_total + $total;  
            }
       }
       //주간 매출 구하기
       $sql= "select * from order_list where owner_no = '$owner_no[$i]' and state='end' and order_date between '$week_start' and '$week_end'"; //주간 총매출 구하기
       $result = mysqli_query($con, $sql) or die("실패원인2:".mysqli_error($con));
       if(!mysqli_num_rows($result)){
           $total=0;  
           $week_total= $week_total + $total;
           
       }else{
           while($row=mysqli_fetch_array($result)){
               $total=$row['total'];
               $week_total= $week_total + $total;
           }
       }
       
       $sql= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date between '$month_start' and '$month_end'"; //월간 총매출 구하기
       $result = mysqli_query($con, $sql) or die("실패원인3:".mysqli_error($con));
       if(!mysqli_num_rows($result)){
           $total=0;
           $month_total= $month_total + $total;
         
       }else{
           while($row=mysqli_fetch_array($result)){
               $total=$row['total'];
               $month_total= $month_total + $total;
           }
       }
        $i++;
    }
    
    $today_total=number_format($today_total);    
    $week_total=number_format($week_total);    
    $month_total=number_format($month_total);    
    
echo "
    <table>
     <tr class='tr0'><td colspan='2' class='td1'>일간 총 매출액
     <tr class='tr1'><td class='td1'><b>$today</b><td class='td2'>선택하신 <font color='red'>$store_count</font>개 매장의 일간 총 매출액입니다.
     <tr class='tr2'><td colspan='2' class='td1'>$today_total 원
     <tr class='tr3'><td class='td1'>정산일<td class='td2'>$today
    </table><table>
     <tr class='tr0'><td colspan='2' class='td1'>주간 총 매출액
     <tr class='tr1'><td class='td1'><b>$ws ~ $we</b><td class='td2'>선택하신 <font color='red'>$store_count</font>개 매장의 주간 총 매출액입니다.
     <tr class='tr2'><td colspan='2' class='td1'>$week_total 원
     <tr class='tr3'><td class='td1'>정산일<td class='td2'>$week_start~$week_end
    </table><table>
     <tr class='tr0'><td colspan='2' class='td1'>월간 총 매출액
     <tr class='tr1'><td class='td1'><b>$m</b><td class='td2'>선택하신 <font color='red'>$store_count</font>개 매장의 월간 총 매출액입니다.
     <tr class='tr2'><td colspan='2' class='td1'>$month_total 원
     <tr class='tr3'><td class='td1'>정산일<td class='td2'>$month_start~$month_end
    </table>

";



}else{
    echo "<script>alert('하나 이상의 매장을 선택해주세요.'); history.go(0);</script>";
    exit();
    
}

function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $w['week_start'] = $dto->setISODate($year, $week)->format('Y/m/d');
    $w['week_end'] = $dto->modify('+6 days')->format('Y/m/d');
    return $w;
}

function getStartAndEndDate2($month,$year){
   $m['month_start'] = date("Y/m/d", mktime(0, 0, 0, $month , 1, $year));  
   $m['month_end'] = date("Y/m/d", mktime(0, 0, 0, $month+1 , 0, $year)); 
   return $m;
}

?>
