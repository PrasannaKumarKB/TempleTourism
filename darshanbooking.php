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

    // Fetch temple name from database
    $query = "SELECT temple_name FROM temples WHERE temple_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $templeId);
        $stmt->execute();
        $stmt->bind_result($templeName);
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

    // Process the booking form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $numTickets = (int)$_POST['tickets'];
        $mobile = $_POST['mobile'];
        $rate = (int)$_POST['rate'];

        // Member details
        $memberDetails = [];
        for ($i = 0; $i < $numTickets; $i++) {
            $memberName = $_POST['member-name-' . $i];
            $memberAge = (int)$_POST['member-age-' . $i];
            $memberDetails[] = array($memberName, $memberAge);
        }

        // Insert booking details
        $stmt = $conn->prepare("INSERT INTO darshan (date, time, num_tickets, mobile, rate, temple_id) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssisdi", $date, $time, $numTickets, $mobile, $rate, $templeId);
            $stmt->execute();
            $bookingId = $stmt->insert_id;
            $stmt->close();
        } else {
            echo "Error occurred while preparing booking statement.";
            exit();
        }

        // Insert member details into the members table
        $memberStmt = $conn->prepare("INSERT INTO members (booking_id, name, age) VALUES (?, ?, ?)");
        if ($memberStmt) {
            foreach ($memberDetails as $member) {
                $memberStmt->bind_param("isi", $bookingId, $member[0], $member[1]);
                $memberStmt->execute();
            }
            $memberStmt->close();
        } else {
            echo "Error occurred while preparing member statement.";
            exit();
        }

        // Redirect to UPI payment page with booking details if successful
        if ($bookingId > 0) {
            $queryParams = http_build_query([
                'booking_id' => $bookingId,
                'temple_id' => $templeId,
                'temple_name' => $templeName
            ]);
            header("Location: upi.php?$queryParams");
            exit();
        } else {
            echo "Error occurred while processing the booking.";
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
    <title>Advanced Darshan Booking Form</title>
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
            background:url("image2.webp");
            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px;
        }

        /* Form Container */
        .form-container {
            width: 90%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .form-container h2 {
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
        form select {
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
        form select:focus {
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
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
            color: white;
            border: none;
            border-radius: 15px;
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
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            form button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
    <h2>Darshan Booking for <?php echo htmlspecialchars($templeName); ?></h2>
        <form class="booking-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <input type="hidden" name="temple_id" value="<?php echo $templeId; ?>">
            <div>
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <!-- Time -->
            <div>
                <label for="time">Select Time:</label>
                <select id="time" name="time" required>
                    <option value="" disabled selected>Choose time slot</option>
                    <option value="09:00">9:00 AM - 10:00 AM</option>
                    <option value="10:00">10:00 AM - 11:00 AM</option>
                    <option value="11:00">11:00 AM - 12:00 PM</option>
                    <option value="14:00">2:00 PM - 3:00 PM</option>
                    <option value="15:00">3:00 PM - 4:00 PM</option>
                    <option value="16:00">4:00 PM - 5:00 PM</option>
                </select>
            </div>

            <!-- Tickets -->
            <div>
                <label for="tickets">Number of Tickets:</label>
                <input type="number" id="tickets" name="tickets" min="1" required onchange="generateMemberFields()">
            </div>

            <!-- Dynamic Member Fields -->
            <div id="dynamic-fields" class="dynamic-fields"></div>

            <!-- Mobile -->
            <div>
                <label for="mobile">Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
            </div>

            <!-- Rate -->
            <div>
                <label for="rate">Select Rate:</label>
                <select id="rate" name="rate" required>
                    <option value="" disabled selected>Choose rate</option>
                    <option value="50">50 Rupees</option>
                    <option value="100">100 Rupees</option>
                    <option value="300">300 Rupees</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit">Book Now</button>
        </form>
    </div>

    <script>
        function generateMemberFields() {
            const numTickets = document.getElementById('tickets').value;
            const container = document.getElementById('dynamic-fields');
            container.innerHTML = '';
            for (let i = 0; i < numTickets; i++) {
                const memberDiv = document.createElement('div');
                memberDiv.innerHTML = `
                    <label for="member-name-${i}">Member ${i + 1} Name:</label>
                    <input type="text" id="member-name-${i}" name="member-name-${i}" placeholder="Enter name" required>
                    <label for="member-age-${i}">Member ${i + 1} Age:</label>
                    <input type="number" id="member-age-${i}" name="member-age-${i}" min="1" placeholder="Enter age" required>
                `;
                container.appendChild(memberDiv);
            }
        }
    </script>
</body>
</html>
