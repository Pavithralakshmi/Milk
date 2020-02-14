<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $cow_name = $cowcode = $dob = $timestamp2 = $bdob = $id = $gender = $sold = $g_reg = $greg = $ml = $el = $breedtype = $tid = $mother = $age = $teeth = $timestamp2 = $timestamp = $timestamp3 = $active = $cowtype = $breedtype = $cowcolor = $remark = "";
$reduce_quantity = 0;
$prefix = $msg = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';
$sold = "no";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `cowreg` where`id` = '$id' ORDER BY id DESC";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $cow_name = $row['name'];
        $cowcode = $row['cowcode'];
        $cowcolor = $row['cowcolor'];
        $gender = $row['gender'];
        $cowtype = $row['cowtype'];
        $breedtype = $row['breedtype'];
        $dob = $row['dob'];
        $timestamp = date("d-m-Y", strtotime($dob));
        $bdob = $row['bdob'];
        $timestamp2 = date("d-m-Y", strtotime($bdob));
        $father = $row['father'];
        $mother = $row['mother'];
        $ml = $row['ml'];
        $el = $row['el'];
        $sold = $row['sold'];
        $solddate = $row['solddate'];
        $timestamp3 = date("d-m-Y", strtotime($solddate));
        $greg = $row['greg'];
        $g_reg = $row['g_reg'];
        $age = $row['age'];
        $teeth = $row['teeth'];
        $remark = $row['remark'];
        $amount = $row['amount'];
        $active = $row['active'];
    }
}
$sql1 = "SELECT `id`, `breedtype` FROM `breedtype`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_breedtype[$row['id']] = $row['breedtype'];
// echo $get_breedtype[$row['breedtype']];exit;
}

