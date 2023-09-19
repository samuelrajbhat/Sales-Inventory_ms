<!DOCTYPE html>
<html>
<head>
  <title>Sales Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  
  <script>
    //this page is sales page.
    //it handles sales task. It integrates multiple functions from fetch_product.php fetch_sales_data.js connection.php and so on. 
    //It records sales transaction data in sales table
   </script>
</head>
<body>
  <h1>Sales Booth</h1>
  <form id="salesForm" method="POST">
    <table id="salesTable">
        <tr>
           <div class="Labels">
            <th><label id="product_id">Product Id</label></th>
            <th><label id="product_name">Product Name</label></th>
            <th><label id="product_sp">Price</label></th>
            <th><label id="quantity"> Quantity</label></th>
            <th><label id="total"> Total</label></th>
            </div>
        </tr>
        <tr>
        <div class="Labels">
        <td><input type="text" id="show_product_id" onblur="fetchProduct()"> </td>
        <td><input type="text" id="show_product_name"></td>
        <td><input type="text" id="show_product_sp"></td>
        <td><input type="text" id="show_quantity"></td>
        <td><input type="total" id="show_total"  onfocus="calculate()"></td>
      </tr> 
    </div>      
      <tr><td colspan="2">
            <button type="button" onclick="addTableRow()">Add Row</button>
          </td>
        <td colspan="2"><button type="button" onfocus="totalpayment()">Total</button>
        </td>
        <td><input type="text" id="show_grand_total"></td>
      </tr>  
</table>
    <table id="customer">
      <tr>
        <td>Customer Name</td>
        <td><input type="text" id="customer_name"></td>
      </tr>
      
    </table>
    <div><button type="submit" id="sales_update" onclick="salesupdate()">Complete</button></div>
  </form>
  <script src="fetch_sales_data.js"></script>

 
</body>
</html>



  