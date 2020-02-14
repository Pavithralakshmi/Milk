<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $msg = $product_name = $timestamp = $paid = $total_amount1 = $total_amount2 = $rate = $voucharno = $discount = $amount = $sellername = $phoneno = $address = $balance = $breedtype = $total_unit = "";
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
$sql1 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
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
if ((isset($_POST['buyer_id']))) {
    $buyer_id = $_POST['buyer_id'];
    if ($buyer_id) {
        $sell = " and `buyer_id`=" . $buyer_id;
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
                        <th style="text-align: center">Date</th>
                        <th style="text-align: center">Product Details</th>
                        <th style="text-align: right"> Payable Amount</th>
                        <th style="text-align: right">Paid Amount</th>
                        <th style="text-align: right">Balance Amount</th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" >
                    <?php
                    $i = 1;
//                    $sql = "(select  'cs' as `action` , `id`, `sellername`,sum(`total_amount`) as `total_amount`,`product`, `paid`,`date`, `sellername` from cowsell where `sellername`='$buyer_id' group by date) UNION (select 'ms' as `action` ,`id`, `sellername`,sum(`total_amount`) as `total_amount`,`breedtype` as product, `paid`,`date`, `sellername` from milksell where `sellername`='$buyer_id' group by date ORDER BY `id` DESC);";
                    $sql = "select sum(`total_amount`) as `total_amount`,date,sum(`paid`) as `paid`,sellername from ((select sum(c.`total_amount`) as `total_amount`,c.`date`,sum(c.`paid`) as `paid`,c.`sellername` from cowsell c where c.`sellername`='$buyer_id' group by c.sellername ) UNION (select sum(c.`total_amount`) as `total_amount`,c.`date`,sum(c.`paid`) as `paid`,c.`sellername` from milksell c where c.`sellername`='$buyer_id' group by c.sellername ORDER BY c.`date` DESC))c group by c.`date`";
                    $result = mysqli_query($mysqli, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $balance = $row['total_amount'] - $row['paid'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>                       
                            <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>                   
                            <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row['sellername']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                            <td style="text-align: right"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                            <td style="text-align: right"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                            <td style="text-align: right"><?php echo sprintf('%0.2f',$balance); ?></td>
                            <?php
                            $i++;
                        }
                        ?>
                    </tr> 
                </tbody>
            </table>
        </div>
        <?php
        exit;
    }
    if (isset($_POST['openmodel'])) {
        $id1 = $_POST['openmodel'];
        ?>
        <table class="table diagnosis_list" id="datatable31">
            <?php
            $sql = "(select  'cs' as `action` ,`csm`.`id`, `csm`.`sellername`,`csm`.`total_amount` as `total_amount`,`csm`.`product` as `product`, `csm`.`paid` as `paid`,(`csm`.`total_amount`- `csm`.`paid`) as `balance`,`csm`.`date`,`csm`.`sellername`,`se`.`name`,`se`.`phoneno`,`se`.`address` from `cowsell` `csm`  cross join `buyer` `se` on `se`.`id`=`csm`.`sellername` where `csm`.`sellername`='$id1' ) UNION (select 'ms' as `action` ,`msm`.`id`,`msm`. `sellername`,`msm`.`total_amount` as `total_amount`,`msm`.`breedtype` as product,`msm`. `paid`,(`msm`.`total_amount`- `msm`.`paid`) as `balance`,`msm`.`date`,`msm`.`sellername`,`se`.`name`,`se`.`phoneno`,`se`.`address`  from `milksell` `msm` cross join `buyer` `se` on `se`.`id`=`msm`.`sellername` where `msm`.`sellername`='$id1' ORDER BY `date` DESC)";
            $result = mysqli_query($mysqli, $sql);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_name = $row['product'];
                    if ($row['action'] == 'cs') {
                        $productname = $row['product'];
                        $date = $row['date'];
                    } else {
                        $productname = $get_breedtype[$row['product']] . " " . "Milk";
                        $date = $row['date'];
                    }
                    $timestamp = date("Y-m-d", strtotime($date));
                    $paid = $row['paid'];
                    $paid1[] = $row['paid'];
                    $total_amount[] = $row['total_amount'];
                    $total_amount2 = $row['total_amount'];
                    $sellername = $row['sellername'];
                    $phoneno = $row['phoneno'];
                    $address = $row['paid'];
                    $balance = $row['balance'];
                    $balance1[] = $row['balance'];
                    ?>
                    <?php if ($i == 1) { ?>
                        <tr>
                            <th style="width:3cm;">Buyer Name:</th> <td  colspan="2"> <?php echo $row['name']; ?></td>
                            <th style="text-align: right;">Phone No:</th><td><?php echo $row['phoneno']; ?></td>
                        </tr>
                        <tr>           
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Product (or) Milk</th>
                            <th style="text-align: right;">Payable Amount</th>
                            <th style="text-align: right;">Paid </th>
                            <th style="text-align: right;">Balance</th>
                        </tr>
                    <?php } ?>
                    <tr> 
                        <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>                   
                        <td style="text-align: center;"><?php echo $productname; ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $total_amount2); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $paid); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $balance); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: right;"> Total :</th>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', array_sum($total_amount)); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', array_sum($paid1)); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', array_sum($balance1)); ?></td>
                    </tr>
                </tfoot>
            </table>
            <?php
        }
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Milk Management-Ledger Report</title>
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
                                                <div class="row der">
                                                    <div class="form-group col-md-4 col-lg-offset-4">                                                       
                                                        <center>Buyer Name</center>
                                                        <select id="seller_change" class="form-control" name="buyer_id" tabindex="1" >
                                                            <option value="">-- Please Select Buyer --</option>
                                                            <?php
                                                            $sql = "select * from buyer";
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
                                            <header>Buyer Ledger Report</header>
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
                </div>
            </div>
            <div class="modal fade" id="mymodal" role="dialog" >
                <div class="modal-dialog modal-lg" style="min-width:100%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Product Details</h4>
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
                                $(document).on('change', '.der', function (e) {
                                    var seller_id = $("option:selected").val();
                                    $.post('ledger.php', {
                                        buyer_id: seller_id,
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
                function openmodel(buyerid) {
                    $.post("ledger.php", {openmodel: buyerid}, function (data) {
                        $("#mymodal").modal("show");
                        $('#openmodel1').html(data);
                        $('#datatable31').DataTable({
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
                }
            </script>
        </body>
    </html>
