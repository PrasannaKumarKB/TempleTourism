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

    // Fetch temple name and type from the database
    $query = "SELECT temple_name, temple_type FROM temples WHERE temple_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $templeId);
        $stmt->execute();
        $stmt->bind_result($templeName, $templeType);
        $stmt->fetch();
        $stmt->close();

        if (!$templeName) {
            echo "Invalid temple ID.";
            exit();
        }
    } else {
        echo "Failed to prepare SELECT query.";
        exit();
    }

    // Define pooja types based on temple type
    // Define pooja types based on temple type
$poojaTypes = [];
switch (strtolower($templeType)) {
    case 'shiva':
        $poojaTypes = ['Rudrabhishekam', 'Maha Mrityunjaya Homam', 'Pradosham Pooja'];
        break;
    case 'vishnu':
        $poojaTypes = ['Sahasranama Archana', 'Vishnu Sahasranamam', 'Thiruppavai Chanting'];
        break;
    case 'durga':
        $poojaTypes = ['Chandi Homam', 'Kumari Pooja', 'Navratri Special Pooja'];
        break;
    case 'murugan':
        $poojaTypes = ['Kavadi Pooja', 'Shasti Pooja', 'Paal Abhishekam'];
        break;
    case 'vinayagar':
        $poojaTypes = ['Ganapathi Homam', 'Sankatahara Chaturthi Pooja', 'Modak Offering'];
        break;
    case 'pandi':
        $poojaTypes = ['Muneeswarar Abhishekam', 'Special Pongal Pooja', 'Pandi Guru Pooja'];
        break;
    case 'narashimhar':
        $poojaTypes = ['Narasimha Homam', 'Lakshmi Narasimha Archana', 'Prahlada Stuti Chanting'];
        break;
    default:
        $poojaTypes = ['Special Pooja', 'General Archana'];
}


    // Process the booking form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $poojaType = $_POST['pooja_type'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $devoteeName = $_POST['devotee_name'];
        $mobile = $_POST['mobile'];
        $rate = (int)$_POST['rate'];

        // Insert booking details into the database
        $stmt = $conn->prepare("INSERT INTO pooja_bookings (temple_id, temple_name, pooja_type, date, time, devotee_name, mobile, rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issssssi", $templeId, $templeName, $poojaType, $date, $time, $devoteeName, $mobile, $rate);
            $stmt->execute();
            $bookingId = $stmt->insert_id;
            $stmt->close();

            // Redirect to the confirmation page with booking details if successful
            if ($bookingId > 0) {
                $queryParams = http_build_query([
                    'booking_id' => $bookingId,
                    'temple_id' => $templeId,
                    'temple_name' => $templeName
                ]);
                header("Location: poojaupi.php?$queryParams");
                exit();
            } else {
                echo "Error occurred while processing the booking.";
            }
        } else {
            echo "Error occurred while preparing booking statement.";
            exit();
        }
    }
} else {
    echo "Error: Temple ID not provided.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pooja Booking</title>
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
        min-height: 100vh;
        background: url("periyakovil3.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        padding: 20px;
    }

    /* Form Container */
    .form-container {
        width: 100%;
        max-width: 600px;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .form-container h2 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #444;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    /* Form Styling */
    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    form label {
        font-size: 1rem;
        font-weight: bold;
        text-align: left;
        margin-bottom: 5px;
        color: #555;
    }

    form input,
    form select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        font-size: 1rem;
        color: #333;
        transition: all 0.3s ease;
    }

    form input:focus,
    form select:focus {
        outline: none;
        border-color: #fcb69f;
        box-shadow: 0px 4px 15px rgba(252, 182, 159, 0.5);
    }

    form button {
        padding: 12px;
        font-size: 1rem;
        font-weight: bold;
        text-transform: uppercase;
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0px 5px 15px rgba(255, 120, 145, 0.5);
    }

    form button:hover {
        transform: translateY(-2px);
        box-shadow: 0px 8px 20px rgba(255, 120, 145, 0.6);
    }

    /* Dynamic Fields Container */
    .dynamic-fields {
        display: grid;
        gap: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        form button {
            font-size: 0.9rem;
        }
    }

    </style>
</head>
<body>
    <div class="form-container">
        <h2>Pooja Booking</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="temple_id" value="<?php echo $templeId; ?>">

            <label for="pooja_type">Pooja Type</label>
            <select id="pooja_type" name="pooja_type" required>
                <option value="" disabled selected>Select Pooja</option>
                <?php foreach ($poojaTypes as $pooja): ?>
                    <option value="<?php echo $pooja; ?>"><?php echo $pooja; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time</label>
            <select id="time" name="time" required>
                <option value="" disabled selected>Select Time</option>
                <option value="06:00">6:00 AM</option>
                <option value="08:00">8:00 AM</option>
                <option value="10:00">10:00 AM</option>
                <option value="16:00">4:00 PM</option>
            </select>

            <label for="devotee_name">Devotee Name</label>
            <input type="text" id="devotee_name" name="devotee_name" placeholder="Enter your name" required>

            <label for="mobile">Mobile Number</label>
            <input type="text" id="mobile" name="mobile" placeholder="Enter mobile number" required>

            <label for="rate">Rate</label>
            <select id="rate" name="rate" required>
                <option value="" disabled selected>Select Rate</option>
                <option value="500">₹500</option>
                <option value="1000">₹1000</option>
                <option value="1500">₹1500</option>
            </select>

            <button type="submit">Book Pooja</button>
        </form>
    </div>
</body>
</html>
