<!DOCTYPE html>
<html>
<head>
  <title>Contact Trichy District</title>
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
  </style>
</head>
<body>
  <header>
    <h1>Contact - Trichy District</h1>
  </header>

  <div class="contact-container">
    <div class="contact-details">
      <h2>Trichy Collector's Office</h2>
      <img src="trichycollectorate.jpg" alt="Trichy Collector's Office">
      <p>Address: Collector's Office, Cantonment, Trichy - 620001</p>
      <p>Email: collector.trichy@tn.gov.in</p>
      <p>Phone: +91-431-2415733</p>
    </div>

    <div class="contact-details">
      <h2>Trichy Corporation</h2>
      <img src="trichycorporation.jpeg" alt="Trichy Corporation">
      <p>Address: Corporation Office, Bharathidasan Road, Trichy - 620001</p>
      <p>Email: commissioner@trichycorporation.gov.in</p>
      <p>Phone: +91-431-2415373</p>
    </div>

    <div class="contact-details">
      <h2>Trichy Commissioner's Office</h2>
      <img src="trichycommissioner.jpg" alt="Trichy Commissioner's Office">
      <p>Address: Commissioner's Office, Pudukkottai Main Road, Trichy - 620017</p>
      <p>Email: commissioner.trichy@tn.gov.in</p>
      <p>Phone: +91-431-2450303</p>
    </div>
  </div>

  <h1>For Any Queries</h1>

  <div class="contact-form">
    <form>
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
    <p>&copy; 2023 Trichy District. All rights reserved.</p>
  </footer>
</body>
</html>
