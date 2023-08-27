<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: http://localhost/Skripsi/2. Index Form/Index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rfid";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM datalogin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $_SESSION['username'] = $username;
        header("Location: http://localhost/Skripsi/2. Index Form/Index.php");
        exit;
    } else {
 
        $error = "Username atau password salah!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="custom-title">Prison Security Systems</h3>
            <div class="text-center">
              <img src="Prison.png" alt="Logo" style="width: 185px;">
            </div>
          </div>
          <div class="card-body">
            <?php if (isset($error)) { ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php } ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <div class="form-group">
                <div class="form-outline mb-4">
                  <input type="text" name="username" class="form-control form-control-lg" required />
                  <label class="form-label">Username</label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-outline mb-4">
                  <input type="password" name="password" class="form-control form-control-lg" required />
                  <label class="form-label">Password</label>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary custom-button">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
