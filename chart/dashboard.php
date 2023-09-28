<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DASHBOARD</title>
    <link rel = "stylesheet" type = "text/css" href= "dashboard.css">

    <?php

    // hELLO PRADIP 
    //  i HAVE ADDED CODES TO SHOW THE LEAST (SABAI BHANDA THORAI )  VAKO ITEM LAI SHOW GARNE, CURRENT DAY KO SALES SHOW GARNE AND OTHER STUFFS;
    // aLSO THE CHARTS SHOW WEEKLY PROFITS,
    //IF YOU HAVENT INTEGRATED THIS IM YET.
    //i REquest you to integrate it somewhere i our System
    //thank you


    //at first the sales_product view is created
    //this view will record all the necessary details of product that are sold, it also calculates te profit occured in each product sold
        include 'connection.php';
       $sales_product_view= "CREATE OR REPLACE VIEW product_sales_view AS 
                SELECT
                    s.salesId,
                    s.productId,
                    s.customerName,
                    p.productName,
                    p.cost_price,
                    p.selling_price,
                    s.salesQuantity,
                    p.category,
                    s.salesTime,
                    (p.selling_price * s.salesQuantity) AS dailySales,
                    (p.selling_price * s.salesQuantity - p.cost_price * s.salesQuantity) AS profit
                FROM
                    sales s
                JOIN
                    products p ON s.productId = p.productId;";
            
            if ($connection->query($sales_product_view) === TRUE) { 
            ?>
            <script> console.log("sales details are organized");</script>
            <?php
            }
            else {
                 echo "Error creating product sales view " . $connection->error . "<br>";
            }  
               // Create the view of 7 days sales profit
               //DAILY PROFIT VIEW is ALso created. this view is used to display sales data on top of dashboard
               $sqlWeek = "CREATE OR REPLACE VIEW daily_profit_view AS
               SELECT
               date_seq.salesDate,
               COALESCE(SUM(psv.profit), 0) AS totalProfit,
               COALESCE(SUM(psv.dailySales),0) AS dailySales

               FROM
               (
                   SELECT CURDATE() - INTERVAL (seq.n - 1) DAY AS salesDate
                   FROM
                       (SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                       UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7) AS seq
               ) AS date_seq
               LEFT JOIN
               product_sales_view AS psv ON DATE(psv.salesTime) = date_seq.salesDate
                   WHERE
                   date_seq.salesDate >= CURDATE() - INTERVAL 6 DAY
                GROUP BY
               date_seq.salesDate;";
             


            

            // Execute the view creation query
            if ($connection->query($sqlWeek) === TRUE)
            // EXECUTION msg in displayed in console
         { ?>
            

            <script> console.log(" Weekly profit calculated");</script>

            <?php   
            } else {
                echo "Error creating daily profit view: " . $connection->error . "<br>";
            }
            $fetch_sevendays_record = "SELECT * FROM daily_profit_view;";
            $week_result= $connection->query($fetch_sevendays_record);
            if ($week_result != false){
                $salesDate= array();
                $totalProfit = array();
                ?>

                <script> console.log("weekly data processed sucessfully"); </script>
                <?php
                while ($row = $week_result->fetch_assoc()) {
                    // Access the data fields
                    $salesDate []= $row['salesDate'];
                    $totalProfit[] = $row['totalProfit'];
            
                   
                }
            }
            else{
                echo "error fetching data: " . $connection->error . "<br>";
            }
            //create monthly sales view

           $sqlMonth="CREATE OR REPLACE VIEW monthly_profit_view AS
                        SELECT
                            date_seq.salesDate AS MonthSalesDate,
                            COALESCE(SUM(psv.profit), 0) AS MonthDailyProfit
                        FROM
                            (
                                SELECT CURDATE() - INTERVAL (seq.n - 1) DAY AS salesDate
                                FROM
                                    (SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                                        UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
                                        UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                                        UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
                                        UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19
                                        UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23
                                        UNION ALL SELECT 24 UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27
                                        UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30) AS seq
                            ) AS date_seq
                        LEFT JOIN
                            product_sales_view AS psv ON DATE(psv.salesTime) = date_seq.salesDate
                        WHERE
                            date_seq.salesDate >= CURDATE() - INTERVAL 1 MONTH
                        GROUP BY
                            date_seq.salesDate;";

                if ($connection->query($sqlMonth) === TRUE) {
                ?>
                <script>console.log("Monthly sales data are calculated");</script>
                <?php
                }
                else {
                    echo "Error creating Monntly profit view: " . $connection->error . "<br>";
                }                 
          

            //fetching one month profit record from a view created in above section 
            //to create month profit chart
            $fetch_oneMonth_record = "SELECT * FROM monthly_profit_view;";
            $month_result =$connection->query($fetch_oneMonth_record);
            if($fetch_oneMonth_record != false){
                $MonthSalesDate = array();
                $MonthDailyProfit = array();
                ?>
                <script> console.log("data fetched sucessfully");</script>
                <?php
                while($row=$month_result->fetch_assoc()){
                    $MonthSalesDate[]= $row['MonthSalesDate'];
                    $MonthDailyProfit[]=$row['MonthDailyProfit'];
                }
            
            } 
            // Create a view named 'lowest_quantity_products_view' that selects the 10 items with the lowest quantity
            $lowest_quantity_products= "CREATE OR REPLACE VIEW lowest_quantity_products_view AS
                        SELECT
                            productId,
                            productName,
                            
                            quantity,
                            category,
                            manufacturer
                        FROM
                            products
                        ORDER BY
                            quantity ASC
                        LIMIT 10;"; 
            $lowest_quantity_products_Query = mysqli_query($connection,$lowest_quantity_products);                  
            ?>
