<?php
// Get the temple_id and booking_id from the URL
$templeId = isset($_GET['temple_id']) ? $_GET['temple_id'] : null;
$bookingId = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

// Validate if temple_id and booking_id are set and not empty
if (!$templeId || !$bookingId) {
    die("Temple ID or Booking ID is missing or invalid.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "temple");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booking details
$query = "
    SELECT temple_name, pooja_type, date, time, devotee_name, mobile, rate 
    FROM pooja_bookings
    WHERE booking_id = ? AND temple_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $bookingId, $templeId);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Check if booking exists
if (!$booking) {
    die("No booking found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pooja Booking Confirmation</title>
    <style>
        /* Universal Reset */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body Styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url("image4.webp");
            padding: 20px;
            color: #fff;
        }

        /* Card Container */
        .confirmation-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .confirmation-container h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .confirmation-container p {
            font-size: 1rem;
            margin-bottom: 30px;
            color: #dcdcdc;
            line-height: 1.5;
        }

        /* Link Styling */
        .confirmation-container a,
        .confirmation-container button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, #e67e22, #f39c12);
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4);
            border: none;
            cursor: pointer;
        }

        .confirmation-container a:hover,
        .confirmation-container button:hover {
            transform: scale(1.05);
            box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.5);
        }

        /* Notification Message */
        .notification {
            margin-top: 20px;
            padding: 15px 20px;
            background: #27ae60;
            color: #fff;
            font-size: 0.9rem;
            border-radius: 8px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
            display: none; /* Hidden by default */
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h2>Pooja Booking Successful!</h2>
        <p>Thank you for booking the pooja service.</p>
        
    
        
        <!-- Download Receipt Button -->
        <a id="downloadButton" href="download_bill.php?temple_id=<?= urlencode($templeId) ?>&booking_id=<?= urlencode($bookingId) ?>" onclick="handleDownload()">Download Receipt as PDF</a>
        
        <!-- Go to Home Page Button (hidden initially) -->
        <button id="homeButton" style="display: none;" onclick="goToHome()">Go to Home Page</button>

        <!-- Notification -->
        <div id="notification" class="notification">
            Receipt downloaded successfully! You can now return to the home page.
        </div>
    </div>

    <script>
        // Handle Download
        function handleDownload() {
            // Simulate a delay for the download to complete
            setTimeout(() => {
                // Show notification
                const notification = document.getElementById('notification');
                notification.style.display = 'block';

                // Hide the download button and show the home button
                document.getElementById('downloadButton').style.display = 'none';
                document.getElementById('homeButton').style.display = 'inline-block';
            }, 1000); // Adjust delay as needed
        }

        // Redirect to Home Page
        function goToHome() {
            window.location.href = 'home.html';
        }
    </script>
</body>
</html>
