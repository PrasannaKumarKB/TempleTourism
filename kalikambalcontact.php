<!DOCTYPE html>
<html>
<head>
  <title>Kalikambal Temple - Contact</title>
  <style>
    /* CSS styling for the page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f2f2f2;
    }
    
    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    
    .contact-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .contact-form label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    .contact-form input,
    .contact-form textarea,
    .contact-form button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .contact-form textarea {
      resize: vertical;
      min-height: 100px;
    }
    
    .contact-form button {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .contact-form button:hover {
      background-color: #555;
    }
    
    .contact-info {
      margin-top: 30px;
    }
    
    .contact-info h3 {
      margin-bottom: 10px;
    }
    
    .footer {
      text-align: center;
      margin-top: 20px;
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
  <h1>Kalikambal Temple - Contact</h1>

  <div class="notification-container"></div>

  <div class="contact-container">
    <form class="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="message">Message:</label>
      <textarea id="message" name="message" placeholder="Enter your message" required></textarea>

      <button type="submit">Send Message</button>
    </form>

    <div class="contact-info">
      <h3>Official Contacts:</h3>
      <p>For any inquiries or assistance, please contact the following:</p>
      <ul>
        <li>Phone: +91 44 3243 4323</li>
        <li>Email: info@kalikambaltemple.com</li>
        <li>Address: 212, Thambu Chetty St, near DHL Express Courier, Mannadi, George Town, Chennai-600001, Tamilnadu.</li>
      </ul>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2023 Kalikambal Temple. All rights reserved.</p>
  </footer>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Save the data to the database
    // Replace the database connection details with your own
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'temple';

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert the data
    $stmt = $conn->prepare("INSERT INTO kalikambal_contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $phone, $message);

    if ($stmt->execute()) {
      // Display success message
      echo "<script>showNotification('Your query has been successfully received. Thank you for contacting us, $name!');</script>";
    } else {
      // Display error message
      echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
  }
  ?>
</body>
</html>
