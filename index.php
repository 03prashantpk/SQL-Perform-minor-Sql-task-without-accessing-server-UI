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
$con = new mysqli($hostname, $hostuser, $hostpass, $$hostdb);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    $connSuccess =  "Failed to Connect " . $database;
} else {
    $connSuccess =  "Connected to " . $hostdb;
}
?>

<html>

<head>
    <title>SQL - UPDATE</title>
    <!-- CSS only -->
    <link href="assets/main.css" rel="stylesheet">

    <!-- JavaScript Bundle with Popper -->
    <script src="assets/main.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">
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

    <div class="bodypad3">
        <br><br><br>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php#database">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php#tablecol">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>
    </div>

    <div class="bodypad3">
        <br><br><br>

        <div class="extapad">
            <div style="padding-left: 35px;">
                <h2>Terminal</h2>
                <br>
                <a onclick="location.href='terminal.php'">
                    <div class="card" style="width: 18rem; background-color: #484848; color: #fff;">
                        <img src="https://code.visualstudio.com/assets/docs/languages/tsql/execute.gif" class="card-img-top" alt="Terminal">
                        <div class="card-body">
                            <p class="card-text">Use SQL Terminal Instead</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <div class="bodypad" id="database">
        <br><br><br>

        <div class="extapad">
            <h2>Database Function</h2>
            <div class="centerd scroll">

                <div class="cardp  padleftcard">
                    <div class="card" style="width: 18rem;">
                        <img src="img/sql.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Create Database</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='createdb.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/sqldump.jpg" class="card-img-top" alt="dump img">
                        <div class="card-body">
                            <h5 class="card-title">Import SQl Dump</h5>
                            <p class="card-text">Use this to dump Sql data using your Username, Password and sql dump file. Note: work with db_name.sql format only. </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='sqldump.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/bdtable.png" class="card-img-top" alt="table img">
                        <div class="card-body">
                            <h5 class="card-title">Backup Database</h5>
                            <p class="card-text">Use this to create a new table in a database with some default values. Such as: id int(10), name varchar(255), date_added_on date </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='backupdb.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/60abalter.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Drop Database</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='dropdb.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/60abalter.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">List All Database</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='listdb.php'">Click here</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bodypad" id="tablecol">
        <div class="extapad">
            <h2>Table Function</h2>
            <div class="centerd scroll">
                <div class="cardp padleftcard">
                    <div class="card" style="width: 18rem;">
                        <img src="img/bdtable.png" class="card-img-top" alt="table img">
                        <div class="card-body">
                            <h5 class="card-title">Create Table</h5>
                            <p class="card-text">Use this to create a new table in a database with some default values. Such as: id int(10), name varchar(255), date_added_on date </p>
                            <button class="btn btn-primary" type="button" disabled onclick="location.href='#'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/60abalter.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Alter Table</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" onclick="location.href='altertable.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/clean.png" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Truncate Table</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" disabled onclick="location.href='altertable.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/sql.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Drop Table</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" disabled onclick="location.href='altertable.php'">Click here</button>
                        </div>
                    </div>
                </div>

                <div class="cardp">
                    <div class="card" style="width: 18rem;">
                        <img src="img/sql.jpg" class="card-img-top" alt="alter img">
                        <div class="card-body">
                            <h5 class="card-title">Drop Table</h5>
                            <p class="card-text">Used this to add, delete, or modify columns in an existing table or to add and drop various constraints on an existing table </p>
                            <button class="btn btn-primary" type="button" disabled onclick="location.href='altertable.php'">Click here</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <p class="footer" onclick="location.href='https://github.com/03prashantpk'">Dev by Prashant Kumar <?php echo date("Y") ?></p>
</body>
<style>
    .extapad {
        padding-right: 60px;
        padding-left: 60px;
    }

    .scroll {
        overflow-x: scroll;
        scrollbar-width: thin;
        scrollbar-color: #424242 #ccc;
        border-radius: 20px;
    }

    *::-webkit-scrollbar {
        width: 12px;
        border-radius: 20px;
        cursor: pointer;
    }

    *::-webkit-scrollbar-track {
        background: #ccc;
        border-radius: 20px;
        cursor: pointer;
    }

    *::-webkit-scrollbar-thumb {
        background-color: #424242;
        border-radius: 20px;
        border: 3px solid #ccc;
        cursor: pointer;
    }

    .logout {
        width: 150px;
    }

    .shadow33 {
        box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072), 0 41.8px 33.4px rgba(0, 0, 0, 0.086), 0 100px 80px rgba(0, 0, 0, 0.12)
    }

    .me-2 {
        text-align: center;
    }

    .bodypad {
        padding-top: 90px;
    }

    .bodypad {
        padding-top: 90px;
    }

    .centerd {
        display: flex;
        justify-content: center;
    }

    body {
        background: #EEF2F7;
    }

    .cardp {
        padding: 12px;
    }

    .padleftcard {
        padding-left: 210px;
    }

    .card-title {
        font-weight: 600;
    }

    .footer {
        text-align: center;
        color: #808080;
        font-family: sans-serif;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #F94620;
        color: #fff;
        border: 1px solid #F94639;
    }

    .btn-primary:hover {
        background-color: #fff;
        color: #F94639;
        border: 1px solid #F94639;
    }

    .card {
        border-radius: 8px;
    }

    .card:hover {
        border-radius: 10px;
    }

    .card-img-top {
        height: 200px;
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
        text-align: left;
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