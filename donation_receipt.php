<?php
require('fpdf.php'); // Include the FPDF library

// Database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'temple';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET['donation_id'])) {
    $donationId = (int)$_GET['donation_id'];

    $stmt = $conn->prepare("SELECT d.name, d.email, d.phone, d.donation_type, d.specific_donation, d.message, t.temple_name, t.temple_id
                            FROM donations d 
                            JOIN temples t ON d.temple_id = t.temple_id 
                            WHERE d.donation_id = ?");
    $stmt->bind_param("i", $donationId);
    $stmt->execute();
    $stmt->bind_result($name, $email, $phone, $donationType, $specificDonation, $message, $templeName, $templeId);
    $stmt->fetch();
    $stmt->close();

    if (!$name) {
        echo "Donation not found.";
        exit();
    }

    if (!$templeId) {
        echo "Temple ID is missing or invalid.";
        exit();
    }

    // Create PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, "Donation Receipt", 0, 1, 'C');

    // Add content to the PDF
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 10, "Temple Name: " . $templeName, 0, 1);
    $pdf->Cell(100, 10, "Name: " . $name, 0, 1);
    $pdf->Cell(100, 10, "Email: " . $email, 0, 1);
    $pdf->Cell(100, 10, "Phone: " . $phone, 0, 1);
    $pdf->Cell(100, 10, "Donation Type: " . $donationType, 0, 1);
    $pdf->Cell(100, 10, "Specific Donation: " . $specificDonation, 0, 1);
    $pdf->Cell(100, 10, "Message: " . $message, 0, 1);

    // Output PDF (force download)
    $pdf->Output('D', 'DonationReceipt.pdf');
    exit();
} else {
    echo "Donation ID not provided.";
    exit();
}

$conn->close();
?>
