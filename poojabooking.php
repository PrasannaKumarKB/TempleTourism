<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Process form submission here
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $service = $_POST['service'];
  $specificService = $_POST['specific-service'];
  $date = $_POST['date'];
  $message = $_POST['message'];

  // Perform further validation and processing as needed

  // Example: Saving form data to a database
  $hostname = 'localhost'; // Hostname for the database server
  $username = 'root';      // Username for the database
  $password = '';      // Password for the database (leave empty if no password is set)
  $database = 'temple';  // Name of the database

  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO pooja (name, email, phone, service, specific_service, date, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssss", $name, $email, $phone, $service, $specificService, $date, $message);
  $stmt->execute();
  $bookingId = $stmt->insert_id;

  if ($bookingId > 0) {
    echo "Booking successful! Your booking ID is: " . $bookingId;
    header("Location: paymentoptions.php");
    exit();
  } else {
    echo "Error occurred while processing the booking.";
  }

  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Pooja - Booking</title>
  <style>
    /* CSS styling for the page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f2f2f2;
      background-image: url("poojabackground.avif");
      background-size: cover;
      background-repeat: no-repeat;
    }
    
    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    
    .booking-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .booking-form label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    .booking-form input,
    .booking-form select,
    .booking-form textarea,
    .booking-form button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .booking-form textarea {
      resize: vertical;
      min-height: 100px;
    }
    
    .booking-form button {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .booking-form button:hover {
      background-color: #555;
    }
    
    .footer {
      text-align: center;
      margin-top: 20px;
    }
  </style>
  <script>
    function updateSpecificServiceOptions() {
      var service = document.getElementById('service').value;
      var specificServiceContainer = document.getElementById('specific-service-container');
      specificServiceContainer.innerHTML = '';

      var exchangeRate = 75; // Conversion rate: 1 USD = 75 INR

      if (service === 'pooja') {
        var poojaOptions = [
          { value: 'ganesha_pooja', label: 'Ganesha Pooja', amountUSD: 8 },
          { value: 'lingam_pooja', label: 'Lingam Pooja', amountUSD: 8 },
          { value: 'navagraha_pooja', label: 'Navagraha Pooja', amountUSD: 8 }
          // Add more pooja options as needed
        ];

        var selectPoojaLabel = document.createElement('label');
        selectPoojaLabel.textContent = 'Select Pooja:';

        var selectPooja = document.createElement('select');
        selectPooja.name = 'specific-service';
        selectPooja.required = true;

        for (var i = 0; i < poojaOptions.length; i++) {
          var option = document.createElement('option');
          option.value = poojaOptions[i].value;
          var amountINR = poojaOptions[i].amountUSD * exchangeRate;
          option.textContent = poojaOptions[i].label + ' (₹' + amountINR + ')';
          selectPooja.appendChild(option);
        }

        specificServiceContainer.appendChild(selectPoojaLabel);
        specificServiceContainer.appendChild(selectPooja);
      } else if (service === 'abhishekam') {
        var abhishekamOptions = [
          { value: 'rudra_abhishekam', label: 'Rudra Abhishekam', amountUSD: 15 },
          { value: 'chandan_abhishekam', label: 'Chandan Abhishekam', amountUSD: 15 },
          { value: 'milk_abhishekam', label: 'Milk Abhishekam', amountUSD: 15 },
          { value: 'ghee_abhishekam', label: 'Ghee Abhishekam', amountUSD: 15 },
          { value: 'honey_abhishekam', label: 'Honey Abhishekam', amountUSD: 15 }
          // Add more abhishekam options as needed
        ];

        var selectAbhishekamLabel = document.createElement('label');
        selectAbhishekamLabel.textContent = 'Select Abhishekam:';

        var selectAbhishekam = document.createElement('select');
        selectAbhishekam.name = 'specific-service';
        selectAbhishekam.required = true;

        for (var i = 0; i < abhishekamOptions.length; i++) {
          var option = document.createElement('option');
          option.value = abhishekamOptions[i].value;
          var amountINR = abhishekamOptions[i].amountUSD * exchangeRate;
          option.textContent = abhishekamOptions[i].label + ' (₹' + amountINR + ')';
          selectAbhishekam.appendChild(option);
        }

        specificServiceContainer.appendChild(selectAbhishekamLabel);
        specificServiceContainer.appendChild(selectAbhishekam);
      } else if (service === 'homam') {
        var homamOptions = [
          { value: 'maha_mrityunjaya_homam', label: 'Maha Mrityunjaya Homam', amountUSD: 26 },
          { value: 'sudarshana_homam', label: 'Sudarshana Homam', amountUSD: 26 },
          { value: 'navagraha_homam', label: 'Navagraha Homam', amountUSD: 26 }
          // Add more homam options as needed
        ];

        var selectHomamLabel = document.createElement('label');
        selectHomamLabel.textContent = 'Select Homam:';

        var selectHomam = document.createElement('select');
        selectHomam.name = 'specific-service';
        selectHomam.required = true;

        for (var i = 0; i < homamOptions.length; i++) {
          var option = document.createElement('option');
          option.value = homamOptions[i].value;
          var amountINR = homamOptions[i].amountUSD * exchangeRate;
          option.textContent = homamOptions[i].label + ' (₹' + amountINR + ')';
          selectHomam.appendChild(option);
        }

        specificServiceContainer.appendChild(selectHomamLabel);
        specificServiceContainer.appendChild(selectHomam);
      }
    }
  </script>
</head>
<body>
  <h1>Pooja - Booking</h1>

  <div class="booking-container">
    <form class="booking-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="service">Select Service:</label>
      <select id="service" name="service" required onchange="updateSpecificServiceOptions()">
        <option value="">Choose a service</option>
        <option value="pooja">Pooja</option>
        <option value="abhishekam">Abhishekam</option>
        <option value="homam">Homam</option>
      </select>

      <div id="specific-service-container">
        <!-- Specific service options will be dynamically added here -->
      </div>

      <label for="date">Select Date:</label>
      <input type="date" id="date" name="date" required>

      <label for="message">Message:</label>
      <textarea id="message" name="message" placeholder="Enter any additional information or special requests"></textarea>

      <button type="submit">Book Now</button>
    </form>
  </div>

  <footer class="footer">
    <p>&copy; 2023 Tamilnadu Temple Tourism. All rights reserved.</p>
  </footer>
</body>
</html>
