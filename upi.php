<?php
// Validate booking_id from URL
$bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : null;

if (!$bookingId) {
    die("Invalid booking ID.");
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'temple');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve temple_id based on booking_id
$templeQuery = $conn->prepare("SELECT temple_id FROM darshan WHERE id = ?");
$templeQuery->bind_param("i", $bookingId);
$templeQuery->execute();
$templeQuery->bind_result($templeId);
$templeQuery->fetch();
$templeQuery->close();

if (!$templeId) {
    die("Temple ID not found for this booking.");
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upiId = $_POST['upi_id'];
    $transactionId = $_POST['transaction_id'];

    // Update UPI details for the booking
    $stmt = $conn->prepare("UPDATE darshan SET upi_id = ?, transaction_id = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $upiId, $transactionId, $bookingId);
        
        // Execute the update and check for success
        if ($stmt->execute()) {
            // Redirect to confirmation page with temple_id
            header("Location: confirmation.php?temple_id=" . urlencode($templeId) . "&booking_id=" . urlencode($bookingId));
            exit;  // Stop further script execution after redirect
        } else {
            echo "Error updating payment details. Please try again.";
        }
        $stmt->close();
    } else {
        echo "Database error. Please try again later.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter UPI Details</title>
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

    <script>
        document.getElementById('upiForm').addEventListener('submit', function (event) {
            let isValid = true;

            // Validate UPI ID
            const upiInput = document.getElementById('upi_id');
            const upiError = document.getElementById('upiError');
            if (!upiInput.value.match(/^[\w.+-]+@[a-zA-Z]+$/)) {
                upiError.textContent = 'Enter a valid UPI ID (e.g., yourname@upi).';
                isValid = false;
            } else {
                upiError.textContent = '';
            }

            // Validate Transaction ID
            const txnInput = document.getElementById('transaction_id');
            const txnError = document.getElementById('txnError');
            if (txnInput.value.trim() === '') {
                txnError.textContent = 'Transaction ID cannot be empty.';
                isValid = false;
            } else {
                txnError.textContent = '';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
