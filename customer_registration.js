function submitForm(){
    // Get form values
    var name = document.getElementById("name").value;
    var phone = document.getElementById("phone").value;
    var address = document.getElementById("address").value;

    // Validate form data
    if (name.trim() === "") {
        alert("Please enter your name.");
        return;
    }

    if (phone.trim() === "") {
        alert("Please enter your phone number.");
        return;
    }

    if (!/^\d{10}$/.test(phone)) {
        alert("Please enter a valid 10-digit phone number.");
        return;
    }

    if (address.trim() === "") {
        alert("Please enter your address.");
        return;
    }

    // Send form data to PHP script
   const xhr = new XMLHttpRequest();
    const url = "customer_registration.php";
    const params = `name=${name}&phone=${phone}&address=${address}`;

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Request successful
            alert(xhr.responseText);
            // Optionally, perform further actions after successful registration
        }
    };

    xhr.send(params);

}