</head>
<body>
<?php 

//we will show current date profit and sales
$sql= "SELECT totalProfit, dailySales from daily_profit_view where salesDate = CURDATE();" ;
$result = mysqli_query($connection, $sql);

if( $result){
$row = mysqli_fetch_assoc($result);
$profit = $row['totalProfit'];
$sales = $row['dailySales'];
}
else{
$profit = "NILL";
$sales = "NILL";
}

$maxStockSql= "SELECT productName , quantity FROM products WHERE quantity = (SELECT MAX(quantity) FROM products)";
$maxStockQuery = mysqli_query($connection, $maxStockSql);
if($maxStockQuery){
    $row = mysqli_fetch_assoc($maxStockQuery);
    $maxPName = $row['productName'];
    $maxPQuantity = $row['quantity'];
}

$minStockSql = "SELECT productName , quantity FROM products WHERE quantity = (SELECT MIN(quantity) FROM products)";
$minStockQuery = mysqli_query($connection, $minStockSql);

if($minStockQuery){
    $row= mysqli_fetch_assoc($minStockQuery);
    $minPName = $row['productName'];
    $minPQuantity = $row['quantity'];
}


$connection->close();

?> 
<script>
    var maxPQuantity = <?php echo json_encode($maxPQuantity); ?>;
    var minPQuantity = <?php echo json_encode($minPQuantity); ?>;
    var maxPName = <?php echo json_encode($maxPName); ?>;
    var minPName = <?php echo json_encode($minPName); ?>;
  
</script>
<table class="placeholder-table">
<thead>
            <tr>
                <th>Today's Profit</th>
                <th>Today's Sales</th>
                <th id= "max-quantity">Max Quantity</th>
                <th id="min-quantity">Min Quantity</th>
            </tr>
        </thead>
        <tbody>
            <tr ID= "popup">
                <td><?php echo $profit ?></td>
                <td><?php echo $sales ?></td>
                <td ><?php echo $maxPName ?></td>
                <td ><?php echo $minPName ?></td>
            </tr>
        </tbody>
    </table>
   
  

    <div class="chartContainer" style="position: relative; width:90vh; display: flex; ">
        <canvas id="myChart" class= "chart" style="flex: 1;"></canvas>
        <canvas id="linechart" class= "chart" style="flex: 1;"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js">
        //online library is included
    </script>
    <script>
        //profit grapsh for last 7 days  sales
        //setup Block
       const salesDate= <?php echo json_encode($salesDate); ?>;
       const totalProfit = <?php echo json_encode($totalProfit); ?>;
       // conersion of php data into javascript format

        const data = {
        labels: salesDate ,
        datasets: [{
            label: 'Weekly Profit Graph',
            data: totalProfit,
            borderWidth: 1
        }]
        };

        
        //config Block
        const config = {
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                    }
           }
            
            };
        
            //render block
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );   
</script>
<script>


    //Profit graph for last 30 days sales activities
        const MonthSalesDate = <?php echo json_encode($MonthSalesDate); ?>;
        const MonthDailyProfit = <?php echo json_encode($MonthDailyProfit); ?>;
        //setup block
        const Monthdata = {
        labels: MonthSalesDate ,
        datasets: [{
            label: 'Monthly Profit Graph',
            data: MonthDailyProfit,
            borderWidth: 1
        }]
        };

        
        //config Block
        const confi = {
            type: 'line',
            data: Monthdata,
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                    }
           }
            
            };
        
            //render block
            const linechart = new Chart(
                document.getElementById('linechart'),
                confi
            );
    </script>

</body>     <script>
    document.addEventListener('DOMContentLoaded', function () {
    const maxQuantityCell = document.getElementById('max-quantity');
    
    const minQuantityCell = document.getElementById('min-quantity');
    var tableRow = document.getElementById('popup')

    //storing orginal text of max quantity cell
    //var maxPName = maxQuantityCell.textContent;
    //var minPName = minQuantityCell.textContent;
    maxQuantityCell.addEventListener('mouseover', () => {
        popup.cells[2].textContent = maxPName + ": "+ maxPQuantity;
        maxQuantityPopup.style.display = 'block';
    });

    maxQuantityCell.addEventListener('mouseout', () => {
        //maxQuantityPopup.style.display = 'none';
        popup.cells[2].textContent = maxPName;
    });

    minQuantityCell.addEventListener('mouseover', () => {
        popup.cells[3].textContent = minPName+ ": "+  minPQuantity;
        minQuantityPopup.style.display = 'block';
    });

    minQuantityCell.addEventListener('mouseout', () => {
        popup.cells[3].textContent = minPName;
        //minQuantityPopup.style.display = 'none';
       
    });
});

</script> 
</html>