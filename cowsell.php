<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $product = $date = $timestamp = $address = $sold_pname = $remark = $breedtype = $sold_cowname = $phoneno = $total_unit = $total_amount = $unit = $rate = $sellername = $id = "";
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
        <input type="number" class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>" readonly>
        <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
    </div>
    <div class="col-sm-6 form-group">
        <textarea id="address" class="form-control" name="address" rows="5" style="resize:none;width:100%;" readonly ><?php echo $address; ?></textarea>
        <label for="address">&nbsp; &nbsp;Address</label>
    </div>
    <?php
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
//    $sql = "SELECT * FROM `cowsell` where`id` = '$id'";
    $sql = "select `ms`.*,`by`.`name`,`by`.`phoneno`, `by`.`address` from cowsell `ms` cross join `buyer` `by` on `by`.`id`=`ms`.`sellername` where`ms`.`id` = '$id' ORDER BY `ms`.`id` DESC";
    $result = mysqli_query($mysqli, $sql);
 //   echo $sql;
    while ($row = mysqli_fetch_assoc($result)) {
        $product = $row['product'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $breedtype = $row['breedtype'];
        $total_unit = $row['total_unit'];
        $total_amount = $row['total_amount'];
        $unit = $row['unit'];
        $rate = $row['rate'];
        $sellername = $row['sellername'];
        $phoneno = $row['phoneno'];
        $address = $row['address'];
        $sold_cowname = $row['sold_cowname'];
        //echo $sold_cowname; 
        $sold_pname = $row['sold_pname'];
        $remark = $row['remark'];
    }
}

$sql1 = "SELECT `id`, `name` FROM `cowreg`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cname[$row['id']] = $row['name'];
    // echo $get_name[$row['name']];exit;
}

$sql1 = "SELECT `id`, `product` FROM `sb_productname`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_pname[$row['id']] = $row['product'];
    // echo $get_name[$row['name']];exit;
}

$sqlb1 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sqlb1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}

