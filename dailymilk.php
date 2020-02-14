<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$reduce_quantity = 0;
$prefix = $name = $cowtype = $breedtype = $date = $timestamp = $session = $total = $remark = $id = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `dailymilk` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $gender = $row['gender'];
        $breedtype = $row['breedtype'];
        $cowtype = $row['cowtype'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $date1 = $row['date1'];
        $timestamp1 = date("d-m-Y", strtotime($date1));
        $session = $row['session'];
        $session1 = $row['session1'];
        $total = $row['total'];
        $total_milk = $row['total_milk'];
        $remark = $row['remark'];
        $remark1 = $row['remark1'];
    }
}

$sql11 = "SELECT `id`, `name` FROM `cowreg`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $row['name'];
// echo $get_cowtype[$row['name']];exit;
}
$sql14 = "SELECT `id`, `cowtype` FROM `cowtype`";
$resu = mysqli_query($mysqli, $sql14);
while ($row = mysqli_fetch_assoc($resu)) {
    $get_cowtypee[$row['id']] = $row['cowtype'];
// echo $get_cowtypee[$row['cowtype']];exit;
}
$sql12 = "SELECT `id`, `breedtype` FROM `breedtype`";
$resut = mysqli_query($mysqli, $sql12);
while ($row = mysqli_fetch_assoc($resut)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_POST['save'])) {
    $cdate = date('y/m/d');
    $name = $_POST['name'];
//    $cowtype = $_POST['cowtype'];
    $date1 = $_POST['date'];
    $date = new DateTime($date1);
    $timestamp = $date->format('Y-m-d');
//    $breedtype = $_POST['breedtype'];
    $session = $_POST['session'];
    $total = $_POST['total'];
    $remark = $_POST['remark'];
    $sql1 = "SELECT   `cowtype`, `breedtype` FROM `cowreg` WHERE `id`='$name'";
    $ret = mysqli_query($mysqli, $sql1);
    while ($row = mysqli_fetch_assoc($ret)) {
        $cowtype = $row['cowtype'];
        $breedtype = $row['breedtype'];
    }

    if ($id) {
        $check = "select * from `dailymilk` where `cowtype`='$cowtype' AND `breedtype`='$breedtype'AND`date`='$timestamp' AND `session`='$session' AND id != $id";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = " UPDATE `dailymilk` SET `name`='$name',`date`='$timestamp',`session`='$session',`total`='$total',`cowtype`='$cowtype',`breedtype`='$breedtype',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]')  WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        }
        header("Location: dailymilk.php?msg=3");
        exit;
    } else {
;
        $check = "select * from `dailymilk` where `cowtype`='$cowtype' AND `breedtype`='$breedtype'AND`date`='$timestamp' AND `session`='$session'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
            header("Location: dailymilk.php?msg=1");
        } else {
            $sql = "INSERT INTO `dailymilk`(`type`,`name`,`cowtype`,`breedtype`,`date`,`session`, `total`,`remark`,`cby`, `cdate`, `cip`) VALUES ('single','$name','$cowtype','$breedtype','$timestamp','$session', '$total','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//            echo $sql;exit;
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: dailymilk.php?msg=2");
            exit;
        }
    }
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `dailymilk` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "1";
    }
    header('Location: dailymilk.php?msg=' . $msg);
}

