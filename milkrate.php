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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `milktype` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $milktype = $row['milktype'];
        $rate = $row['rate'];
        $cdate = $row['cdate'];
        $dob = $row['dob'];
    }
}

$sql1 = "SELECT `id`, `milktype1` FROM `milktype1`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_milktype[$row['id']] = $row['milktype1'];
// echo $get_milktype[$row['milktype']];exit;
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
//cho 'hhkhljljl';exit;
}
if (isset($_POST['save'])) {

    $cdate = date('y/m/d');
    $milktype = $_POST['milktype'];
    $rate = $_POST['rate'];
    $dob = $_POST['dob'];
    if ($id) {
//        $sql1 = "SELECT  `milktype`, `rate`, `dob`, `cdob`, `cdate`  where id='$id'";
//        $result1 = mysqli_query($mysqli, $sql1);
//        while ($row = mysqli_fetch_assoc($result1)) {
//            $sql = "INSERT INTO `milktype`(`milktype`, `rate`, `dob`, `cdob`, `cdate`) VALUES ($row[milktype],$row[rate],$row[dob],$row[cdob],$row[cdob])";
//            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
//        }

        $sql = " UPDATE `milktype` SET `milktype`='$milktype',`rate`='$rate',`dob`='$dob' WHERE id='$id'";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: milkrate.php?msg=3");
        exit;
    } else {
//        $sql = "INSERT INTO `milktype`(`milktype`, `rate`, `dob`, `cdate`) VALUES ('$milktype','$rate','$dob','$cdate')";
////        echo $sql;exit;
//        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: milkrate.php?msg=5");
        exit;
    }
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `milktype` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "1";
    }
    header('Location: milkrate.php?msg=' . $msg);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Milk Rate</title>
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

        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <form class="form form-validate" role="form" method="POST">
                                        <div class="card-head style-primary">
                                            <header>Update Milk Rate</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class = "col-sm-6 form-group ">
                                                    <select name="milktype"required="true" id="milktype" tabindex="1" class="form-control js-example-basic-single">
                                                        <option value="<?php echo $milktype; ?>">&nbsp;</option>
                                                        <?php
                                                        $sql = "select * from milktype1 ";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                        if ($milktype == $id1) {
                                                            echo "selected";
                                                        }
                                                            ?>><?php echo $row['milktype1']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="milktype">&nbsp; &nbsp;Milk Type <sup style="color:red;">*</sup></label>
                                                </div>
                                                <div class="col-sm-6 form-group ">
                                                    <input type="text" class="form-control" min="1" maxlength="3" required="true" name="rate" tabindex="1" value="<?php echo $rate; ?>">
                                                    <label for="rate">&nbsp; &nbsp;Rate Per Liter <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <input type="date" class="form-control" required="true" name="dob" max = "<?php echo date('Y-m-d'); ?>" tabindex="1" value="<?php echo $dob; ?>">
                                                    <label for="dob">&nbsp; &nbsp;Changed Date <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div>


                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>
                                                    <div class="col-md-2">
                                                        <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>
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
                        <div class="row"><!--end .col -->
                            <div class=" col-md-12 col-sm-12">
                                <!--<h2 class="text-primary">Please Fill the Details</h2>-->
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Milk Rate Entry Information</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">

                                            <div id="regwise_select" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th>SlNo</th>
                                                            <th>Actions</th>
                                                            <th>Change Date</th>
                                                            <th>Milk Type</th>
                                                            <th>Rate Per Liter</th> 
<!--                                                            <th>New Date</th>
                                                            <th>Milk Type</th>
                                                            <th>Rate</th>         -->
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select * from milktype ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            ?>
                                                            <tr  id="<?php echo $row['id']; ?>"  >
                                                                <td><?php echo $i; ?></td>
                                                                <td class="text-left">   
                                                                    <a href="milkrate.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                    <!--<a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>-->

                                                                                <!--<a href="milkrate.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>-->

                                                                </td>
                                                                <!--<td><?php echo $row['MAX(dob)']; ?></td>-->
                                                                <td><?php echo date('d/m/Y',  strtotime($row['dob'])); ?></td>
                                                                <!--<td><?php echo $row['cdate']; ?></td>-->
                                                                <td><?php echo $get_milktype[$row['milktype']]; ?></td>
                                                                <td><?php echo $row['rate']; ?></td>
    <!--                                                                <td><?php echo $row['dob']; ?></td>
                                                                <td><?php echo $row['cdate']; ?></td>                                                                
                                                                <td><?php echo $get_milktype[$row['milktype']]; ?></td>
                                                                <td><?php echo $row['rate']; ?></td>-->
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
                Command: toastr["success"]("Milk Rate Added  sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Some error occur", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"](" Deleted Sucesssfully", "Sucesss")
<?php } elseif ($msg == '5') {
    ?>
                Command: toastr["error"]("Can't Insert", "Error")
<?php } ?>

        </script>

    </body>
</html>

