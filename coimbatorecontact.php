<!DOCTYPE html>
<html>
<head>
  <title>Contact Coimbatore City</title>
  <style>
    /* CSS styling for the page */
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
    .notification{
      color: black;
      background-color: green;
      text-align:center;
    }
  </style>
</head>
<body>
  <header>
    <h1>Contact - Coimbatore City</h1>
    <a class="back-button" href="coimbatore.html" style="position: absolute; top: 20px; left: 20px; font-size: 48px; color: black;text-decoration: none;">&larr;</a>

  </header>

  <div class="contact-container">
    <div class="contact-details">
      <h2>Coimbatore City Corporation</h2>
      <img src="coimbatorecorporation.jpg" alt="Coimbatore City Corporation">
      <p>Address: Town Hall, R.S. Puram, Coimbatore - 641002</p>
      <p>Email: commissioner@ccbeu.com</p>
      <p>Phone: +91-422-2390250</p>
    </div>

    <div class="contact-details">
      <h2>Coimbatore District Collectorate</h2>
      <img src="coimbatorecollectrate.jpg" alt="Coimbatore District Collectorate">
      <p>Address: Coimbatore Collectorate, Coimbatore - 641018</p>
      <p>Email: collector@coimbatore.nic.in</p>
      <p>Phone: +91-422-2301110</p>
    </div>
    
    <div class="contact-details">
      <h2>Other Officials</h2>
      
      <h3>Deputy Commissioner, Coimbatore City Corporation</h3>
      <img src="coimbatorecommissioner.jpg" alt="Deputy Commissioner">
      <p>Email: deputycommissioner@ccbeu.com</p>
      <p>Phone: +91-422-2390260</p>
    </div>
  </div>
  
  <h1>For Any Queries</h1>
  
  <div class="contact-form">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Retrieve form data
      $name = $_POST['name'];
      $email = $_POST['email'];
      $subject = $_POST['subject'];
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
      $stmt = $conn->prepare('INSERT INTO coimbatore_contacts (name, email, subject, message) VALUES (?, ?, ?, ?)');
      $stmt->bind_param('ssss', $name, $email, $subject, $message);
      $stmt->execute();

      // Close the statement and connection
      $stmt->close();
      $conn->close();

      // Display a notification message
      echo '<div class="notification">Your query has been successfully received. Thank you for contacting us, ' . $name . '!</div>';
    }
    ?>
    
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
    <p>&copy; 2023 Coimbatore City. All rights reserved.</p>
  </footer>
</body>
</html>
