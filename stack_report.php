<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $msg = $balan = $StockReport = $ProductNames = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}


$sqlc1 = "SELECT `id`, `name` FROM `buyer`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_bname[$row['id']] = $row['name'];
    // echo $get_bname[$row['name']];exit;
}

$sql1 = "SELECT `id`, `name` FROM `seller`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_sbname[$row['id']] = $row['name'];
    // echo $get_sbname[$row['name']];exit;
}
$sql21 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql21);
while ($row = mysqli_fetch_assoc($result)) {
    $get_ename[$row['id']] = $row['expences'];
    // echo $get_ename[$row['expences']];exit;
}

if (isset($_POST['FromToBalanceResultFrom']) && $_POST['FromToBalanceResultTo']) {
    $FromToBalanceResultFrom = date('Y-m-d', strtotime($_POST['FromToBalanceResultFrom']));
    $FromToBalanceResultTo = date('Y-m-d', strtotime($_POST['FromToBalanceResultTo']));
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th style="text-align: center">SlNo</th>
                    <th style="text-align: left">Product</th>
                    <th style="text-align: right">Total Quantity</th>
                    <th style="text-align: right">Used Quantity</th>
                    <th style="text-align: right">Balance</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $StockReport = $ProductNames = Array();
                $sql = "SELECT * FROM `expense`";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    $StockReport['inward'][$row_main['id']] = 0;
                    $StockReport['outward'][$row_main['id']] = 0;
                    $ProductNames[$row_main['id']] = $row_main['expences'];
                }
                $sql = "select expences,SUM(`total_unit`) as `total_unit` from inward where `date` BETWEEN '$FromToBalanceResultFrom' AND '$FromToBalanceResultTo' GROUP BY `expences` ";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    $StockReport['inward'][$row_main['expences']] = $row_main['total_unit'];
                }
                $sql = "select expences,SUM(`unit`) as `total_unit` from outward where `date` BETWEEN '$FromToBalanceResultFrom' AND '$FromToBalanceResultTo' GROUP BY `expences` ";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    $StockReport['outward'][$row_main['expences']] = $row_main['total_unit'];
//                    $StockReport['outward'][$row_main['expences']] = $row_main['balance'];
                }
//                    print_r  ($StockReport);exit;           
                foreach ($ProductNames as $key => $value) {
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo $i; ?></td>
                        <td style="text-align: left"><?php echo $value; ?></td>
                        <td style="text-align: right"><?php echo $StockReport['inward'][$key]; ?></td>
                        <td style="text-align: right"><?php echo $StockReport['outward'][$key]; ?></td>
                        <td style="text-align: right"><?php echo $StockReport['inward'][$key] - $StockReport['outward'][$key]; ?></td>
                    </tr> 
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management-Stock Report</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.19.custom.min.js"></script>

    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
<!--                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <form class="form form-validate" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Stock Report</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <em class="text-caption">Datepickers</em>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="input-daterange input-group" id="demo-date-range">
                                                                <div class="input-group-content">
                                                                    <input type="text" class="form-control" id="start" autocomplete="off" />
                                                                    <label>Date range</label>
                                                                </div>
                                                                <span class="input-group-addon">to</span>
                                                                <div class="input-group-content">
                                                                    <input type="text" autocomplete="off" class="form-control" max = "<?php echo date('d-m-Y'); ?>" id="end" />
                                                                    <div class="form-control-line"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="row text-right">
                                                                    <div class="col-md-12"><br>
                                                                        <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" id="search">Submit</button>

                                                                        <div class="col-md-2">
                                                                            <button type="reset" class="btn ink-reaction btn-flat btn-primary">Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>   
                                                        </div>end .card-body 
                                                    </div>end .card 
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>-->
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-8">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Stock Report</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="FromToBalanceResult" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th style="text-align: center;">S.No</th>
                                                            <th style="text-align: center;">Product</th>
<!--                                                            <th style="text-align: right">Total Quantity</th>
                                                            <th style="text-align: right">Used Quantity</th>-->
                                                            <th style="text-align: right;">Balance Unit</th>
                                                            <th style="text-align: right;">Rate Per Unit</th>
                                                            <th style="text-align: right;">Amount</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $StockReport = $ProductNames = Array();
                                                        $sql = "SELECT * FROM `expense`";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row_main = mysqli_fetch_assoc($result)) {
                                                            $StockReport['inward'][$row_main['id']] = 0;
                                                            $StockReport['outward'][$row_main['id']] = 0;
                                                            $ProductNames[$row_main['id']] = $row_main['expences'];
                                                        }

                                                        $sql = "select expences,SUM(`total_unit`) as `total_unit`,rate from inward GROUP BY `expences` ";
