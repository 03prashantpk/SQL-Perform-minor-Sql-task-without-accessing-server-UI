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
$con = new mysqli($hostname, $hostuser, $hostpass, $hostdb);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    $connSuccess =  "Failed to Connect " . $database;
} else {
    $connSuccess =  "Connected to " . $hostdb;
}

//connection and result
$pdo = new PDO("mysql:host=$hostname;", $hostuser, $hostpass);
$stmt = $pdo->query('SHOW DATABASES');
$databases = $stmt->fetchAll(PDO::FETCH_COLUMN);




// Form Submission
if (isset($_POST["submit"])) {

    // Database Input //
    $server_name = $_POST["server_name"];
    $server_user_name = $_POST["server_user_name"];
    $server_password = $_POST["server_password"];
    $database_name = $_POST["database_name"];

    $sqlcode = $_POST["sqlcode"];

    // column Creation detail //
    //$table_name = $_POST["table_name"];
    //$column1_name = $_POST["column1_name"];
    //$column1_after = $_POST["column1_after"];
    //$column2_name = $_POST["column2_name"];
    //$column2_after = $_POST["column2_after"];

    // column Type 
    //$input_type1 = $_POST["column1_input_type"];
    //$input_type2 = $_POST["column2_input_type"];

    // sql code to create table
    $sql = "$sqlcode";

    $servername = $server_name;
    $username = $server_user_name;
    $password = $server_password;
    $dbname = $database_name;

    // checking connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // echo "Connected! <br>";
    }

    if ($conn->query($sql) === TRUE) {
        // echo "Column email_verified and email_verified created successfully <br>";
        $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Success!</strong> All task completed.
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
        //header("location: terminal.php");
    } else {
        $error =  "Error adding column: " . $conn->error;
        $success = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
       <strong>Alert!</strong> ' . $error . '
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
    }
    $conn->close();
} else {
    //echo "Please fill the form";
}

?>


<html>

<head>
    <title>SQL Terminal</title>
    <link href="assets/main.css" rel="stylesheet">

    <!-- JavaScript Bundle with Popper -->
    <script src="assets/main.js"></script>
    <script src="assets/ace.js"></script>
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
                    <h2>Database Credentials</h2>
                    <hr class="style14">
                    <br>
                    <?php echo  @$success; ?>
                    <!-- Database details --->
                    <div class="padding">
                        <label for="fname">Server Name: <strong>Eg: localhost</strong></label>
                        <input required class="form-control" list="host" type="username" placeholder="server_name" name="server_name">
                        <datalist id="host">
                            <option value="localhost">
                            <option value="http://127.0.0.1">
                            <option value="127.0.0.1">
                        </datalist>
                    </div>

                    <div class="padding">
                        <label for="fname">Server Username: <strong>Eg: root</strong></label>
                        <input required class="form-control" list="databaseusernames" type="username" placeholder="server_user_name" name="server_user_name">
                        <datalist id="databaseusernames">
                            <option value="root">
                            <option value="STSTEM">
                            <option value="SYS">
                        </datalist>
                    </div>

                    <div class="padding">
                        <label for="fname">Database Name: <strong>Eg: enally</strong></label>
                        <input class="form-control" type="username" list="databasenames" placeholder="database_name" name="database_name">
                        <datalist id="databasenames">
                            <?php foreach ($databases as $database) {
                                echo '<option value="' . $database .'">';
                            } ?>

                        </datalist>
                    </div>

                    <div class="padding">
                        <label for="fname">Database Password: <strong>Eg: root or leave blank for null</strong></label>
                        <input class="form-control" list="passwordd" type="username" placeholder="server_password" name="server_password">
                        <datalist id="passwordd">
                            <option value="">Null</option>
                            <option value="root">
                            <option value="Root">
                        </datalist>
                    </div>


                    <!-- Add column detail--->
                    <br><br>
                    <h2>Type SQL Query </h2>
                    <hr class="style14">

                    <div class="padding">
                        <div class="textarea-wrapper">
                            <textarea rows="15" name="sqlcode" placeholder="// Please Input SQL 
    CREATE TABLE table_name (
    column1 datatype,
    column2 datatype,
    column3 datatype,
   ....
);" cols="40"></textarea>
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Run">
                </form>
            </div>
        </div>
    </div>

    <p class="footer" onclick="location.href='https://github.com/03prashantpk'">Dev by Prashant Kumar <?php echo date("Y") ?></p>
</body>
<style type="text/css" media="screen">
    #editor {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
<style>
    textarea {
        width: 100%;
        min-height: 100px;
        background: url(http://i.imgur.com/2cOaJ.png) top -12px left / auto no-repeat,
            linear-gradient(#F1F1F1 50%, #F9F9F9 50%) top left / 100% 32px;
        border: 1px solid #CCC;
        box-sizing: border-box;
        padding: 0 0 0 30px;
        resize: vertical;
        line-height: 20px;
        font-size: 13px;
        color: #424242;
        font-size: 16px;
    }


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