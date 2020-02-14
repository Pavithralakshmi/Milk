<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $milktype = $date = $timestamp = $session = $total_milk = $total_amount = $cowtype = $remark = $address = $phoneno = $breedtype = $sellername = $rate = $id = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

if (isset($_POST['sellername_for_post'])) {
    $sellername_for_post = $_POST['sellername_for_post'];
    $sql = "SELECT * FROM `buyer` where `id` = '$sellername_for_post' ";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $phoneno = $row['phoneno'];
        $address = $row['address'];
    }
    ?>
    <div class="col-sm-6 form-group ">
        <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>">
        <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
    </div>
    <div class="col-sm-6 form-group">
        <textarea id="address" class="form-control" name="address" rows="1" style="resize:none;width:100%;" ><?php echo $address; ?></textarea>
        <label for="address">&nbsp; &nbsp;Address</label>
    </div>
    <?php
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // $sql = "SELECT * FROM `milksell` where`id` = '$id'";
    $sql = "select `ms`.*,`by`.`name`,`by`.`phoneno`, `by`.`address` from milksell `ms` cross join `buyer` `by` on `by`.`id`=`ms`.`sellername` where `ms`.`id` = '$id'  ORDER BY `id` DESC";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $milktype = $row['milktype'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $session = $row['session'];
        $total_milk = $row['total_milk'];
        $total_amount = $row['total_amount'];
        $cowtype = $row['cowtype'];
        $breedtype = $row['breedtype'];
        $rate = $row['rate'];
        $sellername = $row['sellername'];
        $phoneno = $row['phoneno'];
        $address = $row['address'];
        $remark = $row['remark'];
        $sql = "SELECT sum(`dm`.`total`) as `totalmilk` , (SELECT SUM(`ms`.`total_milk`) FROM `milksell` `ms` WHERE `ms`.`breedtype`='$breedtype' and `id`!='$id' ) as `salemilk` FROM `dailymilk` `dm`  where `dm`.`breedtype`='$breedtype' ";
        $result = mysqli_query($mysqli, $sql);
        while ($data = mysqli_fetch_assoc($result)) {
            $totalmilk = $data['totalmilk'];
            if ($totalmilk != 0) {
                $salemilk = $data['salemilk'];
                $remimilk = $totalmilk - $salemilk;
            }
        }
    }
}
// GetMilkTyperate Begin
if (isset($_POST['GetMilkType'])) {
    $GetMilkType = $_POST['GetMilkType'];
    $sqlc2 = "SELECT `rate` FROM `milktype` WHERE `id` = '$GetMilkType' ";
    $result = mysqli_query($mysqli, $sqlc2);
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $GetMilkTypeRate = $row['rate'];
        echo $GetMilkTypeRate;
    } else {
        echo "0";
    }
    exit;
}
// GetMilkTyperate End
$sql1 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}

$sql11 = "SELECT `id`, `cowtype` FROM `cowtype`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $row['cowtype'];
}


if (isset($_POST['get_breed'])) {
    $breeadty = $_POST['get_breed'];
    $sql = "SELECT sum(`dm`.`total`) as `totalmilk` , (SELECT SUM(`ms`.`total_milk`) FROM `milksell` `ms` WHERE `ms`.`breedtype`='$breeadty' ) as `salemilk` FROM `dailymilk` `dm`  where `dm`.`breedtype`='$breeadty' ";
//    echo $sql;
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)) {
        $totalmilk = $data['totalmilk'];
        if ($totalmilk != 0) {
            $salemilk = $data['salemilk'];
            $remimilk = $totalmilk - $salemilk;
            echo $remimilk;
        }
    }
    exit;
}


