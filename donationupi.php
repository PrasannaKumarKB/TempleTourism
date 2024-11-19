<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'temple';

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and fetch the donation_id from the URL
$donationId = isset($_GET['donation_id']) ? (int)$_GET['donation_id'] : null;

if (!$donationId) {
    die("Invalid donation ID.");
}

// Fetch the temple_id for the given donation_id
$templeQuery = $conn->prepare("SELECT temple_id FROM donations WHERE donation_id = ?");
$templeQuery->bind_param("i", $donationId);
$templeQuery->execute();
$templeQuery->bind_result($templeId);
$templeQuery->fetch();
$templeQuery->close();

if (!$templeId) {
    die("Temple ID not found for this donation.");
}

// If form is submitted, process the UPI ID and Transaction ID
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upiId = isset($_POST['upi_id']) ? trim($_POST['upi_id']) : null;
    $transactionId = isset($_POST['transaction_id']) ? trim($_POST['transaction_id']) : null;

    // Validate inputs
    if (!$upiId || !$transactionId) {
        die("Both UPI ID and Transaction ID are required.");
    }

    // Update the UPI and Transaction ID in the donations table
    $updateQuery = $conn->prepare("UPDATE donations SET upi_id = ?, transaction_id = ? WHERE donation_id = ?");
    $updateQuery->bind_param("ssi", $upiId, $transactionId, $donationId);

    if ($updateQuery->execute()) {
        // Redirect to donationconfirmation.php with donation_id and temple_id
        header("Location: donationconfirmation.php?donation_id=$donationId&temple_id=$templeId");
        exit; // Ensure no further code is executed
    } else {
        echo "Error updating details: " . $conn->error;
    }

    $updateQuery->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation UPI</title>
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
