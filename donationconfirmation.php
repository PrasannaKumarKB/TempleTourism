<?php
// Get the temple_id from the URL
$templeId = isset($_GET['temple_id']) ? $_GET['temple_id'] : null;

// Validate if temple_id is set and not empty
if (!$templeId) {
    die("Temple ID is missing or invalid.");
}

$donationId = isset($_GET['donation_id']) ? $_GET['donation_id'] : null;

// Check if donation_id is set and valid
if (!$donationId) {
    die("Donation ID is missing or invalid.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Confirmation</title>
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
        <h2>Donation Successful!</h2>
        <p>Thank you for your generous contribution.</p>
        <!-- Download Receipt Button -->
        <a id="downloadButton" href="donation_receipt.php?temple_id=<?= urlencode($templeId) ?>&donation_id=<?= urlencode($donationId) ?>" onclick="handleDownload()">Download Receipt as PDF</a>
        
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
