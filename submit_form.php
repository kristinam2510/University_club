<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password (if any)
$dbname = "club_management";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$year = $_POST['year'];
$dob = $_POST['dob'];
$prn = $_POST['prn'];
$course = $_POST['course'];
$club = $_POST['club'];

// Check if PRN already exists using prepared statement
$sql_check_prn = "SELECT * FROM students WHERE prn = ?";
$stmt_check_prn = $conn->prepare($sql_check_prn);
$stmt_check_prn->bind_param("s", $prn);
$stmt_check_prn->execute();
$result = $stmt_check_prn->get_result();

if ($result->num_rows > 0) {
    echo "PRN already exists. Please use a different PRN.";
    exit();
}

// Insert data into the database using prepared statement
$sql = "INSERT INTO students (name, year, dob, prn, course, club)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sissss", $name, $year, $dob, $prn, $course, $club);

if ($stmt->execute()) {
    echo "New record created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
