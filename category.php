<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = "";
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/MM/";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';
$aname = $id = $msg = $image_edit = $color_code = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'])) {
    $encrypt_action = $_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'];
    $action = encrypt_decrypt('decrypt', $encrypt_action);
    $encrypt_id = $_GET['WnAyV3FOdHJ3dkNiMEgrMGxVcytZUT09'];
    $id = encrypt_decrypt('decrypt', $encrypt_id);
    //echo $action.$id;exit;
    if ($action == 'edit') {
        $sql = "select * from `category` where `category_id` = '$id' ";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $aname = $row['category_name'];
            $image_edit = $row['images'];
        }
    } else if ($action == 'deactive') {
        $sql = "UPDATE `category` SET `status` = '1' where `category_id`='$id'";
        $result = mysqli_query($mysqli, $sql);
        $sql = "DELETE uc FROM user_cart uc INNER JOIN stock_entry se ON se.`stock_id` = uc.`model_id` WHERE se.`type` = '$id' AND uc.`status` = '0'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Category Deactivated");
        header("Location: category.php?msg=3");
    } else if ($action == 'active') {
        $sql = "UPDATE `category` SET `status` = '0' where `category_id`='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Category Activated");
        header("Location: category.php?msg=3");
    } else if ($action == 'delete') {
        $sql = "DELETE FROM `category` where `category_id`='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Category Deleted");
        $sql = "DELETE uc FROM user_cart uc INNER JOIN stock_entry se ON se.`stock_id` = uc.`model_id` WHERE se.`type` = '$id' AND uc.`status` = '0'";
        $result = mysqli_query($mysqli, $sql);
        header("Location: category.php?msg=4");
    }
}
if (isset($_POST['save'])) {
    $aname = $_POST['category_name'];
    $uploaddir = 'assets/category_images/';
    $image_rand = mt_rand("0000", "9999");
//image update
    if (isset($_FILES['category_image'])) {
        $file_name = $_FILES['category_image']['name'];
        $file_type = $_FILES['category_image']['type'];
        $temp_name = $_FILES['category_image']['tmp_name'];
        if ($file_name) {
            if ($image_edit) {
                $del_lnik1 = explode('/', $image_edit);
                $imag1 = end($del_lnik1);
                chmod($uploaddir . $imag1, 465);
                unlink($uploaddir . $imag1);
            }
            $name = explode(".", $file_name);
            $loc = $image_rand . "." . $name[1];
            $uploadfile = $uploaddir . basename($loc);
            if (file_exists($uploadfile)) {
                $increment = 0;
                while (file_exists($uploadfile)) {
//                $increment++;
                    $loc = $image_rand . $increment . '.' . $name[1];
                    $uploadfile = $uploaddir . basename($loc);
                    $increment++;
                }
                move_uploaded_file($temp_name, $uploadfile);
                $image_edit = $actual_link . $uploadfile;
            } else {
                move_uploaded_file($temp_name, $uploadfile);
                $image_edit = $actual_link . $uploadfile;
            }
        }
    }
    if ($id) {
        $sql = "select * from `category` where `category_name`= '$aname' AND `category_id`!='$id' ";
        $result = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($result)) {
            $msg = 1;
        } else {
            $sql = "UPDATE `category` SET  `category_name` = '$aname', `images` = '$image_edit', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') where `category_id`= '$id' ";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            accesslog($user, $datetime, "Category Updated");
            header("Location: category.php?msg=3");
        }
    } else {
        $sql = "select * from category where category_name= '$aname'";
        $result = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($result)) {
            $msg = 1;
        } else {
            $sql = "INSERT INTO `category` (`category_name`, `images`, `status`, `cby`, `cdate`, `cip`)"
                    . " VALUES ('$aname', '$image_edit','0','$user', '$datetime', '$_SERVER[REMOTE_ADDR]')";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            accesslog($user, $datetime, "Category Inserted");
            header("Location: category.php?msg=2");
        }
    }
}
if (isset($_POST['order'])) {
    $id_array = $_POST['order'];
    foreach ($id_array as $key => $value) {
        if ($value) {
            $sql = "UPDATE `category` SET `position`='$key' where category_id='$value'";
            $result = mysqli_query($mysqli, $sql);
            accesslog($user, $datetime, "Category Position Changed");
        }
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>மகளிர் மட்டும்  - Category</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <script src="assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function () {
                //Helper function to keep table row from collapsing when being sorted               
                var fixHelperModified = function (e, tr) {
                    var $originals = tr.children();
                    //alert($originals);
                    var $helper = tr.clone();
                    $helper.children().each(function (index)
                    {
                        $(this).width($originals.eq(index).width())
                    });
                    return $helper;
                };

                //Make diagnosis table sortable
                $(".diagnosis_list tbody").sortable({
                    //alert('hi');
                    helper: fixHelperModified,
                    stop: function (event, ui) {
                        renumber_table('.diagnosis_list')

                    }
                }).disableSelection();
            });
            //Renumber table rows
            function renumber_table(tableID) {
                //alert('hi');
                var all = new Array();
                $(tableID + " tr").each(function () {
                    var trid = $(this).attr('id'); // table row ID   
                    //alert(trid);
                    count = $(this).parent().children().index($(this)) + 1;
                    $(this).find('.priority').html(count);
                    all[count] = trid;
                    //alert(JSON.stringify(all));
                });
                $.post("category.php",
                        {
                            order: all
                        },
                        function (data, status) {
                            alert(status);
                        });
            }
        </script>
        <style>
            .ui-sortable tr {
                cursor:pointer;
            }
            .ui-sortable tr:hover {
                background:rgba(244,251,17,0.45);
            }
        </style>
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN HEADER-->
        <?php include_once $prefix . 'include/header.php'; ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">

            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">                       
                        <div class="row">                                                                        
                            <div class="col-lg-offset-3 col-md-6">
                                <div class="card center-block">
                                    <div class="card-head style-primary">
                                        <header>Add category</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST" enctype="multipart/form-data">
                                            <div class="form-group floating-label">
                                                <input tabindex="1" type="text" value="<?php
                                                if ($aname) {
                                                    echo $aname;
                                                }
                                                ?>" name="category_name"  class="form-control" required>
                                                <label>Add category Name *</label>
                                            </div>
                                            <div class="form-group floating-label">
                                                <input tabindex="1"  type="file" name="category_image" id="category_image" accept="image/*" class="form-control" <?php if (!$id) {
                                                           echo "required";
                                                       } ?>>
                                            </div>
                                            <button tabindex="3" type="reset" name="cancel" class="btn btn-flat btn-default-light ink-reaction">Cancel</button>
                                            <button tabindex="2" type="submit" name="save" class="btn ink-reaction btn-raised btn-primary ">Save</button>
                                        </form>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                        <?php
                        $id_string = encrypt_decrypt("encrypt", "id");
                        $action_string = encrypt_decrypt("encrypt", "action");
                        $edit_string = encrypt_decrypt("encrypt", "edit");
                        $delete_string = encrypt_decrypt("encrypt", "delete");
                        $active_string = encrypt_decrypt("encrypt", "active");
                        $deactive_string = encrypt_decrypt("encrypt", "deactive");
                        ?>
                        <div class="row">
                            <div class="col-md-8 col-lg-offset-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="text-primary">View/Edit Category</h2>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table diagnosis_list">
                                                <thead>
                                                    <tr>                                    
                                                        <th>S.No</th>
                                                        <th>Actions</th>
                                                        <th>Category Name</th>
                                                        <th>Image</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="ui-sortable" >
                                                    <?php
                                                    $i = 1;
                                                    $sql = "select * from `category` order by `position` asc";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = encrypt_decrypt('encrypt', $row['category_id']);
                                                        ?>
                                                        <tr  id="<?php echo $row['category_id']; ?>"  >
                                                            <td class="priority"><?php echo $i; ?></td>
                                                            <td class="text-left">
                                                                <a href="category.php?<?php echo $action_string . '=' . $edit_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                <!--<a href="category.php?<?php echo $action_string . '=' . $delete_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" onclick="return confirm('You are going to delete ?')" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button></a>-->
                                                                <?php if ($row['status'] == '1') { ?>
                                                                    <a href="category.php?<?php echo $action_string . '=' . $active_string . '&' . $id_string . '=' . $id; ?>" type="button" class="btn ink-reaction btn-block-action btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Active now"><i class="glyphicon glyphicon-remove"></i> &nbsp; Active </a>
                                                                <?php } else { ?>
                                                                    <a href="category.php?<?php echo $action_string . '=' . $deactive_string . '&' . $id_string . '=' . $id; ?>" type="button" class="btn ink-reaction btn-block-action btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="InActive now"><i class="fa fa-close"></i> &nbsp; In-Active</a>
    <?php } ?>
                                                            </td>
                                                            <td><?php echo $row['category_name']; ?></td>
                                                            <td><img src="<?php echo $row['images']; ?>" width="80px" height="80px"></td>
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
                    </div><!--end .section-body -->
                </section>
            </div><!--end .section-body -->
            <!-- END CONTENT -->
            <!-- BEGIN MENUBAR-->
<?php include_once $prefix . 'include/menubar.php'; ?>
            <!-- END MENUBAR -->
        </div><!--end .offcanvas-->
        <!-- BEGIN JAVASCRIPT -->
<?php //include_once $prefix . 'include/jsfiles.php';   ?>
        <script src="<?php echo $prefix; ?>assets/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/autosize/jquery.autosize.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/toastr/toastr.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/App.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppNavigation.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppOffcanvas.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppCard.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppForm.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppNavSearch.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/source/AppVendor.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/demo/Demo.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/demo/DemoFormComponents.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/core/demo/DemoTableDynamic.js"></script>
        <script src="<?php echo $prefix; ?>assets/js/libs/select2/select2.min.js"></script>

        <script src="<?php echo $prefix; ?>assets/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <!-- END JAVASCRIPT -->
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"]("Category added sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Same Category Name already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Category Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Category Deleted Sucesssfully", "Sucesss")
<?php } ?>

        </script>
        <script>
            $('#datatable3').DataTable({
                "dom": 'lCfrtip',
                "order": [],
                "colVis": {
                    "buttonText": "Columns",
                    "overlayFade": 0,
                    "align": "right"
                },

            });
        </script>
    </body>
</html>