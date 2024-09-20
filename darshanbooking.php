<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form submission here
    $date = $_POST['date'];
    $time = $_POST['time'];
    $numTickets = (int)$_POST['tickets'];
    $mobile = $_POST['mobile'];
    $rate = (int)$_POST['rate'];

    $memberDetails = [];
    for ($i = 0; $i < $numTickets; $i++) {
        $memberName = $_POST['member-name-' . $i];
        $memberAge = (int)$_POST['member-age-' . $i];
        $memberDetails[] = array($memberName, $memberAge);
    }

    // Example: Saving form data to a database
    $hostname = 'localhost'; // Hostname for the database server
    $username = 'root';      // Username for the database
    $password = '';          // Password for the database (leave empty if no password is set)
    $database = 'temple';    // Name of the database

    $conn = new mysqli($hostname, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert main ticket booking details into 'darshan' table
    $stmt = $conn->prepare("INSERT INTO darshan (date, time, num_tickets, mobile, rate) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $date, $time, $numTickets, $mobile, $rate);
    $stmt->execute();
    $bookingId = $stmt->insert_id;

    // Insert member details into 'members' table
    $memberStmt = $conn->prepare("INSERT INTO members (booking_id, name, age) VALUES (?, ?, ?)");
    foreach ($memberDetails as $member) {
        $memberStmt->bind_param("isi", $bookingId, $member[0], $member[1]);
        $memberStmt->execute();
    }

    if ($bookingId > 0) {
        echo "Booking successful! Your booking ID is: " . $bookingId;
        header("Location: paymentoptions.php");
        exit();
    } else {
        echo "Error occurred while processing the booking.";
    }

    $stmt->close();
    $memberStmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Darshan Ticket Booking</title>
    <style>
        /* CSS styling for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
            background-image: url("darshanbackground.avif");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .booking-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .booking-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .booking-form input,
        .booking-form select,
        .booking-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .booking-form button {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .booking-form button:hover {
            background-color: #555;
        }

        .member-fields {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        // JavaScript function to dynamically generate member fields
        function generateMemberFields() {
            var numTickets = parseInt(document.getElementById('tickets').value);
            var memberFieldsContainer = document.getElementById('member-fields-container');
            memberFieldsContainer.innerHTML = ''; // Clear existing fields

            for (var i = 0; i < numTickets; i++) {
                var memberFields = document.createElement('div');
                memberFields.className = 'member-fields';

                var nameLabel = document.createElement('label');
                nameLabel.textContent = 'Member ' + (i + 1) + ' Name';
                memberFields.appendChild(nameLabel);

                var nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.name = 'member-name-' + i;
                nameInput.required = true;
                memberFields.appendChild(nameInput);

                var ageLabel = document.createElement('label');
                ageLabel.textContent = 'Member ' + (i + 1) + ' Age';
                memberFields.appendChild(ageLabel);

                var ageInput = document.createElement('input');
                ageInput.type = 'number';
                ageInput.name = 'member-age-' + i;
                ageInput.required = true;
                memberFields.appendChild(ageInput);

                memberFieldsContainer.appendChild(memberFields);
            }
        }
    </script>
</head>
<body>
    <h1>Darshan Ticket Booking</h1>
    <div class="booking-container">
        <form class="booking-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Select Time:</label>
            <select id="time" name="time" required>
                <option value="">Choose time slot</option>
                <option value="09:00">9:00 AM - 10:00 AM</option>
                <option value="10:00">10:00 AM - 11:00 AM</option>
                <option value="11:00">11:00 AM - 12:00 PM</option>
                <option value="14:00">2:00 PM - 3:00 PM</option>
                <option value="15:00">3:00 PM - 4:00 PM</option>
                <option value="16:00">4:00 PM - 5:00 PM</option>
            </select>

            <label for="tickets">Number of Tickets:</label>
            <input type="number" id="tickets" name="tickets" min="1" required onchange="generateMemberFields()">

            <div id="member-fields-container"></div>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required>

            <label for="rate">Select Rate:</label>
            <select id="rate" name="rate" required>
                <option value="">Choose rate</option>
                <option value="50">50 Rupees</option>
                <option value="100">100 Rupees</option>
                <option value="300">300 Rupees</option>
            </select>

            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
