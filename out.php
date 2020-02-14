<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $ids = "";
$reduce_quantity = 0;
$prefix = $msg =$sold_pname=$sold_cowname="";
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
    $cdate = "";
    if (isset($_POST['income_id'])) {
        $id = $_POST['income_id'];
    } else {
        $id = "";
    }
    $bid = $_POST['buyer_ids'];
    //$biid = $_POST['buyer_id_insert'];
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
    if (isset($_POST['buyername'])) {
        $buyername = $_POST['buyername'];
    } else {
        $buyername = "";
    }
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
            $total = "SELECT (`total_amount`-`paid`) as `amount` FROM `cowsell` WHERE `id`='$ids'";
            $to_res = mysqli_query($mysqli, $total);
            while ($t = mysqli_fetch_assoc($to_res)) {
                $amount = $t['amount'];

                if (($amount > $paid) && ($paid != 0)) {

                    $balance = $amount - $paid;
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$paid' WHERE `id`='$ids' ";
//                    echo '$updrf';exit;
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = 0;
                    $sql2 = "INSERT INTO `income`(`buyer_id`, `product`, `date`, `amount`, `paid`, `balance`, `buyername`, `sold_cowname`, `sold_pname`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`, `cby`, `cdate`, `cip`) VALUES  ('$GetBuyerId','$product','$date','$amount','$paid','$balance','$buyername','$sold_cowname','$sold_pname','$payment_date','$payment_mode','$bank_details','$transaction_no', '$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
                    $result = mysqli_query($mysqli, $sql2);
                } else if ($paid >= $amount && $paid != 0) {
                    $sql = "INSERT INTO `income`(`buyer_id`,`product`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`,  `cby`, `cdate`, `cip`) VALUES ('$GetBuyerId','$product','$amount','0','$remarks','$payment_date', '$payment_mode','$bank_details','$transaction_no','$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$amount' WHERE `id`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = $paid - $amount;
                }
            }
        } else if ($ActionEvent == 'ms') {
            $total = "SELECT (`total_amount`-`paid`) as `amount`  FROM `milksell` WHERE `id`='$ids'";
            $to_res = mysqli_query($mysqli, $total);
            if (mysqli_num_rows($to_res)) {
                while ($t = mysqli_fetch_assoc($to_res)) {
                    $amount = $t['amount'];
                    if ($amount > $paid && $paid != 0) {
                        $balance = $amount - $paid;
                        $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$paid'  WHERE `id`='$ids' ";
                        $upres = mysqli_query($mysqli, $updrf);
                        $paid = 0;

                        $sql_1 = "INSERT INTO `income`(`buyer_id`, `product`, `date`, `amount`, `paid`, `balance`, `buyername`, `sold_cowname`, `sold_pname`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`, `cby`, `cdate`, `cip`) VALUES  ('$GetBuyerId','$product','$date','$amount','$paid','$balance','$buyername','$sold_cowname','$sold_pname','$payment_date','$payment_mode','$bank_details','$transaction_no', '$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
                        $upres1 = mysqli_query($mysqli, $sql_1);
                    } else if ($paid >= $amount) {
                        $sql = "INSERT INTO `income`(`buyer_id`,`product`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`,   `cby`, `cdate`, `cip`) VALUES ('$GetBuyerId','$product','$amount','0','$remarks','$payment_date', '$payment_mode','$bank_details','$transaction_no','$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
                        $result = mysqli_query($mysqli, $sql);
                        $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$amount' WHERE `id`='$ids' ";
                        $upres = mysqli_query($mysqli, $updrf);
                        $paid = $paid - $amount;
                    }
                }
            }
        }
    }
//    header('Location: out.php');
    exit;
}

