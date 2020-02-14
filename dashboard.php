<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$extra_order = $number_rows = 0;
$user_cart_date = array();
if ($user) {
    $prefix = '';
} else {
    session_destroy();
    header("Location: index.php");
}
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: index.php");
    exit;
}
include_once $prefix . 'db.php';
$sql1 = "SELECT `id`, `milktype1` FROM `milktype1`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_milktype[$row['id']] = $row['milktype1'];
// echo $get_milktype[$row['milktype']];exit;
}
function moneyFormatIndia($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
          }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management  - Dashboard</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <style>
                  </style>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
        <?php include_once $prefix . 'include/header.php'; ?>
        <!-- END HEADER-->
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->
            <!-- BEGIN CONTENT-->
            <div id="content">
                <br>
                <div class="section-body"><center><h1 style="color:green;font-family: serif;font-size: 12;">MILK MANAGEMENT </h1></center> </div>
            </div><!--end #content-->

</div>


        <!-- END CONTENT -->

        <!-- BEGIN MENUBAR-->
        <?php include_once $prefix . 'include/menubar.php'; ?>
        <!-- END MENUBAR -->

    </div><!--end #base-->
    <!-- END BASE -->

    <!-- BEGIN JAVASCRIPT -->
    <?php include_once $prefix . 'include/jsfiles.php'; ?>
    <!-- END JAVASCRIPT -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</body>
</html>