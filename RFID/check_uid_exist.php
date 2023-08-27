<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "rfid"; 


$uid = $_GET["uid"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT uid FROM rfid_tags WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->execute();
$stmt->store_result();

// Check if UID exists
if ($stmt->num_rows > 0) {
    echo "exist";
} else {
    echo "not_exist";
}

$stmt->close();
$conn->close();
?>
