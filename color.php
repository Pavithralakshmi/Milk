<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $cowcolor=$id="";
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
    $sql = "SELECT * FROM `cowcolor` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $cowcolor = $row['cowcolor'];
    }
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
//cho 'hhkhljljl';exit;
if (isset($_POST['save'])) {
$cdate=date('y/m/d');
    $cowcolor = $_POST['cowcolor'];
    if ($id) {
        $check = "select * from `cowcolor` where cowcolor='cowcolor'AND id !='$id'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = " UPDATE `cowcolor` SET `cowcolor`='$cowcolor', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: color.php?msg=3");
            exit;
        }
    } else {
        $check = "select * from `cowcolor` where cowcolor='$cowcolor'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "INSERT INTO `cowcolor`(`cowcolor`,`cby`, `cdate`, `cip`) VALUES ('$cowcolor','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
//         echo $sql;exit;
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: color.php?msg=2");
            exit;
        }
    }
}
if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `cowcolor` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "1";
    }
    header('Location: color.php?msg=' . $msg);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Add Color</title>
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
                                            <header>Add Cattle Color</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-sm-12 form-group ">
                                                    <input type="text" class="form-control" maxlength="25" minlength="3" required="true" name="cowcolor" tabindex="1" value="<?php echo $cowcolor; ?>">
                                                    <label for="cowcolor">&nbsp; &nbsp;Cattle Color<sup style="color:red;">*</sup></label>
                                                </div>

                                            </div>

                                            <!-- 
                                                                                        <div class="card-actionbar">
                                                                                            <div class="card-actionbar-row"> -->

                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" name="save">Save</button>

                                                    <div class="col-md-2">
                                                        <?php if ($id) { ?>
                                                            <!--<button type="reset"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>-->
                                                            <button onclick="goBack()" class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                        <?php } else {
                                                            ?>
                                                            <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Reset</button>
                                                        <?php } ?>

                                                    </div>

                                                </div>
                                            </div>
                                            <!-- </div> -->
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
                                        <header>Product List</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">

                                            <div id="regwise_select" class="tbgetsect">
                                                <table id="datatable1" class="table diagnosis_list">
                                                    <thead>
                                                        <tr>                                    
                                                            <th>S.No</th>
                                                            <th>Actions</th>
                                                            <th>Cattle Color</th>          
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "select * from cowcolor ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            ?>
                                                            <tr  id="<?php echo $row['id']; ?>"  >
                                                                <td><?php echo $i; ?></td>
                                                                <td class="text-left">   
                                                                    <a href="color.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                    <!--<a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>-->

                                                                        <!--<a href="color.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>-->
                                                                    <?php
                                                                    $NumType = 0;
                                                                    $sql_type = "select * from `cowreg` WHERE  `cowcolor` = '$row[id]' ";
                                                                    $result_type = mysqli_query($mysqli, $sql_type);
                                                                    if (!mysqli_num_rows($result_type)) {
                                                                        ?>   
                                                                        <a href="color.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                                                            <?php } ?>

                                                                </td>
                                                                <td><?php echo $row['cowcolor']; ?></td>
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
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"]("Cow Color Added  sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Same Cow Color already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Cow Color Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Cow Color Deleted Sucesssfully", "Sucesss")
<?php } ?>
        </script>
    </body>
</html>