//                                                       echo $sql;exit;
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row_main = mysqli_fetch_assoc($result)) {
                                                            $StockReport['inward'][$row_main['expences']] = $row_main['total_unit'];
                                                            $rate[$row_main['expences']] = $row_main['rate'];
                                                            $rate_val[] = $row_main['rate'];
                                                        }
                                                        $sql = "select expences,SUM(`unit`) as `total_unit` from outward GROUP BY `expences` ";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row_main = mysqli_fetch_assoc($result)) {
                                                            $StockReport['outward'][$row_main['expences']] = $row_main['total_unit'];
                                                        }
                                                        foreach ($ProductNames as $key => $value) {
                                                            if (isset($StockReport['outward'][$key]) && isset($StockReport['inward'][$key])&& isset($rate[$key])) {
                                                                $array_total[] = (($StockReport['inward'][$key] - $StockReport['outward'][$key]) * $rate[$key]);
                                                            }
                                                            $balan = $StockReport['inward'][$key] - $StockReport['outward'][$key];
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo $i; ?></td>
                                                                <td style="text-align: center;"><?php echo $value; ?></td>
                                                                <td style="text-align: right;"><?php echo $balan; ?></td>
                                                                <td style="text-align: right;"><?php if(isset($rate[$key])) echo $rate[$key]; ?></td>
                                                                <td style="text-align: right;"><?php if (isset($StockReport['outward'][$key]) && isset($StockReport['inward'][$key])&& isset($rate[$key])) { echo (($StockReport['inward'][$key] - $StockReport['outward'][$key]) * $rate[$key]); } ?></td>
                                                            </tr> 
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th style="text-align: right;" colspan="2">
                                                                Total:
                                                            </th>
                                                            <td style="text-align: right;">
                                                                <?php echo array_sum($rate_val); ?>
                                                            </td>
                                                            <td></td>
                                                            <td style="text-align: right;">
                                                                <?php echo array_sum($array_total); ?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include_once 'include/menubar.php'; ?>
        <?php include_once 'include/jsfiles.php'; ?>
        <script type="text/javascript">
            $('#start').datepicker({
                format: 'dd-mm-yyyy',
            });
            $('#end').datepicker({
                format: 'dd-mm-yyyy',
            });
        </script>
        <script>

            $(function () {
                $("#search").click(function (e) {
                    e.preventDefault();
                    var from = $("#start").val();
                    var to = $("#end").val();
                    $.post('stack_report.php', {
                        FromToBalanceResultFrom: from,
                        FromToBalanceResultTo: to
                    }, function (data, status) {
                        console.log(data);
                        $('#FromToBalanceResult').html(data);
                        $('#datatable1').DataTable({
                            "dom": 'lCfrtip',
                            "colVis": {
                                "buttonText": "Hide",
                                "overlayFade": 0,
                                "align": "right"
                            },
                            "aLengthMenu": [
                                [10, 25, 50, 100, -1],
                                [10, 25, 50, 100, "All"]
                            ],
                            "iDisplayLength": -1
                        });
                    });
                });
            });
        </script>
    </body>
</html>



