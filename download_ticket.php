<?php
require('fpdf.php');

// Get the temple_id and booking_id from the URL
$templeId = isset($_GET['temple_id']) ? (int)$_GET['temple_id'] : null;
$bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : null;

// Check if temple_id and booking_id are provided
if (!$templeId || !$bookingId) {
    die("Required parameters are missing.");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'temple');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch temple name using temple_id
$templeQuery = $conn->prepare("SELECT temple_name FROM temples WHERE temple_id = ?");
$templeQuery->bind_param("i", $templeId);
$templeQuery->execute();
$templeResult = $templeQuery->get_result();
$temple = $templeResult->fetch_assoc();

if (!$temple) {
    die("Temple not found.");
}

// Fetch booking details using booking_id
$bookingQuery = $conn->prepare("SELECT * FROM darshan WHERE id = ?");
$bookingQuery->bind_param("i", $bookingId);
$bookingQuery->execute();
$bookingResult = $bookingQuery->get_result();
$booking = $bookingResult->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}

// Create PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title and Temple details
$pdf->Cell(0, 10, 'Darshan Ticket', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Temple: " . $temple['temple_name'], 0, 1);
$pdf->Cell(0, 10, "Booking ID: " . $booking['id'], 0, 1);
$pdf->Cell(0, 10, "Date: " . $booking['date'], 0, 1);
$pdf->Cell(0, 10, "Time: " . $booking['time'], 0, 1);
$pdf->Cell(0, 10, "Mobile: " . $booking['mobile'], 0, 1);
$pdf->Cell(0, 10, "Rate: " . $booking['rate'], 0, 1);

// Output the PDF to the browser for download
$pdf->Output('D', 'Darshan_Ticket_' . $booking['id'] . '.pdf');

// Close database connections
$templeQuery->close();
$bookingQuery->close();
$conn->close();
?>
