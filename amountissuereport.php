<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $msg = "";
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
$sql1 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_expences[$row['id']] = $row['expences'];
// echo $get_expences[$row['expences']];exit;
}

$sqlc1 = "SELECT `id`, `unit` FROM `unit`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_uname[$row['id']] = $row['unit'];
// echo $get_uname[$row['unit']];exit;
}

if ((isset($_POST['FromToBalanceResult'])) || (isset($_POST['seller_id']))) {
    $FromToBalanceResult = explode(" - ", $_POST['FromToBalanceResult']);
    $FromToBalanceResultFrom = date('Y-m-d', strtotime($FromToBalanceResult[0]));
    $FromToBalanceResultTo = date('Y-m-d', strtotime($FromToBalanceResult[1]));
    $seller_id = $_POST['seller_id'];
//    echo $seller_id;exit;
    if ($seller_id) {
        $sell = " and `seller_id`=" . $seller_id;
    } else {
        $sell = "and 1";
    }
    ?>
    <div class="card-body">
        <div id="regwise_select" class="tbgetsect table-responsive">
            <table id="datatable1" class="table diagnosis_list " >
                <thead>
                    <tr>                                    
                        <th>S.No</th>
                        <th>Date</th>
                        <th style="text-align: left">Product Details</th>
                        <th style="text-align: center">Paid Amount</th>
                        <th style="text-align: center">Payment Mode</th>
                        <!--<th>Balance</th>-->
                        <th style="text-align: center">Seller Name & Number</th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" >
                    <?php
                    $i = 1;
                    $sql = "SELECT o.*,i.* from inward i CROSS JOIN outcome o on i.inwardno=o.inwardno where `payment_date` BETWEEN '$FromToBalanceResultFrom' AND '$FromToBalanceResultTo' $sell group by `payment_date`";
//                   echo $sql;exit;
                    $result = mysqli_query($mysqli, $sql);
                    while ($row_main = mysqli_fetch_assoc($result)) {
                        $id = $row_main['id'];
                        $paid = $row_main['paid'];
                        $date = $row_main['payment_date'];
                        $timestamp = date("d-m-Y", strtotime($date));
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>                       
                            <td><?php echo date('d-m-Y', strtotime($row_main['payment_date'])); ?></td>
                            <td><center> <button type="button" onclick="openmodel(<?php echo $row_main['inwardno']; ?>)" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></center></td>
                    <td style="text-align: center"><?php echo $row_main['paid']; ?></td>
                    <td style="text-align: center"><?php echo $row_main['payment_mode']; ?></td>
                    <!--<td><?php // echo $row_main['balance'] - $row_main['paid'];  ?></td>-->
                    <td style="text-align: center;"><?php echo $get_sbname[$row_main['sellername']] . "-" . $row_main['phoneno']; ?></td>
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
    if (isset($_POST['openmodel'])) {
        $id1 = $_POST['openmodel'];
        ?>
        <table class="w3-table-all w3-large">
            <?php
            $sql = "SELECT * FROM `inward` where inwardno=$id1 order by `id` desc";
            $result = mysqli_query($mysqli, $sql1);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $inwardno = $row['inwardno'];
                    $date = $row['date'];
                    $expences = $row['expences'];
                    $timestamp = date("Y-m-d", strtotime($date));
                    $qunty = $row['qunty'];
                    $total_amount = $row['total_amount'];
                    $total_amounte[] = $row['total_amount'];
                    $total_amount1 = $row['total_amount1'];
                    $rate = $row['rate'];
                    $voucharno = $row['voucharno'];
                    $discount = $row['discount'];
                    $amount = $row['amount'];
                    $sellername = $row['sellername'];
                    $phoneno = $row['phoneno'];
                    $address = $row['paid'];
                    $balance = $row['balance'];
                    $unit = $row['unit'];
                    $total_unit = $row['total_unit'];
//    }
                    ?>
                    <?php if ($i == 1) { ?>
                        <tr>
                            <th>Inward no:</th> <td  colspan="2"> <?php echo $row['inwardno']; ?></td>
                            <th style="text-align: right;">Date:</th><td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        </tr>
                        <tr>           
                            <th>Expenses</th>
                            <th style="text-align: center;">Unit</th>
                            <th style="text-align: center;">Total Quantity</th>
                            <th style="text-align: center;">Rate Per Unit </th>
                            <th style="text-align: right;">Amount</th>
                    <!--                    <th>Paid</th>
                            <th>Balance</th>-->
                        </tr>
                    <?php } ?>

                    <tr> 
                        <td style="text-align: center;"><?php echo $get_expences[$row['expences']]; ?></td>                   
                        <td style="text-align: center;"><?php echo $get_uname[$row['unit']]; ?></td>
                        <td style="text-align: center;"><?php echo $row['total_unit']; ?></td>
                        <td style="text-align: center;"><?php echo $row['rate']; ?></td>
                        <td style="text-align: right;"><?php echo $row['total_amount']; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr><th></th><td></td><th></th>
                    <th style="text-align: right;">Total Amount:</th>
                    <td colspan="3" style="text-align: right;"><?php echo array_sum($total_amounte); ?></td>
                </tr>
                <tr><th></th><td></td><th></th>
                    <th style="text-align: right;">Discount Amount:</th>
                    <td colspan="3" style="text-align: right;"><?php echo $discount; ?></td>
                </tr>
                <tr><th></th><td></td><th></th>
                    <th style="text-align: right;">Payable Amount</th>
                    <td style="text-align: right;"><?php echo $balance; ?>
                </tr>
                <?php ?>
            </table>  <?php
        }
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Milk Management-Amountissue Report</title>
            <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
            <?php include_once 'include/headtag.php'; ?>
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
        </head>
        <body class="menubar-hoverable header-fixed ">
            <?php include_once 'include/header.php'; ?>
            <div id="base">
                <div class="offcanvas">  </div>
                <div id="content">
                    <section>
                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class=" col-md-12 col-sm-12">
                                    <div class="card">
                                        <form class="form form-validate" role="form" method="POST">                                         
                                            <div class="card-body">
                                                <div class="row god">
                                                    <div class="form-group col-md-4">
                                                        <div class="input-daterange input-group" >
                                                            <div class="input-group-content">
                                                                <label>Date Range</label>
                                                                <input type="text" class="form-control" id="reportrange" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 god">                                                       
                                                        <center>Seller Name</center>
                                                        <select id="seller_change" class="form-control" name="seller_id" tabindex="1" >
                                                            <option value="">-- Please Select Seller --</option>
                                                            <?php
                                                            $sql = "select * from seller";
                                                            $res = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                ?>                                                   
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['phoneno']; ?></option>  
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                            </div>
                        </div>                               

                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class=" col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-head style-primary">
                                            <header>Amount Issue Report</header>
                                        </div>
                                        <div class="card-body">
                                            <div id="FromToBalanceResult" class="tbgetsect table-responsive">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th>S.No</th>
                                                            <th>Date</th>
                                                            <th style="text-align: left">Product Details</th>
                                                            <th style="text-align: center">Paid Amount</th>
                                                            <th style="text-align: center">Payment Mode</th>
                                                            <!--<th>Balance</th>-->
                                                            <th style="text-align: center">Seller Name & Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "SELECT o.*,i.* from inward i CROSS JOIN outcome o on i.inwardno=o.inwardno group by o.inwardno order by o.outcome_id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row_main = mysqli_fetch_assoc($result)) {
                                                            $id = $row_main['id'];
                                                            $paid = $row_main['paid'];
                                                            $date = $row_main['payment_date'];
                                                            $timestamp = date("d-m-Y", strtotime($date));
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>                       
                                                                <td><?php echo date('d-m-Y', strtotime($row_main['payment_date'])); ?></td>
                                                                <td><center> <button type="button" onclick="openmodel(<?php echo $row_main['inwardno']; ?>)" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></center></td>
                                                        <td style="text-align: center"><?php echo $row_main['paid']; ?></td>
                                                        <td style="text-align: center"><?php echo $row_main['payment_mode']; ?></td>
                                                        <!--<td><?php // echo $row_main['balance'] - $row_main['paid'];  ?></td>-->
                                                        <td style="text-align: left"><?php echo $get_sbname[$row_main['sellername']] . "-" . $row_main['phoneno']; ?></td>
                                                        </tr> 
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="modal fade" id="mymodal" role="dialog" >
                <div class="modal-dialog modal-lg" style="min-width:100%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Inward Product Details</h4>
                        </div>
                        <div class="modal-body" id="openmodel1">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once 'include/menubar.php'; ?>
            <?php include_once 'include/jsfiles.php'; ?>
            <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
            <script>
                        $(document).on('change', '.god', function (e) {
                            var seller_id = $("option:selected").val();
                            var date = $("#reportrange").val();
                            $.post('amountissuereport.php', {
                                seller_id: seller_id,
                                FromToBalanceResult: date,
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
                        $('#reportrange').daterangepicker({
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            },
                            startDate: moment().subtract(29, 'days'),
                            endDate: moment()
                        },
                                function (start, end) {
                                    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                                    });
                                });
            </script>
            <script>
                function openmodel(inwardno) {
                    $.post("amountissuereport.php", {openmodel: inwardno}, function (data) {
                        console.log();
                        $("#mymodal").modal("show");
                        $('#openmodel1').html(data);
                    });
                }
            </script>
        </body>
    </html>
