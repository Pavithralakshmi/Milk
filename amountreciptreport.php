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
$sql1 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}
$sql31 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['breedtype'];
    // echo $get_cn3ame[$row['cowtype']];exit;
}

if ((isset($_POST['FromToBalanceResult'])) || (isset($_POST['seller_id']))) {
    $FromToBalanceResult = explode(" - ", $_POST['FromToBalanceResult']);
    $FromToBalanceResultFrom = date('Y-m-d', strtotime($FromToBalanceResult[0]));
    $FromToBalanceResultTo = date('Y-m-d', strtotime($FromToBalanceResult[1]));
    $seller_id = $_POST['seller_id'];
//    echo $seller_id;exit;
    if ($seller_id) {
        $sell = " and `buyer_id`=" . $seller_id;
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
                        <th style="text-align: center">Buyer Name </th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" >
                    <?php
                    $i = 1;
                    $sql = "select * from income where `payment_date` BETWEEN '$FromToBalanceResultFrom' AND '$FromToBalanceResultTo' $sell ";
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
                            <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row_main['buyer_id']; ?>', '<?php echo $row_main['payment_date']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                            <td style="text-align: center"><?php echo sprintf('%0.2f', $row_main['paid']); ?></td>
                            <td style="text-align: center"><?php echo $row_main['payment_mode']; ?></td>
                            <td style="text-align: center"><?php echo $get_bname[$row_main['buyer_id']]; ?></td>
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
        $id2 = $_POST['payment_date'];
        ?>
        <table class="table diagnosis_list" id="datatable31">
            <?php
//            $sql = "(select  'cs' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`product` as `product`, `paid` as `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername`,`phoneno` from cowsell where `sellername`='$id1' AND `paid` >0 ) UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`breedtype` as product, `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername`,`phoneno` from milksell where `sellername`='$id1'  AND `paid` >0 ORDER BY `date` DESC)";
            $intab = "Select `payment_date`,`income_id`,`cowsell_id`,`milksell_id`,`buyer_id` FROM  `income` WHERE `buyer_id`='$id1' AND `payment_date` = '$id2'";
//            echo $intab;exit;
            $resintab = mysqli_query($mysqli, $intab);
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($resintab)) {
                $cowsell_id[] = $row1['cowsell_id'];
                $milksell_id[] = $row1['milksell_id'];
            }
            $cowsell_id = implode(',', $cowsell_id);
            $milksell_id = implode(',', $milksell_id);
            $payment_date = $row1['payment_date'];
            $income_id = $row1['income_id'];

//                $cowtab = "select `id`, `sellername`,`total_amount` as `total_amount`,`product` as `product`, `paid` as `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername`,`phoneno`,`date` from cowsell where id IN($cowsell_id)";
            $cowtab = "(select  'cs' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`product` as `product`, `paid` as `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername`,`phoneno` from cowsell where `id`IN($cowsell_id) ) UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`breedtype` as product, `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername`,`phoneno` from milksell where `id` IN ($milksell_id) ORDER BY `date` DESC)";
            $rescow = mysqli_query($mysqli, $cowtab);
            $i = 1;
            ?>

            <?PHP
            while ($row2 = mysqli_fetch_assoc($rescow)) {
                $product_name = $row2['product'];
                  $product_name = $row2['product'];
                        if ($row2['action'] == 'cs') {
                            $productname = $row2['product'];
                            $date = $row2['date'];
                        } else {
                            $productname = $get_productname[$row2['product']] . " " . "Milk";
                            $date = $row2['date'];
                        }
                $balance = $row2['total_amount'] - $row2['paid'];
                if ($i == 1) {
                    ?>
                    <tr>
                        <th style="width:3cm;">Buyer Name:</th> <td  colspan="2"> <?php echo $get_bname[$row2['sellername']]; ?></td>
                        <th style="text-align: right;">Phone No:</th><td><?php echo $row2['phoneno']; ?></td>
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
                    <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($row2['date'])); ?></td>                   
                    <td style="text-align: center;"><?php echo $productname; ?></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['total_amount']); ?></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['paid']); ?></td>
                    <td style="text-align: right;"><?php
                        if ($balance != 0) {
                            echo sprintf('%0.2f', $balance);
                        } else {
                            echo "-";
                        };
                        ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
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
                <div class="offcanvas">  </div>
                <div id="content">
                    <section>
                        <div class="section-body contain-lg">
                            <div class="row">
                                <div class=" col-md-12 col-sm-12">
                                    <div class="card">
                                        <form class="form form-validate" role="form" method="POST">                                         
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="form-group col-md-4">
                                                        <div class="input-daterange input-group" >
                                                            <div class="input-group-content god">
                                                                <label>Date Range</label>
                                                                <input type="text" class="form-control "  id="reportrange" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 ">                                                       
                                                        <center>Buyer Name</center>
                                                        <select id="seller_change" class="form-control god" name="seller_id" tabindex="1" >
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
                                            <header>Amount Receipt Report</header>
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
                                                            <th>Balance</th>
                                                            <th style="text-align: center">Buyer Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select * from income order by income_id DESC";
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
                                                                <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row_main['buyer_id']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                                                                <td><?php echo sprintf('%0.2f', $row_main['paid']); ?></td>
                                                                <td style="text-align: center"><?php echo $row_main['payment_mode']; ?></td>
                                                                <td><?php echo sprintf('%0.2f', $row_main['balance'] - $row_main['paid']); ?></td>
                                                                <td style="text-align: center"><?php echo $get_bname[$row_main['buyer_id']]; ?></td>
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
            <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
            <script>
                                                                $(document).on('change', '.god', function (e) {
                                                                    var seller_id = $("option:selected").val();
                                                                    var date = $("#reportrange").val();
                                                                    $.post('amountreciptreport.php', {
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
                function openmodel(buyerid, payment_date) {
                    $.post("amountreciptreport.php", {openmodel: buyerid, payment_date: payment_date}, function (data) {
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
