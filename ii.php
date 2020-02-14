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
$sql31 = "SELECT `id`, `milktype1` FROM `milktype1`";
$result = mysqli_query($mysqli, $sql31);
while ($row = mysqli_fetch_assoc($result)) {
    $get_productname[$row['id']] = $row['milktype1'];
    // echo $get_cn3ame[$row['name']];exit;
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
//        echo $id; exit;
    if ($action == 'delete') {

        $sql = "delete from income where `income_id`='$id'";
//                echo $sql; 
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
//    echo "wrr";exit
    $cdate = date('y/m/d');
    $id = $_POST['income_id'];
    $bid = $_POST['buyer_ids'];
    $GetBuyerId = $_POST['GetBuyerId'];
    $product = $_POST['product'];
//    echo $product;exit;
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $paid = $_POST['paid'];
    $balance = $_POST['balance'];
    $buyername = $_POST['buyername'];
    $payment_date = $_POST['payment_date'];
    $payment_mode = $_POST['payment_mode'];
    $bank_details = $_POST['bank_details'];
    $transaction_no = $_POST['transaction_no'];
    $cheque_no = $_POST['cheque_no'];
    $cheque_date = $_POST['cheque_date'];
    $cby = $_POST['cby'];
//    $cdate = $_POST['cdate'];
    $cip = $_POST['cip'];
//    print_r($bid);
    foreach ($bid as $idss) {
        $idss = explode('$#$', $idss);
        $ActionEvent = $idss[0];
        $ids = $idss[1];
        $product = $idss[2];
        if ($ActionEvent == 'cs') {
            echo "dfsdf";exit;
            $total = "SELECT `total_amount`-`paid` as `amount` FROM `cowsell` WHERE `sellername`='$ids'";
            $to_res = mysqli_query($mysqli, $total);
            while ($t = mysqli_fetch_assoc($to_res)) {
                $amount = $t['amount'];
//                $payable_amt = $t['payable_amt'];

                if ($amount > $paid && $paid != 0) {
//                  echo "hiiii";exit;
                    $balance = $amount - $paid;
                    $sql = "INSERT INTO `income`(`buyer_id`, `product`, `date`, `amount`, `paid`, `balance`, `buyername`, `sold_cowname`, `sold_pname`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`, `cby`, `cdate`, `cip`) VALUES  ('$GetBuyerId','$product','$date','$amount','$paid','$balance','$buyername','$sold_cowname','$sold_pname','$payment_date','$payment_mode','$bank_details','$transaction_no', '$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
//                    echo 'if-' . $sql;exit;

                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$paid' WHERE `sellername`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = 0;
                } else if ($paid >= $amount && $paid != 0) {
//                      echo "dsad";exit;
                    $sql = "INSERT INTO `income`(`buyer_id`,`product`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`,   `cby`, `cdate`, `cip`) VALUES ('$GetBuyerId','$product','$amount','0','$remarks','$payment_date', '$payment_mode','$bank_details','$transaction_no','$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
//                    echo 'else-' . $sql;exit;

                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `cowsell` SET `paid`=`paid`+'$amount' WHERE `sellername`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = $paid - $amount;
                }
            }
        } else
        if ($ActionEvent == 'ms') {
//             echo "byee";
            $total = "SELECT `total_amount`-`paid` as `amount`  FROM `milksell` WHERE `sellername`='$ids'";
            $to_res = mysqli_query($mysqli, $total);
            while ($t = mysqli_fetch_assoc($to_res)) {
                $amount = $t['amount'];

                if ($amount > $paid && $paid != 0) {
                    $balance = $amount - $paid;
                    $sql = "INSERT INTO `income`(`buyer_id`, `product`, `date`, `amount`, `paid`, `balance`, `buyername`, `sold_cowname`, `sold_pname`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`, `cby`, `cdate`, `cip`) VALUES  ('$ids','$product','$date','$amount','$paid','$balance','$buyername','$sold_cowname','$sold_pname','$payment_date','$payment_mode','$bank_details','$transaction_no', '$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
//                    echo 'if-' . $sql;exit;

                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$paid' WHERE `sellername`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = 0;
                } else if ($paid >= $amount && $paid != 0) {
                    $sql = "INSERT INTO `income`(`buyer_id`,`product`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `bank_details`, `transaction_no`, `cheque_no`, `cheque_date`,   `cby`, `cdate`, `cip`) VALUES ('$ids','$product','$amount','0','$remarks','$payment_date', '$payment_mode','$bank_details','$transaction_no','$cheque_no', '$cheque_date', '$cby','$cdate','$_SERVER[REMOTE_ADDR]')";
//                    echo 'else-' . $sql;exit;

                    $result = mysqli_query($mysqli, $sql);
                    $updrf = "UPDATE `milksell` SET `paid`=`paid`+'$amount' WHERE `sellername`='$ids' ";
                    $upres = mysqli_query($mysqli, $updrf);
                    $paid = $paid - $amount;
                }
            }
        }
    }
    exit;
}

if (isset($_POST['buyer_id'])) {
    $buyer_id = $_POST['buyer_id'];
    $sql = "(select  'cs' as `action` , `id`, `sellername`,`total_amount` as `amount`,`product`, `paid`,`date`, `sellername` from cowsell where `sellername`='$buyer_id') UNION (select 'ms' as `action` ,`id`, `sellername`,`total_amount` as `amount`,`milktype` as product, `paid`,`date`, `sellername` from milksell where `sellername`='$buyer_id' ORDER BY `id` DESC)";
    $res = mysqli_query($mysqli, $sql);
    $i = 1;
    ?>
    <div class="table-responsive">
        <table id="datatable1" class="table">
            <thead>
                <tr>                                    
                    <th>S.No</th>
                    <th>Select Payment</th>
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
                        $productname = $get_productname[$data['product']];
                        $date = $data['date'];
                    }
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <label class="checkbox-inline checkbox-styled add_seleted_amount">
                                <input type="checkbox" onclick="add_select_amount();" class="checkbox_checked" name="chk"  id="<?php echo $data['action'] . '$#$' . $data['sellername'] . '$#$' . $productname; ?>"  value="<?php echo $data['amount'] - $data['paid']; ?>"><span></span>
                            </label>
                        </td>
                        <!--<td><?php // echo $get_cn3ame[$data['sellername']];           ?></td>-->
                        <td><?php echo $data['date']; ?></td>
                        <td><?php echo $productname; ?></td>
                        <td><?php echo $data['total_amount']; ?></td>
                        <td><?php echo $data['paid']; ?></td>
                        <td><?php echo $data['total_amount'] - $data['paid']; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr style="background-color:#305ADD;    color: white;font-family: serif;font-size: large;">
                    <td colspan="1">Total Select Amount</td>
                    <td><h4  id="slected_amt" >RS : 0</h4><input type="text" value="" id="edit_amount" hidden=""></td>
                    <td colspan="2" align="right">Amount To Be Paid :  </td>
                    <td colspan="1"><input type="number" value="0"  name="paid"    style="background-color: white;  color: balck" onkeyup="calculate_balnce(this.value)" class="form-control" id="pay_amount" ></td>
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
            <tr id="bank-div" style="display: none;">
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
            </tr>
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
        <title>Milk Management</title>
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
                                                <!--<a href="../../../../F:/xampp/hddocs/Milk/income.php"></a>-->
                                            <?php } ?>
                                        </select> 
                                        <div class="col-md-4"></div>
                                    </div>
                                </div><!--end .card-body -->
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <form id="save_payment_submit" >
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
                                                <button  class="btn btn-default-bright btn-raised" tabindex="1" onclick="location.href = 'income.php'" name="save" style="float: left;" >Cancel</button>
                                                <!--<button type="submit" id="save_payment" class="btn ink-reaction btn-raised btn-primary" tabindex="1" onclick="return confirm('Are you sure to save?');" name="save">Save</button>-->
                                                <button type="submit" id="save_payment" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
                                            </div>                                            
                                        </div>
                                    </form>
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
            $.post("income.php", {
                buyer_id: buyer_id,
            }, function (data) {

                console.log(data);
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
            var checkaction = $(".checkbox_checked").is(':checked');
            var checkpayment = $(".paymode").is(':checked');
            if (checkaction && checkpayment) {
                var ConfirmCheck = confirm('Are you sure to save?');
                if (ConfirmCheck) {
                    var buyer_ids = [];
                    var action = $("#ActionEvent").val();
                    var payment_mode = $('input[name=payment_mode]:checked').val();
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
                    console.log(buyer_ids);
                    //// <----
                    //
//                    alert(paid);
                    //        $('#loadingmessage').show();
                    $.post("income.php", {
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
                        console.log(data);
                        $('#loadingmessage').hide();
//                        location.reload();
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
            $.post("income.php", {
                open_modal_view: buyerid
            }, function (data, status) {
//                alert(data);
                console.log(data);
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
            $.post("income.php",
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
</body>
</html>
