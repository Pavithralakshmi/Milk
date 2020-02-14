<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $ids = "";
$reduce_quantity = 0;
$prefix = $msg = $sold_pname = $sold_cowname = $remarks = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

$sql = "SELECT `product`,`id`,`sellername` FROM `cowsell`";
$res = mysqli_query($mysqli, $sql);
while ($row1 = mysqli_fetch_array($res)) {
    $get_coname[$row1['id']] = $row1['product'];
    $get_came[$row1['id']] = $row1['sellername'];
}

$sql31 = "SELECT `id`, `name` FROM `buyer`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cn3ame[$row['id']] = $row['name'];
    // echo $get_cn3ame[$row['name']];exit;
}
$sql31 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['breedtype'];
    // echo $get_cn3ame[$row['cowtype']];exit;
}
$sql1 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_expences[$row['id']] = $row['expences'];
// echo $get_expences[$row['expences']];exit;
}
$sql1 = "SELECT `id`, `name` FROM `seller`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_sbname[$row['id']] = $row['name'];
    // echo $get_sbname[$row['name']];exit;
}

$sqlc1 = "SELECT `id`, `unit` FROM `unit`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_uname[$row['id']] = $row['unit'];
// echo $get_uname[$row['unit']];exit;
}


if (isset($_POST['openmodel'])) {
    $id1 = $_POST['openmodel'];
    ?>
    <table class="w3-table-all w3-large">
        <?php
        $sql = "SELECT * FROM `inward` where inwardno=$id1 order by `id` desc";
        $result = mysqli_query($mysqli, $sql1);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $inwardno = $row['inwardno'];
                $date = $row['date'];
                $expences = $row['expences'];
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
                $address = $row['paid'];
                $balance = $row['balance'];
                $unit = $row['unit'];
                $total_unit = $row['total_unit'];
                $paid = $row['paid'];
//    }
                ?>
                <?php if ($i == 1) { ?>
                    <tr>
                        <th>Inward no:</th> <td  colspan="2"> <?php echo $row['inwardno']; ?></td>
                        <th style="text-align: right;">Date:</th><td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                    </tr>
                    <tr>           
                        <th>Expenses</th>
                        <th style="text-align: center;">Unit</th>
                        <th style="text-align: center;">Total Quantity</th>
                        <th style="text-align: center;">Rate Per Unit </th>
                        <th style="text-align: right;">Amount</th>
                <!--                    <th>Paid</th>
                        <th>Balance</th>-->
                    </tr>
                <?php } ?>

                <tr> 
                    <td style="text-align: left;"><?php echo $get_expences[$row['expences']]; ?></td>                   
                    <td style="text-align: center;"><?php echo $get_uname[$row['unit']]; ?></td>
                    <td style="text-align: center;"><?php echo $row['total_unit']; ?></td>
                    <td style="text-align: center;"><?php echo sprintf('%0.2f', $row['rate']); ?></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr><th></th><td></td><th></th>
                <th style="text-align: right;">Total Amount:</th>
                <td colspan="3" style="text-align: right;"><?php echo sprintf('%0.2f', array_sum($total_amountr)); ?></td>
            </tr>
            <tr><th></th><td></td><th></th>
                <th style="text-align: right;">Discount Amount:</th>
                <td colspan="3" style="text-align: right;"><?php echo sprintf('%0.2f', $discount); ?></td>
            </tr>
               <?php
            if($paid!=0){ ?>
             <tr><th></th><td></td><th></th>
                <th style="text-align:right">Paid Amount:</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f', $paid); ?></td>
            </tr><?php } else { ?>
            <br>
                <?php } ?>
            <tr><th></th><td></td><th></th>
                <th style="text-align:right">Payable Amount</th>
                <td style="text-align:right"><?php echo sprintf('%0.2f',$balance-($paid));  ?>
            </tr>
<!--            <tr><th></th><td></td><th></th>
                <th style="text-align: right;">Payable Amount</th>
                <td style="text-align: right;"><?php // echo $balance; ?>
                            </td> <td><?php // echo $row['paid'];             ?></td>
                <td><?php // echo $row['balance'] - $row['paid'];             ?></td>
            </tr>-->
            <?php ?>
        </table>  <?php
    }
    exit;
}

