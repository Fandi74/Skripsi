<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rfid";

$uid = $_POST['uid'];
$Pemilik = $_POST['Pemilik'];

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengeksekusi query untuk memasukkan data ke dalam tabel
$sql = "INSERT INTO rfid_tags (uid, Pemilik) VALUES ('$uid', '$Pemilik')";

if ($conn->query($sql) === TRUE) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil memasukkan data UID
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
} else {
    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Error inserting data: ' . $conn->error . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

$conn->close();
?>
