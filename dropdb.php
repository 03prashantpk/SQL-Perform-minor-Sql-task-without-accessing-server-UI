<?php
require('../admin/connection.inc.php');
require('../admin/functions.inc.php');
include("../config/dbconn.php");
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
} else {

    header('location:login.php');
    die();
}

// checking connection
$con = new mysqli($hostname, $username, $password, $hostdb);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    $connSuccess =  "Failed to Connect " . $database;
} else {
    $connSuccess =  "Connected to " . $hostdb;
}

// Form Submission
if (isset($_POST["submit"])) {
    $server_name = $_POST["server_name"];
    $server_user_name = $_POST["server_user_name"];
    $server_password = $_POST["server_password"];

    //Database name input
    $dbname = $_POST["dbname"];

    $conn = mysqli_connect($server_name, $server_user_name, $server_password);
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    $sql = "DROP Database " . $dbname . " ";
    if (mysqli_query($conn, $sql)) {
        $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Database ' . $dbname . ' Droped Successfully! .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
        //$error =  "Error adding column: " . $conn->error;
        $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
       <strong>Alert!</strong> ' . $error . '
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
     header("location: dropdb.php");
    }
    mysqli_close($conn);
}
?>


<html>

<head>
    <title>Drop DB</title>
    <link href="assets/main.css" rel="stylesheet">

    <!-- JavaScript Bundle with Popper -->
    <script src="assets/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" onclick="location.href='index.php'"><img src="img/sql.jpg" width="80" alt="logo"></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" onclick="location.href='../admin/index.php'">Admin Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" hidden href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"></a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" disabled placeholder="Search" value="<?php echo $connSuccess ?> " aria-label="Search">
                    <button class="btn btn-primary logout" type="button" onclick="location.href='logout.php'">Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="bodypad">
        <br><br>
        <div class="centerd">
            <div class="input-group flex-nowrap">
                <form class="form" action="" method="POST">
                    <h2>Server Credentials</h2>
                    <hr class="style14">
                    <br>
                    <?php echo  @$success; ?><?php echo  @$error; ?><?php echo  @$success1; ?>
                    <!-- Database details --->
                    <div class="padding">
                        <label for="fname">Server Name: <strong>Eg: localhost</strong></label>
                        <input required class="form-control" type="text" placeholder="server_name" name="server_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Server Username: <strong>Eg: root</strong></label>
                        <input required class="form-control" type="username" placeholder="server_user_name" name="server_user_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Database Password: <strong>Eg: root or leave blank for null</strong></label>
                        <input class="form-control" type="password" placeholder="server_password" name="server_password">
                    </div>


                    <!-- Add column detail--->
                    <br><br>
                    <h2>Enter Database Name To Be Droped</h2>
                    <hr class="style14">

                    <div class="padding">
                        <label for="fname">Enter New Database Name: <strong>Eg: mydb</strong></label>
                        <input required class="form-control" aria-label="Username" type="text" placeholder="database_name" name="dbname">
                    </div>
                    <input type="submit" name="submit" value="Drop Database">
                </form>
            </div>
        </div>
    </div>
    <p class="footer" onclick="location.href='https://github.com/03prashantpk'">Dev by Prashant Kumar <?php echo date("Y") ?></p>
</body>
<style>
    .logout {
        width: 150px;
    }
    .form {
        width: 100%;
    }

    .me-2 {
        text-align: center;
    }

    .bodypad {
        padding-top: 120px;
        padding: 30px;
    }

    .centerd {
        display: flex;
        justify-content: center;
        padding-top: 20px;

    }

    body {
        background: #EEF2F7;

    }

    .btn-primary {
        background-color: #F94620;
        color: #fff;
        border: 1px solid #F94639;
    }

    .footer {
        text-align: center;
        color: #808080;
        font-family: sans-serif;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #fff;
        color: #F94639;
        border: 1px solid #F94639;
    }


    input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    .center {
        margin-left: 30%;
        width: 400px;
        padding: 30px 80px 10px 80px;
    }

    label {
        padding-top: 20px;

    }

    h2 {
        text-align: center;
        color: #04AA6D;
    }

    .padding {
        padding: 4px;
        background-color: #fff;
    }

    hr.style14 {
        border: 0;
        height: 1px;
        background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
        background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
        background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
        background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
    }

    .input-group {
        width: 800px;
        padding: 30px 80px 10px 100px;
        background-color: #fff;
        border-radius: 12px;
    }

    .form-control {
        width: 100%;
    }
</style>

</html>