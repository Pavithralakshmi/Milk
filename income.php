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

$sql33 = "SELECT `id`, `product` FROM `sb_productname`";
$result = mysqli_query($mysqli, $sql33);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname1[$row['id']] = $row['product'];
    // echo  $get_productname1[$row['product']];exit;
}

$sql32 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result1 = mysqli_query($mysqli, $sql32);
while ($row = mysqli_fetch_assoc($result1)) {
    $get_productname2[$row['id']] = $row['breedtype'];
    // echo $get_cn3ame[$row['cowtype']];exit;
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

        $sql = "delete from income where `income_id`='$id'";
        $res = mysqli_query($mysqli, $sql);
//                if ($idAction == 'cs')
        $updrf = "UPDATE `cowsell` SET `paid`='0', `balance` = `total_amount`,`mby`=concat(`mby`,'|','$datetime'),`mdate`=concat(`mdate`,'|','$datetime'),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE `id`='$id1' ";
//                else
        $updrf = "UPDATE `milksell` SET `paid`='0',  `balance` = `total_amount`,`mby`=concat(`mby`,'|','$datetime'),`mdate`=concat(`mdate`,'|','$datetime'),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE `id`='$id1' ";
//                echo $updrf;exit;
        $upres = mysqli_query($mysqli, $updrf);
    }
}

if (isset($_POST['paid']) && isset($_POST['balance'])) {
    $cdate = date('y/m/d');
    if (isset($_POST['income_id'])) {
        $id = $_POST['income_id'];
    } else {
        $id = "";
    }
    $bid = $_POST['buyer_ids'];
    $GetBuyerId = $_POST['buyer_id_insert'];
    if (isset($_POST['product'])) {
        $product = $_POST['product'];
    } else {
        $product = "";
    }
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
    $balance = round($balance, 2);
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
        if ($ActionEvent == 'cs') {
            $total = "SELECT (`total_amount`-`paid`) as `amount`,id  FROM `cowsell` WHERE `id`='$ids'ORDER BY `id` DESC";
            $to_res = mysqli_query($mysqli, $total);
            while ($t = mysqli_fetch_assoc($to_res)) {
                $amount = $t['amount'];
                $amo = $t['id'];
                if (($amount > $paid) && ($paid != 0)) {
                    $balance = $amount - $paid;
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$paid' WHERE `id`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $sql2 = "INSERT INTO `income`(`buyer_id`,`cowsell_id`,`product`, `amount`, `paid`, `balance`,`payment_date`, `payment_mode`,`remarks`,`cby`, `cdate`, `cip`) VALUES  ('$GetBuyerId','$amo','$product','$amount','$paid','$balance','$payment_date','$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                    echo $sql2;exit;
                    $result = mysqli_query($mysqli, $sql2);
                    $paid = 0;
                } else if ($paid >= $amount && $paid != 0) {
                    $sql = "INSERT INTO `income`(`buyer_id`,`cowsell_id`,`product`, `paid`, `balance`,  `payment_date`, `payment_mode`,`remarks`,`cby`, `cdate`, `cip`) VALUES ('$GetBuyerId','$amo','$product','$amount','0','$payment_date', '$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                   echo $sql;exit;
                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$amount' WHERE `id`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = $paid - $amount;
                }
            }
        } else if ($ActionEvent == 'ms' && $paid != 0) {
            //echo 'ms'.$paid; 
            $total = "SELECT (`total_amount`-`paid`) as `amount`,id  FROM `milksell` WHERE `id`='$ids'ORDER BY `id` DESC";
            $to_res = mysqli_query($mysqli, $total);
            if (mysqli_num_rows($to_res)) {
                while ($t = mysqli_fetch_assoc($to_res)) {
                    $amount = $t['amount'];
                    $am = $t['id'];
                    if ($amount > $paid && $paid != 0) {
                        $balance = $amount - $paid;
                        $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$paid'  WHERE `id`='$ids' ";
                        $upres = mysqli_query($mysqli, $updrf);
                        $sql_1 = "INSERT INTO `income`(`buyer_id`,`milksell_id`, `product`, `amount`, `paid`, `balance`, `payment_date`, `payment_mode`,`remarks`,`cby`, `cdate`, `cip`) VALUES  ('$GetBuyerId','$am','$product','$amount',('$amount'-'$balance'),'$balance','$payment_date','$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                        echo $sql_1;exit;
                        $upres1 = mysqli_query($mysqli, $sql_1);
//                        exit;
                    } else if ($paid >= $amount) {
                        $sql = "INSERT INTO `income`(`buyer_id`,`milksell_id`,`product`, `paid`, `balance`,`payment_date`, `payment_mode`,  `remarks`,`cby`, `cdate`, `cip`) VALUES ('$GetBuyerId','$am','$product','$amount','0','$payment_date', '$payment_mode','$remarks','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//                          echo $sql;exit;
                        $result = mysqli_query($mysqli, $sql);
                        $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$amount' WHERE `id`='$ids' ";
                        $upres = mysqli_query($mysqli, $updrf);
                        $paid = $paid - $amount;
                    }
                }
            }
        }
    }
