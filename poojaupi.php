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

// Check for parameters in URL
if (isset($_GET['booking_id']) && isset($_GET['temple_id'])) {
    $bookingId = (int)$_GET['booking_id'];
    $templeId = (int)$_GET['temple_id'];

    // Fetch booking details
    $query = "SELECT temple_name, pooja_type, date, time, devotee_name, mobile, rate FROM pooja_bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $stmt->bind_result($templeName, $poojaType, $date, $time, $devoteeName, $mobile, $rate);
        $stmt->fetch();
        $stmt->close();

        if (!$templeName) {
            echo "Invalid booking ID.";
            exit();
        }
    } else {
        echo "Failed to prepare SELECT query.";
        exit();
    }

    // Process the UPI payment form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $upiId = $_POST['upi_id'];
        $upiReference = $_POST['upi_reference'];

        // Update the booking with UPI details
        $stmt = $conn->prepare("UPDATE pooja_bookings SET upi_id = ?, upi_reference = ? WHERE booking_id = ?");
        if ($stmt) {
            $stmt->bind_param("ssi", $upiId, $upiReference, $bookingId);
            $stmt->execute();
            $stmt->close();

            // Redirect to confirmation page after payment update
            header("Location: poojaconfirmation.php?booking_id=$bookingId&temple_id=$templeId");
            exit();
        } else {
            echo "Error occurred while processing the UPI payment.";
            exit();
        }
    }
} else {
    echo "Error: Missing parameters.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
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
    background: url("images.webp");
    background-repeat: no-repeat;
    background-size:cover;
    padding: 20px;
    color: #fff;
}

/* Form Container */
.form-container {
    background: #dacba2;
    padding: 40px;
    border-radius: 20px;
    backdrop-filter: blur(50px);
    box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
    max-width: 450px;
    width: 100%;
}

.form-container h2 {
    margin-bottom: 25px;
    color: black;
    font-size: 2rem;
    font-weight: bold;
}

/* Form Elements */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

label {
    text-align: left;
    font-size: 0.9rem;
    font-weight: bold;
    color: black;
}

input {
    padding: 15px;
    width: 100%;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
    color: black;
    font-size: 1rem;
    transition: 0.3s;
}

input::placeholder {
    color: black;
}

input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.2);
}

/* Button Styling */
button {
    padding: 15px;
    font-size: 1rem;
    font-weight: bold;
    text-transform: uppercase;
    background: linear-gradient(145deg, #e67e22, #f39c12);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4);
}

button:hover {
    transform: scale(1.05);
    box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.5);
}

/* QR Code Section */
.qr-container {
    margin: 20px 0;
}

.qr-container img {
    width: 160px;
    height: 160px;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
}

.qr-container p {
    margin-top: 10px;
    color: black;
    font-size: 0.95rem;
    font-weight: 600;
}

/* Error Message Styling */
.error {
    color: #ff6b6b;
    font-size: 0.85rem;
    text-align: left;
    margin-top: -10px;
    margin-bottom: 10px;
}
    </style>
</head>
<body>
<div class="form-container">
        <h2>Enter UPI Details</h2>
        <div class="qr-container">
            <img src="GooglePay_QR.png" alt="GPay QR Code">
            <p>Scan the QR Code to Pay</p>
        </div>
        <form id="upiForm" method="POST">
            <label for="upi_id">UPI ID:</label>
            <input type="text" id="upi_id" name="upi_id" placeholder="e.g., yourname@upi" required>
            <div id="upiError" class="error"></div>

            <label for="transaction_id">Transaction ID:</label>
            <input type="text" id="transaction_id" name="transaction_id" placeholder="e.g., TXN12345" required>
            <div id="txnError" class="error"></div>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
