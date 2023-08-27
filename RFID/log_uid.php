<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "rfid"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menerima UID dari parameter GET
$uid = $_GET["uid"];

$sql = "INSERT INTO rfid_logs (uid, timestamp) VALUES ('$uid', NOW())";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