if (isset($_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'])) {
    $encrypt_action = $_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'];
    $action = encrypt_decrypt('decrypt', $encrypt_action);
    $encrypt_id = $_GET['WnAyV3FOdHJ3dkNiMEgrMGxVcytZUT09'];
    $id = encrypt_decrypt('decrypt', $encrypt_id);
    $idsArray = explode('$#$', $id);
    $id = $idsArray[2];
    $id1 = $idsArray[1];
    $idAction = $idsArray[0];
    if ($action == 'delete') {

        $sql = "delete from outcome where `outcome_id`='$id'";
        $res = mysqli_query($mysqli, $sql);
//                if ($idAction == 'cs')
        $updrf = "UPDATE `inward` SET `paid`='0', `balance` = `total_amount`,`mby`=concat(`mby`,'|','$datetime'),`mdate`=concat(`mdate`,'|','$datetime'),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE `id`='$id1' ";
        $upres = mysqli_query($mysqli, $updrf);
    }
}

if (isset($_POST['paid']) && isset($_POST['balance'])) {
   $cdate=date('y/m/d');
    if (isset($_POST['outcome_id'])) {
        $id = $_POST['outcome_id'];
    } else {
        $id = "";
    }
    $bid = $_POST['seller_ids'];
    $GetSellerId = $_POST['seller_id_insert'];

    if (isset($_POST['date'])) {
        $date1 = $_POST['date'];
        $date = new DateTime($date1);
        $timestamp = $date->format('Y-m-d');
    } else {
        $date1 = "";
    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    } else {
        $amount = "";
    }
    $paid = $_POST['paid'];
    $balance = $_POST['balance'];
    if (isset($_POST['buyername'])) {
        $buyername = $_POST['buyername'];
    } else {
        $buyername = "";
    }
    $remarks = $_POST['remarks'];
    $payment_date = $_POST['payment_date'];
    $payment_mode = $_POST['payment_mode'];
    if (isset($_POST['bank_details'])) {
        $bank_details = $_POST['bank_details'];
    } else {
        $bank_details = "";
    }

    if (isset($_POST['transaction_no'])) {
        $transaction_no = $_POST['transaction_no'];
    } else {
        $transaction_no = "";
    }
    if (isset($_POST['buyername'])) {
        $buyername = $_POST['buyername'];
    } else {
        $buyername = "";
    }
    if (isset($_POST['cheque_no'])) {
        $cheque_no = $_POST['cheque_no'];
    } else {
        $cheque_no = "";
    }

    if (isset($_POST['cheque_date'])) {
        $cheque_date = $_POST['cheque_date'];
    } else {
        $cheque_date = "";
    }
    if (isset($_POST['cby'])) {
        $cby = $_POST['cby'];
    } else {
        $cby = "";
    }
    foreach ($bid as $idss) {
        $idss = explode('$#$', $idss);
        $ActionEvent = $idss[0];
        $ids = $idss[1];
        $product = $idss[2];
        $InwardNo = $idss[3];
        $total = "SELECT (`balance`-`paid`) as `amount` FROM `inward` WHERE `id`='$ids'";
        $to_res = mysqli_query($mysqli, $total);
        while ($t = mysqli_fetch_assoc($to_res)) {
            $amount = $t['amount'];
            if (($amount > $paid) && ($paid != 0)) {
                $balance = $amount - $paid;
                $updrf = "UPDATE `inward` SET `paid`=`paid`+'$paid' WHERE `id`='$ids' ";
                $upres = mysqli_query($mysqli, $updrf);
                $sql2 = "INSERT INTO `outcome`(`seller_id`,`inwardno`,`date`, `amount`, `paid`, `balance`,  `payment_date`, `payment_mode`,`remarks`,`cby`, `cdate`, `cip`) VALUES  ('$GetSellerId','$InwardNo','$date','$amount','$paid','$balance','$payment_date','$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                echo $sql2;exit;
                $paid = 0;
                $result = mysqli_query($mysqli, $sql2);
            } else if ($paid >= $amount && $paid != 0) {
                $sql = "INSERT INTO `outcome`(`seller_id`,`inwardno`, `date`, `amount`, `paid`, `balance`,  `payment_date`, `payment_mode`, `remarks`,`cby`, `cdate`, `cip`) VALUES  ('$GetSellerId','$InwardNo','$date','$amount','$amount','0','$payment_date','$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                echo $sql;exit;
                $result = mysqli_query($mysqli, $sql);
                $updrf = "UPDATE `inward` SET `paid`=`paid`+'$amount' WHERE `id`='$ids' ";
                $upres = mysqli_query($mysqli, $updrf);
                $paid = $paid - $amount;
            }
        }
    }
    exit;
}

if (isset($_POST['seller_id'])) {
    $seller_id = $_POST['seller_id'];
    $sql = "select `id`, `inwardno`, `sellername`, `inwardno`,sum(`paid`) as paid,`balance` as `amount`,`expences`,`date` from inward where `sellername`='$seller_id' group by inwardno HAVING sum(`paid`) < `balance` ORDER BY `id` DESC";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res)) {
        $i = 1;
        ?>
        <div class="table-responsive">
            <table id="datatable1" class="table">
                <thead>
                    <tr>                                    
                        <th>S.No</th>
                        <th>Select Payment<br><span><input type="checkbox" id="ckbCheckAll" value = "0" />Select all</span></th>
                        <th>Inward No</th>
                        <th>Date</th>
                        <th style="text-align: right">Product Details</th>
                        <th style="text-align: right;">Payable Amount</th>
                        <th style="text-align: center;">Paid Amount</th>
                        <th style="text-align: right;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <label class="checkbox-inline checkbox-styled add_seleted_amount">
                                    <input type="checkbox" onclick="add_select_amount();" class="checkbox_checked" name="chk"  id="<?php echo $data['action'] . '$#$' . $data['id'] . '$#$' . $productname . '$#$' . $data['inwardno']; ?>"  value="<?php echo $data['amount'] - $data['paid']; ?>"><span></span>
                                </label>
                            </td>
                            <td><?php echo $data['inwardno']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($data['date'])); ?></td>
                            <td><center> <button type="button" onclick="openmodel('<?php echo $data['inwardno']; ?>')" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></center></td>
                    <td style="text-align: right;"><?php echo sprintf('%0.2f', $data['amount']); ?></td>
                    <td style="text-align: center;"><?php echo sprintf('%0.2f', $data['paid']); ?></td>
                    <td style="text-align: right;"><?php
                        $bls1 = $data['amount'] - $data['paid'];
                        $bls = sprintf('%0.2f', "$bls1");
                        if ($bls) {
                            echo $bls;
                        } else {
                            echo '';
                        }
                        ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr style="background-color:#2fc3dd;    color: white;font-family: serif;font-size: large;">
                    <td colspan="1">Total Select Amount</td>
                    <td><h4  id="slected_amt" style="font-family: serif;font-size: large;">RS : 0</h4><input type="text" value="" id="edit_amount" hidden=""></td>
                    <td colspan="2" align="right">Amount to be Paid :  </td>
                    <td colspan="1"><input type="number" value="0"  name="paid"  min="0"  style="background-color: white;  color: balck" onkeyup="calculate_balnce(this.value)" class="form-control" id="pay_amount" ></td>
                    <td colspan="1" align="right" >Balance : </td>
                    <td colspan="1"><input type="number"  name="balance" style="color: white" class="form-control" value="0" id="balance"  readonly="" ></td><br>                        
                </tr> 
                <tr>
                    <td style="border-top: 0">Payment Mode<sup>*</sup></td>
                    <td style="border-top: 0">
                        <div class="radio radio-styled">
                            <label>
                                <input type="radio" name="payment_mode" class="paymode" id="r1" value="cash">
                                <span>Cash</span>
                            </label>
                        </div>                    
                    </td>  
                    <td colspan="2" style="border-top: 0">
                        <div class="radio radio-styled">
                            <label>
                                <input type="radio" name="payment_mode" class="paymode" id="r2" value="bank">
                                <span>Online Payment</span>
                            </label>
                        </div>
                    </td>
                    <td  style="border-top: 0">
                        <div class="radio radio-styled">
                            <label>
                                <input type="radio" name="payment_mode"  class="paymode" id="r3" value="cheque">
                                <span>Cheque</span>
                            </label>
                        </div>
                    </td>   
                    <td style="border-top: 0">Select Payment Date<sup>*</sup></td>
                    <td colspan="1" style="border-top: 0">
                        <label> 
                            <input type="date" name="payment_date" value="<?php echo $ymd; ?>" max = "<?php echo date('Y-m-d'); ?>" id="payment_date" class="form-control" required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 0">Remarks</td>
                    <td colspan="6"><input type="text" id="remarks1" class="form-control" placeholder="Enter Remarks if any" name="remarks" tabindex="1" value="<?php echo $remarks; ?>"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" value="<?php echo $seller_id; ?>" id ="GetSellerId" />
        <input type="hidden" value="<?php echo $seller_id; ?>" id ="GetSellerId" />
    <?php } else {
        ?>
        <div class="table-responsive">
            <table  class="table">
                <thead> </thead>
                <tbody>
                <center style="color:blue;">
                    No Pending Data Available For This Seller
                </center>
                </tbody>
            </table>
        </div>
        <?php
    }
    exit;
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management-outcome</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>   
        <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none; 
                margin: 0; 
            }
        </style>
        <script>
                        // disable mousewheel on a input number field when in focus
                        // (to prevent Cromium browsers change the value when scrolling)
                        $(document).on('focus', 'input[type=number]', function (e) {
                            $(this).focusout();
                            $(this).on('mousewheel.disableScroll', function (e) {
                                e.preventDefault()
                            })
                        })
                        $(document).on('blur', 'input[type=number]', function (e) {
                            $(this).off('mousewheel.disableScroll')
                        })
                        $(document).on('keyup', 'input[type=number]', function (e) {

                            if (e.keyCode == '38') {
                                e.preventDefault();
                            } else if (e.keyCode == '40') {
                                e.preventDefault();
                            }
                        })
        </script>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="content">
            <section>              
                <div class="section-body contain-lg">
                    <div class="row">      
                        <h2 class="text-primary"><center>Inward Expenses (Payment Issue)</center></h2><br>
                        <div class="col-md-10 col-lg-offset-1">
                            <div class="card">
                                <div class="card-body col-lg-offset-3 col-md-6">
                                    <div class="row">
                                        <center>Add Payment</center>
                                        <select id="buyer_change" class="form-control" name="seller_id" tabindex="1" required>
                                            <option value="">-- Please Select Seller --</option>
                                            <?php
                                            $sql = "select * from seller";
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

                            <div class="card">
                                <div class="card-body">
                                    <div id="view_pay_recipt">
                                        <table class="table no-margin" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payment Action</th>
                                                    <th>Inward No</th>
                                                    <th>Date</th>
                                                    <th>Product Details</th>
                                                    <th>Payable Amount</th>
                                                    <th>Paid Amount</th>
                                                    <th>Balance</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td align="center" colspan="10" style="color: blue;">
                                                        .... Select Seller above to view Amount... 
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">

                                        </div>
                                        <div class="card-actionbar-row">
                                            <button  class="btn btn-default-bright btn-raised" tabindex="1" onclick="location.href = 'outcome.php'" name="save" style="float: left;" >Cancel</button>
                                            <button type="button" id="save_payment" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
                                        </div>                                            
                                    </div>
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
                    <h4 class="modal-title">Inward Expense (Payment Issue)</h4>
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
<?php if ($msg == '2') { ?>
            Command: toastr["success"]("Payment added sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
            Command: toastr["error"]("Same Payment already exist", "Error")
<?php } elseif ($msg == '3') { ?>
            Command: toastr["success"]("Payment Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
            Command: toastr["success"]("Payment Deleted Sucesssfully", "Sucesss")
<?php } ?>
    </script>
    <script>
        function calculate_balnce(pay_amount)
        {
            var d = 0;
            var totals = $("#edit_amount").val();
            var balance = parseFloat(totals) - parseFloat(pay_amount);
            if (parseFloat(totals) >= parseFloat(pay_amount))
            {
                $("#balance").val(balance);
            } else {
                alert("Give Valid Input");
                $("#pay_amount").val(totals);
                $("#balance").val(d);
            }
        }
        function add_select_amount() {
            var total = 0;
            $(document).find("input:checkbox:checked").each(function () {
                total += parseFloat($(this).val(), 10);
            });

            $("#slected_amt").html('Rs:' + total.toFixed(2));
            $("#edit_amount").val(total.toFixed(2));
            $("#pay_amount").val(total.toFixed(2));
        }
        $('#demo-date').datepicker({dateFormat: "dd-mm-yy"});
        $("#buyer_change").change(function () {
            var seller_id = $(this).val();
            $('#load-images').show();
            $.post("outcome.php", {
                seller_id: seller_id,
            }, function (data) {
                $('#load-images').hide();
                $("#demo-date").datepicker();
                $("#view_pay_recipt").html(data);
            });
        });

        $('#save_payment').click(function () {
            var checkaction = $(".checkbox_checked").is(':checked');
            var checkpayment = $(".paymode").is(':checked');

            if (checkpayment == false && checkaction == false) {
                alert("Select Payment and Payment mode");
            } else if (checkpayment == false && checkaction == true) {
                alert("Select Payment mode");
            }
            if (checkaction && checkpayment) {
                var ConfirmCheck = confirm('Are you sure to Pay?');
                if (ConfirmCheck) {
                    var seller_ids = [];
                    var action = $("#ActionEvent").val();
                    var payment_mode = $('input[name=payment_mode]:checked').val();
                    var seller_id = $("#buyer_change").val();
                    var paid = $("#pay_amount").val();
                    var GetSellerId = $("#GetSellerId").val();
                    var remarks = $("#remarks1").val();
                    var payment_date = $("#payment_date").val();
                    var balance = $("#balance").val();
                    var bank_details = $("#bank_details").val();
                    var transaction_no = $("#transaction_no").val();
                    var cheque_no = $("#cheque_no").val();
                    var cheque_date = $("#cheque_date").val();
                    var seller_ids = $("input:checkbox:checked").map(function () {
                        return $(this).attr('id');
                    }).get();
//                    $('#loadingmessage').show();
                    $.post("outcome.php", {
                        seller_id_insert: parseFloat(seller_id),
                        paid: parseFloat(paid),
                        GetSellerId: parseFloat(GetSellerId),
                        balance: parseFloat(balance),
                        seller_ids: seller_ids,
                        remarks: remarks,
                        payment_date: payment_date,
                        payment_mode: payment_mode,
                        bank_details: bank_details,
                        transaction_no: transaction_no,
                        cheque_no: cheque_no,
                        cheque_date: cheque_date
                    }, function (data, status) {
//                        alert(data);
//                        console.log(data);
                        location.reload();
                    });
                }
            } else {
                if (checkaction) {
                    $(".checkbox_checked").removeAttr("required");
                } else {
                    $(".checkbox_checked").attr("required", true);
                }
                if (checkaction) {
                    if (checkpayment) {
                        $(".paymode").removeAttr("required", true);
                    } else {
                        $(".paymode").attr("required", true);
                    }
                }

            }
        })
        function open_modal(sellerid)
        {
            $('#loadingmessage').show();
            $.post("outcome.php", {
                open_modal_view: sellerid
            }, function (data, status) {
                $('#simpleModal').modal('show');
                var datas = data.split('@#@');
                $("#payablamount").html('<h4 style="color: green; margin-top: 0;">Payable Amount : Rs.' + datas[1] + '/-</h4>');
                $("#client").html('<h4 style="color: brown; margin-top: 0;">Buyer Name : ' + datas[2] + '</h4>');
                $("#project").html('<h4 style="color: brown; margin-top: 0;">Product Name : ' + datas[3] + '</h4>');
                $("#balamount").html('<h4 style="color: orangered; margin-top: 0;">Balance Amount : Rs.' + datas[4] + '/-</h4>');
                $("#paidamount").html('<h4 style="color: darkgreen; margin-top: 0;">Paid Amount : Rs.' + datas[5] + '/-</h4>');
                $("#view_data").html(datas[0]);
                $('#loadingmessage').hide();
            });
        }
    </script>
    <script>
        $(document).on('change', '#buyer_select', function (e) {
            var reg = $(this).val();
            $.post("outcome.php",
                    {
                        buyer_select: reg,
                    },
                    function (data, status) {
                        $("#getstate").html(data);
                        $('#datatable1').DataTable({
                            "dom": 'lCfrtip',
                            "order": [],
                            "colVis": {
                                "buttonText": "Columns",
                                "overlayFade": 0,
                                "align": "right"
                            },
                            "language": {
                                "lengthMenu": '_MENU_ entries per page',
                                "search": '<i class="fa fa-search"></i>',
                                "paginate": {
                                    "previous": '<i class="fa fa-angle-left"></i>',
                                    "next": '<i class="fa fa-angle-right"></i>'
                                }
                            }
                        });
                    });
            $.post("outcome.php",
                    {
                        project_select: reg,
                    },
                    function (data, status) {
                        $("#projsel").html(data);
                    });
        });

        $(document).on('change', '#prj_select', function (e) {
            var project = $(this).val();
            var client = $('#buyer_select').val();
            $.post("outcome.php",
                    {
                        pjct_select: project,
                        clt_select: client,
                    },
                    function (data, status) {
                        $(".tbgetdraft").html(data);
                        $('#datatable1').DataTable({
                            "dom": 'lCfrtip',
                            "order": [],
                            "colVis": {
                                "buttonText": "Columns",
                                "overlayFade": 0,
                                "align": "right"
                            },
                            "language": {
                                "lengthMenu": '_MENU_ entries per page',
                                "search": '<i class="fa fa-search"></i>',
                                "paginate": {
                                    "previous": '<i class="fa fa-angle-left"></i>',
                                    "next": '<i class="fa fa-angle-right"></i>'
                                }
                            }
                        });
                    });
        });
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#ckbCheckAll', function () {
                $(".checkbox_checked").prop('checked', $(this).prop('checked'));
                add_select_amount();
            });
        });
    </script>
    <script>
        function openmodel(inwardno) {
            $.post("outcome.php", {openmodel: inwardno}, function (data) {
                $("#mymodal").modal("show");
                $('#openmodel1').html(data);
            });
        }
    </script>
</body>
</html>
