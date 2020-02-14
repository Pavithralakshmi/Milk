<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $expences = $date = $timestamp = $total_unit = $total_amount = $unit = $rate = $sellername = $phoneno = $address = $remark = $id = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

if (isset($_POST['inwardno_total'])) {
    $inwardno_total = $_POST['inwardno_total'];
    $sql = "SELECT balance FROM `inward` where `inwardno` = '$inwardno_total' group by inwardno";
//    echo $sql;exit;
    $result = mysqli_query($mysqli, $sql);
//    print_r($result); exit;
    while ($row = mysqli_fetch_assoc($result)) {
        $balance = $row['balance'];
//        echo $balance;
    }
//    exit;
    ?>
    <div class="col-sm-6 col-lg-offset-4 form-group ">
        <input type="number" class="form-control" required="true" name="balance" tabindex="1" value="<?php echo $balance; ?>" readonly>
        <label for="balance">&nbsp; &nbsp;Total Amount</label>
    </div>
    <?php
    exit;
}

if (isset($_POST['sellername_for_post'])) {
    $sellername_for_post = $_POST['sellername_for_post'];
    $sql = "SELECT * FROM `seller` where `id` = '$sellername_for_post' ";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $phoneno = $row['phoneno'];
        $address = $row['address'];
    }
    ?>
    <div class="col-sm-6 form-group ">
        <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>"readonly>
        <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
    </div>
    <div class="col-sm-6 form-group">
        <textarea id="address" class="form-control" name="address" rows="1" style="resize:none;width:100%;"readonly ><?php echo $address; ?></textarea>
        <label for="address">&nbsp; &nbsp;Address</label>
    </div>
    <?php
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `exp` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $expencestype = $row['expencestype'];
        $expences = $row['expences'];
        $date1 = $row['date'];
        $date = new DateTime($date1);
        $timestamp = $date->format('d-m-Y'); // 31.07.2012   
       
        $total_unit = $row['total_unit'];
        $unit = $row['unit'];
        $paid = $row['paid'];
        $balance = $row['balance'];
        $inwardno = $row['inwardno'];
        $rate = $row['rate'];
        $total_amount = $row['total_amount'];
        $total_amount1 = $row['total_amount1'];
        $sellername = $row['sellername'];
        $sellername1 = $row['sellername1'];
        $phoneno = $row['phoneno'];
        $address = $row['address'];
//    echo $address;EXIT;
        $remark = $row['remark'];
        $inwardno = $row['inwardno'];
    }
}
$sql1 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_expences[$row['id']] = $row['expences'];
// echo $get_expences[$row['expences']];exit;
}
$sqlc1 = "SELECT `id`, `name` FROM `seller`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_bname[$row['id']] = $row['name'];
// echo $get_bname[$row['name']];exit;
}
$sqlc1 = "SELECT `id`, `unit` FROM `unit`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_uname[$row['id']] = $row['unit'];
// echo $get_uname[$row['unit']];exit;
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
//cho 'hhkhljljl';exit;
if (isset($_POST['save'])) {
    $expencestype = $_POST['expencestype'];
    $expences = $_POST['expences'];
    if(isset($_POST['dir_date'])) {
    $date1 = $_POST['dir_date'];
    }
    if(isset($_POST['for_date'])) {
    $date1 = $_POST['for_date'];
    }
    $timestamp=date("Y-m-d", strtotime($date1));
      
    $total_unit = $_POST['total_unit'];
    $unit = $_POST['unit'];
    $paid = $_POST['paid'];
    $balance = $_POST['balance'];
    $inwardno = $_POST['inwardno'];
    $rate = $_POST['rate'];
    $total_amount = $_POST['total_amount'];
    $sellername = $_POST['sellername'];
    $sellername1 = $_POST['sellername1'];
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
//    echo $address;EXIT;
    $remark = $_POST['remark'];
    $inwardno = $_POST['inwardno'];

    if ($id) {

        $sql = "UPDATE `exp` SET `inwardno`='$inwardno',`expencestype`='$expencestype',`sellername`='$sellername',`sellername1`='$sellername1',`phoneno`='$phoneno',`address`='$address',`expences`='$expences',`rate`='$rate',`total_unit`='$total_unit',`total_amount`=$total_amount,`date`='$timestamp',`unit`='$unit',`paid`='$paid',`balance`='$balance',`remark`='$remark' WHERE id='$id'";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: epr.php?msg=3");
        exit;
    } else {
//        $sql = "INSERT INTO `ex`(`expences`, `date`,`sellername`,`phoneno`,`address`,`total_unit`,`total_amount`, `unit`,`rate`,`remark`) VALUES('$expences','$timestamp','$buyername','$phoneno','$address','$total_unit','$total_amount','$unit','$rate','$remark')";
        $sql = "INSERT INTO `exp`(`inwardno`, `expencestype`,`sellername`,`sellername1`,`phoneno`,`address`,`expences`,`rate`,`total_unit`,`total_amount`,`date`,`unit`,`paid`,`balance`,`remark`) VALUES ('$inwardno','$expencestype','$sellername','$sellername1','$phoneno','$address','$expences','$rate','$total_unit','$total_amount','$timestamp','$unit','$paid','$balance','$remark')";
//        echo $sql;exit;
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: epr.php?msg=2");
        exit;
    }
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `exp` where `inwardno` = '$inwardno' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "2";
    }
    header('Location: epr.php?msg=' . $msg);
}

