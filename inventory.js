function submitForm() {
  //const productId = document.getElementById("productId").value;
  const productName = document.getElementById("productName").value;
  const productDescription = document.getElementById("productDescription").value;
  const costPrice = document.getElementById("costPrice").value;
  const sellingPrice = document.getElementById("sellingPrice").value;
  const quantity = document.getElementById("quantity").value;
  const dropdown = document.getElementById("category");
  const category = dropdown.value;
  const manufacturer = document.getElementById("manufacturer").value;
  //const supplierId = document.getElementById("supplier_id").value;

if (
   // productId.trim() === "" ||
    productName.trim() === "" ||
    costPrice.trim() === "" ||
    sellingPrice.trim() === "" ||
    quantity.trim() === ""||
    category.trim()===""||
    manufacturer.trim()===""
  ) {
    alert("Please fill in all required fields.");
    return ;
  }
  if (
    //isNaN(productId) ||
    isNaN(costPrice) ||
    isNaN(sellingPrice) ||
    isNaN(quantity)
  ) {
    alert("Numeric fields should have valid numbers.");
    return ;
  }
  const xhr = new XMLHttpRequest();
  const url = "inventory_update.php";
  const parameter = `&productName=${productName}&productDescription=${productDescription}
  &costPrice=${costPrice}&sellingPrice=${sellingPrice}&quantity=${quantity}&category=${category}&manufacturer=${manufacturer}`;

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Request successful
      alert(xhr.responseText);
      // Optionally, perform further actions after successful submission
    }
  };

  xhr.send(parameter);
}

