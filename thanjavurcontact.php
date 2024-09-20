<!DOCTYPE html>
<html>
<head>
  <title>Contact - Thanjavur District</title>
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
    <h1>Contact - Thanjavur District</h1>
  </header>

  <div class="contact-container">
    <div class="contact-details">
      <h2>Thanjavur District Collector</h2>
      <img src="thanjavurcollectorate.avif" alt="Thanjavur District Collector">
      <p>Address: No. 15, Nanjikottai Road, Thanjavur - 613006</p>
      <p>Email: collector.thanjavur@tn.gov.in</p>
      <p>Phone: +91-4362-234567</p>
    </div>

    <div class="contact-details">
      <h2>Thanjavur Municipality</h2>
      <img src="thanjavurmunicipal.jpg" alt="Thanjavur Municipality">
      <p>Address: Municipal Office, South Main Street, Thanjavur - 613001</p>
      <p>Email: thanjavurmunicipality@gmail.com</p>
      <p>Phone: +91-4362-345678</p>
    </div>
    
    <div class="contact-details">
      <h2>Other Officials</h2>
      
      <h3>Superintendent of Police, Thanjavur</h3>
      <img src="thanjavurpolice.jpg" alt="Superintendent of Police">
      <p>Email: sp.thanjavur@tn.gov.in</p>
      <p>Phone: +91-4362-456789</p>
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
    <p>&copy; 2023 Thanjavur District. All rights reserved.</p>
  </footer>
</body>
</html>
