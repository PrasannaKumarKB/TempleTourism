<?php
// Database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'temple';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check for temple_id in URL or POST data
if (isset($_GET['temple_id']) || isset($_POST['temple_id'])) {
    $templeId = isset($_POST['temple_id']) ? (int)$_POST['temple_id'] : (int)$_GET['temple_id'];

    // Fetch temple name
    $stmt = $conn->prepare("SELECT temple_name FROM temples WHERE temple_id = ?");
    $stmt->bind_param("i", $templeId);
    $stmt->execute();
    $stmt->bind_result($templeName);
    $stmt->fetch();
    $stmt->close();

    if (!$templeName) {
        echo "Invalid temple ID.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $donationType = $_POST['donation-type'];
        $specificDonation = $_POST['specific-donation'] ?? null;
        $message = $_POST['message'];

        $stmt = $conn->prepare("INSERT INTO donations (temple_id, name, email, phone, donation_type, specific_donation, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $templeId, $name, $email, $phone, $donationType, $specificDonation, $message);
        $stmt->execute();
        $donationId = $stmt->insert_id;
        $stmt->close();

        if ($donationId > 0) {
          header("Location: donationupi.php?donation_id=$donationId&temple_id=$templeId");
          exit();
      } else {
            echo "Error occurred while processing the donation.";
        }
    }
} else {
    echo "Temple ID not provided.";
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <style>
        /* Universal Reset */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        /* Body Styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url("image2.webp");
            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px;
        }

        /* Form Container */
        .donation-container {
            width: 90%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .donation-container h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Form Styling */
        form {
            display: grid;
            gap: 20px;
        }

        form label {
            font-size: 1rem;
            font-weight: bold;
            text-align: left;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 12px;
            background: #f5f5f5;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
            box-shadow: inset 0px 3px 8px rgba(0, 0, 0, 0.1);
        }

        form input:focus,
        form select:focus,
        form textarea:focus {
            outline: none;
            background: #fff;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        form button {
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            background: linear-gradient(135deg, #4CAF50, #81C784);
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0px 5px 15px rgba(76, 175, 80, 0.5);
        }

        form button:hover {
            transform: translateY(-2px);
            box-shadow: 0px 8px 20px rgba(76, 175, 80, 0.6);
        }

        /* Specific Donation Options */
        #specific-donation-container {
            display: none;
        }

        #specific-donation-container.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="donation-container">
        <h2>Donation for <?php echo htmlspecialchars($templeName); ?></h2>
        <form class="donation-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="temple_id" value="<?php echo $templeId; ?>">
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

            <div id="specific-donation-container"></div>

            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Enter any additional information or special requests"></textarea>

            <button type="submit">Donate Now</button>
        </form>
    </div>

    <script>
        function updateSpecificDonationOptions() {
            const donationType = document.getElementById('donation-type').value;
            const container = document.getElementById('specific-donation-container');

            container.classList.remove('active');
            container.innerHTML = '';

            if (donationType === 'monetary') {
                container.innerHTML = `
                    <label for="specific-donation">Enter Donation Amount:</label>
                    <input type="number" id="specific-donation" name="specific-donation" min="1" placeholder="Enter amount" required>
                `;
            } else if (donationType === 'material') {
                container.innerHTML = `
                    <label for="specific-donation">Enter Material Details:</label>
                    <textarea id="specific-donation" name="specific-donation" placeholder="Specify material details" required></textarea>
                `;
            }

            container.classList.add('active');
        }
    </script>
</body>
</html>
