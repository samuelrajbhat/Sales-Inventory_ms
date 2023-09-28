<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
//creating view of inventory status as per the catgeory and manufacturer
    include 'connection.php';
    
    $manufacturer_table =  "CREATE OR REPLACE VIEW manufacturer AS
            SELECT manufacturer,
            GROUP_CONCAT(productName) AS productNames
            FROM
                products
            GROUP BY
                manufacturer;";
    $manufacturer_result=$connection->query($manufacturer_table);
    if($manufacturer_result != false){
        echo "view created suvessfully<br>";

    }

    else{
        echo "error creating view". $connection->error ."<br>";
    }
    $category_stat = "CREATE OR REPLACE VIEW categoryStatus AS
                    SELECT 
                        category AS category_key,
                        COUNT(*) AS number_of_items,
                        SUM(quantity) AS category_accumulation
                    FROM 
                        products
                    WHERE 
                        category IN ('foods', 'drinks', 'beauty', 'health', 'sanitation', 'stationery', 'utensils', 'tools')
                    GROUP BY 
                        category;";

    $category_result = $connection->query($category_stat);
    if($category_result != false){
        echo "Category view created sucessfully";
    }

    else{
        echo "error: " . connection->error."<br>";
    }
?>

<body>
    
</body>
</html>