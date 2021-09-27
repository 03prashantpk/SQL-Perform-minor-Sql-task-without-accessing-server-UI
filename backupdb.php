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

    // Database Inputs
    $server_name = $_POST["server_name"];
    $server_user_name = $_POST["server_user_name"];
    $server_password = $_POST["server_password"];

    //Database name input
    $dbname = $_POST["dbname"];


    // Get connection object and set the charset
    $conn = mysqli_connect($server_name, $server_user_name, $server_password, $dbname);
    $conn->set_charset("utf8");


    // Get All Table Names From the Database
    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $sqlScript = "";
    foreach ($tables as $table) {

        // Prepare SQLscript for creating table structure
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);

        $sqlScript .= "\n\n" . $row[1] . ";\n\n";


        $query = "SELECT * FROM $table";
        $result = mysqli_query($conn, $query);

        $columnCount = mysqli_num_fields($result);

        // Prepare SQLscript for dumping data for each table
        for ($i = 0; $i < $columnCount; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $columnCount; $j++) {
                    $row[$j] = $row[$j];

                    if (isset($row[$j])) {
                        $sqlScript .= '"' . $row[$j] . '"';
                    } else {
                        $sqlScript .= '""';
                    }
                    if ($j < ($columnCount - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
        }

        $sqlScript .= "\n";
    }

    if (!empty($sqlScript)) {
        // Save the SQL script to a backup file
        $backup_file_name = 'name_backup_'  . time() . '.sql';
        $fileHandler = fopen($backup_file_name, 'w+');
        $number_of_lines = fwrite($fileHandler, $sqlScript);
        fclose($fileHandler);

        // Download the SQL backup file to the browser
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backup_file_name));
        ob_clean();
        flush();
        readfile($backup_file_name);
        exec('rm ' . $backup_file_name);
    }
}
?>


<html>

<head>
    <title>Create DB Backup</title>
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
                    <?php echo  @$success; ?><?php echo  @$error; ?>
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
                    <h2>Enter Database Name To backup</h2>
                    <hr class="style14">

                    <div class="padding">
                        <label for="fname">Enter Database Name: <strong>Eg: mydb</strong></label>
                        <input required class="form-control" aria-label="Username" type="text" placeholder="database_name" name="dbname">
                    </div>
                    <input type="submit" name="submit" value="Create Database">
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

    h4 {
        text-transform: capitalize;
    }
</style>

</html>