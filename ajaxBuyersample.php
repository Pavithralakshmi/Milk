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

if (isset($_POST['Buyer_id'])) {
    $Buyer_id = $_POST['Buyer_id'];
//    echo $Buyer_id;
//    exit;
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th>SlNo</th>
                    <th>Date</th>
                    <th>Milk/Product/Cow</th>
                    <th>Paid Amount</th>
                    <th>Payment Mode</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "select * from income order by payment_date DESC";
//                echo $sql;
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
                        <td><?php echo $row_main['product']; ?></td>
                        <td><?php echo $row_main['paid']; ?></td>
                        <td><?php echo $row_main['payment_mode']; ?></td>
                        <td><?php echo $row_main['remarks']; ?></td>
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
        <title>Milk Management-Amountreceipt Report</title>
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
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <form class="form form-validate" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Amount Receipt Report</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <center>Select Buyer <sup style="color:red;">*</sup></center>
                                                                <select id="buyer_change" class="form-control" name="buyer_id" tabindex="1" required>
                                                                    <option value="">-- Please select Buyer --</option>
                                                                    <?php
                                                                    $sql = "select * from buyer";
                                                                    $res = mysqli_query($mysqli, $sql);
                                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                                        ?>                                                   
                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['phoneno']; ?></option>  
                                                                    <?php } ?>
                                                                </select> 
                                                                <div class="col-md-4"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Amount Recipt Report</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="FromToBalanceResult" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
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
                $("#buyer_change").change(function (e) {
//                     alert ($(this).val());
                    var buyer_id = $(this).val();
                    $.post('amountreciptreport.php', {
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
    </body>
</html>





