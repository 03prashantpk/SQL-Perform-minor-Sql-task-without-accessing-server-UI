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

if (isset($_FILES['sql'])) {
    $errors = array();
    $file_name = $_FILES['sql']['name'];
    $file_size = $_FILES['sql']['size'];
    $file_tmp = $_FILES['sql']['tmp_name'];
    $file_type = $_FILES['sql']['type'];
    @$file_ext = strtolower(end(explode('.', $_FILES['sql']['name'])));

    $extensions = array("sql");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "dump/" . $file_name);
        //  echo "Success";
        //  echo "$file_name";

        $import_code = ' <div class="bodypad">
        <br><br>
        <div class="centerd">
            <div class="input-group flex-nowrap">
                <form class="form" action="" method="POST">
                    <h2>Database Credentials</h2>
                    <hr class="style14">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Note!</strong>You  are about to import <u> the above </u>dump file. If you are not sure you can delete and upload again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
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
                        <label for="fname">Database Name: <strong>Eg: flevar</strong></label>
                        <input required class="form-control" aria-describedby="addon-wrapping" type="text" placeholder="database_name" name="database_name">
                    </div>

                    <div class="padding">
                        <label for="fname">Database Password: <strong>Eg: root or leave blank for null</strong></label>
                        <input class="form-control" aria-describedby="addon-wrapping" type="password" placeholder="server_password" name="server_password">
                    </div>

                    <input type="submit" name="upload" value="Start Importing">
                </form>
            </div>
        </div>
    </div>';

        $hiddendiv = "hidden";
    }
} else {
    print_r(@$errors);
}
?>
<?php

$fileList = glob('dump/*.sql');
foreach ($fileList as $filename) {
    if (is_file($filename)) {
        //echo $filename, '<br>'; 
        $filename_upload = substr($filename, 5);
    }
}
if (isset($_POST["upload"])) {

    // Database Input //
    $server_name = $_POST["server_name"];
    $server_user_name = $_POST["server_user_name"];
    $server_password = $_POST["server_password"];
    $database_name = $_POST["database_name"];

    $conn = mysqli_connect($server_name, $server_user_name, $server_password, $database_name);
    $query = '';
    $sqlScript = file($filename);
    foreach ($sqlScript as $line) {

        $startWith = substr(trim($line), 0, 2);
        $endWith = substr(trim($line), -1, 1);

        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
        }
        $query = $query . $line;
        if ($endWith == ';') {
            mysqli_query($conn, $query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query . '</b></div>');
            $query = '';
        }
    }
    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
       <strong>Success!</strong> ' . $filename_upload .  ' Imported Successfully! 
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
    header("location: sqldump.php");
}
//form method
if (isset($_GET['delete'])) {
    unlink($filename);
    header("location: sqldump.php");
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

    <div class="bodypad2" <?php @$hiddendiv ?>>
        <br><br>
        <div class="centerd">
            <div class="input-group flex-nowrap">
                <!--- Upload Data ---->
                <form class="form" action="" method="POST" enctype="multipart/form-data">
                    <h2>Select SQL Dump File</h2>
                    <hr class="style14">

                    <?php echo @$success ?>
                    <?php $fileList = glob('dump/*.sql');
                    foreach ($fileList as $filename) {
                        if (is_file($filename)) {
                            //echo $filename, '<br>'; 
                            $filename_upload = substr($filename, 5);
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Recommended!</strong>Delete this <u>' .  $filename_upload . '</u> dump file.
                            <span onclick="location.href=';
                            echo "'?delete=1'";
                            echo '" class="btn2" type="button">Delete Now <i class="fa fa-trash" aria-hidden="true"></i>
                            </span>
                        </div>';
                        }
                    }
                    @$fileList = glob('dump/*.sql');
                    if (!is_file(@$filename)) {
                        echo ' <br> ';
                        echo   @$success;
                        echo '   <input type="file" name="sql" /> ';
                        echo '   <input type="submit" value="Upload" />';
                    }

                    ?>
                    <br>
                </form>
            </div>
        </div>
    </div>

    <?php echo @$import_code ?>
    <p class="footer" onclick="location.href='https://github.com/03prashantpk'">Dev by Prashant Kumar <?php echo date("Y") ?></p>
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
        padding-bottom: 4px;
    }

    .bodypad2 {
        padding-top: 10px;
        padding: 10px;
    }

    .centerd {
        display: flex;
        justify-content: center;
        padding-top: 5px;

    }

    .centerd {
        display: flex;
        justify-content: center;
        padding-top: 50px;

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

    .form {
        width: 100%;
    }

    input[TYPE=file] {
        width: 100%;
    }

    .btn2 {
        font-weight: 600;
        color: #F94639;
    }
</style>

</html>