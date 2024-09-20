<!DOCTYPE html>
<html>
<head>
  <title>Contact Chennai City</title>
  <style>
  
    body {
      font-family: georgia, TimesNewRoman;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      color: black;
      text-align: center;
    }
    
    p {
      line-height: 1.6;
      margin-bottom: 15px;
    }
    
    .contact-container {
      display: flex;
      justify-content: space-between;
      max-width: 100%;
      margin-bottom: 40px;
    }
    
    .contact-details {
      flex-basis: 48%;
      padding: 20px;
      background-color: #f2f2f2;
      border-radius: 4px;
    }
    
    .contact-details h2 {
      margin-top: 0;
    }
    
    .contact-details p {
      margin-bottom: 10px;
    }
    
    .contact-details img {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
    }
    
    .contact-form {
      max-width: 800px;
      margin-left: 10%;
    }
    
    .contact-form label {
      display: block;
      margin-bottom: 10px;
    }
    
    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .contact-form button {
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .contact-form button:hover {
      background-color: #555;
    }
    
    
.notification-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #4CAF50;
      color: #fff;
      padding: 10px;
      text-align: center;
      display: none;
    }
  </style>
  <script>
    function showNotification(message) {
      const notificationContainer = document.querySelector('.notification-container');
      const notification = document.createElement('div');
      notification.className = 'notification';
      notification.textContent = message;
      notificationContainer.appendChild(notification);
      notificationContainer.style.display = 'block';
      setTimeout(function () {
        notificationContainer.style.display = 'none';
      }, 3000);
    }
  </script>
</head>
<body>
  <header>
  <a class="back-button" href="chennai.html" style="position: absolute; top: 20px; left: 20px; font-size: 48px; color:black;text-decoration: none;">&larr;</a>
    <h1>Contact - Chennai City</h1>
  </header>

  <div class="notification-container"></div>

  <div class="contact-container">
    <div class="contact-details">
      <h2>Chennai City Collectorate</h2>
      <img src="corporationchennai.webp" alt="Chennai City Collectorate">
      <p>Address: No. 82, Noor Veerasamy Street, Nungambakkam, Chennai - 600034</p>
      <p>Email: collectorchennai@tn.gov.in</p>
      <p>Phone: +91-44-28334882</p>
    </div>

    <div class="contact-details">
      <h2>Greater Chennai Corporation</h2>
      <img src="greaterchennaicorporation.jpg" alt="Chennai City Collectorate">
      <p>Address: Ripon Building, EVR Salai, Chennai - 600003</p>
      <p>Email: info@chennaicorporation.gov.in</p>
      <p>Phone: +91-44-25384530</p>
    </div>

    <div class="contact-details">
      <h2>Other Officials</h2>

      <h3>Commissioner, Greater Chennai Corporation</h3>
      <img src="commissionerofficechennai.jpg" alt="Commissioner">
      <p>Email: commissioner@chennaicorporation.gov.in</p>
      <p>Phone: +91-44-25384441</p>
    </div>
  </div>
  <h1>For Any Queries</h1>

  <?php
  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "temple";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    
    $sql = "INSERT INTO chennaicontacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
      // Display success message
      echo "<script>showNotification('Your query has been successfully received. Thank you for contacting us, $name!');</script>";
    } else {
      // Display error message
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  // Close the database connection
  $conn->close();
  ?>

  <div class="contact-form">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="4" required></textarea>

      <button type="submit">Submit</button>
    </form>
  </div>

  <footer>
    <p>&copy; 2023 Chennai City. All rights reserved.</p>
  </footer>
</body>
</html>