if (isset($_POST['buyer_id'])) {
    $buyer_id = $_POST['buyer_id'];
    $sql = "(select  'cs' as `action` , `id`, `sellername`,`total_amount` as `amount`,`product`, `paid`,`date`, `sellername` from cowsell where `sellername`='$buyer_id') UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `amount`,`breedtype` as product, `paid`,`date`, `sellername` from milksell where `sellername`='$buyer_id' ORDER BY `id` DESC)";
    $res = mysqli_query($mysqli, $sql);
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
                    <th>Payable Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_assoc($res)) {
                    $product_name = $data['product'];
                    if ($data['action'] == 'cs') {
                        $productname = $data['product'];
                        $date = $data['date'];
                    } else {
                        $productname = $get_productname[$data['product']]." "."Milk";
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
                        <!--<td><?php // echo $get_cn3ame[$data['sellername']];                                        ?></td>-->
                        <td><?php echo date('d/m/Y', strtotime($data['date'])); ?></td>
                        <td><?php echo $productname; ?></td>
                        <td><?php echo $data['amount']; ?></td>
                        <td><?php echo $data['paid']; ?></td>
                        <td><?php
                            $bls = $data['amount'] - $data['paid'];
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
                    <td><h4  id="slected_amt" >RS : 0</h4><input type="text" value="" id="edit_amount" hidden=""></td>
                    <td colspan="2" align="right">Amount To Be Paid :  </td>
                    <td colspan="1"><input type="number" value="0"  name="paid"  min="0"  style="background-color: white;  color: balck" onkeyup="calculate_balnce(this.value)" class="form-control" id="pay_amount" ></td>
                    <td colspan="1" align="right" >Balance : </td>
                    <td colspan="1"><input type="number"  name="balance" style="color: white" class="form-control" value="0" id="balance"  readonly="" ></td><br>                        
            </tr> 
            <tr>
                <td >Remarks</td>
                <td  colspan="3"><input type="text" id="remarks1" class="form-control" placeholder="Enter Remarks if any" name="clientname" tabindex="1" value=""></td>
                <td >Select Payment Date</td>
                <td colspan="2">
                    <input type="date" name="payment_date" value="<?php echo $ymd; ?>" max = "<?php echo date('Y-m-d'); ?>" id="payment_date" class="form-control" required>
                </td>                
            </tr>
            <tr>
                <td style="border-top: 0">Payment Mode<sup>*</sup></td>
                <td colspan="2" style="border-top: 0">
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
                <td colspan="2" style="border-top: 0">
                    <div class="radio radio-styled">
                        <label>
                            <input type="radio" name="payment_mode"  class="paymode" id="r3" value="cheque">
                            <span>Cheque</span>
                        </label>
                    </div>
                </td>
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

    <?php
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
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
<?php include_once 'include/header.php'; ?>
        <!-- END HEADER-->

        <!-- END BASE -->

        <!-- BEGIN CONTENT-->
        <div id="content">
            <section>              
                <div class="section-body contain-lg">
                    <!-- BEGIN VERTICAL FORM -->
                    <div class="row">      
                        <h2 class="text-primary"><center>Income (Payment Receipt)</center></h2><br>
                        <div class="col-md-10 col-lg-offset-1">
                            <div class="card">
                                <div class="card-body col-lg-offset-3 col-md-6">
                                    <div class="row">
                                        <center>Add Payment</center>
                                        <select id="buyer_change" class="form-control" name="buyer_id" tabindex="1" required>
                                            <option value="">-- Please select Buyer --</option>
                                            <?php
                                            $sql = "select * from buyer";
                                            $res = mysqli_query($mysqli, $sql);
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                ?>                                                   
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " - " . $row['phoneno']; ?></option>  
                                                <!--<a href="../../../../F:/xampp/hddocs/Milk/out.php"></a>-->
<?php } ?>
                                        </select> 
                                        <div class="col-md-4"></div>
                                    </div>
                                </div><!--end .card-body -->
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
                                                    <th>Paid</th>
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
                                            <button  class="btn btn-default-bright btn-raised" tabindex="1" onclick="location.href = 'out.php'" name="save" style="float: left;" >Cancel</button>
                                            <!--<button type="submit" id="save_payment" class="btn ink-reaction btn-raised btn-primary" tabindex="1" onclick="return confirm('Are you sure to save?');" name="save">Save</button>-->
                                            <button type="button" id="save_payment" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
                                        </div>                                            
                                    </div>

                                </div><!--end .card-body -->
                            </div>
                        </div><!--end .col -->
                    </div><!--end .row -->
                </div>
            </section>
        </div><!--end #content-->
        <!-- END CONTENT -->
    </div><!--end #base-->
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
            var balance = parseInt(totals) - parseInt(pay_amount);
            if (parseInt(totals) >= parseInt(pay_amount))
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
                total += parseInt($(this).val(), 10);
            });

            $("#slected_amt").html('Rs:' + total);
            $("#edit_amount").val(total);
            $("#pay_amount").val(total);
        }
        $('#demo-date').datepicker({dateFormat: "dd-mm-yy"});
        $("#buyer_change").change(function () {
            var buyer_id = $(this).val();
            //        alert(buyer_id);
            $('#load-images').show();
            $.post("out.php", {
                buyer_id: buyer_id,
            }, function (data) {
                $('#load-images').hide();
                $("#demo-date").datepicker();
                $("#view_pay_recipt").html(data);
            });
        });
