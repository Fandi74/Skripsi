<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/Skripsi/1. Login Form/Login.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: http://localhost/Skripsi/1. Login Form/Login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Security Control Website</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .logout-box {
      display: inline-block;
      padding: 1px 10px;
      border: 1px;
      border-radius: 5px;
    }
    .logout-box:hover{
      background-color:red;
    }

    .camera-container {
      display: flex;
      justify-content: space-around;
      margin: 15px;

    }

    .camera-box {
      border: 5px solid #ccc;
      width: 480px;
      height: 320px;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-end;
    }

    .camera-text {
      position: absolute;
      top: 1px;
      right: 1px;
      font-size: 18px;
      color: rgba(0, 0, 0, 0.5);
      background-color: rgba(255, 255, 255, 0.5);
      padding: 2px;
    }

    .camera-buttons {
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }

    .camera-buttons .btn {
      margin: 0 5px;
    }

    .section-heading {
      position: relative;
      margin-bottom: 20px;
    }

    .section-heading::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(255, 255, 255, 0.3);
      z-index: -1;
    }

    .section-heading h3 {
      background-color: #000;
      color: #fff;
      display: inline-block;
      padding: 10px 20px;
      border-radius: 4px;
      margin: 0;
    }
    
    .custom-box {
      margin-top: 15px;
      display: flex;
      justify-content: space-around;
  
    }
    
    .custom-box .card {
      width: 40%;
    }
    
    .custom-title {
      color: #000;
      text-align: center;
      margin-bottom: 5px;
    }

    .custom-button {
      width: 50%;
      justify-content: center;
    }

    .custom-button:hover{
    	background-color: #000000;
    }
    .out-of-service {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 16px;
      color: red;
      display: none;
    }
    .loading-gif {
      width: 32px;
      height: 32px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Security Control Website</a>
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
          <a class="nav-link" href="./Access History.php" target="_blank">Access History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://192.168.0.112/Program (Do Not Delete)/index.php" target="_blank">Dataset Wajah</a>
        </li>
        
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link">
            <form action="" method="POST">
  			<button type="submit" name="logout" class="logout-box">Logout (<?php echo $username; ?>)</button>
			</form>
          </a>
        </li>
      </ul>
    </div>
  </nav>
    <h3>CCTV</h3>
  </div>
  <div class="camera-container">
    <div class="camera-box" style="margin-right: 145px;">
      <div class="cctv-container">
        <img src="loading.gif" class="loading-gif" id="loadingGif1">
        <div class="out-of-service" id="outOfServiceText1">Out of Service</div>
        <img src="" class="cctv-stream" id="cctvStream1">
      </div>
      <div class="camera-text">CCTV 1</div>
      <div class="camera-buttons">
        <button type="button" class="btn btn-light" disabled>Ruangan 1</button>

      </div>
    </div>
    <div class="camera-box">
      <div class="cctv-container">
        <img src="loading.gif" class="loading-gif" id="loadingGif2">
        <div class="out-of-service" id="outOfServiceText2">Out of Service</div>
        <img src="" class="cctv-stream" id="cctvStream2">
      </div>
      <div class="camera-text">CCTV 2</div>
      <div class="camera-buttons">
        <button type="button" class="btn btn-light" disabled>Ruangan 2</button>

      </div>
    </div>
    <div class="camera-box" style="margin-left: 145px;">
      <div class="cctv-container">
        <img src="loading.gif" class="loading-gif" id="loadingGif3">
        <div class="out-of-service" id="outOfServiceText3">Out of Service</div>
        <img src="" class="cctv-stream" id="cctvStream3">
      </div>
      <div class="camera-text">CCTV 3</div>
      <div class="camera-buttons">
        <button type="button" class="btn btn-light" disabled>Ruangan 3</button>

      </div>
    </div>
  </div>
    <h3>RFID SMART CONTROL</h3>
  </div>
  
  <div class="custom-box">
    <div class="card">
      <div class="card-header">
        <h3 class="custom-title">RFID TAG INPUT</h3>
      </div>
      <div class="card-body">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])) {
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

          
          $checkQuery = "SELECT * FROM rfid_tags WHERE uid = '$uid' AND Pemilik = '$Pemilik'";
          $checkResult = $conn->query($checkQuery);

          if ($checkResult->num_rows > 0) {
          
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              Data sudah ada. Tidak dapat memasukkan data UID yang sama.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>';
          } else {
           
            $sql = "INSERT INTO rfid_tags (uid, Pemilik) VALUES ('$uid', '$Pemilik')";

            if ($conn->query($sql) === TRUE) {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Berhasil memasukkan data UID
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>';
            } else {
              echo '<div class="alert alert-danger" role="alert">
                      Error inserting data: ' . $conn->error . '
                    </div>';
            }
          }

          $conn->close();
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="form-group">
            <div class="form-outline mb-4">
              <input type="text" name="uid" class="form-control form-control-lg" required />
              <label class="form-label">UID</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-outline mb-4">
              <input type="text" name="Pemilik" class="form-control form-control-lg" required />
              <label class="form-label">Pemilik</label>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" name="insert" class="btn btn-dark custom-button">INSERT</button>
          </div>
        </form>
        
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="custom-title">RFID TAG REMOVE</h3>
      </div>
      <div class="card-body">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
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

          
          $checkQuery = "SELECT * FROM rfid_tags WHERE uid = '$uid' AND Pemilik = '$Pemilik'";
          $checkResult = $conn->query($checkQuery);

          if ($checkResult->num_rows > 0) {
            
            $deleteQuery = "DELETE FROM rfid_tags WHERE uid = '$uid' AND Pemilik = '$Pemilik'";

            if ($conn->query($deleteQuery) === TRUE) {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Berhasil menghapus data UID
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
            } else {
              echo '<div class="alert alert-danger" role="alert">
                      Error deleting data: ' . $conn->error . '
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
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="form-group">
            <div class="form-outline mb-4">
              <input type="text" name="uid" class="form-control form-control-lg" required />
              <label class="form-label">UID</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-outline mb-4">
              <input type="text" name="Pemilik" class="form-control form-control-lg" required />
              <label class="form-label">Pemilik</label>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" name="remove" class="btn btn-dark custom-button">REMOVE</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function showCCTV(cctvStreamId, loadingGifId, outOfServiceTextId, ipAddress) {
      var loadingGif = document.getElementById(loadingGifId);
      var outOfServiceText = document.getElementById(outOfServiceTextId);
      var cctvStream = document.getElementById(cctvStreamId);

      cctvStream.src = ipAddress + "/video_feed?" + new Date().getTime();

      var refreshInterval = setInterval(function() {
        loadingGif.style.display = "none";
        outOfServiceText.style.display = "block";
        cctvStream.style.display = "none";
      }, 5 * 60 * 1000); 

      cctvStream.onload = function() {
        clearInterval(refreshInterval);
        loadingGif.style.display = "none";
        outOfServiceText.style.display = "none";
        cctvStream.style.display = "block";
      };
    }

    // Panggil showCCTV untuk setiap CCTV
    window.onload = function() {
      showCCTV('cctvStream1', 'loadingGif1', 'outOfServiceText1', "http://192.168.0.111:5000/video_feed?");
      showCCTV('cctvStream2', 'loadingGif2', 'outOfServiceText2', "http://192.168.0.112:5000/video_feed?");
      showCCTV('cctvStream3', 'loadingGif3', 'outOfServiceText3', "http://192.168.0.113:5000/video_feed?");
    };
  </script>
</body>

</html>
