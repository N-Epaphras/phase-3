<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_monitoring";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data exists and prevent issues if fields are missing
if (isset($_POST['cropId'], $_POST['fertilizerType'], $_POST['wateringSchedule'], $_POST['pesticide'])) {
    // Sanitize and assign form data to variables
    $cropId = $_POST['cropId'];
    $fertilizerType = $_POST['fertilizerType'];
    $wateringSchedule = $_POST['wateringSchedule'];
    $pesticide = $_POST['pesticide'];

    // Validate cropId existence in crops table
    $checkCrop = $conn->prepare("SELECT id FROM crops WHERE id = ?");
    $checkCrop->bind_param("i", $cropId);
    $checkCrop->execute();
    $result = $checkCrop->get_result();

    if ($result->num_rows === 0) {
        echo "Error: The provided Crop ID does not exist in the crops table. Please check and try again.";
    } else {
        // Prepare the SQL statement to insert data
        $stmt = $conn->prepare("INSERT INTO enhancements (crop_id, fertilizer_type, watering_schedule, pesticide) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters and execute
        $stmt->bind_param("isss", $cropId, $fertilizerType, $wateringSchedule, $pesticide);

        if ($stmt->execute()) {
            echo "<h2>Enhancement Added Successfully</h2>";
            echo "<p>Details of the entry:</p>";
            echo "<ul>";
            echo "<li><strong>Crop ID:</strong> " . htmlspecialchars($cropId) . "</li>";
            echo "<li><strong>Fertilizer Type:</strong> " . htmlspecialchars($fertilizerType) . "</li>";
            echo "<li><strong>Watering Schedule:</strong> " . htmlspecialchars($wateringSchedule) . "</li>";
            echo "<li><strong>Pesticide Used:</strong> " . htmlspecialchars($pesticide) . "</li>";
            echo "</ul>";
            echo "<a href='main page.html'>Return to main page</a>";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the crop validation statement
    $checkCrop->close();
} else {
    echo "Form data is incomplete. Please fill out all fields and try again.";
}

// Close the database connection
$conn->close();
?>