$sql11 = "SELECT `id`, `cowtype` FROM `cowtype`";
$result = mysqli_query($mysqli, $sql11);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowtype[$row['id']] = $row['cowtype'];
// echo $get_cowtype[$row['cowtype']];exit;
}
$sqlv1 = "SELECT `id`, `cowcolor` FROM `cowcolor`";
$result = mysqli_query($mysqli, $sqlv1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowcolor[$row['id']] = $row['cowcolor'];
// echo $get_cowcolor[$row['cowcolor']];exit;
}
$sqlc1 = "SELECT `id`, `name` FROM `cowreg`";
$result = mysqli_query($mysqli, $sqlc1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_cowname[$row['id']] = $row['name'];
// echo $get_cowname[$row['name']];exit;
}
// ajax for get taluk names begin
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_POST['get_breed'])) {
    ?>
    <option value="">Please Select Breed Type</option>
    <?php
    $sql = "Select * From `breedtype` WHERE `cowtype` = '$_POST[get_breed]'  ";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $tid = $row['id'];
        $tname = $row['breedtype'];
        ?>
        <option value="<?php echo $row['id']; ?>"<?php
        if ($breedtype == $tid) {
            echo "selected";
        }
        ?>><?php echo $row['breedtype']; ?> </option>		
                <?php
            }
            exit;
        }
        if (isset($_POST['save'])) {
            $cow_name = $_POST['name'];
            $cowcode = $_POST['cowcode'];
            $cowcolor = $_POST['cowcolor'];
            $gender = $_POST['gender'];
            $active = $_POST['active'];
            $cowtype = $_POST['cowtype'];
            $breedtype = $_POST['breedtype'];
            $date1 = $_POST['dob'];
            if ($date1) {
                $timestamp = date('Y-m-d', strtotime($date1));
            }
            $date1 = $_POST['bdob'];
            if ($date1) {
                $timestamp2 = date('Y-m-d', strtotime($date1));
            }
            $father = $_POST['father'];
            $mother = $_POST['mother'];
            $ml = $_POST['ml'];
            $el = $_POST['el'];
            $sold = $_POST['sold'];
            $date1 = $_POST['solddate'];
            $date = new DateTime($date1);
            $timestamp3 = $date->format('Y-m-d');
            $g_reg = $_POST['g_reg'];
            $greg = $_POST['greg'];
            $age = $_POST['age'];
            $teeth = $_POST['teeth'];
            $remark = $_POST['remark'];
            $cdate = date('y/m/d');
            if ($id) {
                $check = "select * from `cowreg` where cowcode='$cowcode' AND `id` != '$id' ";
                $res = mysqli_query($mysqli, $check);
                if (mysqli_num_rows($res)) {
                    $msg = 1;
                } else {
                    $sql = " UPDATE `cowreg` SET `name`='$cow_name',`cowcode`='$cowcode',`cowcolor`='$cowcolor',`gender`='$gender',`active`='$active',`g_reg`='$g_reg',`greg`='$greg',`cowtype`='$cowtype',`breedtype`='$breedtype',`dob`='$timestamp',`bdob`='$timestamp2',`father`='$father',`mother`='$mother',`ml`='$ml',`el`='$el',`sold`='$sold',`solddate`='$timestamp3',`g_reg`='$g_reg',`greg`='$greg',`age`='$age',`teeth`='$teeth',`remark`= '$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
                    $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                    header("Location: cowreg.php?msg=3");
                    exit;
                }
            } else {
                $check = "select * from `cowreg` where name='$cow_name' AND breedtype='$breedtype' OR cowcode='$cowcode'";
                $res = mysqli_query($mysqli, $check);
                if (mysqli_num_rows($res)) {
                    $msg = 1;
                } else {
                    $sql = "INSERT INTO `cowreg`(`name`,`cowcode`,`cowcolor`, `gender`,`active`,`g_reg`, `greg`,`cowtype`, `breedtype`, `dob`, `bdob`, `father`, `mother`, `ml`, `el`, `sold`,`solddate`,`age`, `teeth`, `remark`,`cby`, `cdate`, `cip`) VALUES ('$cow_name','$cowcode','$cowcolor','$gender','$active','$g_reg','$greg','$cowtype', '$breedtype','$timestamp','$timestamp2', '$father', '$mother', '$ml', '$el', '$sold', '$timestamp3','$age', '$teeth', '$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
                    $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
                    header("Location: cowreg.php?msg=2");
                    exit;
                }
            }
        }
        if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
            $sql = "DELETE FROM `cowreg` where `id` = '$id' ";
            $result = mysqli_query($mysqli, $sql);
            $affected_rows = mysqli_affected_rows($mysqli);
            if ($affected_rows > 0) {
                $msg = "4";
            } else {
                $msg = "2";
            }
            header('Location: cowreg.php?msg=' . $msg);
        }
        ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management- Cattle Registration</title>
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
                        <div class="row">
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10"> 
                                <form class="form  form-validate" role="form" method="POST">
                                    <div class="card">
                                        <div class="card-head style-primary">
                                            <header>Cattle Registration</header>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 form-group ">
                                                    <input type="text" class="form-control" maxlength="39" minlength="3" name="name" tabindex="1" required value="<?php echo $cow_name; ?>">
                                                    <label for="name">&nbsp; &nbsp;Cattle Name <sup style="color:red;">*</sup></label>
                                                </div>

                                                <div class="col-sm-6 form-group ">
                                                    <input type="text" class="form-control" required="true" maxlength=="10" maxlength=="2" name="cowcode" tabindex="1" value="<?php echo $cowcode; ?>" <?php
                                                    if ($id) {
                                                        echo "readonly";
                                                    }
                                                    ?> >
                                                    <label for="cowcode">&nbsp; &nbsp;Cattle Code <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="dob">&nbsp; &nbsp;  Born Date</label>
                                                    <div class="form-group control-width-normal">
                                                        <div class="input-group date" id="demo-date">
                                                            <input type="text" class="form-control" autocomplete="off" id ="BornDate" name="dob" tabindex="1"value="<?php echo $timestamp; ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 form-group">
                                                    <label for="dob">&nbsp; &nbsp;  Buy Date</label>
                                                    <div class="form-group control-width-normal">
                                                        <div class="input-group date" id="demo-date2">
                                                            <input type="text" class="form-control"name="bdob" autocomplete="off" value="<?php echo $timestamp2 ?>">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6  form-group">
                                                    <label for="gender">&nbsp; &nbsp;Gender <sup style="color:red;">*</sup></label><br>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input required type="radio" tabindex="4"  name="gender" id="gender"  value="male"<?php
                                                            if ($gender == "male") {
                                                                echo "checked";
                                                            }
                                                            ?>> Male
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input required type="radio" tabindex="5"  name="gender" id="fgender"  value="female" <?php
                                                            if ($gender == "female") {
                                                                echo "checked";
                                                            }
                                                            ?>> Female
                                                        </div>

                                                        <div class="col-sm-12  form-group <?php
                                                        if ((!$id) || ($gender == "male")) {
                                                            echo 'hide';
                                                        }
                                                        ?>" id="gender_active" >
                                                            <div class="col-sm-12">
                                                                <input type="checkbox" tabindex="4" name="active" id="a" value="Yes"<?php
                                                                if ($active == "Yes") {
                                                                    echo "checked";
                                                                }
                                                                ?>>Is Active For Milk
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6  form-group">
                                                    <label for="sold">&nbsp; &nbsp;Is Govt.Registerd</label><br>
                                                    <div class="row">

                                                        <div class="col-sm-12">
                                                            <input type="checkbox" tabindex="4" name="g_reg" id="g_reg" value="yes" <?php
                                                            if ($g_reg == "yes") {
                                                                echo "checked";
                                                            }
                                                            ?>> Is Govt.Registerd
                                                            <br>
                                                        </div>

                                                        <div class="col-sm-12  form-group <?php
                                                        if ($g_reg == "yes" && $id) {
                                                            echo "show";
                                                        } else {
                                                            echo "hide";
                                                        }
                                                        ?>" id="greg">
                                                            <input type="text" class="form-control" maxlength="10"  minlength="2" required="true" name="greg" tabindex="1" value="<?php echo $greg; ?>">
                                                            <label for="greg">&nbsp; &nbsp;Register Number <sup style="color:red;">*</sup></label>

                                                        </div>
                                                    </div>
                                                </div>                             
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-6 form-group <?php
                                                if ((!$id) || ($gender == "male")) {
                                                    echo 'hide';
                                                }
                                                ?>" id="gender_male">
                                                    <input type="number" class="form-control" min="0" name="ml" tabindex="1" value="<?php echo $ml; ?>">
                                                    <label for="ml">&nbsp; &nbsp;Morning Milk Liter(Approximate)</label>
                                                </div>
                                                <div class="col-sm-6 form-group <?php
                                                if ((!$id) || ($gender == "male")) {
                                                    echo 'hide';
                                                }
                                                ?>" id="gender_male1">
                                                    <input type="number" class="form-control" min="0" name="el" tabindex="1" value="<?php echo $el; ?>">
                                                    <label for="el">&nbsp; &nbsp;Evening Milk Liter(Approximate)</label>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class = "col-sm-6 form-group">
                                                    <select name="cowtype" id="cowtype" tabindex="1" class="form-control js-example-basic-single"  required="">
                                                        <option value="">Please Select Cattle Type</option>
                                                        <?php
                                                        $sql = "select * from cowtype ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if ($cowtype == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $row['cowtype']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="cowtype">&nbsp; &nbsp;Select Cattle Type <sup style="color:red;">*</sup></label>
                                                </div>

                                                <div class = "col-sm-6 form-group">
                                                    <select name="breedtype" id="breedtype" tabindex="1" class="form-control js-example-basic-single"  required="">
                                                        <?php if ($id) { ?>
                                                            <option value="">Please Select Breed Type</option>
                                                            <?php
                                                            $sql = "Select * From `breedtype` ";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $tid = $row['id'];
                                                                $tname = $row['breedtype'];
                                                                ?>
                                                                <option value="<?php echo $row['id']; ?>"<?php
                                                                if ($breedtype == $tid) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $row['breedtype']; ?> </option>			<?php
                                                                    }
                                                                }
                                                                ?>
                                                    </select>
                                                    <label for="breedtype">&nbsp; &nbsp;Select Breed Type <sup style="color:red;">*</sup></label>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class = "col-sm-6 form-group">
                                                    <select name="cowcolor" id="cowcolor" tabindex="1" class="form-control js-example-basic-single"  required="">
                                                        <option value="">Please Select Cattle Color</option>
                                                        <?php
                                                        $sql = "select * from cowcolor ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id1 = $row['id'];
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if ($cowcolor == $id1) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $row['cowcolor']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="cow_color">&nbsp; &nbsp;Select Cattle Color <sup style="color:red;">*</sup></label>
                                                </div>

                                                <div class = "col-sm-6 form-group">
                                                    <select name="mother" id="mother" tabindex="1" class="form-control js-example-basic-single">
                                                        <option value="">Please Select Cattle Mother Name</option>
                                                        <?php
                                                        $sql = "select * from cowreg where gender='female' ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if (isset($mother)) {
                                                                echo ($mother == $row['id']) ? "selected" : "";
                                                            };
                                                            ?>><?php echo $row['name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="mother">&nbsp; &nbsp;Mother Name </label>
                                                </div>
                                            </div><br>

                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <input type="number" class="form-control" min="0" maxlength="3" id="BornDateBasedAge" name="age" tabindex="1" value="<?php echo $age; ?>">
                                                    <label for="age">&nbsp; &nbsp;Age</label>
                                                </div>

                                                <div class="col-sm-6 form-group">
                                                    <input type="number" class="form-control"  maxlength="3" name="teeth" min="1" id="BuyDateBasedAge" tabindex="1" value="<?php
                                                    if ($teeth == 0) {
                                                        
                                                    } else
                                                        echo $teeth;
                                                    ?>">
                                                    <label for="teeth">&nbsp; &nbsp;Teeth</label>
                                                </div>                                            
                                            </div><br>

                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="4" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
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
                                        <header>Registered Cattle Details</header>
                                    </div>
                                    <div class="card-body">
                                        <div id="regwise_select" class="tbgetsect table-responsive">
                                            <table id="datatable1" class="table diagnosis_list " >
                                                <thead>
                                                    <tr>                                    
                                                        <th>S.No</th>
                                                        <th>Actions</th>
                                                        <th>Cattle Name</th>    
                                                        <th>Cattle Code</th>    
                                                        <th>Cattle Color</th>     
                                                        <th>Gender</th>
                                                        <th>Active</th>
                                                        <th>Birth Date</th>  
                                                        <th>Bought Date</th>     
                                                        <th>Cattle Type</th>
                                                        <th>Breed Type</th>     
                                                        <th>Morning Milk </th>
                                                        <th>Evening Milk</th>     
                                                        <th>Mother</th>
                                                        <th>Govt Reg</th>
                                                        <th>Govt_Reg_No</th>
                                                        <th>Age</th>
                                                        <th>Teeth</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="ui-sortable" >
                                                    <?php
                                                    $i = 1;
                                                    $sql = "select * from cowreg  ORDER BY `id` DESC";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = $row['id'];
                                                        ?>
                                                        <tr  id="<?php echo $row['id']; ?>"  >
                                                            <td><?php echo $i; ?></td>

                                                            <td class="text-left">   
                                                                <?php
                                                                $NumType = 0;
                                                                $sql_type = "select * from `cowsell`  WHERE  `sold_cowname` = '$id'  ";
                                                                $result_type = mysqli_query($mysqli, $sql_type);
                                                                if (!mysqli_num_rows($result_type)) {
//                                                                                    if ($maid == $id) {
                                                                    ?>   
                                                                    <a href="cowreg.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>      <?php
                                                                }
                                                                ?>
                                                            </td>

<!--                                                            <td class="text-left">   
                                                                <a href="cowreg.php?id=<?php // echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                            </td>-->
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['cowcode']; ?></td>
                                                            <td><?php echo $get_cowcolor[$row['cowcolor']]; ?></td>
                                                            <td><?php echo $row['gender']; ?></td> 
                                                            <td><?php echo $row['active']; ?></td> 
                                                            <td><?php
                                                            if ($row['dob'] == "0000-00-00") {
                                                                echo "";
                                                            } else {
                                                                echo date('d/m/Y', strtotime($row['dob']));
                                                            }
                                                                ?></td>
                                                            <td><?php
                                                            if ($row['bdob'] == "0000-00-00") {
                                                                echo "";
                                                            } else {
                                                                echo date('d/m/Y', strtotime($row['bdob']));
                                                            }
                                                                ?></td>
                                                          <!--<td><?php // echo date('d/m/Y', strtotime($row['dob']));  ?></td>-->
                                                          <!--<td><?php // echo date('d/m/Y', strtotime($row['bdob']));   ?></td>-->
                                                            <td><?php echo $get_cowtype[$row['cowtype']]; ?></td>
                                                            <td><?php echo $get_breedtype[$row['breedtype']]; ?></td>
                                                            <td style="text-align: right"><?php echo $row['ml']; ?></td>
                                                            <td style="text-align: right"><?php echo $row['el']; ?></td>
                                                            <td><?php echo $get_cowname[$row['mother']]; ?></td>
                                                            <td><?php echo $row['g_reg']; ?></td>
                                                            <td><?php echo $row['greg']; ?></td>
                                                            <td style="text-align: right"><?php echo $row['age']; ?></td>
                                                            <td style="text-align: right"><?php echo $row['teeth']; ?></td>                                                                     
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
            $("#demo-date").datepicker({
                format: 'dd-mm-yyyy'
            });
            $("#demo-date2").datepicker({
                format: 'dd-mm-yyyy'
            });
            $("#demo-date3").datepicker({
                format: 'dd-mm-yyyy'
            });
        </script>
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"]("Cow Registered  sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Same Cow already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Register Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Register Deleted Sucesssfully", "Sucesss")
<?php } ?>
        </script>
        <script>
            $('input[name=sold]').change(function () {
                var sold = $('input[name=sold]:checked').val();
                if (sold === "yes") {
                    $("#sold_date_div").removeClass("hide");
                    $("#amount").removeClass("hide");
                } else {
                    $("#sold_date_div").addClass("hide");
                    $("#amount").addClass("hide");
                }
            });
        </script>
        <script>
            $('input[name=g_reg]').change(function () {
                var greg = $('input[name=g_reg]:checked').val();
                if (greg === "yes") {
                    $("#greg").removeClass("hide");
                } else {
                    $("#greg").addClass("hide");
                }
            });
        </script>
        <script>
            $('input[name=gender]').change(function () {
                var active = $('input[name=gender]:checked').val();
                if (active === "female") {
                    $("#gender_active").removeClass("hide");
                } else {
                    $("#gender_active").addClass("hide");
                }
            });
        </script>
        <script>
            $(document).on('change', '#cowtype', function () {
                var cowtype = $(this).val();
                $.post("cowreg.php",
                        {
                            get_breed: cowtype,
                        },
                        function (data, status) {
                            $("#breedtype").html(data);
                        });
            });
            $(document).on('blur', '#BornDate', function () {
                var BornDate = $(this).val();
                var nedate = BornDate.split('-');
                var nedate = nedate[2] + '-' + nedate[1] + '-' + nedate[0];
                var GetCurrentDate = new Date();
                function treatAsUTC(date) {
                    var result = new Date(date);
                    result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
                    return result;
                }
                function daysBetween(startDate, endDate) {
                    var millisecondsPerDay = 24 * 60 * 60 * 1000;
                    return Math.round((treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay);
                }
                var DayDiff = daysBetween(nedate, GetCurrentDate);
                $('#BornDateBasedAge').val(Math.round(DayDiff / 365));
            });
        </script>
        <script>
            $('input[name=gender]').change(function () {
                var active = $('input[name=gender]:checked').val();
                if (active === "male") {
                    $("#gender_male").addClass("hide");
                    $("#gender_male1").addClass("hide");

                } else {
                    $("#gender_male").removeClass("hide");
                    $("#gender_male1").removeClass("hide");
                }
            });
        </script>
        <script>
            $('#dob').datepicker({
                onSelect: function (value, ui) {
                    var today = new Date(),
                            dob = new Date(value),
                            age = new Date(today - dob).getFullYear() - 1970;

                    $('#age').text(age);
                    alert($age);
                },
                maxDate: '+0d',
                yearRange: '1990:2020',
                changeMonth: true,
                changeYear: true
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
