<?php 
include "../common_lib/common.php";

    if(isset($_POST['owner_no'])){
        $today=$_POST['selected_date']; 
        $today = str_replace("-", "/", $selected_date); 
        $today="2017/07/20"; ////////////////지울꺼

        $month = substr($today, 0 , 7);

        $owner_no = $_POST['owner_no']; //전체 체크된 매장을 배열로 받는당
        $count=count($owner_no); //체크된 전체 매장의 개수  = 배열의 수;        
 
        $menu_name=[];
        $menu_total=[];
        
     
       
        $w_sql="";
        for($i=0; $i< $count; $i++){
            if($count==1 || $i==$count-1){
                $w_sql.="order_list.no=$owner_no[$i]"; //마지막 조건일때 
            }else{
                $w_sql.="order_list.no=$owner_no[$i] or ";
               
            }
        }
       
        $sql= "select cart.menu_name, SUM(cart.menu_count) as menu_total from order_list ";
        $sql .="inner join cart on order_list.no = cart.cart_num where state ='end' and ";
        $sql .= $w_sql;
        $sql .=" and order_list.order_date like '$month%' group by cart.menu_name order by menu_total desc;"; // 해당 가게의 해당 월의 메뉴별 주문수량을 구한다.
        $result = mysqli_query($con, $sql) or die("실패원인2:".mysqli_error($con));        
        $num=mysqli_num_rows($result);
        $i=0;
        while($row=mysqli_fetch_array($result)){             
            $menu_name[$i]=$row['menu_name'];
            $menu_total[$i]=$row['menu_total'];
            $i++;
        }
     
}else{
    exit();
}

?>
<html>
  <head>
  	<style>
  	 #piement{
  	     color: gray;
  	 }
  	</style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
    	var count = <?= $count ?>; //선택한 가게 수
		var menu_name = <?= json_encode($menu_name) ?>; //메뉴 이름 배열
      	var menu_total = <?= json_encode($menu_total) ?>; //메뉴 총 수량 배열

      	var data = google.visualization.arrayToDataTable([
           	['메뉴명', '주문수']
      	<?php for($i=0;$i<$num;$i++){; ?>
      			,[ menu_name[<?= $i?>] , menu_total[<?=$i?>] ]
      	<?php } ?>
        ]);

        var options = {
          title: '메뉴별 판매수',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
  	<div id="piement">선택하신 <font color="red"><?php $count ?>개 </font>매장의 메뉴별 판매수 통계입니다.</div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>