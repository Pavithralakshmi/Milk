<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $expences = $date = $timestamp = $total_unit = $total_amount = $unit = $rate = $sellername = $phoneno = $address = $remark = $id = $voucharno = $msg = "";
$reduce_quantity = $discount = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';
$gh = "select max(inwardno)as inwardno from inward";
$result = mysqli_query($mysqli, $gh);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $inwardno = $row['inwardno'];
    }
    $inwardno = $inwardno + 1;
} else {
    $inwardno = 1;
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
    <div class="col-sm-4 form-group ">
        <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>"readonly>
        <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
    </div>
    <div class="col-sm-4 form-group">
        <textarea id="address" class="form-control" name="address" rows="3" style="resize:none;width:100%;"readonly ><?php echo $address; ?></textarea>
        <label for="address">&nbsp; &nbsp;Address</label>
    </div>

    <?php
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT GROUP_CONCAT(`iw`.`id`) as id,GROUP_CONCAT(`iw`.`rate`) as rate,GROUP_CONCAT(`iw`.`unit`) as unit,GROUP_CONCAT(`iw`.`total_unit`) as total_unit,GROUP_CONCAT(`iw`.`total_amount`) as total_amount,GROUP_CONCAT(`iw`.`expences`) as expences,`iw`.sellername,`iw`.inwardno,`iw`.voucharno,`iw`.date,`iw`.balance,`iw`.total_amount1,`iw`.discount,`iw`.remark,`se`.`name`,`se`.`phoneno`,`se`.`address` FROM `inward` `iw` cross join `seller` `se` on `se`.`id`=`iw`.`sellername` where `iw`.inwardno='$id'";
    //  echo $sql;
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_val = explode(",", $row['id']);
        $inwardno = $row['inwardno'];
        $expences = $row['expences'];
        $date = $row['date'];
        $timestamp = date("Y-m-d", strtotime($date));
        $qunty = $row['qunty'];
        $total_amount = explode(",", $row['total_amount']);
        $total_amount1 = $row['total_amount1'];
        $rate = explode(",", $row['rate']);
        $voucharno = $row['voucharno'];
        $discount = $row['discount'];
        $amount = $row['amount'];
        $sellername = $row['sellername'];
        $phoneno = $row['phoneno'];
        $address = $row['address'];
        $balance = $row['balance'];
        $remark = $row['remark'];
        $unit = explode(",", $row['unit']);
        $total_unit = explode(",", $row['total_unit']);
    }
    $i = 0;
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
if (isset($_POST['save'])) {
    $inwardno = $_POST['inwardno'];
    $expences = $_POST['expences'];
    $date = $_POST['date'];
    $timestamp = date("Y-m-d", strtotime($date));
    $qunty = $_POST['qunty'];
    $total_amount = $_POST['total_amount'];
    $total_amount1 = $_POST['total_amount1'];
    $rate = $_POST['rate'];
    $voucharno = $_POST['voucharno'];
    $discount = $_POST['discount'];
    $amount = $_POST['amount'];
    $sellername = $_POST['sellername'];
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
    $balance = $_POST['balance'];
    $unit = $_POST['unit'];
    $total_unit = $_POST['total_unit'];
    $remark = $_POST['remark'];
    $cdate = date('y/m/d');
    if ($id) {
        $i = 0;
        $id_val = $_POST['id_val'];
        foreach ($expences as $key => $value) {
            $sql = " UPDATE `inward` SET `sellername`='$sellername',`date`='$timestamp',`voucharno`='$voucharno',`expences`='$expences[$key]',`qunty`='$qunty[$i]',`rate`='$rate[$i]',`amount`='$amount',`total_amount`='$total_amount[$i]',`discount`='$discount',`balance`='$balance',`unit`='$unit[$i]',`total_unit`='$total_unit[$i]',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE `id`='$id_val[$key]'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        }
        header("Location: inward.php?msg=3");
    } else {
        foreach ($total_amount as $key => $value) {
            $sql = "INSERT INTO `inward`(`inwardno`, `sellername`, `date`, `voucharno`, `expences`, `qunty`, `rate`, `amount`, `total_amount`,`total_amount1`, `discount`, `balance`, `unit`, `total_unit`,`remark`,`cby`, `cdate`, `cip`) VALUES ('$inwardno', '$sellername',  '$timestamp', '$voucharno',  '$expences[$key]' ,'$qunty','$rate[$key]','$amount','$total_amount[$key]','$total_amount1','$discount','$balance', '$unit[$key]', '$total_unit[$key]','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        }
        header("Location: inward.php?msg=2");
    }
    exit;
}
if (isset($_POST['openmodel'])) {
    $id1 = $_POST['openmodel'];
    ?>
    <table class="w3-table-all w3-large">
        <?php
        $sql = "SELECT `in`.*,`se`.`name`,`se`.`phoneno`,`se`.`address` FROM `inward` `in` cross join `seller` `se` on `se`.`id`=`in`.`sellername` where inwardno=$id1 order by `id` desc";
        $result = mysqli_query($mysqli, $sql);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $inwardno = $row['inwardno'];
                $expences = $row['expences'];
                $date = $row['date'];
                $timestamp = date("Y-m-d", strtotime($date));
                $qunty = $row['qunty'];
                $total_amount = $row['total_amount'];
                $total_amountr[] = $row['total_amount'];
                $total_amount1 = $row['total_amount1'];
                $rate = $row['rate'];
                $voucharno = $row['voucharno'];
                $discount = $row['discount'];
                $amount = $row['amount'];
                $sellername = $row['sellername'];
                $phoneno = $row['phoneno'];
                $address = $row['address'];
                $balance = $row['balance'];
                $unit = $row['unit'];
                $total_unit = $row['total_unit'];
                $remark = $row['remark'];
                $paid = $row['paid'];
                ?>
                <?php if ($i == 1) { ?>
                    <tr>
                        <th style="width: 4cm"> Inward no :</th><td><?php echo $row['inwardno']; ?></td>
                        <th style="text-align:right"> Seller :</th><td style="text-align:left"><?php echo $get_bname[$row['sellername']]; ?></td>
                        <th style="text-align:right"> Phone No :</th><td style="text-align:left"><?php echo $row['phoneno']; ?></td>
                    </tr>
                    <tr>
                        <th> Date :</th><td style="text-align:left"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <th style="text-align:right"> Address :</th><td colspan="3"><?php echo $row['address']; ?> </td>
                    </tr>
                    <tr>
                        <th>S.NO</th>
                        <th>Expenses</th>
                        <th style="text-align:right">Unit</th>
                        <th style="text-align:right">Total Unit</th>
                        <th style="text-align:right">Rate per Unit </th>
                        <th style="text-align:right">Amount</th>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align:left"><?php echo $i; ?></td>
                    <td><?php echo $get_expences[$row['expences']]; ?></td>
                    <td style="text-align:right"><?php echo $get_uname[$row['unit']]; ?></td>
                    <td style="text-align:right"><?php echo $row['total_unit']; ?></td>
                    <td style="text-align:right"><?php echo $row['rate']; ?></td>
                    <td style="text-align:right"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Total Amount:</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', array_sum($total_amountr)); ?></td>
            </tr>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Discount Amount:</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $discount); ?></td>
            </tr>
            <?php if ($paid != 0) { ?>
                <tr><th></th><th></th><td></td><th></th>
                    <th style="text-align:right">Paid Amount:</th>
                    <td style="text-align:right"><?php echo sprintf('%0.2f', $paid); ?></td>
                </tr><?php } else { ?>
                <br>
            <?php } ?>
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Payable Amount</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $balance - ($paid)); ?>
            </tr>
            <?php ?>
        </table>  <?php
    }
    exit;
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `inward` where `inwardno` = '$inwardno' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "1";
    }
    header('Location: inward.php?msg=' . $msg);
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
                <th>Action</th>
                <th>Date</th>
                <th>Inward no</th>
                <th>Expenses</th>
                <th>Product Details</th>
                <th style="text-align:right">Vouchar No</th>
                <!--<th>Rate per Unit </th>-->
                <th style="text-align:right">Total Amount</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "select `inwardno`, `sellername`, `date`, `voucharno`,GROUP_CONCAT(`expences`) as `expences`, `qunty`, `rate`, `amount`, `paid`, `total_amount`, `total_amount1`, `discount`, `balance`, `unit`, `total_unit`,`remark` from inward  where date(date) BETWEEN ('$startdate') AND ('$enddate')  GROUP BY inwardno ORDER BY `id` DESC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $inwardno = $row['inwardno'];
                $expences_array = explode(',', $row['expences']);
                $date = $row['date'];
                $timestamp = date("Y-m-d", strtotime($date));
                $qunty = $row['qunty'];
                $total_amount = $row['total_amount'];
                $total_amount1 = $row['total_amount1'];
                $rate = $row['rate'];
                $voucharno = $row['voucharno'];
                $discount = $row['discount'];
                $amount = $row['amount'];
                $sellername = $row['sellername'];
                $phoneno = $row['phoneno'];
                $address = $row['address'];
                $balance = $row['balance'];
                $unit = $row['unit'];
                $total_unit = $row['total_unit'];
                $remark = $row['remark'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left"> 
                        <?php
                        $sql_type = "select * from `outcome` WHERE  `inwardno` = '$inwardno'";
                        $result_type = mysqli_query($mysqli, $sql_type);
                        if (!mysqli_num_rows($result_type)) {
                            ?>   
                            <a href="inward.php?id=<?php echo $inwardno; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <?php } ?>
                        <?php
                        $sql_type = "select * from `outcome` WHERE  `inwardno` = '$inwardno'";
                        $result_type = mysqli_query($mysqli, $sql_type);
                        if (!mysqli_num_rows($result_type)) {
                            ?>   
                            <a href="inward.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                        <?php } ?>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                    <td  style="text-align:center"><?php echo $row['inwardno']; ?></td>
                    <td><?php
                        foreach ($expences_array as $value) {
                            echo $get_expences[$value] . "<br>";
                        }
                        ?></td>
                    <td style="text-align:center"> <button type="button" onclick="openmodel(<?php echo $inwardno; ?>)" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                    <td style="text-align:right"><?php echo $row['voucharno']; ?></td>
                    <!--<td style="text-align:right"><?php // echo $row['rate'];     ?></td>-->
                    <td style="text-align:right"><?php echo sprintf('%0.2f', $balance); ?></td>
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
        <title>Milk Management - Purchase</title>
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
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header> Purchase Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-4 form-group ">
                                                    <input type="number" class="form-control" name="inwardno" readonly="true"tabindex="1" value="<?php echo $inwardno; ?>">
                                                    <label for="Inwardno">&nbsp; &nbsp;Inward Number</label>
                                                </div>                                               
                                                <div class="col-sm-4 form-group ">
                                                    <label for="dob">&nbsp; &nbsp;Date <sup style="color:red;">*</sup></label>
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
                                                <div class="col-sm-4 form-group ">
                                                    <input type="text" name="voucharno"  id="voucharno" tabindex="1" value="<?php echo $voucharno; ?>"class="form-control">
                                                    <label for="voucharno">&nbsp; &nbsp;Voucher No</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class = "col-sm-4 form-group ">
                                                    <select name="sellername" required="true" id="sellername" tabindex="1" class="form-control js-example-basic-single"> <?php echo $sellername; ?>
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
                                                    <label for="name">&nbsp; &nbsp;Seller Name <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div  id="buyer_detail">
                                                    <div class="col-sm-4 form-group ">
                                                        <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>"readonly>
                                                        <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
                                                    </div>
                                                    <div class="col-sm-4 form-group">
                                                        <textarea id="address" class="form-control" name="address" rows="1" style="resize:none;width:100%;"readonly><?php echo $address; ?></textarea>
                                                        <label for="address">&nbsp; &nbsp;Address</label>
                                                    </div>
                                                </div>
                                            </div>    
                                            <div id="MainCloneDiv">
                                                <?php if (!$id) { ?>
                                                    <div class="row button CloneDivClass" id="buttonid1">
                                                        <div class="col-sm-2 form-group " id="tr">
                                                            <label for="name">&nbsp; &nbsp;Product  <sup style="color:red;">*</sup></label>
                                                            <select name="expences[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                <option value="">Please Select Product </option>
                                                                <?php
                                                                $sql = "select * from `expense`  order by `expences` ";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id1 = $row['id'];
                                                                    ?>
                                                                    <option  value="<?php echo $row['id'] ?>"><?php echo $row['expences'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>                                                           
                                                        <div class="row" id= "total">
                                                            <div class="col-sm-2 form-group ">
                                                                <label for="rate">&nbsp; &nbsp;Select Unit<sup style="color:red;">*</sup></label>
                                                                <select name="unit[]" id="unit" tabindex="1"  required="true" class="form-control js-example-basic-single"> <?php echo $unit; ?>
                                                                    <option value="">Please Select Unit</option>
                                                                    <?php
                                                                    $sql = "select `id`,`unit` from unit";
                                                                    $result = mysqli_query($mysqli, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $id1 = $row['id'];
                                                                        ?>
                                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['unit']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2 form-group ">
                                                                <label for="rate">&nbsp; &nbsp;Price (Per Unit)<sup style="color:red;">*</sup></label>
                                                                <input type="text" name="rate[]" required="true" id="price" min="1" tabindex="1" value=""class="form-control">
                                                            </div>
                                                            <div class="col-sm-2 form-group">
                                                                <label for="rate">&nbsp; &nbsp; Total Unit <sup style="color:red;">*</sup></label>
                                                                <input type="number" class="form-control" required="true" min=1 name="total_unit[]" id="total_unit" tabindex="1" value="">
                                                            </div>
                                                            <div class=" col-sm-2 form-group ">
                                                                <label for="total_amount">&nbsp; &nbsp;Cost Of Product</label>
                                                                <input readonly type="number" id="total_amount" min="1" class="form-control CostOfProduct" required="true" name="total_amount[]" tabindex="1" value="">
                                                            </div>
                                                            <div class=" col-sm-1 form-group AddMoreRow">                                                               
                                                                <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    $i = 0;
                                                    foreach (explode(",", $expences) as $key => $value) {
                                                        ?>
                                                        <div class="row button CloneDivClass" id="buttonid<?php echo $key; ?>">
                                                            <input type="text" class="form-control hide"  name="id_val[]" tabindex="1" value="<?php echo $id_val[$i]; ?>">
                                                            <div class="col-sm-2 form-group " id="tr">
                                                                <label for="name">&nbsp; &nbsp;Expenses  <sup style="color:red;">*</sup></label>
                                                                <select name="expences[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                    <option id="name1" value="">&nbsp;</option>
                                                                    <?php
                                                                    $sql = "select * from `expense`  order by `expences` ";
                                                                    $result = mysqli_query($mysqli, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $id1 = $row['id'];
                                                                        ?>
                                                                        <option  value="<?php echo $row['id'] ?>"<?php
                                                                        if ($value == $id1) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $row['expences'] ?></option>
                                                                             <?php } ?>
                                                                </select>
                                                            </div>        
                                                            <div class="row" id= "total">
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
                                                                            if ($unit[$i] == $id1) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>><?php echo $row['unit']; ?></option>
                                                                                <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2 form-group ">
                                                                    <label for="rate">&nbsp; &nbsp;Price (Per unit)<sup style="color:red;">*</sup></label>
                                                                    <input type="text" name="rate[]" required="true" id="price" min="1" tabindex="1" value="<?php echo $rate[$i]; ?>"class="form-control">

                                                                </div>
                                                                <div class="col-sm-2 form-group">
                                                                    <label for="rate">&nbsp; &nbsp; Total Unit <sup style="color:red;">*</sup></label>
                                                                    <input type="number" class="form-control" required="true" min=1 name="total_unit[]" id="total_unit" tabindex="1" value="<?php echo $total_unit[$i]; ?>">

                                                                </div>
                                                                <div class=" col-sm-2 form-group ">
                                                                    <label for="total_amount">&nbsp; &nbsp;Cost Of Product</label>
                                                                    <input readonly type="number" id="total_amount" min="1" class="form-control CostOfProduct" required="true" name="total_amount[]" tabindex="1" value="<?php echo $total_amount[$i]; ?>">

                                                                </div>
                                                                <div class=" col-sm-1 form-group AddMoreRow">                                                               
                                                                    <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="row form-group pull-right AddMoreRow">                                                               
                                                <button type="button" name="add" id="add" class="btn btn-success buttonclass">Add More</button>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-offset-6 col-md-4 form-group">
                                                    <label for="total_amount1">Amount:</label>
                                                    <input readonly type="number" id="total_amount1" min="1" class="form-control"name="total_amount1" tabindex="1" value="<?php echo $total_amount1; ?>">
                                                </div>
                                                <div class="col-lg-offset-6 col-md-4 form-group">
                                                    <label for="discount">Discount Amount:</label>
                                                    <input type="number" id="discount" min="0" class="form-control" name="discount" tabindex="1" value="<?php echo $discount; ?>">
                                                </div>
                                                <div class="col-lg-offset-6 col-md-4 form-group">
                                                    <label for="balance">Total Amount:</label>
                                                    <input readonly type="number" id="balance" min="1" class="form-control" name="balance" tabindex="1" value="<?php echo $balance; ?>">
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
                                                            <button type="submit" id="save" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save" onClick="return confirm('Are You Sure To Save')">Save</button>
                                                            <div class="col-md-2">
                                                                <?php if ($id) { ?>
                                                                    <button onclick="goBack()" class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                                <?php } else {
                                                                    ?>
                                                                    <button type="button"  onclick="location.reload();" class="btn ink-reaction btn-flat btn-primary">Reset</button>
                                                                <?php } ?>
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
                    </div>
                </section>
                <section>
                    <div class="section-body ">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Purchase Details</header>
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
        <div class="modal fade" id="mymodal" role="dialog" >
            <div class="modal-dialog modal-lg" style="min-width:100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Purchase Details</h4>
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
        <script>
            $("#demo-date").datepicker({
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

                    $.post('inward.php',
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

        <script>
            $('#sellername').change(function () {
                var sellername_variable = $(this).val();
                $.post("inward.php",
                        {
                            sellername_for_post: sellername_variable,
                        },
                        function (data, status) {
                            $('#buyer_detail').html(data);

                        });
            });
        </script>
        <script>
            function total_amount(id)
            {
                var total_unit = $("#" + id).find("#total_unit").val();
                var rate = $("#" + id).find("#price").val();
                var total_amount = parseInt(total_unit) * parseInt(rate);
                $("#" + id).find("#total_amount").val(total_amount);
            }
            $(document).ready(function () {
                $(document).on('keyup', 'input', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    total_amount(id);
                });
            });
            $(document).ready(function () {
                $(document).on('change', 'input', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    total_amount(id);
                });
            });
            document.getElementById("total_unit").addEventListener("wheel", function () {
                var id = $(this).parent().parent().closest('.button').attr("id");
                total_amount(id);
            });
            document.getElementById("price").addEventListener("wheel", function () {
                var id = $(this).parent().parent().closest('.button').attr("id");
                total_amount(id);
            });
        </script>
        <script>
            function balance()
            {
                var total_amount1 = $("#total_amount1").val();
                var discount = $("#discount").val();
                var balance = parseInt(total_amount1) - parseInt(discount);
                $("#balance").val(balance);
            }
            $("#total_amount1").keyup(function () {
                total_amount(id);
            });
            $("#total_amount1").change(function () {
                balance();
            });
            document.getElementById("total_amount1").addEventListener("wheel", total_amount1);
            $("#total_amount1").change(function () {
                balance();
            });
            $("#discount").keyup(function () {
                balance();
            });
            $("#discount").change(function () {
                balance();
            });
            document.getElementById("discount").addEventListener("wheel", discount);
            $("#discount").change(function () {
                balance();
            });
            $(document).ready(function () {
                $(document).on('change', 'input', function () {
                    balance();
                });
            });
        </script>
        <script>
            $(".buttonclass").click(function () {//AddMoreRow CloneDivClass
                $('#MainCloneDiv .CloneDivClass:last').clone().appendTo('#MainCloneDiv').find('input').val('');
                var button = parseInt($('#MainCloneDiv .CloneDivClass:last').prop('id').replace("buttonid", "")) + 1;
                $('#MainCloneDiv .CloneDivClass:last').prop('id', 'buttonid' + button);
                change_select();
                CostOfProductOnChange();
                RemoveButtonShowHide();
                balance();
            });
            $("body").on("click", ".remove", function () {
                $(this).parents(".button").remove();
                change_select();
                RemoveButtonShowHide();
                CostOfProductOnChange();
                balance();
            });
            $(document).on('change', '#total_unit, #price', function () {
                CostOfProductOnChange();
            });
            function CostOfProductOnChange() {
                var sum = 0;
                $('.CostOfProduct').each(function () {
                    sum += parseInt(this.value);
                });
                $('#total_amount1').val(sum);
            }
            $(document).on('change blur', '.name_list', function () {
                change_select();
            });
            function change_select()
            {
                var values = $.map($('.name_list:last option'), function (e) {
                    var data = e.value;
                    if (data) {
                        if ($(".name_list option[value=" + data + "]:selected").length > 0) {
                            $(".name_list option[value=" + data + "]:selected").attr("hidden", true);
                        } else if ($(".name_list option[value=" + data + "]").length > 0) {
                            $(".name_list option[value=" + data + "]").attr("hidden", false);
                        }
                    }
                });
            }
            RemoveButtonShowHide();
            function RemoveButtonShowHide() {
                var RemoveValues = $('#MainCloneDiv .CloneDivClass').length;
                if (RemoveValues < 2)
                    $('button.remove').hide();
                else
                    $('button.remove').show();
                change_select();
            }
        </script>
        <script>
            function openmodel(inwardno) {
                $.post("inward.php", {openmodel: inwardno}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
        </script>
        <script>
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
        <script>
            $(document).on('click', '#save', function (e) {
                $('#MainCloneDiv').find("input,select").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus().select();
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    </body>
</html>