//    header('Location: income.php');
    exit;
}

if (isset($_POST['buyer_id'])) {
    $buyer_id = $_POST['buyer_id'];
//    $sql = "(select  'cs' as `action` , `id`, `sellername`,`total_amount` as `amount`,`sold_pname` as product, `paid`,`date`, `sellername` from cowsell where `sellername`='$buyer_id' AND `paid`<`total_amount`) UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `amount`,`breedtype` as product, `paid`,`date`, `sellername` from milksell where `sellername`='$buyer_id' AND `paid`<`total_amount` ORDER BY `id` DESC)";
    $sql = "(select  'cs' as `action` , `id`, `sellername`,`total_amount` as `amount`,`sold_pname` as product,`sold_cowname` as product1, `paid`,`date`, `sellername` from cowsell where `sellername`='$buyer_id' AND `paid`<`total_amount`) UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `amount`,`breedtype` as product, `session` as product1,`paid`,`date`, `sellername` from milksell where `sellername`='$buyer_id' AND `paid`<`total_amount` ORDER BY `id` DESC)";
//    echo $sql;exit;
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res)) {
        $i = 1;
        ?>
        <div class="table-responsive">
            <table id="datatable1" class="table">
                <thead>
                    <tr>                                    
                        <th>S.No</th>
                        <th>Select Payment<br><span><input type="checkbox" id="ckbCheckAll" value="0" />Select all</span></th>
                        <!--<th>Buyer</th>-->
                        <th>Date</th>
                        <th>Product Name</th>
                        <th  style="text-align: center;">Payable Amount</th>
                        <th  style="text-align: right;">Received Amount</th>
                        <th  style="text-align: right;">Balance To Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($res)) {
                        $product_name = $data['product'];
                        if ($data['action'] == 'cs') {
                            if ($data['product']) {
                                $productname = $get_productname1[$data['product']];
                            } else {

                                $productname = $get_productname2[$data['product1']]. "-"."Cattle";
                            }
                            $date = $data['date'];
                        } else {
                            $productname = $get_productname[$data['product']] . " " . "Milk";
                            $date = $data['date'];
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <label class="checkbox-inline checkbox-styled add_seleted_amount">
                                    <input type="checkbox" onclick="add_select_amount();" class="checkbox_checked" name="chk"  id="<?php echo $data['action'] . '$#$' . $data['id'] . '$#$' . $productname; ?>"  value="<?php echo $data['amount'] - $data['paid']; ?>"><span></span>
                                </label>
                            </td>
                            <!--<td><?php // echo $get_cn3ame[$data['sellername']];                                             ?></td>-->
                            <td><?php echo date('d/m/Y', strtotime($data['date'])); ?></td>
                            <td><?php echo $productname; ?></td>
                            <td  style="text-align: right;"><?php echo number_format($data['amount'], 2, '.', ''); ?></td>
                            <td  style="text-align: right;"><?php echo number_format($data['paid'], 2, '.', ''); ?></td>
                            <td  style="text-align: right;"><?php
            $bls1 = $data['amount'] - $data['paid'];
            $bls = number_format($bls1, 2, '.', '');
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
                    <tr style="background-color:#305ADD;    color: white;font-family: serif;font-size: large;">
                        <td colspan="1">Total Select Amount</td>
                        <td><h4  id="slected_amt" style="font-family: serif;font-size: large;">RS : 0</h4><input type="text" value="" id="edit_amount" hidden=""></td>
                        <td colspan="2" align="right">Amount to be Received :  </td>
                        <td colspan="1"><input type="number" value="0"  name="paid"  min="0"  style="background-color: white;  color: balck" onkeyup="calculate_balnce(this.value)" class="form-control" id="pay_amount" ></td>
                        <td colspan="1" align="right" >Balance : </td>
                        <td colspan="1"><input type="number"  name="balance" style="color: white" class="form-control" value="0" id="balance"  readonly="" ></td><br>                        
                </tr> 
                <tr>
                    <td style="border-top: 0">Payment Mode<sup>*</sup></td>
                    <td  style="border-top: 0">
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
        <!--                <tr id="bank-div" style="display: none;">
                    <td style="border-top: 0">RTGS/NEFT</td>
                    <td colspan="4" style="border-top: 0">
                        <input type="text" class="form-control" id="bank_details" name="bank_details">
                    </td>
                    <td style="border-top: 0">Transaction Date</td>
                    <td colspan="3" style="border-top: 0">
                        <input type="text" class="form-control" id="transaction_no" name="transaction_no">
                    </td>
                </tr>
                <tr id="cheque-div" style="display: none;">
                    <td style="border-top: 0">Cheque No</td>
                    <td colspan="4" style="border-top: 0">
                        <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                    </td>
                    <td style="border-top: 0">Cheque Date</td>
                    <td colspan="3" style="border-top: 0">
                        <input type="text" class="form-control" id="cheque_date" name="cheque_date">
                    </td>
                </tr>-->
                </tbody>
            </table>
        </div>

        <input type="hidden" value="<?php echo $buyer_id; ?>" id ="GetBuyerId" />
        <input type="hidden" value="<?php echo $buyer_id; ?>" id ="GetBuyerId" />

    <?php } else {
        ?>
        <div class="table-responsive">
            <table  class="table">
                <thead> </thead>
                <tbody>
                <center style="color:blue;">
                    No Pending Data Available For This Buyer
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
        <title>Milk Management-income</title>
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
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="content">
            <section>              
                <div class="section-body contain-lg">
                    <div class="row">      
                        <h2 class="text-primary"><center>Income (Payment Receipt)</center></h2><br>
                        <div class="col-md-10 col-lg-offset-1">
                            <div class="card">
                                <div class="card-body col-lg-offset-3 col-md-6">
                                    <div class="row">
                                        <center>Add Payment</center>
                                        <select id="buyer_change" class="form-control" name="buyer_id" tabindex="1" required>
                                            <option value="">-- Please Select Buyer --</option>
                                            <?php
                                            $sql = "select * from buyer";
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
                                                    <th>Buyer</th>
                                                    <th>Purchase Date</th>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Received</th>
                                                    <th>Balance</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td align="center" colspan="10" style="color: blue;">
                                                        .... Select Client above to view Amount... 
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                        </div>
                                        <div class="card-actionbar-row">
                                            <button  class="btn btn-default-bright btn-raised" tabindex="1" onclick="location.href = 'income.php'" name="save" style="float: left;" >Cancel</button>
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
                $("input:checkbox:checked").each(function () {
                    total += parseFloat($(this).val(), 10);
    //                  total = sprintf('%0.2f', "total"); 
                });

                $("#slected_amt").html('Rs:' + total.toFixed(2));
                $("#edit_amount").val(total.toFixed(2));
                $("#pay_amount").val(total.toFixed(2));
            }
            $('#demo-date').datepicker({dateFormat: "dd-mm-yy"});
            $("#buyer_change").change(function () {
                var buyer_id = $(this).val();
                $('#load-images').show();
                $.post("income.php", {
                    buyer_id: buyer_id,
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
                    var ConfirmCheck = confirm('Are you sure to Save?');
                    if (ConfirmCheck) {
                        var buyer_ids = [];
                        var action = $("#ActionEvent").val();
                        var payment_mode = $('input[name=payment_mode]:checked').val();
                        var buyer_id = $("#buyer_change").val();
                        var paid = $("#pay_amount").val();
                        var GetBuyerId = $("#GetBuyerId").val();
                        var remarks = $("#remarks1").val();
                        var payment_date = $("#payment_date").val();
                        var balance = $("#balance").val();
                        var bank_details = $("#bank_details").val();
                        var transaction_no = $("#transaction_no").val();
                        var cheque_no = $("#cheque_no").val();
                        var cheque_date = $("#cheque_date").val();
                        var buyer_ids = $("input:checkbox:checked").map(function () {
                            return $(this).attr('id');
                        }).get();
                        $('#loadingmessage').show();
                        $.post("income.php", {
                            buyer_id_insert: parseFloat(buyer_id),
                            paid: parseFloat(paid),
                            GetBuyerId: parseFloat(GetBuyerId),
                            balance: parseFloat(balance),
                            buyer_ids: buyer_ids,
                            remarks: remarks,
                            payment_date: payment_date,
                            payment_mode: payment_mode,
                            bank_details: bank_details,
                            transaction_no: transaction_no,
                            cheque_no: cheque_no,
                            cheque_date: cheque_date
                        }, function (data, status) {
                            console.log(data);
                            $('#loadingmessage').hide();
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
            function open_modal(buyerid)
            {
                $('#loadingmessage').show();
                $.post("income.php", {
                    open_modal_view: buyerid
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
                $.post("income.php",
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
                $.post("income.php",
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
                $.post("income.php",
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

    </body>
</html>
