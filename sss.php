<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = "";
$reduce_quantity = 0;
$prefix = "";
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
        $cowtype = $row['cowtype'];
        $breedtype = $row['breedtype'];
        $date = $row['date'];
        $timestamp = strtotime($date);
        $session = $row['session'];
        $total = $row['total'];
        $remark = $row['remark'];
    }
}

$sql11 = "SELECT `id`, `name` FROM `cowreg`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $row['name'];
// echo $get_cowtype[$row['name']];exit;
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
//cho 'hhkhljljl';exit;
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $cowtype = $_POST['cowtype'];
    $date = $_POST['date'];
    $breedtype = $_POST['breedtype'];
    $session = $_POST['session'];
    $date = date('Y-m-d', strtotime($date));
    $total = $_POST['total'];

//        echo $value1."**";

    $remark = $_POST['remark'];
    if ($id) {
        $check = "select * from `dailymilk` where `name`='$name' AND`date`='$date'AND`session`='$session' AND id != $id";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = " UPDATE `dailymilk` SET `name`='$value',`date`='$date',`session`='$session',`total`='$value1',`cowtype`='$cowtype',`breedtype`='$breedtype',`remark`='$remark'  WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: ss.php?msg=3");
            exit;
        }
    } else {
        $i = 0;
//        echo "asdasd";exit;
//        print_r($total);
        foreach ($total as $value1) {
//            echo $value1;
            $check = "select * from `dailymilk` where `name`='$name[$i]' AND`date`='$date'AND`session`='$session'";
            $res = mysqli_query($mysqli, $check);
//            echo $check;
            if (mysqli_num_rows($res)) {
//                echo "asdsad";
                $msg = 1;
            } else {
                $sql = "INSERT INTO `dailymilk`(`name`,`cowtype`, `breedtype`, `date`,`session`, `total`,`remark`) VALUES ('$name[$i]','$cowtype', '$breedtype', '$date','$session', '$value1','$remark')";
                echo $sql;
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
//                header("Location: ss.php?msg=2");
//                exit;
            }
            $i++;
        }
//        exit;
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
    header('Location: ss.php?msg=' . $msg);
}
if ($_POST['tablechange']) {
    $dates = $_POST['tablechange'];
    $dates = explode("-", $dates);
    $startdate = date("Y-m-d", strtotime($dates[0]));
    $enddate = date("Y-m-d", strtotime($dates[1]));
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>     
                <th>Date</th>   
                <th>Session</th>
                <th>Total Milk</th>     
                <th>Remark</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "SELECT * from `dailymilk` where date(date) BETWEEN ('$startdate') AND ('$enddate')";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="ss.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <!--<a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>-->

                        <a href="ss.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>

                    </td>
                    <td><?php echo $get_cowtype[$row['name']]; ?></td>
                    <!--<td><?php echo $row['gender']; ?></td>--> 
                    <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $row['session']; ?></td>
                    <td><?php echo $row['total']; ?></td>
                    <td><?php echo $row['remark']; ?></td>
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
        <!-- BEGIN HEADER-->
        <?php include_once 'include/header.php'; ?>
        <!-- END HEADER-->

        <!-- END BASE -->

        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">

                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <form class="form form-validate" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Daily Milk Entry</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 form-group ">
                                                    <select  class="form-control" class="w3-select w3-border" name="session" required>
                                                        <option value="">&nbsp;</option>
                                                        <option <?php
                                                        if ($session == "morning") {
                                                            echo "selected";
                                                        }
                                                        ?> value="morning">Morning</option>
                                                        <option  <?php
                                                        if ($session == "evening") {
                                                            echo "selected";
                                                        }
                                                        ?>value="evening">Evening</option>

                                                    </select>
                                                    <label for="session">&nbsp; &nbsp;Session <sup style="color:red;">*</sup></label>
                                                </div>

                                                <div class="col-sm-6 form-group ">
                                                    <!-- <div class="input-group date" id="demo-date" > -->
                                                    <input type="date" class="form-control" required="true" name="date" max = "<?php echo date('Y-m-d'); ?>" tabindex="1" value="<?php echo $ymd; ?>">
                                                    <label for="date">&nbsp; &nbsp;Date<sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="table-responsive form-group ">  
                                                    <table class="table table-bordered" id="dynamic_field">  
                                                        <tr>  
                                                            <!--<td><input type="text"  name="name[]" id="name" placeholder="Enter your Name" class="form-control name_list" required="" /></td>-->  
                                                            <td> 
                                                                <div class="form-group ">
                                                                    <select name="name[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                        <option value="">&nbsp;</option>
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
                                                                    <label for="name">&nbsp; &nbsp;Cow Name  <sup style="color:red;">*</sup></label>
                                                                </div>
                                                            </td>  
                                                            <td>
                                                                <div class="form-group ">
                                                                    <input type="number" class="form-control" required="true" name="total[]" min="1" maxlength="2" tabindex="1" value="<?php echo $total; ?>">
                                                                    <label for="el">&nbsp; &nbsp;Total Milk(liter) <sup style="color:red;">*</sup></label>
                                                                </div>
                                                            </td>
                                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  

                                                        </tr>  
                                                    </table>  
                                                    <!--<input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />-->  
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
                                                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Submit</button>
                                                            <div class="col-md-2">
                                                                <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                            </div>

                                                        </div>
                                                    </div></form>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </section>
                                <section>
                                    <div class="section-body contain-lg">
                                        <div class="row"><!--end .col -->
                                            <div class=" col-md-12 col-sm-12">
                                                <!--<h2 class="text-primary">Please Fill the Details</h2>-->
                                                <div class="card">
                                                    <div class="card-head style-primary">
                                                        <header>Daily Milk Entry Details</header>
                                                    </div>
                                                    <div class="card-body">
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
<?php if ($msg == '2') { ?>
                        Command: toastr["success"](" Sucesssfully Inserted", "Sucesss")
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

                            $.post('ss.php',
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


                        <script type="text/javascript">
                            $(document).ready(function () {
                                var postURL = "/addmore.php";
                                var i = 1;


                                $('#add').click(function () {
                                    i++;
                                    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"> <td> <select name="name[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list"><option value="">&nbsp;</option><?php
$sql = "select * from cowreg where gender='female' AND active!='no' AND sold !='yes' AND `id` NOT IN (select sold_cowname from cowsell WHERE `sold_cowname` != '0')";
$result = mysqli_query($mysqli, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id1 = $row['id'];
    ?><option value="<?php echo $row['id'] ?>"<?php
    if ($name == $id1) {
        echo "selected";
    }
    ?>><?php echo $row['cowcode'] . " - " . $row['name']; ?></option><?php } ?></select></td><td><input type="number" class="form-control" required="true" name="total[]" min="1" maxlength="2" tabindex="1" value="<?php echo $total; ?>"></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
                                });
                                $(document).on('click', '.btn_remove', function () {
                                    var button_id = $(this).attr("id");
                                    $('#row' + button_id + '').remove();
                                });


                                $('#submit').click(function () {
                                    $.ajax({
                                        url: postURL,
                                        method: "POST",
                                        data: $('#add_name').serialize(),
                                        type: 'json',
                                        success: function (data)
                                        {
                                            i = 1;
                                            $('.dynamic-added').remove();
                                            $('#add_name')[0].reset();
                                            alert('Record Inserted Successfully.');
                                        }
                                    });
                                });


                            });
                        </script>
                        </body>
                        </html>

