<!DOCTYPE html>
<html>
<head>
    <title>RFID Access History</title>
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

        .custom-button {
    
        }

        .button-container {
            margin-right: 5px;
            margin-left: 5px;
            margin-bottom: 15px;
        }

       
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">RFID Access History</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="./UID List.php" target="_blank">UID List</a>
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
</nav>

<div class="custom-container">
    <div class="row">
        <div class="col-md-6">
            <h2>Search by Date</h2>
            <form method="GET" action="Access History.php">
                <div class="input-group">
                    <input type="date" name="date" class="form-control">
                    <div class="button-container">
                        <button type="submit" name="submit_date" class="btn btn-dark custom-button">Search</button>
                        <button type="submit" name="submit_all" class="btn btn-dark custom-button">Show All</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rfid";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET["submit_date"])) {
        $date = $_GET["date"];
        $sql = "SELECT * FROM rfid_logs WHERE DATE(timestamp) = '$date'";
    } elseif (isset($_GET["submit_uid"])) {
        $uid = $_GET["uid"];
        $sql = "SELECT * FROM rfid_logs WHERE uid = '$uid'";
    } else {
        $sql = "SELECT * FROM rfid_logs";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table id='accessTable' class='table table-dark table-hover'>";
        echo "<thead><tr><th>ID</th><th>UID</th><th>Timestamp</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["uid"] . "</td>";
            echo "<td>" . $row["timestamp"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No access history available";
    }

    $conn->close();
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#accessTable').DataTable();
    });
</script>
</body>
</html>
