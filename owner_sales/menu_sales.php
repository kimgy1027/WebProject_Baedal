<?php 
include "../common_lib/common.php";

// $_POST['business_license']=['1111','2222']; ///////////지울꺼

//     if(isset($_POST['business_license'])){
//         $today=$_POST['selected_date']; 
//         $today = str_replace("-", "/", $selected_date); 
//         $today="2017/07/20"; ////////////////지울꺼

//         $month = substr($today, 0 , 7);

//         $business_license = $_POST['business_license'];
//         $count=count($business_license); //체크된 전체 매장의 개수  = 배열의 수;        
 
//         $menu_name=[];
//         $menu_total=[];
        
//         $w_sql="";
//         for($i=0; $i< $count; $i++){
//             if($count==1 || $i==$count-1){
//                $w_wql=$w_sql."o.business_license='$business_license[$i]' and "; //마지막 조건은 and로 설정해준당
//             }else{
//                 $w_wql=$w_sql."o.business_license='$business_license[$i]' or ";
//             }
//         }
              
//         $sql= "select c.menu_name, SUM(c.menu_count) as menu_total from order_list o ";
//         $sql."inner join cart c on o.cart_num = c.cart_num where state = 'end' and ".$w_sql;
//         $sql."o.order_date like '$month'% group by c.menu_name order by menu_total desc"; // 해당 가게의 해당 월의 메뉴별 주문수량을 구한다.
//         $result = mysqli_query($con, $sql) or die("실패원인2:".mysqli_error($con));        
       
//         $i=0;
//         while(mysqli_num_rows($result)){
//             $row=mysqli_fetch_array($result);
            
//             $menu_name[$i]=$row['menu_name'];
//             $menu_total[$i]=$row['menu_total'];
//         }
// }else{
//     exit();
// } //수정 필요
    $count=3;
    
    $menu_name[0]="양념치킨";
    $menu_total[0]="70";
    $menu_name[1]="후라이드치킨";
    $menu_total[1]="35";
    $menu_name[2]="간장치킨";
    $menu_total[2]="20";
    $menu_name[3]="까르보치킨";
    $menu_total[3]="18";  

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
    	var count = <?= json_encode($count) ?>; //레코드수...를 받아야함

      	var menu_name = <?= json_encode($menu_name) ?>; //메뉴 이름 배열
      	var menu_total = <?= json_encode($menu_total) ?>; //메뉴 총 수량 배열
      	
      	var rows = new Array();
      	for(var i=0; i< count; i++){
      		rows.push(menu_name[i], menu_total[i]);
      	}
      	
        var data = google.visualization.arrayToDataTable([
           	['menu', 'menu_count'],
           	rows
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
  </body>
</html>