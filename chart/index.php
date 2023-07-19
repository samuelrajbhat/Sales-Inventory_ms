<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
  
    <?php
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
                    (p.selling_price * s.salesQuantity - p.cost_price * s.salesQuantity) AS profit
                FROM
                    sales s
                JOIN
                    products p ON s.productId = p.productId;";
            
            if ($connection->query($sales_product_view) === TRUE) {
                echo "Product Sales view created.<br>";
            } else {
                echo "Error creating product sales view " . $connection->error . "<br>";
            }   


            // Create the view of 7 days sales profit
                $sqlWeek = "CREATE OR REPLACE VIEW daily_profit_view AS
                    SELECT
                    date_seq.salesDate,
                    COALESCE(SUM(psv.profit), 0) AS totalProfit
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
            if ($connection->query($sqlWeek) === TRUE) {
                echo "Daily profit view created successfully.<br>";
            } else {
                echo "Error creating daily profit view: " . $connection->error . "<br>";
            }
            $fetch_sevendays_record = "SELECT * FROM daily_profit_view;";
            $week_result= $connection->query($fetch_sevendays_record);
            if ($week_result != false){
                $salesDate= array();
                $totalProfit = array();
                echo"data fetched sucessfully.<br>";
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
                    echo "Monthly view created successfully.<br>";
                } else {
                    echo "Error creating daily profit view: " . $connection->error . "<br>";
                }                 
          

            //fetching one month profit record from a view created in above section 
            $fetch_oneMonth_record = "SELECT * FROM monthly_profit_view;";
            $month_result =$connection->query($fetch_oneMonth_record);
            if($fetch_oneMonth_record != false){
                $MonthSalesDate = array();
                $MonthDailyProfit = array();
                echo "data fetched sucessfully";
                while($row=$month_result->fetch_assoc()){
                    $MonthSalesDate[]= $row['MonthSalesDate'];
                    $MonthDailyProfit[]=$row['MonthDailyProfit'];
                }
            
            }

            // Close the connection
            $connection->close();
?>
</head>

<body>

    <h1>SALES & INVENTORY MANAGEMENT SYSTEM</h1>    
   
    <div class="chartBox" style="position: relative; height:40vh; width:80vw">
        <canvas id="myChart"  ></canvas>
    </div>

    <div class="lineChart" style="position: relative; height:40vh; width:80vw">
        <canvas id="linechart"></canvas><p1>hello</p1>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            label: 'Weekly Profit Graph',
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

</body>
</html>