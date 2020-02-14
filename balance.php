<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$extra_order = $number_rows = 0;
$user_cart_date = array();
$id = '';
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


$sql31 = "SELECT `id`, `name` FROM `buyer`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cn3ame[$row['id']] = $row['name'];
    // echo $get_cn3ame[$row['name']];exit;
}

$sql31 = "SELECT `id`, `milktype1` FROM `milktype1`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['milktype1'];
    // echo $get_cn3ame[$row['name']];exit;
}

$sql = "SELECT `product`,`id`,`sellername` FROM `cowsell`";
$res = mysqli_query($mysqli, $sql);
while ($row1 = mysqli_fetch_array($res)) {
    $get_coname[$row1['id']] = $row1['product'];
    $get_came[$row1['id']] = $row1['sellername'];
//    echo $get_coname[$row1['sold_pname']];exit;
}

$sql31 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['breedtype'];
    // echo $get_cn3ame[$row['cowtype']];exit;
}

$sqlc1 = "SELECT `id`, `name` FROM `seller`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_bname[$row['id']] = $row['name'];
    // echo $get_bname[$row['name']];exit;
}

if (isset($_POST['Buyer_id'])) {
    $Buyer_id = $_POST['Buyer_id'];
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th style="text-align: center">S.No</th>
                    <th style="text-align: center">Buyer Name</th>
                    <th style="text-align: right">Paid Amount</th> 
                    <th style="text-align: right">Balance</th> 
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "select `action`,`sellername`,sum(`amount`) as `total`,sum(`paid`) as `paid`,sum(`balance`) as `balance`,`product`,`date` from  ( select 'cs' as `action` ,`sellername`,`total_amount` as `amount`,sum(`paid`) as paid,sum(`total_amount`-`paid`) as `balance`,`product` as product,`date` from cowsell   GROUP BY `sellername`  UNION ALL   select 'ms' as `action` ,`sellername`,`total_amount` as `amount`,sum(`paid`) as paid,sum(`total_amount`-`paid`) as `balance`,'product', `date`from milksell GROUP BY `sellername`  ) cowsell where sellername='$Buyer_id' AND balance != 0 GROUP BY `sellername`";
//               echo $sql;exit;
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr  id="<?php echo $row['id']; ?>"  >
                        <td style="text-align: center"><?php echo $i; ?></td>
                        <td style="text-align: center"><?php echo $get_cn3ame[$row['sellername']]; ?></td>
                        <td style="text-align: right"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                        <td style="text-align: right"><?php echo sprintf('%0.2f', $row['balance']); ?></td>
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
    <table class="table diagnosis_list" id="datatable31">
        <?php
        $sql = "(select  'cs' as `action` ,`in`.`id`, `in`.`sellername`,`in`.`total_amount` as `total_amount`,`in`.`product` as `product`,`in`. `paid` as `paid`,(`in`.`total_amount`- `in`.`paid`) as `balance`,`in`.`date`,`in`.`sellername`,`se`.`name`,`se`.`phoneno`,`se`.`address` from cowsell `in` cross join `buyer` `se` on `se`.`id`=`in`.`sellername` where `in`.`sellername`='$id1' ) UNION (select 'ms' as `action` ,`iny`.`id`, `iny`.`sellername`,`iny`.`total_amount` as `total_amount`,`iny`.`breedtype` as product,`iny`. `paid`,(`iny`.`total_amount`- `iny`.`paid`) as `balance`,`iny`.`date`,`iny`.`sellername`,`se`.`name`,`se`.`phoneno`,`se`.`address` from milksell`iny` cross join `buyer` `se` on `se`.`id`=`iny`.`sellername` where `iny`.`sellername`='$id1' ORDER BY `iny`.`date` DESC)";
//            echo $sql;exit;
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
                    $productname = $get_productname[$row['product']] . " " . "Milk";
                    $date = $row['date'];
                }
                $timestamp = date("Y-m-d", strtotime($date));
                $paid = $row['paid'];
                $total_amount = $row['total_amount'];
                $sellername = $row['sellername'];
                $phoneno = $row['phoneno'];
                $address = $row['paid'];
                $balance = $row['balance'];
                $balance1[] = $row['balance'];
                ?>
                <?php if ($i == 1) { ?>
                    <tr>
                        <th style="width:3cm;text-align: right;">Seller Name:</th> <td  colspan="2"> <?php echo $get_cn3ame[$row['sellername']]; ?></td>
                        <th style="text-align: right;">Phone No:</th><td><?php echo $phoneno; ?></td>
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
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $total_amount); ?></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $paid); ?></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $balance); ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr>
                <th colspan="4" style="text-align:right">Total Balance</th>
                <td  style="text-align:right"> <?php echo sprintf('%0.2f', array_sum($balance1)); ?></td>
            </tr>
        </table>
        <?php
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management  - BuyerwiseBalance</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <form class="form form-validate" role="form" method="POST">
                                    <div class="card">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-5 col-md-offset-4" >
                                                    <center>Select Buyer</center>
                                                    <select id="buyer_change" class="form-control" name="buyer_id" tabindex="1" required>
                                                        <option value="">-- Please Select Buyer --</option>
                                                        <?php
                                                        $sql = "select * from buyer";
                                                        $res = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            $id1 = $row['id'];
                                                            ?>                                                   
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['phoneno']; ?></option>  
                                                        <?php } ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Consolidated Report For Buyer</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="FromToBalanceResult" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th style="text-align: center;width: 10%">S.No</th>
                                                            <th style="text-align: center;width: 10%">Buyer Name</th>
                                                            <!--<th style="text-align: right;width: 10%">Paid Amount</th>--> 
                                                            <th style="text-align: right;width: 10%">Balance</th> 
                                                            <th style="text-align: center;width: 10%">Details</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select `action`,`sellername`,sum(`amount`) as `total`,sum(`paid`) as `paid`,sum(`balance`) as `balance`,`product`,`date` from  ( select 'cs' as `action` ,`sellername`,`total_amount` as `amount`,sum(`paid`) as paid,sum(`total_amount`-`paid`) as `balance`,`product` as product,`date` from cowsell   GROUP BY `sellername`  UNION ALL   select 'ms' as `action` ,`sellername`,`total_amount` as `amount`,sum(`paid`) as paid,sum(`total_amount`-`paid`) as `balance`,'product', `date`from milksell GROUP BY `sellername`  ) cowsell where balance != 0 GROUP BY `sellername`";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $Buyer_id = $row['sellername'];
                                                            $product_name = $row['product'];
                                                            if ($row['action'] == 'cs') {
                                                                $productname = $row['product'];
                                                                $date = $row['date'];
                                                            } else {
                                                                $productname = $get_productname[$row['product']];
                                                                $date = $row['date'];
                                                            }
                                                            ?>
                                                            <tr  id="<?php echo $row['id']; ?>"  >
                                                                <td style="text-align: center;width: 10%"><?php echo $i; ?></td>
                                                                <td style="text-align: center;width: 10%"><?php echo $get_cn3ame[$row['sellername']]; ?></td>
                                                                <!--<td style="text-align: right;width: 10%"><?php echo sprintf('%0.2f', $row['paid']); ?></td>-->
                                                                <td style="text-align: right;width: 10%"><?php echo sprintf('%0.2f', $row['balance']); ?></td>
                                                                <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel(<?php echo $Buyer_id; ?>)" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                                                            </tr>  
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
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
            </div>
        </div>
        <?php include_once 'include/menubar.php'; ?>
        <?php include_once 'include/jsfiles.php'; ?>
        <script>
            $(function () {
                $("#buyer_change").change(function (e) {
                    var buyer_id = $(this).val();
                    $.post('balance.php', {
                        Buyer_id: buyer_id,
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
        <script>
            function openmodel(buyerid) {
                $.post("balance.php", {openmodel: buyerid}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
//                    $('#datatable31').DataTable({
//                        "dom": 'lCfrtip',
//                        "colVis": {
//                            "buttonText": "Hide",
//                            "overlayFade": 0,
//                            "align": "right"
//                        },
//                        "aLengthMenu": [
//                            [10, 25, 50, 100, -1],
//                            [10, 25, 50, 100, "All"]
//                        ],
//                        "iDisplayLength": -1
//                    });
                });
            }
        </script>
    </body>
</html>