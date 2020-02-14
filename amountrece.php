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

if ((isset($_POST['From']))) {
    $buyer_id=$_POST['buyer_id'];
    $From = str_replace('/', '-', $_POST['From']);
    $From = date("Y-m-d", strtotime($From));
    $To = str_replace('/', '-', $_POST['To']);
    $To = date("Y-m-d", strtotime($To));
    if ($buyer_id) {
        $sell = " and `sellername`=" . $buyer_id;
    } else {
        $sell = "and 1";
    }
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th style="text-align: center;">Date</th>
                    <th style="text-align: center;">Payment Details</th>
                    <th style="text-align: center;">Product</th>
                    <th style="text-align: right;">Payable Amount</th>
                    <th style="text-align: right;">Paid </th>
                    <th style="text-align: center;">Buyer Name</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "(select  'cs' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`product` as `product`, `paid` as `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername` from cowsell where `date` BETWEEN '$From' AND '$To' $sell and `paid`!='0'  ) UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `total_amount`,`breedtype` as product, `paid`,(`total_amount`- `paid`) as `balance`,`date`,`sellername` from milksell where `date` BETWEEN '$FromToBalanceResultFrom' AND '$FromToBalanceResultTo' $sell and `paid`!='0' ORDER BY `date` DESC)";
                $result = mysqli_query($mysqli, $sql);
                while ($row2 = mysqli_fetch_assoc($result)) {
                    $product_name = $row2['product'];
                    $product_name = $row2['product'];
                    if ($row2['action'] == 'cs') {
                        $productname = $row2['product'];
                        $date = $row2['date'];
                        $cowsell_id1 = $row2['id'];
                        $milksell_id1 = "";
                    } else {
                        $productname = $get_productname[$row2['product']] . " " . "Milk";
                        $date = $row2['date'];
                        $milksell_id1 = $row2['id'];
                        $cowsell_id1 = "";
                    }
                    ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($row2['date'])); ?></td>
                        <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row2['sellername']; ?>', '<?php echo $cowsell_id1; ?>', '<?php echo $milksell_id1; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                        <td style="text-align: center;"><?php echo $productname; ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['total_amount']); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['paid']); ?></td>
                        <td style="text-align: right"><?php echo $get_bname[$row2['sellername']]; ?></td>
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
    $cowsell_id = $_POST['cowsell_id'];
    $milksell_id = $_POST['milksell_id'];
    if ($cowsell_id) {
        $sell = " and `cowsell_id`=" . $cowsell_id;
    } else {
        $sell = " and `milksell_id`=" . $milksell_id;
    }
    ?>
    <table class="table diagnosis_list" id="datatable31">
        <?php
        $cowtab = "select `a`.`income_id`,`a`. `buyer_id`, `a`.`product`,`a`. `amount`, `a`.`paid`, `a`.`balance`, `a`.`remarks`, `a`.`payment_date`,`a`. `payment_mode`,`se`.`name`,`se`.`phoneno`,`se`.`address` FROM `income` `a` cross join `buyer` `se` on `se`.`id`=`a`.`buyer_id` WHERE `a`.`buyer_id`='$id1' $sell";
        $rescow = mysqli_query($mysqli, $cowtab);
        $i = 1;
        ?>

        <?PHP
        while ($row2 = mysqli_fetch_assoc($rescow)) {

            if ($i == 1) {
                ?>
                <tr>
                    <th style="width:3.5cm;">Buyer Name:</th> <td  colspan="2"> <?php echo $row2['name']; ?></td>
                    <th style="text-align: right;">Phone No:</th><td><?php echo $row2['phoneno']; ?></td>
                </tr>
                <tr>                                    
                    <th style="text-align: center;">Date</th>
                    <th style="text-align: right;">Payable Amount</th>
                    <th style="text-align: right;">Paid Amount</th>
                    <th style="text-align: right;">Payment Mode</th>
                    <th style="text-align: right;">Balance</th>
                </tr>
            <?php } ?>
            <tr> 
                <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row2['payment_date'])); ?></td>                  
                <td style="text-align: right;"><?php
                    if ($row2['amount'] == 0) {
                        echo sprintf('%0.2f', $row2['amount']) + $row2['paid'];
                    } ELSE {
                        ECHO sprintf('%0.2f', $row2['amount']);
                    }
                    ?></td>
                <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['paid']); ?></td>
                <td style="text-align: right;"><?php echo $row2['payment_mode']; ?></td>
                <td style="text-align: right;"><?php echo sprintf('%0.2f', $row2['balance']); ?></td>
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
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row daterangeclass">
                                            <div class="form-group col-md-6 ">
                                                <div class="input-daterange input-group" >
                                                    <div class="input-group-content">
                                                        <label>Date Range</label>
                                                        <input type="text" class="form-control" id="reportrange" autocomplete="off" />
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
                        <h4 class="modal-title"> Payment Details</h4>
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

                            $(document).on('change', '.daterangeclass', function (e) {
                                var buyer_id = $("#seller_change").val();
                                var date = $("#reportrange").val();
                                var daterange_split = date.split("-");
                                var start_date = daterange_split[0];
                                var to_date = daterange_split[1];
                                $.post('amountrece.php', {
                                    From: start_date,
                                    To: to_date,
                                    buyer_id: buyer_id,
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
            function openmodel(buyerid, cowsell_id, milksell_id) {
                $.post("amountrece.php", {openmodel: buyerid, cowsell_id: cowsell_id, milksell_id: milksell_id}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
        </script>
    </body>
</html>