if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_POST['get_breed'])) {
    ?>
    <option value="">Please Select Breed Type</option>
    <?php
    $sql = "Select * From `breedtype` WHERE `cowtype` = '$_POST[get_breed]'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $tid = $row['id'];
        $tname = $row['breedtype'];
        ?>
        <option value="<?php echo $row['id']; ?>"<?php
        if ($breedtype == $tid) {
            echo "selected";
        }
        ?>><?php echo $row['breedtype']; ?> </option>			<?php
            }
            exit;
        }
        if (isset($_POST['save'])) {
            $milktype = $_POST['milktype'];
            $date1 = $_POST['date'];
            $date = new DateTime($date1);
            $timestamp = $date->format('Y-m-d'); // 31.07.2012
            $session = $_POST['session'];
            $total_milk = $_POST['total_milk'];
            $cowtype = $_POST['cowtype'];
            $breedtype = $_POST['breedtype'];
            $rate = $_POST['rate'];
            $total_amount = $_POST['total_amount'];
            $buyername = $_POST['buyername'];
            $phoneno = $_POST['phoneno'];
            $address = $_POST['address'];
            $remark = $_POST['remark'];
            $cdate = date('y/m/d');
            if ($id) {
                $sql = "UPDATE `milksell` SET `breedtype`='$breedtype',`date`='$timestamp',`session`='$session',`total_milk`='$total_milk',`total_amount`='$total_amount',`sellername`='$buyername',`rate`='$rate',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime') WHERE id='$id'";
                // echo $sql;exit;
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                if ($result) {
                    header("Location: milksale.php?msg=3");
                } else {
                    $msg = 1;
                }
            } else {
                $sql = "INSERT INTO `milksell`(`date`,`session`, `total_milk`, `breedtype`,`sellername`,`total_amount`, `rate`,`remark`,`cby`, `cdate`, `cip`) VALUE ('$timestamp','$session', '$total_milk', '$breedtype','$buyername','$total_amount','$rate','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//        echo $sql;exit;
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                if ($result) {
                    header("Location: milksale.php?msg=2");
                } else {
                    $msg = 1;
                }
            }
        }
        if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
            $sql = "DELETE FROM `milksell` where `id` = '$id' ";
            $result = mysqli_query($mysqli, $sql);
            $affected_rows = mysqli_affected_rows($mysqli);
            if ($affected_rows > 0) {
                $msg = "4";
            } else {
                $msg = "2";
            }
            header('Location: milksale.php?msg=' . $msg);
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
                <th>Breed Type</th>     
                <th>Sale Date</th>     
                <th>Session</th>
                <th>Total Liter</th>
                <th>Rate per Liter </th>
                <th>Total Amount</th>
                <th>Paid</th>
                <th>Buyer</th>
                <th>Phone No</th>
                <th>Address</th>                                                              
                <th>Remark</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "select `ms`.*,`by`.`name`,`by`.`phoneno`, `by`.`address` from milksell `ms` cross join `buyer` `by` on `by`.`id`=`ms`.`sellername`  AND date(`ms`.date) BETWEEN ('$startdate') AND ('$enddate') ORDER BY `id` DESC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $sql = "SELECT max(`id`) as `maid` FROM `milksell` WHERE `breedtype`='$row[breedtype]'  AND date(date) BETWEEN ('$startdate') AND ('$enddate') ";
                $rea = mysqli_query($mysqli, $sql);
                $datas = mysqli_fetch_assoc($rea);
                $maid = $datas['maid'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <?php
                        $NumType = 0;
                        $sql_type = "select * from `income`  WHERE  `milksell_id` = '$id'  ";
                        $result_type = mysqli_query($mysqli, $sql_type);
                        if (!mysqli_num_rows($result_type)) {
//                                                                                    if ($maid == $id) {
                            ?>   
                            <a href="milksale.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                            <a href="milksale.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                            <?php
                            //  }
                        }
                        ?>
                    </td>
                    <td><?php echo $get_breedtype[$row['breedtype']]; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $row['session']; ?></td>
                    <td style="text-align: right"><?php echo $row['total_milk']; ?></td>
                    <td style="text-align: right"><?php echo $row['rate']; ?></td>
                    <td style="text-align: right"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                    <td style="text-align: right"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                    <td><?php echo nl2br($row['name']); ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
                    <td><?php echo $row['address']; ?></td>
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
        <title>Milk Management- MilkSale</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
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
                                    <form class="form  form-validate" id="cpa-form" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Milk Sale Entry</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class = "col-sm-12 form-group">
                                                    <?php
                                                    $sql = "SELECT max(`id`) as `maid` FROM `milksell` WHERE `breedtype`='$breedtype'";
                                                    $rea = mysqli_query($mysqli, $sql);
                                                    $datas = mysqli_fetch_assoc($rea);
                                                    $maid = $datas['maid'];
                                                    ?>
                                                    <select name="breedtype" id="breedtype"  tabindex="1" required="true" <?php
                                                    if ($maid != $id) {
                                                        echo "disabled";
                                                    }
                                                    ?> class="form-control js-example-basic-single">
                                                        <option value="">Please Select Cow Type & Breed Type</option>
                                                        <?php
                                                        $sql = "select DISTINCT cowtype,breedtype from cowreg  WHERE gender='female' AND active!='no'";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['breedtype'];
                                                            ?>
                                                            <option value="<?php echo $row['breedtype'] ?>" <?php
                                                            if ($breedtype == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $get_cowtype[$row['cowtype']] . " - " . $get_breedtype[$row['breedtype']]; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="breedtype">&nbsp; &nbsp;Select Cow Type & Breed Type <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div><br>
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
                                                        if ($session == "evening") {
                                                            echo "selected";
                                                        }
                                                        ?> value="evening">Evening</option>

                                                    </select>
                                                    <label for="session">&nbsp; &nbsp;Session <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <label for="dob">&nbsp; &nbsp;  Sale Date <sup style="color:red;">*</sup></label>
                                                    <div class="form-group control-width-normal">
                                                        <div class="input-group date" id="demo-date">
                                                            <input type="text" class="form-control" required="true" name="date"value="<?php
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
                                                    <select name="buyername" id="sellername" required="true" tabindex="1" class="form-control js-example-basic-single"> <?php echo $sellername; ?>
                                                        <option value="">Please Select Buyer Name</option>
                                                        <?php
                                                        $sql = "select `id`,`name` from buyer";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if ($sellername == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $row['name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="name">&nbsp; &nbsp;Buyer Name <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <input type="text" class="form-control"  min="0"  maxlength="7" id="total_milk" required="true" name="total_milk" tabindex="1" value="<?php echo $total_milk; ?>">
                                                    <label for="total_milk">&nbsp; &nbsp;Total Milk (liter)<sup style="color:red;">*</sup></label>
                                                </div>
                                                <!--                                                 <div class="col-sm-6 form-group ">
                                                                                                    <input type="text" class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'')"  min="0" <?php
//                                                    if ($maid != $id) {
//                                                        echo "readonly";
//                                                    }
                                                ?> max="<?php
//                                                           if ($id) {
//                                                               echo $remimilk;
//                                                           } else {
//                                                               echo 0;
//                                                           }
                                                ?>" maxlength="7" id="total_milk" required="true" name="total_milk" tabindex="1" value="<?php // echo $total_milk; ?>">
                                                                                                    <label for="total_milk">&nbsp; &nbsp;Total Milk (liter)<sup style="color:red;">*</sup></label>
                                                <?php // if ($id) { ?>  <span class="text-bold text-warning" id="remview">Remining Milk : <?php
//                                                        if ($id) {
//                                                            echo $remimilk;
//                                                        }
                                                ?></span> <?php // } ?>
                                                                                                </div>-->
                                            </div><br>

                                            <div class="row" id= "total">
                                                <div class="col-sm-4 form-group ">
                                                    <input type="text" name="rate" id="price" min="1" tabindex="1" value="<?php echo $rate; ?>"class="form-control">
                                                    <label for="rate">&nbsp; &nbsp;Price (Per Liter)<sup>*</sup></label>
                                                </div>
                                                <div class="col-sm-2 form-group ">
                                                    <input type="text"  tabindex="1" value="<?php echo "/ 1 liter"; ?>" readonly="true" class="form-control">
                                                </div>

                                                <div class="col-sm-6 form-group ">
                                                    <input readonly type="number" id="total_amount" min="1" class="form-control" required="true" name="total_amount" tabindex="1" value="<?php echo $total_amount; ?>">
                                                    <label for="total_amount">&nbsp; &nbsp;Total Amount</label>
                                                </div>
                                            </div><br>

                                            <div class="row" id="buyer_detail">
                                                <div class="col-sm-6 form-group ">
                                                    <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>"readonly>
                                                    <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <textarea id="address" class="form-control" name="address" rows="1" style="resize:none;width:100%;"readonly><?php echo $address; ?></textarea>
                                                    <label for="address">&nbsp; &nbsp;Address</label>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-sm-12 form-group">
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                    <textarea id="remark" class="form-control" name="remark" rows="5" style="resize:none;width:100%;" ><?php echo $remark; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">

                                                    <div class="row text-right">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save" >Save</button>
                                                            <div class="col-md-2">
                                                                <?php if ($id) { ?>
                                                                    <button onclick="goBack()" class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                                <?php } else {
                                                                    ?>
                                                                    <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Reset</button>
                                                                <?php } ?>

                                                            </div>                                                                                                    </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div></div></div></div></section>

                            <section>
                                <div class="section-body ">
                                    <div class="row">
                                        <div class=" col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-head style-primary">
                                                    <header>Milk Sales Reports</header>
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
                        function check() {
                            document.getElementById("rate").value = '/ 1 ' + document.getElementById("getqnty").value;
                        }
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

                                $.post('milksale.php',
                                        {
                                            tablechange: dates1,
                                        },
                                        function (data, status) {
                                            console.log(data);
                                            $('#showtable').html(data);
                                            //                                  $('#reportrange').val(start.format('D-MM-YYYY') + ' To ' + end.format('D-MM-YYYY'));
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
                        })
                    </script>
                    <script>   function check() {
                            document.getElementById("rate").value = '/ 1 ' + document.getElementById("getqnty").value;
                        }
                    </script>
                    <script>
                        function total_amount()
                        {
                            var total_milk = $("#total_milk").val();
                            var rate = $("#price").val();
                            var total_amount = parseFloat(total_milk) * parseFloat(rate);
                            $("#total_amount").val(total_amount);
                        }

                        $("#total_milk").keyup(function () {
                            total_amount();
                        });
                        $("#total_milk").change(function () {
                            total_amount();
                        });
                        document.getElementById("total_milk").addEventListener("wheel", total_amount);

                        $("#price").change(function () {
                            total_amount();
                        });

                        $("#price").keyup(function () {
                            total_amount();
                        });
                        $("#price").change(function () {
                            total_amount();
                        });
                        document.getElementById("price").addEventListener("wheel", total_amount);

                        $("#price").change(function () {
                            total_amount();
                        });
                        $('#sellername').change(function () {
                            var sellername_variable = $(this).val();
                            $.post("cowsell.php",
                                    {
                                        sellername_for_post: sellername_variable,
                                    },
                                    function (data, status) {
                                        //alert("Data: " + data + "\nStatus: " + status);
                                        $('#buyer_detail').html(data);
                                    });
                        });
                    </script>

                    <script>
<?php if ($msg == '2') { ?>
                            Command: toastr["success"]("Sold Sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                            Command: toastr["error"]("Some Error Occured", "Error")
<?php } elseif ($msg == '3') { ?>
                            Command: toastr["success"]("Entry Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                            Command: toastr["success"]("Entry Deleted Sucesssfully", "Sucesss")
<?php } ?>
                    </script>
                    <script>
                        function goBack() {
                            event.preventDefault();
                            history.back(1);
                        }
                    </script>
                    </body>
                    </html>