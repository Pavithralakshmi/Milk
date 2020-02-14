<?php
session_start();
$user = $_SESSION['user'];
$name = $role = $_SESSION['name'];

$username = array();
if ($user) {
    $prefix = '../';
} else {
    session_destroy();
    header("Location: index.php");
}
$msg = $userid = $edit_id = $phones = $address = '';
include_once $prefix . 'db.php';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_POST['typesave'])) {
    $product = $_POST['product'];
    $ex_rates_start = $_POST['ex_rates_start'];
    $alavu = $_POST['alavu'];
    $ex_rate = $ex_rates_start . '/ 1' . $alavu;
    $quality = $_POST['quality'];
    $description = $_POST['description'];
    $phones = $_POST['phones'];
    $address = $_POST['address'];
    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
    }
    if (isset($_POST['inser_userid'])) {
        $userid = $_POST['inser_userid'];
    }
    if ($edit_id) {
        $sql = "UPDATE `marketeer` SET  `product`='$product', unit_id='$alavu',`ex_rate`='$ex_rate', `quality`='$quality',`description`='$description', `phone`='$phones',  `address`='$address', `mdate`=concat(`mdate`,'|','$datetime' ),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]' ),`mby`=concat(`mby`,'|',' Update this at $datetime by $user') WHERE id='$edit_id'";
        $result = mysqli_query($mysqli, $sql);
    } else if ($userid) {
        $sql = "INSERT INTO `marketeer`(`userid`, `product`, `unit_id`, `ex_rate`, `quality`, `description`, `phone`, `address`, `cdate`,  `cby`, `cip`) VALUES ('$userid', '$product', '$alavu'  ,'$ex_rate','$quality','$description', '$phones', '$address', '$datetime','$user','$_SERVER[REMOTE_ADDR]')";
        $result = mysqli_query($mysqli, $sql);
    }
}
if (isset($_POST['view_modaltrining123'])) {
    $tid = $_POST['view_modaltrining123'];
    $sql = "SELECT `id`, `userid`, `product`, `ex_rate`, `unit_id` ,`quality`, `description`, `phone`, `address`  FROM `marketeer` WHERE id='$tid' ";
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)) {
        $ex_rate = explode('/', $data['ex_rate']);
        $extrate= trim($ex_rate[0]);
        ?>
        <script type = "text/javascript">
            $(document).ready(function () {
                $(".js-example-basic-single").select2();
            });
        </script>    
        <input type="text" value="<?php echo $data['id'] ?>" hidden="" name="edit_id">
        <div class="form-group floating-label">
            <lable>பொருள் பெயர் தேர்வு செய்க</lable>
            <select name="product" class="form-control"  required>
                <option value="">பொருள் பெயர் தேர்வு செய்க</option>
                <?php
                $sql = "SELECT * FROM `sb_productname` where isdelete='0' and  isverfy='1' ";
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $row['id'] ?>"<?php
                    if (isset($data['product'])) {
                        echo ($data['product'] == $row['id']) ? "selected" : "";
                    };
                    ?>><?php echo $row['pname'] ?></option>
                        <?php } ?>
            </select>     
        </div>                                               
        <div class="row">
            <div class="col-md-6" >
                <div class="form-group floating-label">
                    <lable>தோராயமான விலை</lable>
                    <input name="ex_rates_start" type="number" value="<?php echo $extrate; ?>" class="form-control" id="regular2" required="" placeholder="முதல்">  
                </div>     </div>  
             <div class="col-md-6" >
                  <lable>அளவு </lable>
            <select tabindex="4" name="alavu" class="form-control js-example-basic-single" required="" id="getqnty" onChange="check()">
                <option value=""></option>
                <?php
                $sql = "SELECT `name` FROM `unites_table`";
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value=" <?php echo $row['name'] ?>"<?php
                    if (isset($data['unit_id'])) {
                        echo ($data['unit_id'] == $row['name']) ? "selected" : "";
                    };
                    ?>><?php echo $row['name'] ?></option>
                        <?php } ?>
            </select>
        </div>  </div> 
        <div class="form-group floating-label">
            <lable>தரம்</lable>
            <input name="quality" type="text" value="<?php echo $data['quality'] ?>" class="form-control" id="regular2" required="" placeholder="தரம்">
        </div>  
        <div class="form-group floating-label">
            <textarea name="description" id="textarea2" class="form-control" rows="3" placeholder="விளக்கம்" required><?php echo $data['description'] ?></textarea>
        </div>
                <div class="form-group floating-label">
                    <lable>தொலைப்பேசி</lable>
                    <input name="phones" type="text"  value="<?php echo $data['phone'] ?>" class="form-control" id="regular2" required="" placeholder="தொலைப்பேசி">
                </div> 
                <div class="form-group floating-label">
                    <lable>முகவரி</lable>
                    <textarea name="address" id="textarea2" class="form-control" rows="3" placeholder="முகவரி" required><?php echo $data['address'] ?></textarea>
                </div>
        <?php
    }
    exit;
}
if (isset($_POST['seracvalue'])) {
    $seracvalue = $_POST['seracvalue'];
    $checks = $_POST['check_values'];
    if ($checks == 'tobeverify') {
        $check = ' and `mr`.`is_verfiy`="0" ';
    } else if ($checks == 'verfiyed') {
        $check = ' and `mr`.`is_verfiy`="1" ';
    } elseif ($checks == 'all') {
        $check = ' and 1 ';
    }
    if ($seracvalue) {
        $seracvalue = ' and  CONCAT_WS("", `reg`.`name`, `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile`) LIKE ' . "'%$seracvalue%'";
    } else {
        $seracvalue = ' and 1 ';
    }
    $sql = "SELECT  `mr`.`id` as ids, `reg`.`name`,`reg`.`id`, count(`mr`.`userid`) as count_user , `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile` FROM `registration` `reg`  CROSS JOIN `marketeer` `mr` ON `reg`.`id`=`mr`.`userid` and `reg`.`is_market`='1'  and  `mr`.`is_delete`='0' and `mr`.`is_from`='0'  $seracvalue $check GROUP BY `mr`.userid   ORDER BY `mr`.`id` DESC LIMIT 0, 10";
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-12 scroll_ids"  id="<?php echo $data['ids']; ?>" >
            <div class="card">
                <div class="card-head">
                    <header> <?php echo $data['market_name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['alt_mobile']; ?></header>
                    <?php if ($data['count_user'] < 5) { ?><button data-toggle="tooltip" data-placement="top" data-original-title="Add New"  type="button"  value="add_new"  id="<?php echo $data['id']; ?>"  class="btn ink-reaction btn-floating-action btn-danger typebtn"><i class="md md-add-box" ></i></button> <?php } ?>
                </div>
                <div class="nano has-scrollbar" style="height:90px;"><div class="nano-content" tabindex="0" style="right: -50px;"><div class="card-body height-3 scroll style-default-bright" style="height: auto;">
                            <h5><?php echo $data['name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['district']; ?>, <?php echo $data['taluk']; ?>, <?php echo $data['address']; ?></h5>
                        </div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 64px);"></div></div></div>
                <div class="nano has-scrollbar" style="height: 250px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="card-body height-3 scroll " style="height: auto;">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover  ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>பொருள்</th>
                                            <th>தோராயமான விலை</th>
                                            <th>தரம்</th>
                                            <th>விளக்களம்</th>
                                                    <th>தொலைப்பேசி</th>
                                            <th>முகவரி</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $sql12 = "SELECT `mr`.`id`, `mr`.`userid`,`pro`.`pname`, `mr`.`product`, `mr`.`ex_rate`, `mr`.`quality`, `mr`.`description`, date(`mr`.`cdate`) as dates, `mr`.`phone`, `mr`.`address`,  `mr`.`is_verfiy`  FROM `marketeer` `mr` CROSS JOIN `sb_productname` `pro` ON `pro`.`id`=`mr`.`product` WHERE  `mr`.`is_delete`='0' and `mr`.`userid`='$data[id]' $check ";
                                        $getrs = mysqli_query($mysqli, $sql12);
                                        while ($row = mysqli_fetch_assoc($getrs)) {
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i; ?><font size="2" color="blue"><?php
                                                    if ($row['is_verfiy']) {
                                                        echo ' Verified';
                                                    }
                                                    ?></font></td>
                                                <td><?php echo $row['pname']; ?></td>
                                                <td><?php echo $row['ex_rate']; ?></td>
                                                <td><?php echo $row['quality']; ?></td>
                                                <td  ><?php echo mb_substr($row['description'] . '...', 0, 25, 'utf-8'); ?></td>
                                                            <td  ><?php echo$row['phone']; ?></td>
                                                <td  ><?php echo wordwrap($row['address'], 50, "<br>\n"); ?></td>
                                                <td><button type="button"  value="<?php echo $row['id']; ?>"   class="btn ink-reaction btn-raised btn-info typebtn"><i class="md md-mode-edit"></i></button> <?php if (empty($row['is_verfiy'])) { ?> <button type="button" onClick="verfiys_marketers('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="View"> <i class="md md-done"></i></button><?php } ?> <button type="button" onClick="deleteval('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button> </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div></div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 0px);"></div></div></div>
            </div><!--end .card -->
        </div>  <?php
    }
    exit;
}
if (isset($_POST['view_modaltrining'])) {
    $sql = "UPDATE `marketeer` SET `is_delete`='1', `mdate`=concat(`mdate`,'|','$datetime' ),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]' ),`mby`=concat(`mby`,'|',' Vivasaym Team  Delete this at $datetime by $user') WHERE  `id`='$_POST[view_modaltrining]'  ";
    $res = mysqli_query($mysqli, $sql);
    exit;
}
if (isset($_POST['verfiy_markets'])) {
    $sqll = "UPDATE `marketeer` SET  `is_verfiy`='1',`mdate`=concat(`mdate`,'|','$datetime'),`mip`=concat(`mip`,'|','$_SERVER[REMOTE_ADDR]'),`mby`='$user' WHERE  id='$_POST[verfiy_markets]' ";
//    echo $sqll;
    $res = mysqli_query($mysqli, $sqll);
    exit;
}
if (isset($_POST['scroll_view'])) {
    $scrolid = $_POST['scroll_view'];
    $search = $_POST['seracvalue1'];
    $checks = $_POST['checkvalues'];
    if ($checks == 'tobeverify') {
        $check = ' and `mr`.`is_verfiy`="0" ';
    } else if ($checks == 'verfiyed') {
        $check = ' and `mr`.`is_verfiy`="1" ';
    } elseif ($checks == 'all') {
        $check = ' and 1 ';
    }
    if ($search) {
        $search = ' and  CONCAT_WS("", `reg`.`name`, `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile`) LIKE ' . "'%$search%'";
    } else {
        $search = ' and 1 ';
    }
    $sql = "SELECT  `mr`.`id` as ids, `reg`.`name`,`reg`.`id`, count(`mr`.`userid`) as count_user , `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile` FROM `registration` `reg`  CROSS JOIN `marketeer` `mr` ON `reg`.`id`=`mr`.`userid` and `reg`.`is_market`='1'  and  `mr`.`is_delete`='0'  and `mr`.`is_from`='0'   and  `mr`.`id`<'$scrolid' $search  $check   GROUP BY `mr`.userid   ORDER BY `mr`.`id` DESC LIMIT 0, 10";
    $result = mysqli_query($mysqli, $sql);
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-12 scroll_ids"  id="<?php echo $data['ids']; ?>" >
            <div class="card">
                <div class="card-head">
                    <header> <?php echo $data['market_name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['alt_mobile']; ?></header>
                    <?php if ($data['count_user'] < 5) { ?><button data-toggle="tooltip" data-placement="top" data-original-title="Add New"  type="button"  value="add_new"  id="<?php echo $data['id']; ?>"  class="btn ink-reaction btn-floating-action btn-danger typebtn"><i class="md md-add-box" ></i></button> <?php } ?>
                </div>
                <div class="nano has-scrollbar" style="height:90px;"><div class="nano-content" tabindex="0" style="right: -50px;"><div class="card-body height-3 scroll style-default-bright" style="height: auto;">
                            <h5><?php echo $data['name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['district']; ?>, <?php echo $data['taluk']; ?>, <?php echo $data['address']; ?></h5>
                        </div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 64px);"></div></div></div>
                <div class="nano has-scrollbar" style="height: 250px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="card-body height-3 scroll " style="height: auto;">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover  ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>பொருள்</th>
                                            <th>தோராயமான விலை</th>
                                            <th>தரம்</th>
                                            <th>விளக்களம்</th>
                                                    <th>தொலைப்பேசி</th>
                                            <th>முகவரி</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $sql12 = "SELECT `mr`.`id`, `mr`.`userid`,`pro`.`pname`, `mr`.`product`, `mr`.`ex_rate`, `mr`.`quality`, `mr`.`description`, date(`mr`.`cdate`) as dates, `mr`.`phone`, `mr`.`address`,  `mr`.`is_verfiy`  FROM `marketeer` `mr` CROSS JOIN `sb_productname` `pro` ON `pro`.`id`=`mr`.`product` WHERE  `mr`.`is_delete`='0' and `mr`.`userid`='$data[id]' ";
                                        $getrs = mysqli_query($mysqli, $sql12);
                                        while ($row = mysqli_fetch_assoc($getrs)) {
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i; ?><font size="2" color="blue"><?php
                                                    if ($row['is_verfiy']) {
                                                        echo ' Verified';
                                                    }
                                                    ?></font></td>
                                                <td><?php echo $row['pname']; ?></td>
                                                <td><?php echo $row['ex_rate']; ?></td>
                                                <td><?php echo $row['quality']; ?></td>
                                                <td  ><?php echo mb_substr($row['description'] . '...', 0, 25, 'utf-8'); ?></td>
                                                            <td  ><?php echo$row['phone']; ?></td>
                                                <td  ><?php echo wordwrap($row['address'], 50, "<br>\n"); ?></td>
                                                <td><button type="button"  value="<?php echo $row['id']; ?>"   class="btn ink-reaction btn-raised btn-info typebtn"><i class="md md-mode-edit"></i></button> <?php if (empty($row['is_verfiy'])) { ?> <button type="button" onClick="verfiys_marketers('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="View"> <i class="md md-done"></i></button><?php } ?> <button type="button" onClick="deleteval('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button> </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div></div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 0px);"></div></div></div>
            </div><!--end .card -->
        </div>  <?php
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>மகளிர் மட்டும்  - Category</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <!-- BEGIN META -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="your,keywords">
        <meta name="description" content="Short explanation about this website">
        <!-- END META -->
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/select2/select2.css?1424887856" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/multi-select/multi-select.css?1424887857" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
        <style>
            .scroll123{
                height:600px;
                overflow-y: scroll;
            }
            .ui-sortable tr {
                cursor:pointer;
            }
            .ui-sortable tr:hover {
                background:#D8FFF0;
            }
        </style>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once $prefix . 'include/header.php'; ?>
        <!-- BEGIN HEADER-->
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
                    <div class="section-body ">
                        <div class="card">
                            <div class="card-body style-default-bright height-1"><div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="searchvales"  placeholder="Enter your search here">
                                        </div>   
                                    </div>
                                    <div>                                                                  
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="markets" onclick="select_views(this.value)"  value="tobeverify"  checked=""  ><span>To Be Verify</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="markets" onclick="select_views(this.value)"  value="verfiyed" ><span>Verified</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="markets" onclick="select_views(this.value)"  value="all"><span>All</span>
                                        </label>
                                    </div> 
                                </div> </div>
                        </div>
                        <!--end .form-group -->
                    </div>     
                    <br>
                    <div class="row" id="searchview">
                        <!-- BEGIN ADD CONTACTS FORM -->
                        <?php
//                        $sql = "SELECT  `mr`.`id` as ids, `reg`.`name`,`reg`.`id`, count(`mr`.`userid`) as count_user , `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile` FROM `registration` `reg`  CROSS JOIN `marketeer` `mr` ON `reg`.`id`=`mr`.`userid` and `reg`.`is_market`='1'  and  `mr`.`is_delete`='0'  GROUP BY `mr`.userid   ORDER BY `mr`.`id` DESC LIMIT 0, 1";
                        $sql = "SELECT  `mr`.`id` as ids, `reg`.`name`,`reg`.`id`, count(`mr`.`userid`) as count_user , `reg`.`market_name`, `reg`.`phone`,`reg`.`district`,`reg`.`taluk`,`reg`.`address`,`reg`.`alt_mobile` FROM `registration` `reg`  CROSS JOIN `marketeer` `mr` ON `reg`.`id`=`mr`.`userid` and `reg`.`is_market`='1'  and  `mr`.`is_delete`='0' and `mr`.`is_verfiy`='0'  and `mr`.`is_from`='0'    GROUP BY `mr`.userid   ORDER BY `mr`.`id` DESC ";
                        $result = mysqli_query($mysqli, $sql);
                        while ($data = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col-md-12 scroll_ids"  id="<?php echo $data['ids']; ?>" >
                                <div class="card">
                                    <div class="card-head">
                                        <header> <?php echo $data['market_name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['alt_mobile']; ?></header>
                                        <?php if ($data['count_user'] < 5) { ?><button data-toggle="tooltip" data-placement="top" data-original-title="Add New"  type="button"  value="add_new"  id="<?php echo $data['id']; ?>"  class="btn ink-reaction btn-floating-action btn-danger typebtn"><i class="md md-add-box" ></i></button> <?php } ?>
                                    </div>
                                    <div class="nano has-scrollbar" style="height:90px;"><div class="nano-content" tabindex="0" style="right: -50px;"><div class="card-body height-3 scroll style-default-bright" style="height: auto;">
                                                <h5><?php echo $data['name']; ?>, <?php echo $data['phone']; ?>, <?php echo $data['district']; ?>, <?php echo $data['taluk']; ?>, <?php echo $data['address']; ?></h5>
                                            </div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 64px);"></div></div></div>
                                    <div class="nano has-scrollbar" style="height: 250px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="card-body height-3 scroll " style="height: auto;">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover  ">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>பொருள்</th>
                                                                <th>தோராயமான விலை</th>
                                                                <th>தரம்</th>
                                                                <th>விளக்களம்</th>
                                                                    <th>தொலைப்பேசி</th>
                                                                <th>முகவரி</th>
                                                                <th>action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            $sql12 = "SELECT `mr`.`id`, `mr`.`userid`,`pro`.`pname`, `mr`.`product`, `mr`.`ex_rate`, `mr`.`quality`, `mr`.`description`, date(`mr`.`cdate`) as dates, `mr`.`phone`, `mr`.`address`,  `mr`.`is_verfiy`  FROM `marketeer` `mr` CROSS JOIN `sb_productname` `pro` ON `pro`.`id`=`mr`.`product` WHERE  `mr`.`is_delete`='0' and `mr`.`is_verfiy`='0' and `mr`.`userid`='$data[id]' ";
                                                            $getrs = mysqli_query($mysqli, $sql12);
                                                            while ($row = mysqli_fetch_assoc($getrs)) {
                                                                ?>
                                                                <tr>
                                                                    <td align="center"><?php echo $i; ?><font size="2" color="blue"><?php
                                                                        if ($row['is_verfiy']) {
                                                                            echo ' Verified';
                                                                        }
                                                                        ?></font></td>
                                                                    <td><?php echo $row['pname']; ?></td>
                                                                    <td><?php echo $row['ex_rate']; ?></td>
                                                                    <td><?php echo $row['quality']; ?></td>
                                                                    <td  > <?php echo mb_substr($row['description'] . '...', 0, 25, 'utf-8'); ?></td>
                                                                            <td  ><?php echo$row['phone']; ?></td>
                                                                    <td  ><?php echo wordwrap($row['address'], 50, "<br>\n"); ?></td>
                                                                    <td><button type="button"  value="<?php echo $row['id']; ?>"   class="btn ink-reaction btn-raised btn-info typebtn"><i class="md md-mode-edit"></i></button> <?php if (empty($row['is_verfiy'])) { ?> <button type="button" onClick="verfiys_marketers('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="View"> <i class="md md-done"></i></button><?php } ?> <button type="button" onClick="deleteval('<?php echo $row['id']; ?>')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button> </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div></div><div class="nano-pane"><div class="nano-slider" style="height: 56px; transform: translate(0px, 0px);"></div></div></div>
                                </div><!--end .card -->
                            </div>
                        <?php } ?>
                    </div>
                    <div id='loadingmessage' style='display:none'>
                        <center><img src='../assets/img/712.gif' width="200px"/></center>
                    </div>
                    <div  class=" modal fade align-center" id="seller_model_openid" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="simpleModalLabel">வகை சேர்க்க </h4>
                                </div>
                                <form class="form-validate" method="post">
                                    <div class="modal-body">
                                        <div id="view_details">
                                            <input type="text" value="" id="id_user"  hidden="" name="inser_userid">
                                            <div class="form-group floating-label">
                                                <lable>பொருள் பெயர் தேர்வு செய்க</lable>
                                                <select name="product" class="form-control"  required>
                                                    <option value="">பொருள் பெயர் தேர்வு செய்க</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `sb_productname` where isdelete='0' and  isverfy='1' ";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['pname'] ?></option>
                                                    <?php } ?>
                                                </select>     
                                            </div>                                               
                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group floating-label">
                                                        <lable>தோராயமான விலை</lable>
                                                        <input name="ex_rates_start" type="number" value="" class="form-control" id="regular2" required="" placeholder="முதல்">  
                                                    </div>     </div>  
                                                <div class="col-md-6" >
                                                    <div class="form-group floating-label">
                                                        <lable>தோராயமான விலை</lable>
                                                        <input name="ex_rates_end" type="number" value="" class="form-control" id="regular2" required="" placeholder="வரை">
                                                    </div>  
                                                </div>    
                                            </div>  
                                            <div class="form-group floating-label">
                                                <lable>தரம்</lable>
                                                <input name="quality" type="text" value="" class="form-control" id="regular2" required="" placeholder="தரம்">
                                            </div>  
                                            <div class="form-group floating-label">
                                                <textarea name="description" id="textarea2" class="form-control" rows="3" placeholder="விளக்கம்" required></textarea>
                                            </div>
                                                                                        <div class="form-group floating-label">
                                                                                            <lable>தொலைப்பேசி</lable>
                                                                                            <input name="phones" type="text"  value="" class="form-control" id="regular2" required="" placeholder="தொலைப்பேசி">
                                                                                        </div> 
                                                                                        <div class="form-group floating-label">
                                                                                            <lable>முகவரி</lable>
                                                                                            <textarea name="address" id="textarea2" class="form-control" rows="3" placeholder="முகவரி" required></textarea>
                                                                                        </div>
                                        </div></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">ரத்து</button>
                                        <button type="submit" onclick="return confirm(' Are You sure want Save ?')" class="btn btn-primary" name="typesave"> சேமி </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div><!--end .col -->
            <!-- END ADD CONTACTS FORM -->
        </div><!--end .row -->
    </div><!--end .section-body -->
</div>
</div><!--end #base-->
<?php include_once $prefix . 'include/menubar.php'; ?>
<?php include_once $prefix . 'include/jsfiles.php'; ?>
<script src="../assets/js/libs/select2/select2.min.js"></script>
<!-- END JAVASCRIPT -->
<script>
                                            function deleteval(id) {
                                                if (confirm('Are You Sure Want Delete')) {
                                                    $.post("view_marketeer.php",
                                                            {
                                                                view_modaltrining: id
                                                            },
                                                            function (data, status) {
                                                                alert(status);
                                                                location.reload();
                                                            });
                                                }
                                            }
                                            function verfiys_marketers(id) {
                                                if (confirm('Are You Sure Want Verfiy')) {
                                                    $.post("view_marketeer.php",
                                                            {
                                                                verfiy_markets: id
                                                            },
                                                            function (data, status) {
                                                                alert(status);
                                                                console.log(data);
                                                                location.reload();
                                                            });
                                                }
                                            }
                                            $(document).on('click', '.typebtn', function (e) {
                                                var trian_id = $(this).val();
                                                if (trian_id === 'add_new') {
                                                    var id = $(this).attr('id');
                                                    $('#id_user').val(id);
                                                    $('#seller_model_openid').modal('show');
                                                } else {
                                                    $.post("view_marketeer.php",
                                                            {
                                                                view_modaltrining123: trian_id
                                                            },
                                                            function (data, status) {
                                                                $('#seller_model_openid').modal('show');
                                                                $('#view_details').html(data);
                                                            });
                                                }
                                            });

                                            var arr = [];
                                            i = 0;
                                            $(window).scroll(function () {
                                                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                                                    var id = $(".scroll_ids").last().attr('id');
                                                    var checkvalie = $('input[name=markets]:checked').val();
                                                    if (jQuery.inArray(id, arr) != -1) {
                                                        console.log("is in array");
                                                    } else {
                                                        console.log("is Not in array");
                                                        $('#loadingmessage').show();
                                                        var seracvalue1 = $('#searchvales').val();
                                                        $.post("view_marketeer.php",
                                                                {
                                                                    scroll_view: id,
                                                                    seracvalue1: seracvalue1,
                                                                    checkvalues: checkvalie,
                                                                },
                                                                function (data, status) {
                                                                    $("#searchview").append(data);
                                                                    if (data === '')
                                                                    {
                                                                        $('#loadingmessage').html("<center><h4 style='color:blue;'> வியபாரிகள் இல்லை </h4></center>");
                                                                    } else {
                                                                        $('#loadingmessage').hide();
                                                                    }
                                                                });
                                                        arr[i++] = id;
                                                    }
                                                }
                                            });
                                            function select_views(va) {
                                                // console.log(va);
                                                var vales = va;
                                                var seracvalue = $('#searchvales').val();
                                                $('#loadingmessage').show();
                                                $.post("view_marketeer.php",
                                                        {
                                                            seracvalue: seracvalue,
                                                            check_values: vales
                                                        },
                                                        function (data, status) {
                                                            $("#searchview").html(data);
                                                            if (data === '')
                                                            {
                                                                $('#loadingmessage').html("<center><h4 style='color:blue;'> வியபாரிகள் இல்லை </h4></center>");
                                                            } else {
                                                                $('#loadingmessage').hide();
                                                            }
                                                        });
                                            }
                                            $("#searchvales").keypress(function (e) {

                                                var seracvalue = $('#searchvales').val();
                                                if (e.which === 13) {
                                                    var vales = $("input:checked").val();
                                                    $('#loadingmessage').show();
                                                    if (seracvalue !== "")
                                                    {
                                                        $.post("view_marketeer.php",
                                                                {
                                                                    seracvalue: seracvalue,
                                                                    check_values: vales
                                                                },
                                                                function (data, status) {
                                                                    $("#searchview").html(data);
                                                                    if (data === '')
                                                                    {
                                                                        $('#loadingmessage').html("<center><h4 style='color:blue;'> வியபாரிகள் இல்லை </h4></center>");
                                                                    } else {
                                                                        $('#loadingmessage').hide();
                                                                    }
                                                                });
                                                    } else {
                                                        alert("Give Valid Search Values");
                                                    }
                                                }
                                            });



</script>
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($msg == '1') {
    ?>
            Command: toastr["error"]("Word allrady Exited", "Error")
<?php } elseif ($msg == '2') {
    ?>
            Command: toastr["success"]("வெற்றிகரமாக சேர்க்கப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '3') {
    ?>
            Command: toastr["success"]("வெற்றிகரமாக மாற்றப்பட்டது", "வெற்றி")
<?php }
?>
    });

</script>
</body>
</html>



