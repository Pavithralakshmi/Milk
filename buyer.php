<?php
session_start();
$user = $_SESSION['user'];
//$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $name = $timestamp = $date = $product = $amount = $phoneno = $address = $id = $remark = "";
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
    $sql = "SELECT * FROM `buyer` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $phoneno = $row['phoneno'];
        $address = $row['address'];
        $remark = $row['remark'];
    }
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
//cho 'hhkhljljl';exit;
}
if (isset($_POST['save'])) {
    $cdate=date('y/m/d');
    $name = trim($_POST['name']);
    $timestamp = date("Y-m-d", strtotime($_POST['date']));
    $phoneno = $_POST['phoneno'];
    $address = $_POST['address'];
    $remark = $_POST['remark'];
    if ($id) {
        $check = "select * from `buyer` where phoneno='$phoneno'AND id !='$id'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "UPDATE `buyer` SET `date`='$timestamp',`name`='$name',`phoneno`='$phoneno',`address`='$address',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: buyer.php?msg=3");
        }
       
    } else {
        $check = "select * from `buyer` where phoneno='$phoneno'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "INSERT INTO `buyer`(`date`, `name`,`phoneno`, `address`,`remark`,`cby`, `cdate`, `cip`) VALUES ('$timestamp','$name','$phoneno', '$address','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: buyer.php?msg=2");
        }
    }
}


if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `buyer` where `id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "1";
    }
    header('Location: buyer.php?msg=' . $msg);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Buyer Registration</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>
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
                                        <header>Buyer Registration</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <input type="text" class="form-control" required="true" name="name" maxlength="35" minlength="3" tabindex="1" value="<?php echo $name; ?>">
                                                    <label for="name">&nbsp; &nbsp;Buyer Name <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <label for="dob">&nbsp; &nbsp;  Register Date <sup style="color:red;">*</sup></label>
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
                                                <div class="col-sm-6 form-group">
                                                    <input type="number" class="form-control" required="true" name="phoneno" minlength="10" maxlength="12" pattern="[789][0-9]{9}"tabindex="1" value="<?php echo $phoneno; ?>">
                                                    <label for="phoneno">&nbsp; &nbsp;Contact Number <sup style="color:red;">*</sup></label>
                                                </div>

                                                <div class="col-sm-6 form-group">
                                                    <label for="address">&nbsp; &nbsp;Address <sup style="color:red;">*</sup></label>
                                                    <textarea id="address" class="form-control" required="true" name="address" rows="5" style="resize:none;width:100%;" ><?php echo $address; ?></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="1" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                </div>
                                            </div>
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">
                                                    <div class="row text-right">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
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
                            </section>
                            <section>
                                <div class="section-body contain-lg">
                                    <div class="row">
                                        <div class=" col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-head style-primary" style="width:100%;">
                                                    <header>Buyer Details</header>
                                                </div>
                                                <div class="card-body">
                                                    <div id="regwise_select" class="tbgetsect table-responsive">
                                                        <table id="datatable1" class="table diagnosis_list " >
                                                            <thead>
                                                                <tr>                                    
                                                                    <th>S.No</th>
                                                                    <th>Actions</th>
                                                                    <th>Name</th>     
                                                                    <th>Date</th>     
                                                                    <th>Phoneno</th> 
                                                                    <th>Address</th>            
                                                                    <th>Remark</th>     
                                                                </tr>
                                                            </thead>
                                                            <tbody class="ui-sortable" >
                                                                <?php
                                                                $i = 1;
                                                                $sql = "select * from buyer ORDER BY id DESC";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id = $row['id'];
                                                                    ?>
                                                                    <tr  id="<?php echo $row['id']; ?>"  >
                                                                        <td><?php echo $i; ?></td>
                                                                        <td class="text-left">   
                                                                            <a href="buyer.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                            <?php
                                                                            $NumType = 0;
                                                                            $sql_type = "select `id` from `cowsell` where `phoneno` = '$row[phoneno]' UNION select `id` from `milksell` where `phoneno` = '$row[phoneno]' ";
                                                                            $result_type = mysqli_query($mysqli, $sql_type);
                                                                            if (!mysqli_num_rows($result_type)) {
                                                                                ?>   
                                                                                <a href="buyer.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                                                                    <?php } ?>
                                                                        </td>
                                                                        <td><?php echo $row['name']; ?></td>
                                                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                                                        <td><?php echo $row['phoneno']; ?></td>
                                                                        <td><?php echo  nl2br($row['address']); ?></td>
                                                                        <td><?php echo nl2br($row['remark']); ?></td>
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
<?php if ($msg == '2') { ?>
                            Command: toastr["success"]("Buyer Details Registered  Sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                            Command: toastr["error"]("Same Buyer already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                            Command: toastr["success"]("Register Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                            Command: toastr["success"]("Register Deleted Sucesssfully", "Sucesss")
<?php } ?>
                    </script>

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
                        function goBack() {
                            event.preventDefault();
                            history.back(1);
                        }
                    </script>
                    </body>
                    </html>

