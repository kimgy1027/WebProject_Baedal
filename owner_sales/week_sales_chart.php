<?php 
include "../common_lib/common.php";

    if(isset($_POST['owner_no'])){
        $today=$_POST['selected_date'];
        
        $today_1=date("Y/m/d", strtotime($today." -1 day"));
        $today_2=date("Y/m/d", strtotime($today." -2 day"));
        $today_3=date("Y/m/d", strtotime($today." -3 day"));
        $today_4=date("Y/m/d", strtotime($today." -4 day"));
        $today_5=date("Y/m/d", strtotime($today." -5 day"));
        $today_6=date("Y/m/d", strtotime($today." -6 day"));
        
    
 
        $owner_no = $_POST['owner_no'];
        $count=count($business_license); //체크된 전체 매장의 개수  = 배열의 수;

        $week_total0 =[]; //1 매장별 총 매출액을 넣을 배열 선언
        $week_total1 =[]; 
        $week_total2 =[];
        $week_total3 =[];
        $week_total4 =[];
        $week_total5 =[];
        $week_total6 =[]; //7 매장별 총 매출액을 넣을 배열 선언
    
        $store_name=[]; //매장 이름을 넣을 배열 선언
 
    $i=0;
    while(isset($business_license[$i])){   
        $sql0= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_6'"; //주간 총매출 구하기
        $result0= mysqli_query($con, $sql0) or die("실패원인:".mysqli_error($con));
        
        $sql1= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_5'"; //주간 총매출 구하기
        $result1 = mysqli_query($con, $sql1) or die("실패원인:".mysqli_error($con));
        
        $sql2= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_4'"; //주간 총매출 구하기
        $result2 = mysqli_query($con, $sql2) or die("실패원인:".mysqli_error($con));
        
        $sql3= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_3'"; //주간 총매출 구하기
        $result3 = mysqli_query($con, $sql3) or die("실패원인:".mysqli_error($con));
        
        $sql4= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_2'"; //주간 총매출 구하기
        $result4 = mysqli_query($con, $sql4) or die("실패원인:".mysqli_error($con));
        
        $sql5= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today_1'"; //주간 총매출 구하기
        $result5 = mysqli_query($con, $sql5) or die("실패원인:".mysqli_error($con));
        
        $sql6= "select * from order_list where owner_no='$owner_no[$i]' and state='end' and order_date = '$today'"; //주간 총매출 구하기
        $result6 = mysqli_query($con, $sql6) or die("실패원인:".mysqli_error($con));
        
        $sql= "select * from store_regi where no='$owner_no[$i]'"; // 가게 이름 가져오기
        $result = mysqli_query($con, $sql) or die("실패원인2:".mysqli_error($con));        
        $row=mysqli_fetch_array($result);
        $store_name[$i]=$row['store_name']; //가게이름0~가게이름+가게수

        if(!mysqli_num_rows($result0)){ //i번째 가게의 6일전의 판매량
            $total=0;
            $week_total0[$i] =  $week_total0[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result0)){
                $total=$row['total'];                
                $week_total0[$i] =  $week_total0[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result1)){ //i번째 가게의 5일전의 판매량
            $total=0;
            $week_total1[$i] = $week_total1[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result1)){
                $total=$row['total'];
                $week_total1[$i] = $week_total1[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result2)){ //i번째 가게의 4일전의 판매량
            $total=0;
            $week_total2[$i] = $week_total2[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result2)){
                $total=$row['total'];
                $week_total2[$i] = $week_total2[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result3)){ //i번째 가게의 3일전의 판매량
            $total=0;
            $week_total3[$i] = $week_total3[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result3)){
                $total=$row['total'];
                $week_total3[$i] = $week_total3[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result4)){ //i번째 가게의 2일전의 판매량
            $total=0;
            $week_total4[$i] = $week_total4[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result4)){
                $total=$row['total'];
                $week_total4[$i] = $week_total4[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result5)){ //i번째 가게의 1일전의 판매량
            $total=0;
            $week_total5[$i] = $week_total5[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result5)){
                $total=$row['total'];
                $week_total5[$i] = $week_total5[$i] + $total;
            }
        }
        
        if(!mysqli_num_rows($result6)){ //i번째 가게의  당일의 판매량
            $total=0;
            $week_total6[$i] = $week_total6[$i] + $total;
        }else{
            while($row=mysqli_fetch_array($result6)){
                $total=$row['total'];
                $week_total6[$i] = $week_total6[$i] + $total;
            }
        }
        $i++;
    }
}else{
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <style type="text/css">
    .chart_title{
        width:100%; text-align: center;
        margin:50px 0 20px 0;
    }
    .chart_title p{
        font-family: 'NANUMSQUARER';font-size: 16pt;
    }
    .chart_title small{
        color: gray;
    }
    #line_top_x{  
        margin-top: 30px;
        margin-bottom: 50px;
    }
  </style>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);
    	
    function drawChart() {
    	var count = <?= json_encode($count) ?>;
     	
    	var today_6 = <?= json_encode($today_6) ?>;
    	var today_5 = <?= json_encode($today_5) ?>;
    	var today_4 = <?= json_encode($today_4) ?>;
    	var today_3 = <?= json_encode($today_3) ?>;
    	var today_2 = <?= json_encode($today_2) ?>;
    	var today_1 = <?= json_encode($today_1) ?>;
    	var today = <?= json_encode($today) ?>;
    	

    	var week_total0 = <?= json_encode($week_total0) ?>; //6일전 판매량
    	var week_total1 = <?= json_encode($week_total1) ?>;
    	var week_total2 = <?= json_encode($week_total2) ?>;
    	var week_total3 = <?= json_encode($week_total3) ?>;
    	var week_total4 = <?= json_encode($week_total4) ?>;
    	var week_total5 = <?= json_encode($week_total5) ?>;
    	var week_total6 = <?= json_encode($week_total6) ?>; //당일 판매량
       	var store_name = <?= json_encode($store_name) ?>;

      var data = new google.visualization.DataTable();
      
      data.addColumn('string', '일자');
     
     for(var i=0; i < count ; i++){     
    	  data.addColumn('number', store_name[i]);
      }
     
     var rows1 = new Array(today_6);
     var rows2 = new Array(today_5);
     var rows3 = new Array(today_4);
     var rows4 = new Array(today_3);
     var rows5 = new Array(today_2);
     var rows6 = new Array(today_1);
     var rows7 = new Array(today);

     for(var i=0; i < count ; i++){
    	 rows1.push(week_total0[i]/10000);
    	 rows2.push(week_total1[i]/10000);
    	 rows3.push(week_total2[i]/10000);
    	 rows4.push(week_total3[i]/10000);
    	 rows5.push(week_total4[i]/10000);
    	 rows6.push(week_total5[i]/10000);
    	 rows7.push(week_total6[i]/10000);
     }
    
     data.addRows([
        rows1,
        rows2,
        rows3,
        rows4,
        rows5,
        rows6,
        rows7
      ]);

      var options = { 		  
        chart: {

        },
        width: 1000,
        height: 500,
        linewidth : 15,
        axes: {
          x: {
            0: {side: 'bottom'}
          }
        }

      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>
</head>
<body>
	<div class="chart_title"><p>7일간 판매액 그래프 <small>단위 (만 원)</small></p></div>
 	 <div id="line_top_x"></div>
</body>
</html>
