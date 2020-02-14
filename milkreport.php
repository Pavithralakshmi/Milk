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
                   <th>S.No</th>
                    <th>Date</th>
                    <th>Milk Entry(in liter)</th>
                    <th>Sale Milk(in liter)</th>
                    <th>Inhouse(in liter)</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                $sql = "SELECT `b`.`date`,`m`.`date`,sum(b.`total`) as total_sum,`m`.`total_milk` as total_milk1 from `dailymilk` b cross join `milksell` m  ON `m`.`date` = (`b`.`date`)where (`m`.`date` BETWEEN '$From' AND '$To') group by m.date";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                       <td><?php echo $i; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row_main['date'])); ?></td>
                        <td style="text-align: center;"><?php echo $row_main['total_sum']; ?></td>
                        <!--<td><?php // echo "Cow Code - " . $row_main['cowcode'] . " <br>" . "Cattel Name -" . $row_main['name'] . " <br> " . "Cattel Breed Type -" . $breedtype;     ?></td>-->
                        <td style="text-align: center;"><?php echo $row_main['total_milk1']; ?></td>
                        <td style="text-align: center;"><?php echo $row_main['total_sum'] - $row_main['total_milk1']; ?></td>
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
        <title>Milk Management-Milk Report</title>
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
                                    <header>Milk Report</header>
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
                $.post('milkreport.php', {
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
    </body>
</html>



