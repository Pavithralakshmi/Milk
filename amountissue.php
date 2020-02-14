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

$sql11 = "SELECT `id`, `cowtype` FROM `cowtype`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $row['cowtype'];
// echo $get_cowtype[$row['cowtype']];exit;
}
$sql1 = "SELECT `id`, `breedtype`,`cowtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $get_cowtype[$row['cowtype']] . "-" . $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}
$sqlc2 = "SELECT `id`, `milktype1` FROM `milktype1`";
$result = mysqli_query($mysqli, $sqlc2);
while ($row = mysqli_fetch_assoc($result)) {
    $get_mname[$row['id']] = $row['milktype1'];
    // echo $get_bname[$row['milktype']];exit;
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

    if ((isset($_POST['From'])) || (isset($_POST['seller_id']))) {
    $seller_id = $_POST['seller_id'];
    $From = str_replace('/', '-', $_POST['From']);
    $From = date("Y-m-d", strtotime($From));
    $To = str_replace('/', '-', $_POST['To']);
    $To = date("Y-m-d", strtotime($To));
    if ($seller_id) {
        $sell = " and `sellername`=" . $seller_id;
    } else {
        $sell = "and 1";
    }
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th style="text-align: center">S.No</th>
                    <th style="text-align: center">Date</th>
                    <th style="text-align: center">Inward no</th>
                    <th style="text-align: right;">Amount</th>
                    <th style="text-align: right;">Paid</th>
                    <th style="text-align: center;">Payment Details </th>
                    <th style="text-align: center">Seller Name </th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "SELECT * FROM `inward` where (`date` BETWEEN '$From' AND '$To' ) $sell AND `paid`!='0' group by `inwardno`";
//                echo $sql;exit;
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
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo $i; ?></td>                       
                        <td style="text-align: center"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <td style="text-align: center;"><?php echo $row['inwardno']; ?></td>                   
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $balance); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                        <td style="text-align: center"><center> <button type="button" onclick="openmodel('<?php echo $row['sellername']; ?>', '<?php echo $row['inwardno']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></center></td>
                <td style="text-align: center;"><?php echo $get_sbname[$row['sellername']]; ?></td>
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
    $inwardno = $_POST['inwardno'];
    ?>
    <table class="w3-table-all w3-large">
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "SELECT DISTINCT o.seller_id,o.payment_date,o.paid,o.balance,o.amount,o.payment_mode,i.sellername,`se`.`name`,`se`.`phoneno`,`se`.`address` from inward i CROSS JOIN outcome o CROSS JOIN seller se  on i.sellername=o.seller_id And  i.sellername= se.id where o.seller_id=$id1 AND o.inwardno=$inwardno";
            $result = mysqli_query($mysqli, $sql);
            while ($row_main = mysqli_fetch_assoc($result)) {
                $paid = $row_main['paid'];
                $date = $row_main['payment_date'];
                $timestamp = date("d-m-Y", strtotime($date));
                if ($i == 1) {
                    ?>
                    <tr>
                        <th style="text-align: left;width:4.5cm;">Seller Name:</th> <td  colspan="2"> <?php echo $get_sbname[$row_main['sellername']]; ?></td>
                        <th style="text-align: right;">Phone No:</th><td><?php echo $row_main['phoneno']; ?></td>
                    </tr>
                    <tr>                                    
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: right;">Payable Amount</th>
                        <th style="text-align: right;">Paid Amount</th>
                        <th style="text-align: center;">Payment Mode</th>
                        <th style="text-align: right;">Balance</th>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($row_main['payment_date'])); ?></td>
                    <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['amount']); ?></td>
                    <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['paid']); ?></td>
                    <td style="text-align: center"><?php echo $row_main['payment_mode']; ?></td>
                    <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['balance']); ?></td>
                </tr> 
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
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
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row daterangeclass god">
                                            <div class="form-group col-md-6 ">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="section-body contain-lg">
                        <div class=" col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-head style-primary">
                                    <header>Amountissue Report</header>
                                </div>
                                <div class="card-body">
                                    <div id="FromTo" class="tbgetsect">
                                        <table id="datatable1" class="table diagnosis_list">

                                        </table>
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
                        <h4 class="modal-title">Payment Details</h4>
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
                            $(function () {
                                var start = moment().subtract(6, 'days');
                                var end = moment();
                                function cb(start, end) {
                                    $('#reportrange').val(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
                                }
                                $('#reportrange').daterangepicker({
                                    startDate: start,
                                    endDate: end,
                                    locale: {
                                        format: 'D/MM/YYYY'
                                    },
                                    ranges: {
                                        'Today': [moment(), moment()],
                                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                    }
                                }, cb);
                                cb(start, end);
                            })

                            $(document).on('change', '.daterangeclass', '.god', function (e) {
                                  var seller_id = $("option:selected").val();
                                var date = $("#reportrange").val();
                                var daterange_split = date.split("-");
                                var start_date = daterange_split[0];
                                var to_date = daterange_split[1];
                                $.post('amountissue.php', {
                                    From: start_date,
                                    To: to_date,
                                    seller_id: seller_id,
                                }, function (data, status) {
                                    console.log(data);
                                    $('#FromTo').html(data);
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
        </script>
        <script>
            function openmodel(seller_id, inwardno) {
                $.post("amountissue.php", {openmodel: seller_id, inwardno: inwardno}, function (data) {
                    console.log();
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
        </script>
    </body>
</html>