if (isset($_POST['tablechange'])) {
    $dates = $_POST['tablechange'];
    $dates = explode("-", $dates);
    $startdate = date("Y-m-d", strtotime($dates[0]));
    $enddate = date("Y-m-d", strtotime($dates[1]));
//    echo $enddate ;exit
    ?>
    <div class="col-md-6 col-sm-6">
        <!--<h2 class="text-primary">Please Fill the Details</h2>-->
        <div class="card">
            <div class="card-head style-primary">
                <header>Inward Expence Entry Details</header>
            </div>
            <div class="card-body">
                <div id="regwise_select" class="tbgetsect">


                </div>
                <table id="datatable1" class="table diagnosis_list ">
                    <thead>
                        <tr>                                    
                            <th>SlNo</th>
                            <!--<th>Action</th>-->
                            <th>Inward no</th>
                            <th>Expence Type</th>
                            <th>Expenses</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Seller</th>
                            <th>Phone No</th>
                            <th>Address</th>  
                        </tr>
                    </thead>
                    <tbody class="ui-sortable" >
                        <?php
                        $i = 1;
                        $sql = "SELECT * FROM `exp` CROSS JOIN `inward` ON exp.`inwardno` = inward.`id` where date(inward.`date`) BETWEEN ('$startdate') AND ('$enddate') ORDER BY inward.inwardno DESC";

                        $result = mysqli_query($mysqli, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $expencestype1 = $row['expencestype'];
                            $total_amount1 = $row['total_amount'];
                            $balance = $row['balance'];
//                echo $total_amount1;exit;
                            ?>
                            <tr  id="<?php echo $row['id']; ?>"  >
                                <td><?php echo $i; ?></td>
<!--                                <td class="text-left">   
                                    <a href="epr.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                    <a href="epr.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                </td>-->
                                <td><?php echo $row['inwardno']; ?></td>
                                <td><?php echo "frominward"; ?></td>
                                <td><?php echo $get_expences[$row['expences']]; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>

                                <td><?php echo $row['balance']; ?></td>
                                <td><?php echo $get_bname[$row['sellername']] ?></td>

                                <td><?php echo $row['phoneno']; ?></td>
                                <td><?php echo $row['address']; ?></td>

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

    <div class="col-md-6 col-sm-6">
        <!--<h2 class="text-primary">Please Fill the Details</h2>-->
        <div class="card">
            <div class="card-head style-primary">
                <header>Direct Expence Entry Details</header>
            </div>
            <div class="card-body">
                <div id="regwise_select" class="tbgetsect">


                </div>
                <table id="datatable2" class="table diagnosis_list ">
                    <thead>
                        <tr>                                    
                            <th>SlNo</th>
                            <!--<th>Action</th>-->
                            <!--<th>Inward no</th>-->
                            <th>Expence Type</th>
                            <th>Expenses</th>
                            <th>Date</th>
                            <th>Total Unit</th>
                            <th>Unit</th>
                            <th>Rate per Unit </th>
                            <th>Total Amount</th>
                            <th>Seller</th>
                            <th>Phone No</th>
                            <th>Address</th>  
                        </tr>
                    </thead>
                    <tbody class="ui-sortable" >
                        <?php
                        $i = 1;
                        $sql = "SELECT * from exp where expencestype='directexpe' AND date(date12) BETWEEN ('$startdate') AND ('$enddate')";
                        $result = mysqli_query($mysqli, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $expencestype1 = $row['expencestype'];
//                $total_amount1 = $row['total_amount'];              
//                $balance = $row['balance'];
////                echo $total_amount1;exit;
                            ?>
                            <tr  id="<?php echo $row['id']; ?>"  >
                                <td><?php echo $i; ?></td>
<!--                                <td class="text-left">   
                                    <a href="epr.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                    <a href="epr.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                </td>-->
                                <!--<td><?php echo $row['inwardno']; ?></td>-->
                                <td><?php echo $row['expencestype']; ?></td>
                                <td><?php echo $row['expences']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                <td><?php echo $row['total_unit']; ?></td>
                                <td><?php echo $get_uname[$row['unit']]; ?></td>
                                <td><?php echo $row['rate']; ?></td>
                                <td><?php echo $row['total_amount']; ?></td>
                                <?php if ($expencestype1 == "frominward") { ?>
                                    <td><?php echo $get_bname[$row['sellername']] ?></td>
        <?php } else { ?>
                                    <td><?php echo $get_bname[$row['sellername1']] ?></td><?php } ?>
                                <td><?php echo $row['phoneno']; ?></td>
                                <td><?php echo $row['address']; ?></td>

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
    <?php
    ?>

    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management - Inward</title>
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
        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <!-- END BASE -->
                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Expense Type (Payment Issue)</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6  form-group">
                                                    <label for="expenses type">&nbsp; &nbsp;Expenses Type <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6  form-group">
                                                    <input type="radio" tabindex="4"  name="expencestype" id="expencestype"  value="frominward"<?php
                                                    if ($expencestype == "frominward") {
                                                        echo "checked";
                                                    }
                                                    ?>> From Inward
                                                </div>
                                                <div class="col-sm-6  form-group">
                                                    <input type="radio" tabindex="5"  name="expencestype" id="expencestype1"  value="directexpences" <?php
                                                    if ($expencestype == "directexpences") {
                                                        echo "checked";
                                                    }
                                                    ?>checked> Direct Expenses
                                                </div>
                                            </div>

                                            <div class="row <?php
                                            if ($id) {
                                                echo 'hide';
                                            }
                                            ?>" id="did">
                                                <div class="row">
                                                    <div class = "col-sm-6 form-group ">
                                                        <input type="text" class="form-control"  required="true" name="expences" id="expences" tabindex="1" value="<?php echo $expences; ?>">
                                                        <label for="expences">&nbsp;&nbsp; Expenses Particulars <sup style="color:red;">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-6 form-group ">
                                                        <label for="dob">&nbsp; &nbsp;Date <sup style="color:red;">*</sup></label>
                                                        <div class="form-group control-width-normal">
                                                            <div class="input-group date" id="demo-date">
                                                                <input type="text" class="form-control" required="true" autocomplete="off" name="dir_date" value="<?php
                                                                if (!$id) {
                                                            echo "";
                                                                } else {
                                                                    echo $timestamp;
                                                                }
                                                                ?>">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                        </div><!--end .form-group -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <input type="number" class="form-control" required="true" name="total_unit" id="total_unit" min="1" tabindex="1" value="<?php echo $total_unit; ?>">
                                                        <label for="rate">&nbsp; &nbsp; Total Unit <sup style="color:red;">*</sup></label>
                                                    </div>
                                                    <div class = "col-sm-6 form-group ">
                                                        <select name="sellername1" id="sellername" tabindex="1" class="form-control js-example-basic-single"> <?php echo $sellername; ?>
                                                            <option value="">Please Select Seller Name</option>
                                                            <?php
                                                            $sql = "select `id`,`name` from seller";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id1 = $row['id'];
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if ($sellername1 == $id1) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $row['name']; ?></option>
<?php } ?>
                                                        </select>
                                                        <label for="name">&nbsp; &nbsp;Seller Name </label>
                                                    </div>
                                                </div>

                                                <div class="row" id= "total">
                                                    <div class="col-sm-4 form-group ">
                                                        <input type="text" name="rate" required="true" id="price" min="1" tabindex="1" value="<?php echo $rate; ?>"class="form-control">
                                                        <label for="rate">&nbsp; &nbsp;Price (Per unit)<sup style="color:red;">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-2 form-group ">
                                                        <label for="rate">&nbsp; &nbsp;select Unit<sup style="color:red;">*</sup></label>
                                                        <select name="unit[]" id="unit" tabindex="1"  required="true" class="form-control js-example-basic-single"> <?php echo $unit; ?>
                                                            <option value="">Select unit</option>
                                                            <?php
                                                            $sql = "select `id`,`unit` from unit";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id1 = $row['id'];
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if ($unit == $id1) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $row['unit']; ?></option>
<?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 form-group ">
                                                        <input readonly type="number" id="total_amount" min="1" class="form-control" required="true" name="total_amount" tabindex="1" value="<?php echo $total_amount; ?>">
                                                        <label for="total_amount">&nbsp; &nbsp;Total Amount</label>
                                                    </div>
                                                </div> 
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
                                                        <textarea id="remark" class="form-control" name="remark" rows="5" style="resize:none;width:100%;" ><?php echo $remark; ?></textarea>
                                                        <label for="remark">&nbsp; &nbsp;Remark</label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row <?php
                                            if (!$id) {
                                                echo 'hide';
                                            }
                                            ?>" id="fi">
                                                <div class = "col-sm-4 form-group ">
                                                    <select name="sellername" id="sellername2" tabindex="1" class="form-control js-example-basic-single"> <?php echo $sellername; ?>
                                                        <option value="">Please Select Seller Name</option>
                                                        <?php
                                                        $sql = "select `id`,`name` from seller";
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
                                                    <label for="name">&nbsp; &nbsp;Seller Name </label>
                                                </div>
                                                <div class="col-sm-4 form-group ">
                                                    <label for="dob">&nbsp; &nbsp;Date <sup style="color:red;">*</sup></label>
                                                    <div class="form-group control-width-normal">
                                                        <div class="input-group date" id="demo-date1">
                                                            <input type="text" class="form-control" required="true" autocomplete="off" name="for_date"value="<?php
                                                            if (!$id) {
                                                        echo "";
                                                            } else {
                                                                echo $timestamp;
                                                            }
                                                            ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "col-sm-4 form-group ">
                                                    <select name="inwardno" id="inwardno" tabindex="1" class="form-control js-example-basic-single"> <?php echo $inwardno; ?>
                                                        <option value="">Please Inward Number</option>
                                                        <?php
                                                        $sql = "select * from inward where id NOT IN (select inwardno from exp) GROUP BY inwardno";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if ($inwardno == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $row['inwardno']; ?></option>
<?php } ?>
                                                    </select>
                                                    <label for="name">&nbsp; &nbsp;Inward No </label>
                                                </div>                                       
                                            </div>  
                                            <div class="row" id="total_amount45">
<div class="col-sm-6 col-lg-offset-4 form-group hide ">
        <input type="number" class="form-control" required="true" name="balance" tabindex="1" value="<?php echo $balance; ?>" readonly>
        <label for="balance">&nbsp; &nbsp;Total Amount</label>
    </div>
                                            </div>
                                            <br><br>
                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Submit</button>

                                                    <div class="col-md-2">
                                                        <?php if ($id) { ?>
                                                            <!--<button type="reset"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>-->
                                                            <button onclick="goBack()">Cancel</button>
                                                        <?php } else {
                                                            ?>
                                                            <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Reset</button>
<?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class="col-md-8 col-sm-8 col-lg-offset-2">
                                <!--<h2 class="text-primary">Please Fill the Details</h2>-->
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Expence Entry Details</header>
                                    </div>
                                    <div class="card-body">
                                        <div id="regwise_select" class="tbgetsect">
                                            <div class="col-sm-4 col-lg-offset-4  form-group">
                                                <div class="input-group date demo-date-format">
                                                    <div class="row">
                                                        <div id="reportrange" class="pull-center" style="cursor: pointer; width: 100%;">
                                                            <input type="text" value="" class="form-control" name="start" id="start" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <span class="input-group-addon"><i class="fa fa-calendar" style="width: 40px"></i></span>
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
                        <div class="row">
                            <div id="rr"><!--end .col -->


                            </div>
                        </div>
                    </div>
                </section>  
            </div>
        </div>
<?php include_once 'include/menubar.php'; ?>
<?php include_once 'include/jsfiles.php'; ?>
        <script>
            $('input[name=expencestype]').change(function () {
                var active = $('input[name=expencestype]:checked').val();
                if (active === "directexpences") {

                    $("#did").removeClass("hide");


                } else {
                    $("#did").addClass("hide");

                }
            });
        </script>
        <script>
            $('input[name=expencestype]').change(function () {
                var active = $('input[name=expencestype]:checked').val();
                if (active === "frominward") {
                    $("#fi").removeClass("hide");
                } else {
                    $("#fi").addClass("hide");
                }
            });
        </script>
        <script>
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
        <script>
            $("#demo-date").datepicker({
                format: 'dd-mm-yyyy',
                startDate: '1-3-2019',
                endDate: '+0d',
            });
        </script>
        <script>
            $("#demo-date1").datepicker({
                format: 'dd-mm-yyyy',
                startDate: '1-3-2019',
                endDate: '+0d',
            });
        </script>
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"]("Entry Added  sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Some Error exist", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Entry Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Entry Deleted Sucesssfully", "Sucesss")
<?php } ?>
        </script>
        <script>
            $('#sellername').change(function () {
                var sellername_variable = $(this).val();
                $.post("epr.php",
                        {
                            sellername_for_post: sellername_variable,
                        },
                        function (data, status) {
                            $('#buyer_detail').html(data);
                        });
            });
        </script>
        <script>
            function total_amount()
            {
                var total_unit = $("#total_unit").val();
                var rate = $("#price").val();
                var total_amount = parseInt(total_unit) * parseInt(rate);
                $("#total_amount").val(total_amount);
            }

            $("#total_unit").keyup(function () {
                total_amount();
            });
            $("#total_unit").change(function () {
                total_amount();
            });
            document.getElementById("total_unit").addEventListener("wheel", total_amount);
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

                    $.post('epr.php',
                            {
                                tablechange: dates1,
                            },
                            function (data, status) {
                                $('#rr').html(data);
//                               $('#showtable1').html(data);
                                $('#datatable1,#datatable2').DataTable({
                                    "scrollX": true,
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
        <script>
            $(document).ready(function () {
                $('#inwardno').change(function () {
                    var sellername = $("#sellername2 option:selected").val();
                    var inwardno = $("#inwardno option:selected").val();
                    $.post("epr.php",
                            {
                                sellername_total: sellername,
                                inwardno_total: inwardno
                            },
                            function (data, status) {
                                console.log(data);
//                                alert(data);
                                $('#total_amount45').html(data);
                            });
                });
            });
        </script>
    </body>
</html>