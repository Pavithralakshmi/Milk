<?php
session_start();
session_destroy();
$mp = array();
$error = $prefix = "";
include_once $prefix . 'db.php';
session_start();
$admin_cookie_array = $mp_cookie = array();
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer_page = $_SERVER['HTTP_REFERER'];
} else {
    $referrer_page = '';
}
if (isset($_POST['username'])) {
    $user = mysqli_real_escape_string($mysqli, $_POST['username']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);
    $sql = "select * from `nithrausers` where BINARY(`username`)=BINARY(trim('$user')) AND BINARY(`password`)=BINARY(trim('$pass')) ";
    $result = mysqli_query($mysqli_nithra, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($sql));
    $num = mysqli_num_rows($result);
    if ($num) {
        hasLogin("success", $user, $pass, $datetime);
        while ($row = mysqli_fetch_assoc($result)) {
            $ugroup = $row['role'];
        }
        $_SESSION['user'] = $user;
        $_SESSION['name'] = $ugroup;
        setcookie("mm_admin", $user, time() + (10 * 365 * 24 * 60 * 60), "/");
        $sql = "INSERT INTO `access_report`(`uname`, `pass`, `page`, `datetime`, `ip`, `success`) VALUES ('$user','$pass', 'magalir_mattum', '$datetime', '$_SERVER[REMOTE_ADDR]', 'YES')";
        $result = mysqli_query($mysqli_nithra, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error());
        header("Location: dashboard.php");
    } else {
        hasLogin("failed", $user, $pass, $datetime);
        $error = 1;
        $sql = "INSERT INTO `access_report`(`uname`, `pass`, `page`, `datetime`, `ip`, `success`) VALUES ('$user','$pass', 'magalir_mattum', '$datetime', '$_SERVER[REMOTE_ADDR]', 'NO')";
        $result = mysqli_query($mysqli_nithra, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error());
    }
}

function hasLogin($status, $uu, $pp, $dd)
{
    $content = $status . "<==>" . $dd . "<==>" . $_SERVER['REQUEST_URI'] . "<==>" . $uu . "<==>" . $pp . "<==>" . $_SERVER['REMOTE_ADDR'] . "<==>" . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
    $fp = fopen("login.txt", "a+");
    fwrite($fp, $content);
    fclose($fp);
}
function hasAccess($uu, $pp, $dd)
{
    $content = $dd . "<==>" . $_SERVER['REQUEST_URI'] . "<==>" . $uu . "<==>" . $pp . "<==>" . $_SERVER['REMOTE_ADDR'] . "<==>" . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
    $fp = fopen("log.txt", "a+");
    fwrite($fp, $content);
    fclose($fp);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Login</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php';?>
        <link type="text/css" rel="stylesheet" href="<?php echo $template_prefix; ?>assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN LOGIN SECTION -->
        <section class="section-account">
            <div class="img-backdrop" style="background-image: url('<?php echo $prefix; ?>assets/img/m1.jpg')"></div>
            <div class="spacer"></div>
            <div class="card contain-sm style-transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <br/>
                            <span class="text-lg text-bold text-primary">Milk Management</span>
                            <br/><br/>
                            <form class="form floating-label" action="" accept-charset="utf-8" method="post" >
                                <div class="form-group" style="display:none">
                                    <input type="text" class="form-control" id="username1" name="username">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-group" style="display:none">
                                    <input type="password" class="form-control" id="password1" name="password">
                                    <label for="password">Password</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="username" name="username" required="true">
                                    <label for="username">Username</label>

                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password" required="true">
                                    <label for="password">Password</label>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-12 text-right">
                                        <button class="btn btn-primary btn-raised" type="submit" >Login</button>
                                    </div><!--end .col -->
                                </div><!--end .row -->
                         </form>
                        </div><!--end .col -->
                    </div><!--end .row -->
                </div><!--end .card-body -->
            </div><!--end .card -->
        </section>
        <!-- END LOGIN SECTION -->


        <!-- BEGIN JAVASCRIPT -->
        <?php include_once $prefix . 'include/jsfiles.php';?>
        <!-- END JAVASCRIPT -->
        <script>
<?php if ($error) {
    ?>
                Command: toastr["error"]("In-correct User name and Password", "Error")
<?php }
?>

        </script>

    </body>
</html>

