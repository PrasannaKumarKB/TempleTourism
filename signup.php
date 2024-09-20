<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $aadharnumber = $_POST["aadharnumber"];
  $password = $_POST["password"];
  $reenterPassword = $_POST["reenterpassword"];
  $mobile = $_POST["mobile"];

  $errorMessage = "";

  if (empty($aadharnumber) || empty($password) || empty($reenterPassword) || empty($mobile)) {
    $errorMessage = "Please enter all the required fields.";
  } elseif (strlen($aadharnumber) !== 12) {
    $errorMessage = "Aadhar number should contain exactly 12 digits.";
  } elseif ($password !== $reenterPassword) {
    $errorMessage = "Passwords do not match. Please re-enter the password.";
  } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{6,}$/', $password)) {
    $errorMessage = "Password should be at least 6 characters long, and contain at least 1 capital letter, 1 symbol, and 1 number.";
  } elseif (strlen($mobile) !== 10) {
    $errorMessage = "Mobile number should contain exactly 10 digits.";
  } else {
    $servername = "localhost";
    $username = "root";
    $db_password = ""; // 
    $dbname = "temple";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO signup (aadharnumber, password, mobile) VALUES (?, ?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $hashedPassword = substr($hashedPassword, 0, 255);

    $stmt->bind_param("sss", $aadharnumber, $hashedPassword, $mobile);

    if ($stmt->execute()) {
      header("Location: home.php");
      exit();
    } else {
      $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup Page</title>
  <style>
    body {
      font-family: Georgia, 'Times New Roman', Times, serif;
      background-color: #f2f2f2;
    }

    .container {
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 56.25%;
    }

    .background-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("signupbackground.webp");
      background-repeat: no-repeat;
      background-size: cover;
      z-index: -1;
    }

    .login-box {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    h1 {
      text-align: center;
    }

    .form-group {
      margin-bottom: 5px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 90%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    input[type="submit"] {
      width: 20%;
      background-color: black;
      color: gold;
      padding: 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    p {
      margin-top: 10px;
    }

    .cta-button {
      display: inline-block;
      background-color: black;
      color: gold;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
      margin-top: 30px;
      margin-left: 90px;
    }
  </style>
  <script>
    function validateForm() {
      var aadharnumber = document.getElementById("aadharnumber").value;
      var password = document.getElementById("password").value;
      var reenterPassword = document.getElementById("reenterpassword").value;
      var mobile = document.getElementById("mobile").value;

      if (aadharnumber === "" || password === "" || reenterPassword === "" || mobile === "") {
        alert("Please enter all the required fields.");
        return false;
      }

      if (aadharnumber.length !== 12) {
        alert("Aadhar number should contain exactly 12 digits.");
        return false;
      }

      if (password !== reenterPassword) {
        alert("Passwords do not match. Please re-enter the password.");
        return false;
      }

      var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{6,}$/;
      if (!passwordRegex.test(password)) {
        alert("Password should be at least 6 characters long, and contain at least 1 capital letter, 1 symbol, and 1 number.");
        return false;
      }

      if (mobile.length !== 10) {
        alert("Mobile number should contain exactly 10 digits.");
        return false;
      }

      return true;
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="background-image"></div>
    <h1>TAMILNADU TOURISM</h1>
    <div class="login-box">
      <h1>Signup</h1>
      <form id="signupForm" action="signup.php" method="post" onsubmit="return validateForm()">
        <div class="form-group">
          <label for="aadharnumber">Aadhar Number</label>
          <input type="text" id="aadharnumber" name="aadharnumber" placeholder="Aadhar Number" maxlength="12">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="reenterpassword">Re-enter Password</label>
          <input type="password" id="reenterpassword" name="reenterpassword" placeholder="Re-enter Password">
        </div>
        <div class="form-group">
          <label for="mobile">Mobile Number</label>
          <input type="text" id="mobile" name="mobile" placeholder="Mobile Number" maxlength="10">
        </div>
        <input type="submit" name="submit" value="Sign Up">
      </form>
      <p>Already have an account?</p>
      <a class="cta-button" href="login.php">Login</a>
    </div>
  </div>
  <?php if (!empty($errorMessage)): ?>
    <p><?php echo $errorMessage; ?></p>
  <?php endif; ?>
</body>
</html>