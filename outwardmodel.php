<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $expences = $date = $timestamp = $total_amount = $id =$remark= "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

$gh = "select max(outwardno)as outwardno from outward";
$result = mysqli_query($mysqli, $gh);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $outwardno = $row['outwardno'];
    }
    $outwardno = $outwardno + 1;
} else {
    $outwardno = 1;
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$sql1 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_expences[$row['id']] = $row['expences'];
// echo $get_expences[$row['expences']];exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `outward` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $outwardno = $row['outwardno'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $expences = explode(",", $row['expences']);
        $total_unit = explode(",", $row['total_unit']);
        $unit = explode(",", $row['unit']);
        $balance = explode(",", $row['balance']);
        $remark = $row['remark'];
    }
}

if (isset($_POST['openmodel'])) {
    $id1 = $_POST['openmodel'];
    ?>
    <table class="w3-table-all w3-large">
        <?php
        $sql = "SELECT * FROM `outward` where outwardno=$id1 order by `id` desc";
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
            <tr><th></th><th></th><td></td><th></th>
                <th style="text-align:right">Payable Amount</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $balance);  ?>
            </tr>
            <?php ?>
        </table>  <?php
    }
    exit;
}
if (isset($_POST['GetTotalUnitValue'])) {
    $GetTotalUnitValue = $_POST['GetTotalUnitValue'];
    $sql = "SELECT COALESCE(SUM(`total_unit`), 0) as `inward` FROM `inward` WHERE `expences` = '$GetTotalUnitValue' ";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $TotalUnitSum['inward'] = $row['inward'];
    $sql = "SELECT COALESCE(SUM(`unit`), 0) as `outward` FROM `outward` WHERE `expences` = '$GetTotalUnitValue' ";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $TotalUnitSum['outward'] = $row['outward'];
    echo $TotalUnitSum['inward'] - $TotalUnitSum['outward'];
    exit;
}

if (isset($_POST['save'])) {
    $outwardno = $_POST['outwardno'];
    $expences = $_POST['expences'];
    $date1 = $_POST['date'];
    $date = new DateTime($date1);
    $timestamp = $date->format('Y-m-d');
    $total_unit = $_POST['total_unit'];
    $unit = $_POST['unit'];
    $balance = $_POST['balance'];
    $remark = $_POST['remark'];
    $cdate=date('y/m/d');

    if ($id) {
        $check = "select * from `outward` where expences='$expences' AND date='$timestamp' AND total_amount='$total_amount' AND id !='$id'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "UPDATE `outward` SET `date`='$timestamp',`expences`='$expences',`total_unit`='$total_unit',`unit`='$unit',`balance`='$balance',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime') WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: outwardmodel.php?msg=3");
            exit;
        }
    } else {
        $check = "SELECT * FROM `outward` WHERE `expences` = '$expences' AND `date` = '$timestamp' AND `total_amount` = '$total_amount' ";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            foreach ($expences as $key => $value) {
                $sql = "INSERT INTO `outward`(`outwardno`,`date`, `expences`, `total_unit`,`unit`,`balance`,`remark`,`cby`, `cdate`, `cip`) VALUES ('$outwardno','$timestamp','$expences[$key]','$total_unit[$key]','$unit[$key]','$balance[$key]','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            }
            header("Location: outwardmodel.php?msg=2");
            exit;
        }
    }
}

