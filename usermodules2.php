<?php
session_start();
$user = $_SESSION['user'];
// $ugroup = $_SESSION['ugroup'];
$name = $_SESSION['name'];
// $mp = $_SESSION['modify_per'];
$pageurl = $_SERVER['REQUEST_URI'];
$localurl = str_replace('/bookstore/', '', $pageurl);
$lcurl = explode("?", $localurl);
$prefix = "";
$prefix1 = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}

include_once $prefix . 'db.php';
$category_name = array();
$ch2 = "select * from usermodules";
$de2 = mysqli_query($mysqli, $ch2);
while ($data2 = mysqli_fetch_assoc($de2)) {
    $category_name[$data2['id']] = $data2['mname'];
}
$icons = $submenu = $url = $mname = $id = $msg = $parent = $icons = $idd = '';
$url1 = $sid = $subid = $parent_submenu = $parent_parent = '';
$category = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'])) {
    $encrypt_action = $_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'];
    $action = encrypt_decrypt('decrypt', $encrypt_action);
    $encrypt_id = $_GET['WnAyV3FOdHJ3dkNiMEgrMGxVcytZUT09'];
    $id = encrypt_decrypt('decrypt', $encrypt_id);
    if ($action == 'edit') {
        $sql = "SELECT a.id,a.parent, b.parent as parent_parent, a.mname, a.url, a.icons, a.submenu, b.submenu as parent_submenu, a.status FROM `usermodules` a LEFT JOIN `usermodules` b ON a.parent = b.id WHERE a.id='$id' ";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $idd = $row['id'];
            $mname = $row['mname'];
            $submenu = $row['submenu'];
            $parent = $row['parent'];
            $parent_parent = $row['parent_parent'];
            $parent_submenu = $row['parent_submenu'];
            $url = $row['url'];
            $icons = $row['icons'];
        }
    } else if ($action == 'deactive') {
        $sql = "UPDATE `usermodules` SET `status` = '1' where id='$id' OR parent='$id'";
        $result = mysqli_query($mysqli, $sql);
        $sql = "UPDATE `usermodules` SET `status` = '1' where `parent`='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Menu Deactivated");
        header("Location: usermodules2.php?msg=3");
    } else if ($action == 'active') {
        $sql = "UPDATE `usermodules` SET `status` = '0' where id='$id' OR parent='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Menu activated");
        header("Location: usermodules2.php?msg=3");
    } else if ($action == 'delete') {
        $sql = "DELETE FROM `usermodules` where id='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Menu deleted");
        header("Location: usermodules2.php?msg=4");
    }
}
if (isset($_POST['order'])) {
    $id_array = $_POST['order'];
//    echo $id_array;    
    foreach ($id_array as $key => $value) {
        if ($value) {
            $sql = "UPDATE `usermodules` SET `position`='$key' where id='$value'";
            $result = mysqli_query($mysqli, $sql);
            accesslog($user, $datetime, "Menu position changed");
        }
    }
    exit;
}

