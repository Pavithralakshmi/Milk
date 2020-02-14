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

$sql31 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['breedtype'];
    // echo  $get_productname[$row['breedtype']];exit;
}
$sql11 = "SELECT `id`, `name`, `breedtype` FROM `cowreg`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $get_productname[$row['breedtype']] . " - " . $row['name'];
// echo $get_cowtype[$row['name']];exit;
}

$sqlv1 = "SELECT `id`, `cowcolor` FROM `cowcolor`";
$result = mysqli_query($mysqli, $sqlv1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowcolor[$row['id']] = $row['cowcolor'];
// echo $get_cowcolor[$row['cowcolor']];exit;
}

if ((isset($_POST['From']))) {
    $From = str_replace('/', '-', $_POST['From']);
    $From = date("Y-m-d", strtotime($From));
    $To = str_replace('/', '-', $_POST['To']);
    $To = date("Y-m-d", strtotime($To));
    ?>
    <div id="regwise_select" class="tbgetsect">
        <table id="datatable1" class="table diagnosis_list">
            <thead>
                <tr>                                    
                    <th style="text-align: center;">S.No</th>
                    <th style="text-align: center;">Date</th>
                    <th style="text-align: center;">Cattle Details</th>
                    <th style="text-align: right;">Amount</th>
                    <th style="text-align: right;">Paid</th>
                    <th style="text-align: center;">Buyer Name</th>
                    <th style="text-align: center;">Buyer Contact Number</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "SELECT  group_concat(`c`.`id`) as `id`,`c`.`name`, group_concat(`c`.`cowcode`) as `cowcode`,`c`.`breedtype`,`cs`.`sold_cowname`,`cs`.`date`,sum(`cs`.`total_amount`) as total_amount,sum(`cs`.`paid`) as paid,`cs`.`sellername`,`by`.`name`,`by`.`phoneno`, `by`.`address` from `cowreg` c cross join `cowsell` cs cross join `buyer` `by` on `by`.`id`=`cs`.`sellername` AND `c`.`id` = `cs`.`sold_cowname` where (`cs`.`date` BETWEEN '$From' AND '$To') group by `date` ";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row_main['date'])); ?></td>
                        <td style="text-align: center;width: 10%"> <button type="button" onclick="openmodel('<?php echo $row_main['id']; ?>', '<?PHP echo $DATTS; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row_main['total_amount']); ?></td>
                        <td style="text-align: right;"><?php echo sprintf('%0.2f', $row_main['paid']); ?></td>
                        <td style="text-align: center;"><?php echo $row_main['name']; ?></td>
                        <td style="text-align: center;"><?php echo $row_main['phoneno']; ?></td>
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
    <table  class="table diagnosis_list" id="datatable31">
        <?php
        $sql = "SELECT * FROM `cowreg` where `id`IN ($id1) order by `id` desc";
        $result = mysqli_query($mysqli, $sql);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $cow_name = $row['name'];
                $cowcode = $row['cowcode'];
                $cowcolor = $row['cowcolor'];
                $gender = $row['gender'];
                $cowtype = $row['cowtype'];
                $breedtype = $row['breedtype'];
                $dob = $row['dob'];
                $timestamp = date("d-m-Y", strtotime($dob));
                $bdob = $row['bdob'];
                $timestamp2 = date("d-m-Y", strtotime($bdob));
                $father = $row['father'];
                $mother = $row['mother'];
                $ml = $row['ml'];
                $el = $row['el'];
                $sold = $row['sold'];
                $solddate = $row['solddate'];
                $timestamp3 = date("d-m-Y", strtotime($solddate));
                $greg = $row['greg'];
                $g_reg = $row['g_reg'];
                $age = $row['age'];
                $teeth = $row['teeth'];
                $remark = $row['remark'];
                $amount = $row['amount'];
                $active = $row['active'];
                ?>
                <?php if ($i == 1) { ?>
                    <tr>           
                        <th style="text-align: center;">Cattle Type / Breed</th>
                        <th style="text-align: center;">Cattle Name</th>
                        <th style="text-align: center;">Cattle Color</th>
                        <th style="text-align: center;">Govt.No </th>
                        <th style="text-align: center;">Remark</th>
                    </tr>
                <?php } ?>

                <tr> 
                    <td style="text-align: center;"><?php echo $get_cowtype[$row['cowtype']] . "  " . $get_breedtype[$row['breedtype']]; ?></td>                   
                    <td style="text-align: center;"><?php echo $row['name']; ?></td>
                    <td style="text-align: center;"><?php echo $get_cowcolor[$row['cowcolor']]; ?></td>
                    <td style="text-align: center;"><?php echo $row['greg']; ?></td>
                    <td style="text-align: center;"><?php echo $row['remark']; ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <?php ?>
        </table>  <?php
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management-Cattlesell Report</title>
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
                                            <div class="form-group col-md-6 col-lg-offset-3 ">
                                                <div class="input-daterange input-group" >
                                                    <div class="input-group-content">
                                                        <label>Date Range</label>
                                                        <input type="text" class="form-control" id="reportrange" autocomplete="off" />
                                                    </div>
                                                </div>
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
                                    <header>Cattlesell Report</header>
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
                        <h4 class="modal-title">Cattle Details</h4>
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
                        var date = $("#reportrange").val();
                        var daterange_split = date.split("-");
                        var start_date = daterange_split[0];
                        var to_date = daterange_split[1];
                        $.post('cowsellreport.php', {
                            From: start_date,
                            To: to_date,
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
            function openmodel(cowcode, dates) {
                $.post("cowsellreport.php", {openmodel: cowcode, dates: dates}, function (data) {
                    console.log(data);
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



