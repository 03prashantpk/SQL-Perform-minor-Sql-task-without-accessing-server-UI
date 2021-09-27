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
$con = new mysqli($hostname, $username, $password, $database);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    $connSuccess =  "Failed to Connect " . $database;
} else {
    $connSuccess =  "Connected to " . $hostdb;
}


// Form Submission
if (isset($_POST["submit"])) {

    // Database Input //
    $server_name = $_POST["server_name"];
    $server_user_name = $_POST["server_user_name"];
    $server_password = $_POST["server_password"];
    $database_name = $_POST["database_name"];

    // column Creation detail //
    $table_name = $_POST["table_name"];
    $column1_name = $_POST["column1_name"];
    $column1_after = $_POST["column1_after"];
    $column2_name = $_POST["column2_name"];
    $column2_after = $_POST["column2_after"];

    // column Type 
    $input_type1 = $_POST["column1_input_type"];
    $input_type2 = $_POST["column2_input_type"];

    // sql code to create table
    $sql = "ALTER TABLE $table_name
            ADD $column1_name $input_type1
            AFTER $column1_after,
            ADD $column2_name $input_type1
            AFTER $column2_after;";

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
     header("location: createdb.php");
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
    <title>Alter Table</title>
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
                <form action="" method="POST">
                    <h2>Database Credentials</h2>
                    <hr class="style14">
                    <br>
                    <?php echo  @$success; ?>
                    <!-- Database details --->
                    <div class="padding">
                        <label for="fname">Server Name: <strong>Eg: localhost</strong></label>
                        <input required class="form-control" aria-describedby="addon-wrapping" type="text" placeholder="server_name" name="server_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Server Username: <strong>Eg: root</strong></label>
                        <input required class="form-control" aria-describedby="addon-wrapping" type="username" placeholder="server_user_name" name="server_user_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Database Name: <strong>Eg: enally</strong></label>
                        <input required class="form-control" aria-describedby="addon-wrapping" type="text" placeholder="database_name" name="database_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Database Password: <strong>Eg: root or leave blank for null</strong></label>
                        <input class="form-control" aria-describedby="addon-wrapping" type="password" placeholder="server_password" name="server_password">
                    </div>


                    <!-- Add column detail--->
                    <br><br>
                    <h2>Table Altering Details</h2>
                    <hr class="style14">

                    <div class="padding">
                        <label for="fname">Table Name To Be ALTER: <strong>Eg: users</strong></label>
                        <input required class="form-control" aria-label="Username" aria-describedby="addon-wrapping" type="text" placeholder="table_name" name="table_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Column Name To Be Added: <strong>Eg: email_verified</strong></label>
                        <input required class="form-control" aria-label="Username" aria-describedby="addon-wrapping" type="text" placeholder="column_name" name="column1_name">
                        <br>
                        <label for="fname">Data type <strong>Eg: int or varchar</strong></label>
                        <select required id="" class="form-select" name="column1_input_type">
                            <option value="">Select column type</option>
                            <option value="int(11)">int (11)</option>
                            <option value="varchar(225)">varchar (225)</option>
                        </select>
                    </div>

                    <div class="padding">
                        <label for="fname">Column Name: <strong>Eg: Ceated email_verified COLUMN AFTER email COLUMN)</strong></label>
                        <input required class="form-control" aria-label="Username" aria-describedby="addon-wrapping" type="text" placeholder="add_column1_after" name="column1_after">
                    </div>

                    <div class="padding">
                        <label for="fname">Column 2 Name To Be Added: <strong>Eg: mobile_verified</strong></label>
                        <input required class="form-control" aria-label="Username" aria-describedby="addon-wrapping" type="text" placeholder="column2_name" name="column2_name">
                        <br>
                        <label for="fname">Data type <strong>Eg: int or varchar</strong></label>
                        <select required class="form-select" id="" name="column2_input_type">
                            <option value="">Select column type</option>
                            <option value="int(11)">int (11)</option>
                            <option value="varchar(225)">varchar (225)</option>
                        </select>
                    </div>


                    <div class="padding">
                        <label for="fname">Column Name: <strong>Eg: Create mobile_verified COLUMN AFTER mobile COLUMN</strong></label>
                        <input required class="form-control" aria-label="Username" aria-describedby="addon-wrapping" type="text" placeholder="add_column2_after" name="column2_after">
                    </div>

                    <input type="submit" name="submit" value="Alter Tabe">
                </form>
            </div>
        </div>
    </div>
    <p class="footer"  onclick="location.href='https://github.com/03prashantpk'">Dev by Prashant Kumar <?php echo date("Y") ?></p>
</body>
<style>
    .logout {
        width: 150px;
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