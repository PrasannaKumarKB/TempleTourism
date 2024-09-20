<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Process form submission here
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $donationType = $_POST['donation-type'];
  $specificDonation = $_POST['specific-donation'];
  $message = $_POST['message'];

  // Perform further validation and processing as needed

  // Example: Saving form data to a database
  
  $hostname = 'localhost'; // Hostname for the database server
  $username = 'root';      // Username for the database
  $password = '';          // Password for the database (leave empty if no password is set)
  $database = 'temple';    // Name of the database

  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO donations (name, email, phone, donation_type, specific_donation, message) VALUES ('$name', '$email', '$phone', '$donationType', '$specificDonation', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "Donation successful!";
    header("Location: paymentoptions.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title> Temple - Donation</title>
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
    
    .donation-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .donation-form label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    .donation-form input,
    .donation-form select,
    .donation-form textarea,
    .donation-form button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .donation-form textarea {
      resize: vertical;
      min-height: 100px;
    }
    
    .donation-form button {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .donation-form button:hover {
      background-color: #555;
    }
    
    .footer {
      text-align: center;
      margin-top: 20px;
    }
  </style>
  <script>
    function updateSpecificDonationOptions() {
      var donationType = document.getElementById('donation-type').value;
      var specificDonationContainer = document.getElementById('specific-donation-container');
      specificDonationContainer.innerHTML = '';

      if (donationType === 'monetary') {
        var monetaryOptions = [
          { value: 'general_donation', label: 'General Donation' },
          { value: 'sponsorship', label: 'Sponsorship' },
          { value: 'annual_membership', label: 'Annual Membership' }
          // Add more monetary donation options as needed
        ];

        var selectMonetaryLabel = document.createElement('label');
        selectMonetaryLabel.textContent = 'Select Monetary Donation:';

        var selectMonetaryDonation = document.createElement('select');
        selectMonetaryDonation.name = 'specific-donation';
        selectMonetaryDonation.required = true;

        for (var i = 0; i < monetaryOptions.length; i++) {
          var option = document.createElement('option');
          option.value = monetaryOptions[i].value;
          option.textContent = monetaryOptions[i].label;
          selectMonetaryDonation.appendChild(option);
        }

        specificDonationContainer.appendChild(selectMonetaryLabel);
        specificDonationContainer.appendChild(selectMonetaryDonation);
      } else if (donationType === 'material') {
        var materialOptions = [
          { value: 'flower_donation', label: 'Flower Donation' },
          { value: 'prasad_donation', label: 'Prasad Donation' },
          { value: 'cloth_donation', label: 'Cloth Donation' }
          // Add more material donation options as needed
        ];

        var selectMaterialLabel = document.createElement('label');
        selectMaterialLabel.textContent = 'Select Material Donation:';

        var selectMaterialDonation = document.createElement('select');
        selectMaterialDonation.name = 'specific-donation';
        selectMaterialDonation.required = true;

        for (var i = 0; i < materialOptions.length; i++) {
          var option = document.createElement('option');
          option.value = materialOptions[i].value;
          option.textContent = materialOptions[i].label;
          selectMaterialDonation.appendChild(option);
        }

        specificDonationContainer.appendChild(selectMaterialLabel);
        specificDonationContainer.appendChild(selectMaterialDonation);
      }
    }
  </script>
</head>
<body>
  <h1> Temple - Donation</h1>

  <div class="donation-container">
    <form class="donation-form" method="POST" action="process_donation.php">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="donation-type">Donation Type:</label>
      <select id="donation-type" name="donation-type" required onchange="updateSpecificDonationOptions()">
        <option value="">Choose a donation type</option>
        <option value="monetary">Monetary</option>
        <option value="material">Material</option>
      </select>

      <div id="specific-donation-container">
        <!-- Specific donation options will be dynamically added here -->
      </div>

      <label for="message">Message:</label>
      <textarea id="message" name="message" placeholder="Enter any additional information or special requests"></textarea>

      <button type="submit">Donate Now</button>
    </form>
  </div>

  <footer class="footer">
    <p>&copy; 2023 Sivan Temple. All rights reserved.</p>
  </footer>
</body>
</html>