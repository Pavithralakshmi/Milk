<?php
session_start();
$user = $_SESSION['user'];
//$ugroup = $_SESSION['ugroup'];
$name = $_SESSION['name'];
//$mp = $_SESSION['modify_per'];
$pageurl = $_SERVER['REQUEST_URI'];

$prefix = "";
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
$url = $uname = $id = $idd = $msg = $parent = $aaaper = $mmmper = '';
$mmdper = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'])) {
    $encrypt_action = $_GET['Tmd3ZFVwaCtxWmNsYU1UODJWaUYxUT09'];
    $action = encrypt_decrypt('decrypt', $encrypt_action);
    $encrypt_id = $_GET['WnAyV3FOdHJ3dkNiMEgrMGxVcytZUT09'];
    $id = encrypt_decrypt('decrypt', $encrypt_id);
    //echo $id;exit;
    if ($action == 'edit') {
        $sql = "select * from `usergroup` where id='$id'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $idd = $row['id'];
            $uname = $row['name'];
            $aaaper = explode(",", $row['access_per']);
//            print_r($aaaper); exit;
            $mmmper = explode(",", $row['modify_per']);
        }
    } else if ($action == 'delete') {
        $sql = "DELETE FROM `usergroup` where id='$id'";
        $result = mysqli_query($mysqli, $sql);
        accesslog($user, $datetime, "Usergroup deleted");
        header("Location: usergroup2.php?msg=4");
    }
}
if (isset($_POST['save'])) {
    $uname = $_POST['uname'];
    $accper = $_POST['acc_per'];
    $aper = implode(",", $accper);
//    print_r($accper);
    if ($id) {
        $sql = "UPDATE `usergroup` SET  `name` = '$uname', `access_per` = '$aper', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') where `id`= '$id' ";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        accesslog($user, $datetime, "Usergroup updated");
        header("Location: usergroup2.php?msg=3");
    } else {
        $sql4 = "select * from `usergroup` where name= '$uname' AND `access_per` = '$aper'";
        $res4 = mysqli_query($mysqli, $sql4);
        if (mysqli_num_rows($res4)) {
            $msg = 1;
        } else {
            $sql = "INSERT INTO `usergroup` (`name`, `access_per`, `cby`, `cdate`, `cip`) "
                    . " VALUES ('$uname', '$aper', '$user', '$datetime', '$_SERVER[REMOTE_ADDR]')";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            accesslog($user, $datetime, "Usergroup inserted");
            header("Location: usergroup2.php?msg=2");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- User Group</title>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <?php include_once $prefix . 'include/jsfiles.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>          
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once $prefix . 'include/header.php'; ?>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body contain-lg">                       
                        <div class="row">                                                                        
                            <div class="col-md-8 col-lg-offset-2">
                                <div class="card center-block">
                                    <div class="card-head style-primary">
                                        <header>Add User Group</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="col-sm-12 form-group floating-label">
                                                <input tabindex="1" type="text" value="<?php
                                                if ($id) {
                                                    echo $uname;
                                                }
                                                ?>" name="uname"  class="form-control" required>
                                                <label>Add User Group Name</label>
                                            </div> 

                                            <div class=" col-sm-6 col-lg-offset-3 form-group floating-label">                                                
                                                <h4>Access Permission</h4>
                                                <div class="form-group card card-outlined style-primary" style="margin: 30px 0; padding: 10px;">                                                                                                          
                                                    <div class="form-group"> 
                                                        <select id="example-enableCollapsibleOptGroups-enableClickableOptGroups" class="form-control mselect" name="acc_per[]"multiple="multiple">
                                                            <?php
                                                            $sql4 = "SELECT * FROM `usermodules` WHERE status = 0 order by position asc";
                                                            $res4 = mysqli_query($mysqli, $sql4);
                                                            while ($row4 = mysqli_fetch_assoc($res4)) {
                                                                $menu_array[$row4['parent']][$row4['id']] = $row4['mname'];
                                                            }
                                                            foreach ($menu_array[0] as $key => $value) {
                                                                ?>                                                         
                                                                <optgroup label="<?php echo $value; ?>">

                                                                    <option value="<?php echo $key; ?>" <?php
                                                                    if ($id) {
                                                                        if (in_array($key, $aaaper)) {
                                                                            echo 'selected';
                                                                        }
                                                                    }
                                                                    ?>><?php echo $value; ?></option>

                                                                    <?php
                                                                    if (!empty($menu_array[$key])) {
                                                                        foreach ($menu_array[$key] as $key1 => $value1) {
                                                                            ?>
                                                                            <option value="<?php echo $key1; ?>"  <?php
                                                                            if ($id) {
                                                                                if (in_array($key1, $aaaper)) {
                                                                                    echo 'selected';
                                                                                }
                                                                            }
                                                                            ?>><?php echo $value1; ?></option>
                                                                            <?php
                                                                            if (array_key_exists($key1, $menu_array)) {
                                                                                foreach ($menu_array[$key1] as $key2 => $value2) {
                                                                                    ?>
                                                                                    <option value="<?php echo $key2; ?>"  <?php
                                                                                            if ($id) {
                                                                                                if (in_array($key2, $aaaper)) {
                                                                                                    echo 'selected';
                                                                                                }
                                                                                            }
                                                                                            ?>><?php echo $value1 . ' => ' . $value2; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                </optgroup>                                                                
    <?php
}
?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <button tabindex="3" type="reset" name="cancel" class="btn btn-flat btn-default-light ink-reaction" onClick="location.href = 'usergroup2.php'">Cancel</button>
                                                <button tabindex="2" type="submit" name="save" class="btn ink-reaction btn-raised btn-primary ">Save</button>
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
                                        <h2 class="text-primary">Edit And Delete User Group</h2>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-hover">
                                                <thead>
                                                    <tr>                                    
                                                        <th>SlNo</th>
                                                        <th>Actions</th>
                                                        <th>Name</th>
                                                        <th>Access PerMissions</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $sql2 = "SELECT * FROM `usermodules`";
                                                $res2 = mysqli_query($mysqli, $sql2);
                                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                                    $id = $row2['id'];
                                                    $murl = $row2['url'];
                                                    $getname[$row2['id']] = $row2['mname'];
                                                }
                                                ?>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $sql = "SELECT * FROM `usergroup` order by id desc";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = encrypt_decrypt('encrypt', $row['id']);
                                                        $name = $row['name'];
                                                        $acper = $row['access_per'];
                                                        $aaper = explode(",", $acper);
                                                        $mdper = $row['modify_per'];
                                                        $mmdper = explode(",", $mdper);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>                                                           
                                                            <td class="text-left">
                                                                <?php
                                                                $sql3 = "SELECT * FROM `usermodules` WHERE `url` = '$lcurl[0]' ";
                                                                $res3 = mysqli_query($mysqli, $sql3);
                                                                while ($row3 = mysqli_fetch_assoc($res3)) {
                                                                    $id_modify = $row3['id'];
                                                                }
                                                                ?>
                                                                <a href="usergroup2.php?<?php echo $action_string . '=' . $edit_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>                                          
                                                                <button onclick="deletion('<?php echo $action_string . '=' . $delete_string . '&' . $id_string . '=' . $id; ?>')"type="button" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete now" ><i class="fa fa-trash"></i></button>                                                                
                                                            </td>

                                                            <td><?php echo $name; ?></td>                                                            
                                                            <td><?php
                                                            foreach ($aaper as $value) {
                                                                if ($value) {
                                                                    echo $getname[$value] . ',';
                                                                }
                                                            }
                                                                ?></td>                                                                

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
<?php include_once $prefix . 'include/menubar.php'; ?>
            <script>
<?php if ($msg == '2') { ?>
                    Command: toastr["success"]("User Group added sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                    Command: toastr["error"]("User Group already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                    Command: toastr["success"]("User Group Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                    Command: toastr["success"]("User Group deleted Sucesssfully", "Sucesss")
<?php } ?>
            </script>
            <script>
                function deletion(strr) {
                    //alert'hi';
                    if (strr) {
                        var r = confirm("Are You Sure Want To Delete ?");
                        if (r == true) {
                            window.location = "usergroup2.php?" + strr;
                        }
                    }
                }
            </script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#example-enableCollapsibleOptGroups-enableClickableOptGroups').multiselect({
                        enableClickableOptGroups: true,
                        enableCollapsibleOptGroups: true,
                        buttonWidth: '200px'

                    });
                    //$(".btn-group").css('left', 99px);
                    $('#example-enableCollapsibleOptGroups-enableClickableOptGroups1').multiselect({
                        enableClickableOptGroups: true,
                        enableCollapsibleOptGroups: true,
                        buttonWidth: '200px'
                    });

                    $('li.multiselect-item a').find('input[type="checkbox"]').css({"display": "none"});
//                    $.each($("li.multiselect-item a"), function () {
//                    var dd = $(this).find('input[type="checkbox"]').val();
//                    if(dd == "undefined"){
//                        $(this).find('b.caret').css({"display": "none"});
//                    }
//                });
                });
            </script>
    </body>
</html>