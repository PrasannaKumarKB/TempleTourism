<?php
if (isset($_POST['submit'])) {
  $cardNumber = $_POST['card-number'];
  $expiryDate = $_POST['expiry-date'];
  $cvv = $_POST['cvv'];
  $cardHolder = $_POST['card-holder'];
  $otp = $_POST['otp'];
  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "temple";

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO card_payments (card_number, expiry_date, cvv, card_holder, otp) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiss", $cardNumber, $expiryDate, $cvv, $cardHolder, $otp);
  
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
  <title>Card Payment</title>
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

    .card-form {
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
    .form-group input[type="number"],
    .form-group select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
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

    .error-message {
      color: red;
      font-size: 14px;
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
    <h1>Card Payment</h1>
    <?php
    if (isset($successMessage)) {
      echo '<div class="success-message">' . $successMessage . '</div>';
    } elseif (isset($errorMessage)) {
      echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>
    <form class="card-form" action="" method="POST" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="card-number">Card Number</label>
        <input type="text" id="card-number" name="card-number" maxlength="16" required>
        <div id="card-number-error" class="error-message"></div>
      </div>
      <div class="form-group">
        <label for="expiry-date">Expiry Date (MM/YY)</label>
        <input type="text" id="expiry-date" name="expiry-date" pattern="[0-9/]{1,5}" required>
        <div id="expiry-date-error" class="error-message"></div>
      </div>
      <div class="form-group">
        <label for="cvv">CVV</label>
        <input type="number" id="cvv" name="cvv" required>
        <div id="cvv-error" class="error-message"></div>
      </div>
      <div class="form-group">
        <label for="card-holder">Card Holder</label>
        <input type="text" id="card-holder" name="card-holder" required>
        <div id="card-holder-error" class="error-message"></div>
      </div>
      <div class="form-group">
        <label for="otp">Enter OTP</label>
        <input type="number" id="otp" name="otp" required>
        <div id="otp-error" class="error-message"></div>
      </div>
      <div class="form-group">
        <input class="cta-button" type="submit" name="submit" value="Proceed">
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      var cardNumberInput = document.getElementById("card-number");
      var expiryDateInput = document.getElementById("expiry-date");
      var cvvInput = document.getElementById("cvv");
      var cardHolderInput = document.getElementById("card-holder");
      var otpInput = document.getElementById("otp");

      var cardNumberError = document.getElementById("card-number-error");
      var expiryDateError = document.getElementById("expiry-date-error");
      var cvvError = document.getElementById("cvv-error");
      var cardHolderError = document.getElementById("card-holder-error");
      var otpError = document.getElementById("otp-error");

      var isValid = true;

      var cardNumber = cardNumberInput.value.trim();
      if (!/^\d{16}$/.test(cardNumber)) {
        cardNumberError.textContent = "Card number is incorrect. Please enter 16 digits.";
        isValid = false;
      } else {
        cardNumberError.textContent = "";
      }

      var expiryDate = expiryDateInput.value.trim();
      if (!/^\d{2}\/\d{2}$/.test(expiryDate) || expiryDate.length !== 5 || !/^\d+$/.test(expiryDate.replace('/', ''))) {
        expiryDateError.textContent = "Expiry date is incorrect. Please use the format MM/YY.";
        isValid = false;
      } else {
        expiryDateError.textContent = "";
      }

      var cvv = cvvInput.value.trim();
      if (!/^\d{3}$/.test(cvv)) {
        cvvError.textContent = "CVV should be a 3-digit number.";
        isValid = false;
      } else {
        cvvError.textContent = "";
      }

      var cardHolder = cardHolderInput.value.trim();
      if (!/^[A-Za-z\s]+$/.test(cardHolder)) {
        cardHolderError.textContent = "Card holder name should only contain alphabets.";
        isValid = false;
      } else {
        cardHolderError.textContent = "";
      }

      var otp = otpInput.value.trim();
      if (!/^\d{4}$/.test(otp)) {
        otpError.textContent = "OTP should be a 4-digit number.";
        isValid = false;
      } else {
        otpError.textContent = "";
      }

      return isValid;
    }
  </script>
</body>
</html>
