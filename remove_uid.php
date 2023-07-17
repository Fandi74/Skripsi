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

// Mengeksekusi query untuk mengecek keberadaan data sebelum menghapus
$checkQuery = "SELECT * FROM rfid_tags WHERE uid = '$uid' AND Pemilik = '$Pemilik'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    // Data ditemukan, jalankan query DELETE
    $deleteQuery = "DELETE FROM rfid_tags WHERE uid = '$uid' AND Pemilik = '$Pemilik'";

    if ($conn->query($deleteQuery) === TRUE) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Berhasil menghapus data UID
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Error deleting data: ' . $conn->error . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
} else {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Data tidak ditemukan. Tidak ada data yang dihapus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

$conn->close();
?>
