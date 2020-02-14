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

$sqlc1 = "SELECT `id`, `name` FROM `seller`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_bname[$row['id']] = $row['name'];
    // echo $get_bname[$row['name']];exit;
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
                    <th style="text-align: center">Inward_No</th>
                    <th style="text-align: center">Product_Details</th>
                    <th style="text-align: right">Total_Amount</th>
                    <th style="text-align: right">Discount_Amount</th>
                    <th style="text-align: right">Payable_Amount</th>
                    <th style="text-align: center">Seller_Name</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "select * from inward where (`date` BETWEEN '$From' AND '$To') $sell group by `inwardno`";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    $inwardno = $row_main['inwardno'];
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row_main['date'])); ?></td>
                        <td style="text-align: center"><?php echo $row_main['inwardno']; ?></td>
                        <td style="text-align:center"> <button type="button" onclick="openmodel('<?php echo $inwardno; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                        <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['total_amount1']); ?></td>
                        <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['discount']); ?></td>
                        <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['balance']); ?></td>
                        <td style="text-align: left"><?php echo $get_bname[$row_main['sellername']]; ?></td>
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
        $sql = "SELECT `in`.*,`se`.`name`,`se`.`phoneno`,`se`.`address` FROM `inward` `in` cross join `seller` `se` on `se`.`id`=`in`.`sellername`  where inwardno=$id1 order by `id` desc";
        $result = mysqli_query($mysqli, $sql);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $inwardno = $row['inwardno'];
                $expences = $row['expences'];
                $date = $row['date'];
                $timestamp = date("Y-m-d", strtotime($date));
                $qunty = $row['qunty'];
                $total_amount = $row['total_amount'];
                $total_amount1 = $row['total_amount1'];
                $rate = $row['rate'];
                $voucharno = $row['voucharno'];
                $discount = $row['discount'];
                $amount = $row['amount'];
                $sellername = $row['sellername'];
                $phoneno = $row['phoneno'];
                $address = $row['address'];
                $balance = $row['balance'];
                $unit = $row['unit'];
                $total_unit = $row['total_unit'];
                $remark = $row['remark'];
                ?>
                <?php if ($i == 1) { ?>
                    <tr>
                        <th> Inward no :</th><td><?php echo $row['inwardno']; ?></td>
                        <th style="text-align:right"> Seller :</th><td style="text-align:left"><?php echo $row['name']; ?></td>
                        <th style="text-align:right"> Phone No :</th><td style="text-align:left"><?php echo $row['phoneno']; ?></td>
                    </tr>
                    <tr>
                        <th> Date :</th><td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <th style="text-align:right"> Address :</th><td colspan="3"><?php echo $row['address']; ?> </td>
                    </tr>
                    <tr>
                        <th>S.NO</th>
                        <th>Expenses</th>
                        <th style="text-align:right">Unit</th>
                        <th style="text-align:right">Total Unit</th>
                        <th style="text-align:right">Rate per Unit </th>
                        <th style="text-align:right">Amount</th>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align:left"><?php echo $i; ?></td>
                    <td><?php echo $get_expences[$row['expences']]; ?></td>
                    <td style="text-align:right"><?php echo $get_uname[$row['unit']]; ?></td>
                    <td style="text-align:right"><?php echo $row['total_unit']; ?></td>
                    <td style="text-align:right"><?php echo sprintf('%0.2f', $row['rate']); ?></td>
                    <td style="text-align:right"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Total Amount:</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $total_amount1); ?></td>
            </tr>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Discount Amount:</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $discount); ?></td>
            </tr>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Payable Amount</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $balance); ?>
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
        <title>Milk Management-Purchase Report</title>
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
                                        <div class="row daterangeclass cde">
                                            <div class="form-group col-md-6 ">
                                                <div class="input-daterange input-group" >
                                                    <div class="input-group-content">
                                                        <label>Date Range</label>
                                                        <input type="text" class="form-control" id="reportrange" autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 cde">                                                       
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
                  <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Purchase Report</header>
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
                    </div>
            </div>
        </div>

        <div class="modal fade" id="mymodal" role="dialog" >
            <div class="modal-dialog modal-lg" style="min-width:100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Purchase Product Details</h4>
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

                            $(document).on('change', '.daterangeclass', '.cde', function (e) {
                                var seller_id = $("option:selected").val();
                                var date = $("#reportrange").val();
                                var daterange_split = date.split("-");
                                var start_date = daterange_split[0];
                                var to_date = daterange_split[1];
                                $.post('inwardreport.php', {
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
            function openmodel(inwardno) {
                $.post("inwardreport.php", {openmodel: inwardno}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
        </script>
    </body>
</html>