if (isset($_POST['save'])) {
    $parent = $submenu = $scategory = 0;
    $mname = $_POST['mname'];
    $parent = $_POST['parent'];
    $url = $_POST['url'];
    if (isset($_POST['submenu'])) {
        $submenu = $_POST['submenu'];
    }
    if (isset($_POST['category'])) {
        $scategory = $_POST['category'];
    }
    if (isset($_POST['icons'])) {
        $icons = $_POST['icons'];
    }
//    echo $scategory; exit;
    if ($id) {
        if ($scategory) {
            $sql = "select * from `usermodules` where `mname`= '$mname' AND `parent` = '$scategory' AND `url`='$url' AND  `id`!='$id' ";
        } else {
            $sql = "select * from `usermodules` where `mname`= '$mname' AND `parent` = '$parent' AND `url`='$url' AND  `id`!='$id' ";
        }
//        echo $sql;exit;
        $result = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($result)) {
            $msg = 1;
        } else {
            if ($scategory) {
                $sql = "UPDATE `usermodules` SET  `mname` = '$mname', `parent` = '$scategory',`url` = '$url',  `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') where `id`= '$id' ";
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            } else {
//                $sql = "UPDATE `usermodules` SET  `parent` = '0',`mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') where `id`= '$id' ";
//                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                $sql = "UPDATE `usermodules` SET  `mname` = '$mname', `parent` = '$parent',`url` = '$url', `icons` = '$icons', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') where `id`= '$id' ";
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            }
            accesslog($user, $datetime, "Menu updated");
            header("Location: usermodules2.php?msg=3");
        }
    } else {
        $sql = "select * from `usermodules` where (mname= '$mname' AND `parent` = '$parent') ";
//        echo $sql; exit;
        $result = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($result)) {
            $msg = 1;
        } else {
            $sql = "select * from `usermodules` where (mname= '$mname' AND `parent` = '$scategory') ";
//        echo $sql; exit;
            $result = mysqli_query($mysqli, $sql);
            if (mysqli_num_rows($result)) {
                $msg = 1;
            } else {
                if ($scategory) {
                    $sql = "INSERT INTO `usermodules` (`mname`, `parent`, `url`,`submenu`,`icons`,`status`,`position`, `cby`, `cdate`, `cip`)"
                            . " VALUES ('$mname', '$scategory', '$url','$submenu', '$icons','0', '1', '$user', '$datetime', '$_SERVER[REMOTE_ADDR]')";
//                            echo "if".$sql;exit;
                } else {
                    $sql = "INSERT INTO `usermodules` (`mname`, `parent`, `url`,`submenu`,`icons`,`status`,`position`, `cby`, `cdate`, `cip`)"
                            . " VALUES ('$mname', '$parent', '$url','$submenu', '$icons','0', '1', '$user', '$datetime', '$_SERVER[REMOTE_ADDR]')";
                }
//echo "else".$sql;exit;
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                accesslog($user, $datetime, "Menu inserted");
                header("Location: usermodules2.php?msg=2");
            }
        }
    }
}
if (isset($_POST['parent_cat'])) {
    $dt = $_POST['parent_cat'];
    //echo $dt;
    $sql5 = "select * from `usermodules` Where submenu='1' AND `parent`='$dt' ";
    $result = mysqli_query($mysqli, $sql5);
    if (mysqli_num_rows($result)) {
        ?>   
        <div class="row">
            <div class=" col-sm-6  form-group ">
                <select tabindex="1"  name="category" class="form-control">
                    <option value="">&nbsp;</option>
                    <?php
                    while ($row5 = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $row5['id']; ?>" <?php
                        if ($parent == $row5['id']) {
                            echo 'selected';
                        }
                        ?>><?php echo $row5['mname']; ?></option>
                                <?php
                            }
                            ?>                                            
                </select>                                       
                <label for="category_id">Select Submenu Category</label>   
            </div>
        </div>
        <?php
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NITHRA - User Modules</title>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <script src="<?php echo $template_prefix; ?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
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
                $.post("usermodules2.php",
                        {
                            order: all
                        },
                        function (data, status) {
                            // alert(data);
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
        <?php include_once $prefix . 'include/header.php'; ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">     
                        <?php if ($msg == '2') { ?>
                            <div class="row info-box">                                                                        
                                <div class="col-md-4 col-lg-offset-4">
                                    <div class="card center-block">
                                        <div class="card-head style-primary">
                                            <header>Information Box</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-sm-12 form-group floating-label">                                               
                                                <p class="text-xl"> Do you want to Add (or) Change Access and Modify Permissions to Existing User Group? </p>
                                            </div>                                              
                                            <div class="col-sm-12">
                                                <button tabindex="2" class="btn btn-raised btn-primary " onClick="location.href = 'usergroup2.php'">Yes</button>
                                                <button tabindex="3" id="cancel-info" class="btn btn-raised btn-primary" style="float: right;">No</button>

                                            </div>
                                        </div>
                                    </div>                           
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">                                                                        
                            <div class="col-md-8 col-lg-offset-2">
                                <div class="card center-block">
                                    <div class="card-head style-primary">
                                        <header>Add Menu</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-sm-6 form-group floating-label">
                                                    <input tabindex="1" type="text" value="<?php
                                                    if ($mname) {
                                                        echo $mname;
                                                    }
                                                    ?>" name="mname"  class="form-control" required>
                                                    <label>Add Name*</label>
                                                </div>   
                                                <div class="col-sm-6 checkbox checkbox-styled">
                                                    <label>                                        
                                                        <input type="checkbox" name="submenu" class="chkbox" id="chkurl" value="1"
                                                        <?php
                                                        if ($submenu) {
                                                            echo "checked";
                                                        }
                                                        ?>>
                                                        <span>Submenu</span>
                                                    </label>
                                                </div>
                                            </div>                                        
                                            <div class="row">
                                                <div class=" col-sm-5  form-group floating-label">
                                                    <select tabindex="1" id="usermod" name="parent" class="form-control ">
                                                        <option value="">&nbsp;</option>
                                                        <?php
                                                        if ($id) {
                                                            $sql = "select * from `usermodules` Where `parent`='0'";
                                                        } else {
                                                            $sql = "select * from `usermodules` where `status`='0' AND `parent`='0' ";
                                                        }
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['id']; ?>" <?php
                                                            if ($parent == $row['id'] || $parent_parent == $row['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo $row['mname']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>                                            
                                                    </select>                                       
                                                    <label for="category_id">Select Parent Category</label>   
                                                </div>
                                                <div  id="parentcat">
                                                    <?php if ($parent_submenu) { ?>                                                    
                                                        <div class=" col-sm-6  form-group">
                                                            <select tabindex="1"  name="category" class="form-control">
                                                                <option value="">&nbsp;</option>
                                                                <?php
                                                                $sql5 = "select * from `usermodules` where submenu='1' AND `parent`='$parent_parent' ";
                                                                $result = mysqli_query($mysqli, $sql5);
                                                                while ($row5 = mysqli_fetch_assoc($result)) {
                                                                    ?>
                                                                    <option value="<?php echo $row5['id']; ?>" <?php
                                                                    if ($parent == $row5['id']) {
                                                                        echo 'selected';
                                                                    }
                                                                    ?>><?php echo $row5['mname']; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>                                            
                                                            </select>                                       
                                                            <label for="category_id">Select Submenu Category</label>   
                                                        </div>                                                                                                          
                                                    <?php } ?>
                                                </div>
                                                <div <?php
                                                if ($submenu) {
                                                    echo 'style="display:none"';
                                                }
                                                ?> class="col-sm-7 form-group floating-label" id="urlid">
                                                    <input tabindex="1" type="text" value="<?php
                                                    if ($id) {
                                                        echo $url;
                                                    }
                                                    ?>" name="url" id="urlmod"  class="form-control" required>
                                                    <label>Add URL*</label>

                                                </div> 
                                            </div> 

                                            <div <?php
                                            if ($submenu) {
                                                echo 'style="display:none"';
                                            }
                                            ?> class="row" id="exurl">
                                                <h4>Example: </h4>
                                                <h4 class="col-sm-6">URL Main: admin/master/</h4>
                                                <h4 class="col-sm-6">URL Sub: admin/master/publisher.php</h4>
                                            </div>
                                            <?php if ($parent == 0) { ?>
                                                <div class="row" id="iconmod">
                                                    <div class="col-sm-6 form-group floating-label">
                                                        <input tabindex="1" type="text" value="<?php
                                                        if ($icons) {
                                                            echo $icons;
                                                        }
                                                        ?>" name="icons"   class="form-control" >
                                                        <label>Add Icon for Menu*</label>
                                                    </div>
                                                    <div class="col-sm-6 form-group floating-label">
                                                        <a href="materialicons.html" target="_blank" style="text-decoration: none;"><button type="button" class="btn ink-reaction btn-raised btn-primary">Click here to choose icons</button></a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-sm-12">
                                                <button tabindex="3" type="reset" name="cancel" class="btn btn-flat btn-default-light ink-reaction" onClick="location.href = 'usermodules2.php'">Cancel</button>
                                                <button tabindex="2" type="submit" name="save" id="save" class="btn ink-reaction btn-raised btn-primary ">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>                            
                            </div>
                        </div> 
                        <?php
                        $id_string = encrypt_decrypt("encrypt", "id");
                        $action_string = encrypt_decrypt("encrypt", "action");
                        $edit_string = encrypt_decrypt("encrypt", "edit");
                        $active_string = encrypt_decrypt("encrypt", "active");
                        $deactive_string = encrypt_decrypt("encrypt", "deactive");
                        $delete_string = encrypt_decrypt("encrypt", "delete");
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="text-primary">Edit And DeActive Menu</h2>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table diagnosis_list">
                                                <thead>
                                                    <tr>                                    
                                                        <th>SlNo</th>
                                                        <th>Actions</th>
                                                        <th>Name</th>
                                                        <th>Parent</th>
                                                        <th>Icon</th>
                                                        <th>URL</th>                                                
                                                    </tr>
                                                </thead>
                                                <tbody class="ui-sortable">
                                                    <?php
                                                    $i = 1;
                                                    $sql = "(SELECT  id, mname , parent, url,icons,position FROM `usermodules` WHERE parent='0' AND `status`='0') UNION ALL (SELECT sb.id,sb.mname, c.mname `parent`, sb.url, sb.icons, sb.position  FROM `usermodules` c, `usermodules` sb where c.id=sb.parent AND sb.`status`='0') ORDER BY `parent`,`position` asc";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = encrypt_decrypt('encrypt', $row['id']);
                                                        ?>
                                                        <tr id="<?php echo $row['id']; ?>">
                                                            <td class="priority"><?php echo $i; ?></td>
                                                            <td class="text-left">
                                                                <?php
                                                                // $sql3 = "SELECT * FROM `usermodules` WHERE `url` = '$lcurl[0]' ";
                                                                // $res3 = mysqli_query($mysqli, $sql3);
                                                                // while ($row3 = mysqli_fetch_assoc($res3)) {
                                                                //     $id_modify = $row3['id'];
                                                                // }
                                                                ?>
                                                                <?php
                                                                // if (in_array($id_modify, $mp)) {
                                                                ?>
                                                                <a href="usermodules2.php?<?php echo $action_string . '=' . $edit_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>                                          
                                                                <button onclick="deletion('<?php echo $action_string . '=' . $delete_string . '&' . $id_string . '=' . $id; ?>')"type="button" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete now" ><i class="fa fa-trash"></i></button>
                                                                <a href="usermodules2.php?<?php echo $action_string . '=' . $deactive_string . '&' . $id_string . '=' . $id; ?>" type="button" class="btn ink-reaction btn-block-action btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Active now"><i class="fa fa-close"></i> &nbsp; In-Active </a>                                                                                                                                                                                                                           
                                                                <?php //} ?>
                                                            </td>
                                                            <td><?php
                                                                if ($row['parent']) {
                                                                    echo $row['parent'] . ' >> ';
                                                                } {
                                                                    
                                                                } echo $row['mname'];
                                                                ?></td>                                                            
                                                            <td><?php echo $row['parent']; ?></td>
                                                            <td><i class="md <?php echo $row['icons']; ?>" style="font-size: 30px;"></i></td>
                                                            <td><?php echo $row['url']; ?></td>                                                    
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="text-primary">Edit And Active Menu</h2>
                                        <div class="table-responsive">
                                            <table id="datatable3" class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>SlNo</th>
                                                        <th>Actions</th>
                                                        <th>Name</th>
                                                        <th>Parent</th>
                                                        <th>Icon</th>
                                                        <th>URL</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $sql = "(SELECT  id, mname , parent, url,icons FROM `usermodules` WHERE parent='0' AND `status`='1') UNION ALL (SELECT sb.id,sb.mname, c.mname `parent`,sb.url, sb.icons  FROM `usermodules` c, `usermodules` sb where c.id=sb.parent AND sb.`status`='1')";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = encrypt_decrypt('encrypt', $row['id']);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td class="text-left">
                                                                <?php
                                                                // if (in_array($id_modify, $mp)) {
                                                                ?>
                                                                <a href="usermodules2.php?<?php echo $action_string . '=' . $edit_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                <button onclick="deletion('<?php echo $action_string . '=' . $delete_string . '&' . $id_string . '=' . $id; ?>')"type="button" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete now" ><i class="fa fa-trash"></i></button>
                                                                <a href="usermodules2.php?<?php echo $action_string . '=' . $active_string . '&' . $id_string . '=' . $id; ?>" type="button" class="btn ink-reaction btn-block-action btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Active now"><i class="fa fa-check"></i> &nbsp; Active </a>                                        
                                                                <?php //} ?>
                                                            </td>
                                                            <td><?php
                                                                if ($row['parent']) {
                                                                    echo $row['parent'] . ' >> ';
                                                                } {
                                                                    
                                                                } echo $row['mname'];
                                                                ?></td>                                                            
                                                            <td><?php echo $row['parent']; ?></td>
                                                            <td><i class="md <?php echo $row['icons']; ?>" style="font-size: 30px;"></i></td>
                                                            <td><?php echo $row['url']; ?></td>
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
            </div><
            <?php include_once $prefix . 'include/menubar.php'; ?>
            <?php //include_once $prefix . 'include/jsfiles.php';     ?>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/autosize/jquery.autosize.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/toastr/toastr.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/App.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppNavigation.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppOffcanvas.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppCard.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppForm.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppNavSearch.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/source/AppVendor.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/demo/Demo.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/demo/DemoFormComponents.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/core/demo/DemoTableDynamic.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/select2/select2.min.js"></script>
            <script src="<?php echo $template_prefix; ?>assets/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>           
            <!-- END JAVASCRIPT -->
            <script>
<?php if ($msg == '2') { ?>
                                                                    Command: toastr["success"]("Menu added sucesssfully", "Sucesss")

<?php } elseif ($msg == '1') {
    ?>
                                                                    Command: toastr["error"]("Menu adding error", "Error")
<?php } elseif ($msg == '3') { ?>
                                                                    Command: toastr["success"]("Menu Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                                                                    Command: toastr["success"]("Menu deleted Sucesssfully", "Sucesss")
<?php } ?>
            </script>
            <script>
                $(document).ready(function () {
                    $("#cancel-info").click(function () {
                        $(".info-box").hide();
                    });
                });
            </script>
            <script>
                function deletion(strr) {
                    if (strr) {
                        var r = confirm("Are You Sure Want To Delete ?");
                        if (r == true) {
                            window.location = "usermodules2.php?" + strr;
                        }
                    }
                }
            </script>
            <script>
                $(document).ready(function () {
                    $(document).on('change', '#usermod', function () {
                        if (this.value != '') {
                            $("#iconmod").hide();
                            var prnt = $(this).val();
                            //alert(prnt);
                            $.post("usermodules2.php",
                                    {
                                        parent_cat: prnt,
                                    },
                                    function (data, status) {
                                        $("#parentcat").html(data);
                                        // alert(data);
                                    });

                        } else {
                            $("#iconmod").show();
                        }

                    });

                    $('#chkurl').change(function () {
                        if ($(this).is(":checked")) {
                            $('#urlid').hide();
                            $('#exurl').hide();
                            $('#iconmod').hide();
                            $('.parentcat').hide();
                        } else {
                            $('#urlid').show();
                            $('#exurl').show();
                            $('#iconmod').show();
                            $('.parentcat').show();
                        }
                    });

                });
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
