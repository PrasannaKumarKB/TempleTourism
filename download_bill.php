<?php
require('fpdf.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "temple");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and get the booking ID
$templeId = isset($_GET['temple_id']) ? intval($_GET['temple_id']) : null;
$bookingId = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : null;

if (!$templeId || !$bookingId) {
    die("Invalid parameters.");
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

// Generate PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Pooja Booking Confirmation', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10);

$pdf->Cell(0, 10, 'Devotee Name: ' . $booking['devotee_name'], 0, 1);
$pdf->Cell(0, 10, 'Temple Name: ' . $booking['temple_name'], 0, 1);
$pdf->Cell(0, 10, 'Pooja Type: ' . $booking['pooja_type'], 0, 1);
$pdf->Cell(0, 10, 'Booking Date: ' . $booking['date'], 0, 1);
$pdf->Cell(0, 10, 'Booking Time: ' . $booking['time'], 0, 1);
$pdf->Cell(0, 10, 'Mobile: ' . $booking['mobile'], 0, 1);
$pdf->Cell(0, 10, 'Rate: ' . $booking['rate'], 0, 1);

// Output PDF as a downloadable file
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="pooja_booking_confirmation.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

$pdf->Output('D', 'pooja_booking_confirmation.pdf');
exit();
?>
