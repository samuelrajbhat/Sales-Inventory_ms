var rowCounter = 0; // Global variable to keep track of the row count
function fetchProduct() {
  var productId = document.getElementById('show_product_id').value;

  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Prepare the request
  xhr.open('GET', 'fetch_product.php?product_id=' + productId, true);

  // Set the callback function when the request is completed
  xhr.onload = function() {
    if (xhr.status === 200) {
      var productDetails = xhr.responseText;
      if (productDetails !== '') {
        var details = productDetails.split(',');
        document.getElementById('show_product_name' ).value = details[0];
        document.getElementById('show_product_sp').value = details[1];
      } else {
        // Handle case when product ID is not found
        document.getElementById('show_product_name' + row).value = '';
        document.getElementById('show_product_sp' + row).value = '';
      }
    }
  };
  // Send the request
  xhr.send();
}
function calculate() {
  var sp = document.getElementById('show_product_sp').value;
  var quant = document.getElementById('show_quantity').value;
  var total = (sp * quant);
  document.getElementById('show_total').value = total;
}
function addTableRow() {
  var salesTable = document.getElementById("salesTable");
  var newRow = salesTable.insertRow(salesTable.rows.length - 1);
  var cell1 = newRow.insertCell(0);
  var cell2 = newRow.insertCell(1);
  var cell3 = newRow.insertCell(2);
  var cell4 = newRow.insertCell(3);
  var cell5 = newRow.insertCell(4);
  
  cell1.innerHTML = '<input type="text" id="show_product_id' + rowCounter + '" onblur="fetchProductDetails(' + rowCounter + ')">';
  cell2.innerHTML = '<input type="text" id="show_product_name' + rowCounter + '">';
  cell3.innerHTML = '<input type="text" id="show_product_sp' + rowCounter + '">';
  cell4.innerHTML = '<input type="text" id="show_quantity' + rowCounter + '">';
  cell5.innerHTML = '<input type="text" id="show_total' + rowCounter + '" class="product_cost" onfocus="calculatetotal(' + rowCounter + ')">';

  rowCounter++;
  var rows = salesTable.rows;
  for (var i = 1; i < rows.length - 1; i++) {
    rows[i].parentNode.insertBefore(rows[i], rows[i + 1]);
  }
}

function fetchProductDetails(row) {
  var productId = document.getElementById('show_product_id' + row).value;

  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Prepare the request
  xhr.open('GET', 'fetch_product.php?product_id=' + productId, true);

  // Set the callback function when the request is completed
  xhr.onload = function() {
    if (xhr.status === 200) {
      var productDetails = xhr.responseText;
      if (productDetails !== '') {
        var details = productDetails.split(',');
        document.getElementById('show_product_name' + row).value = details[0];
        document.getElementById('show_product_sp' + row).value = details[1];
      } else {
        // Handle case when product ID is not found
        document.getElementById('show_product_name' + row).value = '';
        document.getElementById('show_product_sp' + row).value = '';
      }
    }
  };

  // Send the request
  xhr.send();
}

function calculatetotal(row) {
  var sp = document.getElementById('show_product_sp' + row).value;
  var quant = document.getElementById('show_quantity' + row).value;
  var total = (sp * quant);
  document.getElementById('show_total' + row).value = total;
}
function totalpayment(){
  var p1 = parseInt(document.getElementById('show_total').value);
  var rowCount = rowCounter;
   // Assuming 'rowCounter' is the variable that holds the row count

  for (var j = 0; j < rowCount; j++) {
    p1 += parseInt(document.getElementById('show_total' + j).value);
  }
  document.getElementById('show_grand_total').value= p1;
}

    function salesupdate() {
    
  var customerName = document.getElementById('customer_name').value;
  productId = document.getElementById("show_product_id").value;
    quantity = document.getElementById("show_quantity").value;
    sendRowData(productId, quantity, customerName);
    //alert(productId);
    //alert(quantity);
    //alert(customerName);

  // Get all table rows except the header row
  //var rows = document.querySelectorAll('#salesTable tr:not(:first-child)');

  // Iterate over each row and extract the data
  for (var i = 0; i <10; i++) {
    //var row = rows[i];
    let productId='';
    let quantity = '';

   
      productId = document.getElementById('show_product_id'+i).value;
      quantity = document.getElementById('show_quantity'+i).value;
    //sendRowData(productId, quantity, customerName);
    //alert(productId);
    //alert(quantity);
    //alert(customerName);
    

    
    // Send the row data to the server
    sendRowData(productId, quantity, customerName);
  }
}

function sendRowData(productId, quantity, customerName) {
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Prepare the request
  xhr.open('POST', 'insert_sales.php', true);

  // Set the content type header for form data
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  // Set the callback function when the request is completed
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log('Row data sent successfully');
    } else {
      console.error('Error sending row data');
    }
  };

  // Create the request data
  var data = 'productId=' + encodeURIComponent(productId) +
             '&quantity=' + encodeURIComponent(quantity) +
              '&customerName=' +encodeURIComponent(customerName);
  // Send the request with the data
  xhr.send(data);
}