if (isset($_POST['tablechange'])) {
    $dates = $_POST['tablechange'];
    $dates = explode("-", $dates);
    $startdate = date("Y-m-d", strtotime($dates[0]));
    $enddate = date("Y-m-d", strtotime($dates[1]));
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>S.No</th>
                <th>Actions</th>
                <th>Name</th>     
                <th>Date</th>   
                <th>Session</th>
                <th style="text-align:center;">Total Milk (in liter)</th>     
                <th>Remark</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "SELECT * from `dailymilk` where date(date) BETWEEN ('$startdate') AND ('$enddate')AND `type`='single' ORDER BY `id` DESC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="dailymilk.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <a href="dailymilk.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                    </td>
                    <td><?php echo $get_cowtype[$row['name']]; ?></td>
        <!--                     <td><?php // echo $get_cowtypee[$row['cowtype']];    ?></td>-->
                    <!--<td><?php // echo $get_breedtype[$row['breedtype']];    ?></td>-->
                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $row['session']; ?></td>
                    <td style="text-align:center;"><?php echo $row['total']; ?></td>
                    <td><?php echo nl2br($row['remark']); ?></td>
                </tr>  
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Dailymilk</title>
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
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <form class="form form-validate" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Daily Milking Entry</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class = "col-sm-6 form-group ">
                                                    <select name="name" id="name" tabindex="1" required="true" class="form-control js-example-basic-single">
                                                        <option value="">Please Select Cattle Name</option>
                                                        <?php
                                                        $sql = "select * from cowreg where gender='female' AND active!='no' AND sold !='yes' AND `id` NOT IN (select sold_cowname from cowsell WHERE `sold_cowname` != '0')";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if ($name == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $row['cowcode'] . " - " . $row['name']; ?></option>
<?php } ?>
                                                    </select>
                                                    <label for="name">&nbsp; &nbsp;Cattle Name  <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <label for="dob">&nbsp; &nbsp;  Entry Date <sup style="color:red;">*</sup></label>
                                                    <div class="form-group control-width-normal">
                                                        <div class="input-group date" id="demo-date">
                                                            <input type="text" class="form-control" required="true"name="date"value="<?php
                                                            if (!$id) {
                                                                echo date('d-m-Y');
                                                            } else {
                                                                echo $timestamp;
                                                            }
                                                            ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group ">
                                                    <select  class="form-control" class="w3-select w3-border" name="session" required>
                                                        <option value="">Please Select Session</option>
                                                        <option <?php
                                                        if ($session == "morning") {
                                                            echo "selected";
                                                        }
                                                        ?> value="morning">Morning</option>
                                                        <option  <?php
                                                        if ($session == 'evening') {
                                                            echo 'selected';
                                                        }
                                                        ?> value="evening">Evening</option>
                                                    </select>
                                                    <label for="session">&nbsp; &nbsp;Session <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <input type="number" class="form-control" required="true" name="total" min="1" maxlength="7" tabindex="1" value="<?php echo $total; ?>">
                                                    <label for="el">&nbsp; &nbsp;Total Milk(liter) <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="4" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                </div>
                                            </div>
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">
                                                    <div class="row text-right">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
                                                            <div class="col-md-2">
                                                                <?php if ($id) { ?>
                                                                    <button onclick="goBack()"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                                <?php } else {
                                                                    ?>
                                                                    <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Reset</button>
<?php } ?>
                                                            </div>
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
                                    <div class="card-head style-primary" style="width:100%;">
                                        <header>Daily Milking Entry Details</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="regwise_select" class="tbgetsect">
                                                <div class="col-sm-5 col-lg-offset-4  form-group">
                                                    <div class="input-group date demo-date-format">
                                                        <div class="row">
                                                            <div id="reportrange" class="pull-center" style="cursor: pointer; width: 100%;">
                                                                <input type="text" value="" class="form-control" name="start" id="start" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <span class="input-group-addon"><i class="fa fa-calendar" style="width: 40px"></i></span>
                                                    </div>
                                                </div>
                                                <div id="showtable"></div>
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
        <script>
            $("#demo-date").datepicker({
                format: 'dd-mm-yyyy',
                startDate: '1-3-2019',
                endDate: '+0d',
            });
        </script>
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"](" Saved Sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Already Exits", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Entry Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Entry Deleted Sucesssfully", "Sucesss")
<?php } ?>
        </script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script>
            $(function () {
                var start = moment().subtract(6, 'days');
                var end = moment();
                function cb(start, end) {
                    var dates = $('#start').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    var dates1 = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
                    $(document).ajaxStart(function () {
                        $("#loadingmessage").css("display", "block");
                    });
                    $(document).ajaxComplete(function () {
                        $("#loadingmessage").css("display", "none");
                    });

                    $.post('dailymilk.php',
                            {
                                tablechange: dates1,
                            },
                            function (data, status) {
                                console.log(data);
                                $('#showtable').html(data);
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
                }
                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'D-MM-YYYY'
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
            });
        </script>
        <script>
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
    </body>
</html>

