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
if ((isset($_POST['seller_id']))) {
    $seller_id = $_POST['seller_id'];
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
                        <th style="text-align: center">S.No</th>
                        <th style="text-align: center">Purchase Date</th>
                        <th style="text-align: center">Product</th>
                        <th style="text-align: right">Amount</th>
                        <!--<th style="text-align: center">Payment Date</th>-->
                        <th style="text-align: right">Paid</th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" >
                    <?php
                    $i = 1;
                    $sql = "select * from inward where `sellername`='$seller_id' group by inwardno";
                    $result = mysqli_query($mysqli, $sql);
                    while ($row_main = mysqli_fetch_assoc($result)) {
                        $id = $row_main['id'];
                        ?>
                        <tr>
                            <td style="text-align: center"><?php echo $i; ?></td>                       
                            <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row_main['date'])); ?></td>                   
                            <td style="text-align: center"><?php echo $get_ename[$row_main['expences']]; ?></td>
                            <td style="text-align: right"><?php echo sprintf('%0.2f', $row_main['balance']); ?></td>
                            <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row_main['sellername']; ?>','<?php echo $row_main['expences']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
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
        $exp = $_POST['exp'];
        ?>
        <table  class="table diagnosis_list" id="datatable31">
            <?php
            $sql = "SELECT `ot`.* FROM `outcome` `ot` cross join `inward` `in` on `in`.`inwardno`=`ot`.`inwardno`  where (`ot`.`seller_id`='$id1' and `in`.`expences`='$exp')";
//            echo $sql;exit;
            $result = mysqli_query($mysqli, $sql);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                 
                    ?>
                    <?php if ($i == 1) { ?>
                        <tr>           
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: right;">Payable Amount</th>
                            <th style="text-align: right;">Paid</th>
                            <th style="text-align: right;">Balance</th>
                        </tr>
                    <?php } ?>

                    <tr> 
                        <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row['payment_date'])); ?></td>                   
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['amount']); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['balance']); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
<!--                <tr><th></th><td></td><th></th>
                    <th style="text-align: right;">Discount:</th>
                    <td colspan="3" style="text-align: right;"><?php // echo $discount; ?></td>
                </tr>
                <tr><th></th><td></td><th></th>
                    <th style="text-align: right;">Total Amount</th>
                    <td style="text-align: right;"><?php // echo $balance; ?>
                                </td> <td><?php // echo $row['paid'];              ?></td>
                    <td><?php // echo $row['balance'] - $row['paid'];              ?></td>
                </tr>-->
                <?php ?>
            </table>  <?php
        }
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Milk Management-Seller Ledger Report</title>
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
                                <div class="col-md-12 col-sm-12">
                                    <div class="card">
                                        <form class="form form-validate" role="form" method="POST">                                         
                                            <div class="card-body">
                                                <div class="row grt">
                                                    <div class="form-group col-md-4 col-lg-offset-4">                                                       
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
                                            <header>Seller Ledger Report</header>
                                        </div>
                                        <div class="card-body">
                                            <div id="FromToBalanceResult" class="tbgetsect table-responsive">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="mymodal" role="dialog" >
                        <div class="modal-dialog modal-lg" style="min-width:60%;">
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
            <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
            <script>
                $(document).on('change', '.grt', function (e) {
                    var seller_id = $("option:selected").val();
                    $.post('sellerledger.php', {
                        seller_id: seller_id,
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
                            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        });
            </script>
            <script>
                function openmodel(sellerid,exp) {
                    $.post("sellerledger.php", {openmodel: sellerid,exp:exp}, function (data) {
                        console.log(data);
                        $("#mymodal").modal("show");
                        $('#openmodel1').html(data);
//                        $('#datatable31').DataTable({
//                            "dom": 'lCfrtip',
//                            "colVis": {
//                                "buttonText": "Hide",
//                                "overlayFade": 0,
//                                "align": "right"
//                            },
//                            "aLengthMenu": [
//                                [10, 25, 50, 100, -1],
//                                [10, 25, 50, 100, "All"]
//                            ],
//                            "iDisplayLength": -1
//                        });
                    });
                }
            </script>
        </body>
    </html>
