<!DOCTYPE html>
<html>
<head>
  <title>Subramaniya Swamy Temple - Contact</title>
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
  </style>
</head>
<body>
  <h1>Subramaniya Swamy Temple - Contact</h1>

  <div class="contact-container">
    <form class="contact-form" method="POST" action="process_contact.php">
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
        <li>Phone: 0452-6418832</li>
        <li>Email: info@subramaniyaswamytemple.com</li>
        <li>Address: 146a, Big Car St, Thiruparankundram, Tamil Nadu 625005</li>
      </ul>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2023 Subramaniya Swamy Temple. All rights reserved.</p>
  </footer>
</body>
</html>
