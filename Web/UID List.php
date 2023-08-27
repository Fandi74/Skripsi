<!DOCTYPE html>
<html>
<head>
    <title>RFID Database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        .custom-container {
            margin: 0 auto;
            max-width: 100%;
            padding: 0 15px;
            margin-top: 14px;
        }
        
        .custom-table {
            width: 100%;
            margin: 0 auto;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">LIST RFID TAGS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
          
            <li class="nav-item">
                <a class="nav-link" href="./Access History.php" target="_blank">Access History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Dataset Wajah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Training Dataset</a>
            </li>
            
        </ul>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="./Index.php">Home</a>
        </li>
    </ul>
    </div>
</nav>

<div class="custom-container">
    <table id="rfidTable" class="table table-dark table-hover custom-table">
        <thead>
        <tr>
            <th>No.</th>
            <th>UID</th>
            <th>Pemilik</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Mengambil data dari database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "rfid";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM rfid_tags";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $row["uid"] . "</td>";
                echo "<td>" . $row["Pemilik"] . "</td>";
                echo "</tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='3'>No data available</td></tr>";
        }

        mysqli_close($conn);
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#rfidTable').DataTable();
    });
</script>

</body>
</html>
