<?php
require('../admin/connection.inc.php');
require('../admin/functions.inc.php');
$msg = '';
if (isset($_POST['submit'])) {
    $username = get_safe_value($con, $_POST['username']);
    $password = get_safe_value($con, $_POST['password']);
    $sql = "select * from admin_users where username='$username' and password='$password'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($row['status'] == '0') {
            $msg = "Account deactivated";
        } else {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_ID'] = $row['id'];
            $_SESSION['ADMIN_USERNAME'] = $username;
            $_SESSION['ADMIN_ROLE'] = $row['role'];
            header('location: index.php');
            die();
        }
    } else {
        $msg = "Please enter correct login details";
    }
}
?>

<?php
/* This sets the $time variable to the current hour in the 24 hour clock format */
$time = date("H");
/* Set the $timezone variable to become the current timezone */
$timezone = date("e");
/* If the time is less than 1200 hours, show good morning */
if ($time < "12") {
    $change_wallpaper = "background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(https://wallpaperaccess.com/full/633957.jpg) no-repeat center center / cover;";
    $greeting = "Good Moring, We wish you a great day";
} else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($time >= "12" && $time < "17") {
        $change_wallpaper =  "background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(https://wallpaperaccess.com/full/633995.jpg) no-repeat center center / cover;";
        $greeting = "Good Afternoon, Hope your day is going well";
    } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            $change_wallpaper = "background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(https://wallpaperaccess.com/full/634001.jpg) no-repeat center center / cover;";
            $greeting = "Good Evening, Hope you had a good day";
        } else
            /* Finally, show good night if the time is greater than or equal to 1900 hours */
            if ($time >= "19") {
                $change_wallpaper = "background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(https://wallpaperaccess.com/full/634045.jpg) no-repeat center center / cover;";
                $greeting = "Its Night but, glad to see you here";
            }

?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../admin/assets/css/normalize.css">
    <link rel="stylesheet" href="../admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../admin/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../admin/assets/css/pe-icon-7-filled.css">
    <link rel="stylesheet" href="../admin/assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="../admin/assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body class="bg-light">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content shadow-lg">
                <div class="login-form mt-150">
                    <form method="post">
                        <h4>Login Panel</h4>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                    </form>
                    <div class="field_error"><?php echo $msg ?></div>
                </div>
            </div>
        </div>
    </div>
    <script src="../admin/assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="../admin/assets/js/popper.min.js" type="text/javascript"></script>
    <script src="../admin/assets/js/plugins.js" type="text/javascript"></script>
    <script src="../admin/assets/js/main.js" type="text/javascript"></script>

    <footer>
        <h3 id="clock" style=" color: #ffffff91;"></h3> 
        <?php
             //checking connection with @fopen
            if (@fopen("https://flevar.in", "r")) {
                echo " <a href='#' onclick='return false;' style=' color: #ffffff91; text-align: center; float: right; padding-right: 10px; font-size: 22px; padding-bottom: 10px;'><i class='fa fa-check-circle' style='color: #ffffff91' aria-hidden='true'> <span style='color: #ffffff91;  font-size: 18px;
                font-weight: 600;'>Online</span></i>
                </a>";
                } else {
                echo " <a href='#' onclick='return false;'  style=' color: #ffffff91; text-align: center; float: right; padding-right: 10px; font-size: 22px; padding-bottom: 10px;'><i class='fa fa-times-circle' style='color:#ffffff91 ' aria-hidden='true'><span style='color: #ffffff91;  font-size: 18px;
                font-weight: 600;'> Offline</span></i>
                </a>";
            } 
        ?>
    </footer>

</body>

<style>
    #clock {
        text-align: center;
        margin-top: 0%;
        font-size: 22px;
        font-weight: 600;
        width: 150px;
        border-radius: 12px;
        float: left;
        margin-left: 10px;
        color: #f1f1f194;
        text-shadow: #f1f1f11a;
    }

    footer {
        position: fixed;
        left: 0;
        top: 20px;
        width: 100%;
        color: white;
        text-align: center;
        padding-bottom: 2px;
        font-weight: 600;
    }

    .bg-light {
        <?php echo $change_wallpaper ?>;
    }

    .login-content {
        border-radius: 22px;
        color: #fff;
    }

    .mt-150 {
        border-radius: 12px;
        color: #fff;
    }
</style>
<script>
    function clock() {

        //Save the times in variables

        var today = new Date();

        var hours = today.getHours();
        var minutes = today.getMinutes();
        var seconds = today.getSeconds();


        //Set the AM or PM time

        if (hours >= 12) {
            meridiem = " PM";
        } else {
            meridiem = " AM";
        }


        //convert hours to 12 hour format and put 0 in front
        if (hours > 12) {
            hours = hours - 12;
        } else if (hours === 0) {
            hours = 12;
        }

        //Put 0 in front of single digit minutes and seconds

        if (minutes < 10) {
            minutes = "0" + minutes;
        } else {
            minutes = minutes;
        }

        if (seconds < 10) {
            seconds = "0" + seconds;
        } else {
            seconds = seconds;
        }


        document.getElementById("clock").innerHTML = (hours + ":" + minutes + ":" + seconds + meridiem);

    }

    setInterval('clock()', 1000);
</script>

</html>