if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `outward` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "2";
    }
    header('Location: outwardmodel.php?msg=' . $msg);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management - Outward</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Outward Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="Outwardno">&nbsp; &nbsp;Outward Number</label>
                                                    <input type="number" class="form-control" name="outwardno" readonly="true"tabindex="1" value="<?php echo $outwardno; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group date" id="demo-date">
                                                        <label for="date">&nbsp; &nbsp;Date  <sup style="color:red;">*</sup></label>
                                                        <input type="text" class="form-control" required="true" autocomplete="off" name="date" value="<?php
                                                        if (!$id) {
                                                            echo "";
                                                        } else {
                                                            echo $timestamp;
                                                        }
                                                        ?>">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>                                               
                                            </div><br>
                                            <div id="Clonediv">
                                                <?php
                                                if ($id) {
                                                    foreach ($expences as $key => $value) {
                                                        ?>
                                                        <div class="row button clone1" id="buttonid1">                                    
                                                            <div class="col col-sm-3 ">
                                                                <label for="name">&nbsp; &nbsp;Product  <sup style="color:red;">*</sup></label>
                                                                <select name="expences[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                    <option value="">Please Select Product</option>
                                                                    <?php
                                                                    $sql = "select * from `expense`  order by `expences` ";
                                                                    $result = mysqli_query($mysqli, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $id1 = $row['id'];
                                                                        ?>
                                                                        <option  value="<?php echo $row['id'] ?>"<?php
                                                                        if ($expences[$key] == $id1) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $row['expences'] ?></option>
                                                                             <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col col-sm-3">
                                                                <label for="total_unit">&nbsp; &nbsp;Total Unit<sup style="color:red;">*</sup></label>
                                                                <input readonly="true" type="number" id="total_unit" min="1" class="form-control CostOfProduct" required="true" name="total_unit[]" tabindex="1" value="<?php echo $total_unit[$key]; ?>">
                                                            </div> 
                                                            <div class="col col-sm-3">
                                                                <label for="unit">&nbsp; &nbsp;Used Unit<sup style="color:red;">*</sup></label>
                                                                <input type="number" id="unit" min="0" class="form-control CostOfProduct maxvla" required="true" name="unit[]" tabindex="1"value="<?php echo $unit[$key]; ?>">
                                                            </div>
                                                            <div class="col col-sm-2">
                                                                <label for="balance">&nbsp; &nbsp;Balance<sup style="color:red;">*</sup></label>
                                                                <input readonly="true" type="number" id="balance" min="0" class="form-control CostOfProduct" required="true" name="balance[]" tabindex="1" value="<?php echo $balance[$key]; ?>">
                                                            </div>
                                                            <div class=" form-group AddMoreRow pull-right">                                                               
                                                                <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </div>
                                                        </div><br>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="row button clone1" id="buttonid1">                                    
                                                        <div class="col col-sm-3 ">
                                                            <label for="name">&nbsp; &nbsp;Product  <sup style="color:red;">*</sup></label>
                                                            <select name="expences[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                <option value="">Please Select Product</option>
                                                                <?php
                                                                $sql = "select * from `expense`  order by `expences` ";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id1 = $row['id'];
                                                                    ?>
                                                                    <option  value="<?php echo $row['id'] ?>"> <?php echo $row['expences'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-3">
                                                            <label for="total_unit">&nbsp; &nbsp;Total Unit<sup style="color:red;">*</sup></label>
                                                            <input readonly="true"type="number" id="total_unit" min="1" class="form-control CostOfProduct " required="true" name="total_unit[]" tabindex="1" value="<?php echo $total_unit[$key]; ?>">
                                                        </div> 
                                                        <div class="col col-sm-3">
                                                            <label for="unit">&nbsp; &nbsp;Used Unit<sup style="color:red;">*</sup></label>
                                                            <input type="number" id="unit" min="1" class="form-control CostOfProduct maxvla" required="true" name="unit[]" tabindex="1" value="<?php echo $unit[$key]; ?>">
                                                        </div>
                                                        <div class="col col-sm-2">
                                                            <label for="balance">&nbsp; &nbsp;Balance<sup style="color:red;">*</sup></label>
                                                            <input readonly="true"type="number" id="balance" min="0" class="form-control CostOfProduct blan " required="true" name="balance[]" tabindex="1" value="<?php echo $balance[$key]; ?>">
                                                        </div>
                                                        <div class=" form-group AddMoreRow pull-right">                                                               
                                                            <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </div>
                                                    </div><br>
                                                <?php } ?>
                                            </div>
                                            <div class="row form-group pull-right AddMoreRow">                                                               
                                                <button type="button" name="add" id="add" class="btn btn-success buttonclass">Add More</button>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="4" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                </div>
                                            </div>
                                    </div>
                                    <br>
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" id="save" name="save" onClick="return confirm('Are You Sure To Save')">Save</button>
                                                    <div class="col-md-2">
                                                        <?php if ($id) { ?>
                                                            <button onclick="goBack()" class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                        <?php } else {
                                                            ?>
                                                            <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Reset</button>
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
                </section>
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Outward Expenses Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="regwise_select" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th>S.No</th>
                                                            <th>Actions</th>
                                                            <th>Outward No</th>
                                                            <th>Date</th>
                                                            <th>Expenses</th>         
                                                            <th>Total Unit</th>     
                                                            <th>Unit</th>     
                                                            <th>Balance</th>            
                                                            <th>Remark</th>            
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select * from outward ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $outwardno = $row['outwardno'];
                                                            $remark = $row['remark'];
                                                            ?>
                                                            <tr  id="<?php echo $row['id']; ?>"  >
                                                                <td><?php echo $i; ?></td>
                                                                <td class="text-left">   
                                                                    <a href="outwardmodel.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                    <a href="outwardmodel.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                                                <td><?php echo $outwardno; ?></td>
                                                                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                                                <td><?php
                                                                    $expences = explode(",", $row['expences']);
                                                                    foreach ($expences as $key => $value) {
                                                                        echo $get_expences[$value] . '<br><br>';
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo str_replace(",", " <br><br>", $row['total_unit']); ?></td>
                                                                <td><?php echo str_replace(",", " <br><br>", $row['unit']); ?></td>
                                                                <td><?php echo str_replace(",", " <br><br>", $row['balance']); ?></td>
                                                                <td><?php echo $remark; ?></td>
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
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
        <script>
            $(".buttonclass").click(function () {//AddMoreRow clone1
                $('#Clonediv .clone1:last').clone().appendTo('#Clonediv').find('input').val('');
                var button = parseInt($('#Clonediv .clone1:last').prop('id').replace("buttonid", "")) + 1;
                $('#Clonediv .clone1:last').prop('id', 'buttonid' + button);
                CostOfProductOnChange();
                change_select();
                RemoveButtonShowHide();
            });

            $(document).on('change', '.CostOfProduct', function () {
                CostOfProductOnChange();
            });

            function CostOfProductOnChange() {
                var sum = 0;
                $('.CostOfProduct').each(function () {
                    sum += parseInt(this.value);
                });
            }
            $("body").on("click", ".remove", function () {
                $(this).parents(".button").remove();
                change_select();
                CostOfProductOnChange();
                RemoveButtonShowHide();
                CostOfProductOnChange();
            });

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
                var RemoveValues = $('#Clonediv .clone1').length;
                if (RemoveValues < 2)
                    $('button.remove').hide();
                else
                    $('button.remove').show();
                change_select();
            }
        </script>
        <script>
            function balance(id, ids)
            {
                var total_unit = $("#" + id).find("#total_unit").val();
                var rate = $("#" + id).find("#unit").val();
                var total_amount = parseInt(total_unit) - parseInt(rate);
                $("#" + id).find("#balance").val(total_amount);
                var vali = $("#" + id).find("#unit").val();
                if (parseInt(vali) > parseInt(total_unit)) {
                    alert("give Valid Input");
                    $("#" + id).find("#unit").val("");
                    $("#" + id).find("#balance").val("");
                }
            }

            $(document).ready(function () {
                $(document).on('keyup', 'input', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    var ids = $(this);
                    balance(id, ids);

                });
                $(document).on('change', 'select[name="expences[]"]', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    var ids = $(this);
                    $.post("outwardmodel.php", {
                        GetTotalUnitValue: $(this).val()}, function (data) {
                        $("#" + id).find("#total_unit").val(data);
                        balance(id, ids);
                    });

                });
            });
        </script>
        <script>
            $(document).on('click', '#save', function (e) {
                $('#Clonediv').find("input,select").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus().select();
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
             <script>
            function openmodel(outwardno) {
                $.post("outwardmodel.php", {openmodel: outwardno}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
        </script>
    </body>
</html>