$sqlc1 = "SELECT `id`, `name`,`phoneno`,`address`  FROM `buyer`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_bname[$row['id']] = $row['name'];
    $get_bphone[$row['id']] = $row['phoneno'];
    $get_address[$row['id']] = $row['address'];
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
    $product = $_POST['product'];
    $sold_cowname = $_POST['sold_cowname'];
    $sold_pname = $_POST['sold_pname'];
    $date1 = $_POST['date'];
    $date = new DateTime($date1);
    $timestamp = $date->format('Y-m-d');
    $breedtype = $_POST['breedtype'];
    $total_unit = $_POST['total_unit'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $total_amount = $_POST['total_amount'];
    if ($product == "cow")
        $sold_pname = "";
    else if ($product == "product")
        $sold_cowname = "";
    $buyername = $_POST['buyername'];
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
    $cdate=date('y/m/d');
    if ($id) {
        $sql = "UPDATE `cowsell` SET `product`='$product',`sold_cowname`='$sold_cowname' ,`sold_pname`='$sold_pname',`date`='$timestamp',`total_unit`='$total_unit',`total_amount`='$total_amount',`rate`='$rate',`unit`='$unit',`sellername`='$buyername', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: cowsell.php?msg=3");
        exit;
    } else {
        $sql = "INSERT INTO `cowsell`(`product`,`sold_cowname`,`sold_pname`,`date`, `total_unit`,`total_amount`, `unit`,`rate`,`sellername`,`cby`, `cdate`, `cip`) VALUES('$product','$sold_cowname','$sold_pname', '$timestamp', '$total_unit','$total_amount','$unit','$rate', '$buyername','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: cowsell.php?msg=2");
        exit;
    }
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `cowsell` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "2";
    }
    header('Location: cowsell.php?msg=' . $msg);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Cattlesell</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                        <div class="row"><!--end .col -->
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Cattle/ Product Sale Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-6">
                                                        <input type="radio" tabindex="4" required="true" value="cow"<?php
                                                        if ($product == "cow") {
                                                            echo "checked";
                                                        }
                                                        ?> name="product" id="cproduct" > Is Cattle <sup style="color:red;">*</sup>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="radio" tabindex="5" required="true" value="product" <?php
                                                        if ($product == "product") {
                                                            echo "checked";
                                                        }
                                                        ?> name="product" id="mproduct" >  Is Product<sup style="color:red;">*</sup>
                                                    </div>
                                                    <div class="col-sm-7 form-group <?php
                                                    if ($product == "cow") {
                                                        echo "show";
                                                    } else {
                                                        echo "hide";
                                                    }
                                                    ?> " id="sold_cowname">
                                                        <select name="sold_cowname" id="sold_cowname" tabindex="1" class="form-control js-example-basic-single" required="true">
                                                            <option value="">Select Cattle Name</option>
                                                            <?php
                                                            if($sold_cowname) {
                                                                $sold_cowname1="`id`=".$sold_cowname;
                                                            } else {
                                                                $sold_cowname1='1';
                                                            }
                                                            $sql = "select * from cowreg where sold !='yes' AND `id` NOT IN (select sold_cowname from cowsell WHERE `sold_cowname` != '0' and $sold_cowname1)";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id1 = $row['id'];
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if ($sold_cowname == $id1) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $row['cowcode'] . " - " . $row['name'] . " - " . $get_breedtype[$row['breedtype']]; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        <label for="sold_cowname">&nbsp; &nbsp;Sold Cattlename<sup style="color:red;">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-8  col-sm-offset-4 form-group <?php
                                                    if ($product == "product") {
                                                        echo "show";
                                                    } else {
                                                        echo "hide";
                                                    }
                                                    ?>" id="sold_pname">
                                                        <select name="sold_pname" id="sold_pname" tabindex="1" class="form-control js-example-basic-single" required="true">
                                                            <option value="">Select Product Name</option>
                                                            <?php
                                                            $sql = "select * from sb_productname ORDER BY id DESC";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id1 = $row['id'];
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if ($sold_pname == $id1) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $row['product']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        <label for="sold_cowname">&nbsp; &nbsp;Sold Product Name<sup style="color:red;">*</sup></label>
                                                    </div>
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
                                            <div class="row" id= "total">
                                                <div class="col-sm-2 form-group <?php
                                                if ($product != "product") {
                                                    echo 'hide';
                                                }
                                                ?>" id="unit" >
                                                    <select name="unit" tabindex="1"  required="true" class="form-control js-example-basic-single"> <?php echo $unit; ?>
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
                                                    <label for="rate">&nbsp; &nbsp;select Unit<sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-4 form-group <?php
                                                if ($product != "product") {
                                                    echo 'hide';
                                                }
                                                ?>" id="price">
                                                    <input type="text" name="rate" id="price_val" required="true"  min="1" tabindex="1" value="<?php echo $rate; ?>"class="form-control">
                                                    <label for="rate">&nbsp; &nbsp;Price (Per unit)<sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group <?php
                                                if ($product != "product") {
                                                    echo 'hide';
                                                }
                                                ?>" id="total_unit" >
                                                    <input type="number" class="form-control"  id="total_unit_val" required="true" name="total_unit" tabindex="1" value="<?php echo $total_unit; ?>">
                                                    <label for="rate">&nbsp; &nbsp; Total Unit <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class = "col-sm-6 form-group ">
                                                    <select name="buyername" id="sellername" tabindex="1" class="form-control js-example-basic-single" required="true"> <?php echo $sellername; ?>
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
                                                    <input type="number" id="total_amount" min="1" class="form-control" required="true" name="total_amount" tabindex="1" value="<?php echo $total_amount; ?>">
                                                    <label for="total_amount">&nbsp; &nbsp;Total Amount</label>
                                                </div>
                                            </div>
                                            <div class="row" id="buyer_detail">
                                                <div class="col-sm-6 form-group ">
                                                    <input type="number" readonly class="form-control" required="true" name="phoneno" tabindex="1" value="<?php echo $phoneno; ?>">
                                                    <label for="phoneno">&nbsp; &nbsp;Contact Number</label>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <textarea id="address" class="form-control" name="address" rows="5" style="resize:none;width:100%;" readonly><?php echo $address; ?></textarea>
                                                    <label for="address">&nbsp; &nbsp;Address</label>
                                                </div>
                                            </div>
                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" onClick="return confirm('Do You Sale This')" name="save" class="btn ink-reaction btn-raised btn-primary">Save</button>
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
                                        </form>
                                    </div>
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
                                        <header> Cattle/ Product Sales Report</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div id="regwise_select" class="tbgetsect table-responsive">
                                                <table id="datatable1" class="table diagnosis_list " >
                                                    <thead>
                                                        <tr>                                    
                                                            <th>S.No</th>
                                                            <th>Actions</th>
                                                            <th>Date</th> 
                                                            <th>Product</th> 
                                                            <th>Sold_Cattlename</th>
                                                            <th>Sold_Productname</th>
                                                            <th>Unit</th>
                                                            <th>Total_Unit</th>
                                                            <th>Rate_per_Unit </th>
                                                            <th>Total_Amount</th>
                                                            <th>Paid</th>    
                                                            <th>Buyer_Name </th>
                                                            <th>Contact</th>
                                                            <th> Address </th>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select `ms`.*,`by`.`name`,`by`.`phoneno`, `by`.`address` from cowsell `ms` cross join `buyer` `by` on `by`.`id`=`ms`.`sellername`  ORDER BY `id` DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            ?>
                                                            <tr  id="<?php echo $row['id']; ?>"  >
                                                                <td><?php echo $i; ?></td>
                                                                <td class="text-left">  
                                                                    <?php
                                                                    $NumType = 0;
                                                                    $sql_type = "select * from `income` WHERE  `cowsell_id` = '$id'";
                                                                    $result_type = mysqli_query($mysqli, $sql_type);
                                                                    if (!mysqli_num_rows($result_type)) {
                                                                        ?>   
                                                                        <a href="cowsell.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                        <a href="cowsell.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>

                                                                    <?php } ?>
                                                                </td>
                                                                <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                                                                <td><?php echo $row['product']; ?></td>
                                                                <td><?php
                                                                    if (isset($get_cname[$row['sold_cowname']])) {
                                                                        echo $get_cname[$row['sold_cowname']];
                                                                    }
                                                                    ?></td>
                                                                <td><?php
                                                                    if (isset($get_pname[$row['sold_pname']])) {
                                                                        echo $get_pname[$row['sold_pname']];
                                                                    }
                                                                    ?></td>
                                                                <td style="text-align: right;"><?php if ($row['unit']) {
                                                                    echo $get_uname[$row['unit']];
                                                                } ?></td>
                                                                <td style="text-align: right;"><?php echo $row['total_unit']; ?></td>
                                                                <td style="text-align: right;"><?php echo $row['rate']; ?></td>
                                                                <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['total_amount']); ?></td>
                                                                <td style="text-align: right;"><?php echo sprintf('%0.2f', $row['paid']); ?></td>
                                                                <td><?php echo $row['name']; ?></td>
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
                                        </form>
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
                $("#demo-date").datepicker({
                    format: 'dd-mm-yyyy',
                    startDate: '1-3-2019',
                    endDate: '+0d',
                });
            </script>
            <script type="text/javascript">
                $(document).on('change', '#district', function (e) {
                    var distic = $(this).val();
                    $.post("cowsell.php",
                            {
                                distic: distic,
                            },
                            function (data, status) {
                                $("#destirctview").html(data);
                            });

                });

                function check() {
                    document.getElementById("rate").value = '/ 1 ' + document.getElementById("getqnty").value;
                }
                function taluck1() {
                    document.getElementById("palce").value = document.getElementById("taluck").value;
                }

                $(function () {
                    var imagesPreview = function (input, placeToInsertImagePreview) {
                        if (input.files) {
                            var filesAmount = input.files.length;
                            for (i = 0; i < filesAmount; i++) {
                                var reader = new FileReader();
                                reader.onload = function (event) {
                                    $($.parseHTML('<img width="80px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                }
                                reader.readAsDataURL(input.files[i]);
                            }
                        }
                    };
                    $('#gallery-photo-add').on('change', function () {
                        imagesPreview(this, 'div.gallery');
                    });
                });
            </script>
            <script>
                $('#sellername').change(function () {
                    var sellername_variable = $(this).val();
                    $.post("cowsell.php",
                            {
                                sellername_for_post: sellername_variable,
                            },
                            function (data, status) {
                                $('#buyer_detail').html(data);
                            });
                });
                $('input[name=product]').change(function () {
                    var sold = $('input[name=product]:checked').val();
                    if (sold === "cow") {
                        $("#sold_cowname").removeClass("hide");
                        $("#sold_pname").addClass("hide");
                    } else {
                        $("#sold_cowname").addClass("hide");
                        $("#sold_pname").removeClass("hide");
                    }
                });

            </script>
            <script>
                function balance()
                {
                    var amount = $("#amount").val();
                    var paid = $("#paid").val();
                    var balance = parseInt(amount) - parseInt(paid);
                    $("#balance").val(balance);
                }

                $("#amount").keyup(function () {
                    balance();
                });
                $("#paid").change(function () {
                    balance();
                });

            </script>
            <script>
                function total_amount()
                {
                    var total_unit = $("#total_unit_val").val();
                    var rate = $("#price_val").val();
//                     alert(rate);
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
            <script>
                $('input[name=product]').change(function () {
                    var active = $('input[name=product]:checked').val();
                    if (active === "product") {
                        $("#price").removeClass("hide");
                        $("#total_unit").removeClass("hide");
                        $("#unit").removeClass("hide");

                    } else {

                        $("#price").addClass("hide");
                        $("#total_unit").addClass("hide");
                        $("#unit").addClass("hide");

                    }
                });
            </script>
            <script>
<?php if ($msg == '2') { ?>
                    Command: toastr["success"]("Sold  sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                    Command: toastr["error"]("Some Error Occur", "Error")
<?php } elseif ($msg == '3') { ?>
                    Command: toastr["success"]("Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                    Command: toastr["success"]("Deleted Sucesssfully", "Sucesss")
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