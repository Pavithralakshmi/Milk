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
                      <th style="text-align: center">S.No</th>
                    <th style="text-align: center">Date</th>
                    <th style="text-align: left">Milk Type</th>
                    <th style="text-align: right">Total Liter</th>
                    <th style="text-align: center">Remark</th>
                </tr>
            </thead>
            <tbody class="ui-sortable" >
                <?php
                $i = 1;
                 $sql = "SELECT breedtype, SUM(`total_milk`),date,total_milk,remark FROM `milksell` where( `date` BETWEEN '$From' AND '$To' )GROUP BY `breedtype` ORDER BY `date` ASC";
                $result = mysqli_query($mysqli, $sql);
                while ($row_main = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                          <td style="text-align: center"><?php echo $i; ?></td>
                        <td style="text-align: center"><?php echo date('d-m-Y', strtotime($row_main['date'])); ?></td>                   
                        <td style="text-align: left"><?php echo $get_breedtype[$row_main['breedtype']]; ?></td>
                        <td style="text-align: right"><?php echo $row_main['total_milk']; ?></td>
                        <td style="text-align: center"><?php echo $row_main['remark']; ?></td>
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
        <title>Milk Management-Milksale Report</title>
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
                                    <header>Milksale Report</header>
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
                $.post('testre.php', {
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