//$(document).on('submit', 'form#save_payment_submit', function (e) {
//    alert();
//});
        $('#save_payment').click(function () {
//        $(document).on('submit', '#save_payment_submit', function (e) {
//            alert("fsdsd");
            var checkaction = $(".checkbox_checked").is(':checked');
            var checkpayment = $(".paymode").is(':checked');
            if (checkaction && checkpayment) {
                var ConfirmCheck = confirm('Are you sure to save?');
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
//                    console.log(buyer_ids);
                    //// <----
                    //
//                    alert(paid);
                    $('#loadingmessage').show();
                    $.post("out.php", {
                        buyer_id_insert: parseInt(buyer_id),
                        paid: parseInt(paid),
                        GetBuyerId: parseInt(GetBuyerId),
                        balance: parseInt(balance),
                        buyer_ids: buyer_ids,
                        remarks: remarks,
                        payment_date: payment_date,
                        payment_mode: payment_mode,
                        bank_details: bank_details,
                        transaction_no: transaction_no,
                        cheque_no: cheque_no,
                        cheque_date: cheque_date
                    }, function (data, status) {
//                       console.log(data);
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
//            alert(buyerid);
            $('#loadingmessage').show();
            $.post("out.php", {
                open_modal_view: buyerid
            }, function (data, status) {
//                alert(data);
//                console.log(data);
                $('#simpleModal').modal('show');
                var datas = data.split('@#@');
                $("#payablamount").html('<h4 style="color: green; margin-top: 0;">Payable Amount : Rs.' + datas[1] + '/-</h4>');
                $("#client").html('<h4 style="color: brown; margin-top: 0;">Buyer Name : ' + datas[2] + '</h4>');
                $("#project").html('<h4 style="color: brown; margin-top: 0;">Product Name : ' + datas[3] + '</h4>');
                $("#balamount").html('<h4 style="color: orangered; margin-top: 0;">Balance Amount : Rs.' + datas[4] + '/-</h4>');
                $("#paidamount").html('<h4 style="color: darkgreen; margin-top: 0;">Paid Amount : Rs.' + datas[5] + '/-</h4>');
                $("#view_data").html(datas[0]);
                $('#loadingmessage').hide();
//                                        alert(data);
            });
        }
    </script>
    <script>
        $(document).on('change', '#buyer_select', function (e) {

            var reg = $(this).val();
            $.post("out.php",
                    {
                        buyer_select: reg,
                    },
                    function (data, status) {
                        //                                     alert(data);
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
            $.post("out.php",
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
            $.post("out.php",
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

        $(document).on('change', 'input[name=payment_mode]:radio', function () {
            var pay_mode = $(this).val();
            if (pay_mode === 'cash') {
                $('#bank-div').hide();
                $('#cheque-div').hide();
            } else if (pay_mode === 'bank') {
                $('#bank-div').show();
                $('#cheque-div').hide();
            } else if (pay_mode === 'cheque') {
                $('#bank-div').hide();
                $('#cheque-div').show();
            }
        });
    </script>
<script>
$(document).ready(function () {
     $(document).on('click', '#ckbCheckAll', function () {
        $(".checkbox_checked").prop('checked', $(this).prop('checked'));
    });
});
</script>
</body>
</html>
