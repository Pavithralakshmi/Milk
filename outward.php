<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $expences = $date = $timestamp = $total_amount = $id = $remark = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

$gh = "select max(outwardno)as outwardno from outward";
$result = mysqli_query($mysqli, $gh);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $outwardno = $row['outwardno'];
    }
    $outwardno = $outwardno + 1;
} else {
    $outwardno = 1;
}

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$sql1 = "SELECT `id`, `expences` FROM `expense`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_expences[$row['id']] = $row['expences'];
// echo $get_expences[$row['expences']];exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `outward` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $outwardno = $row['outwardno'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $expences = $row['expences'];
        $total_unit = $row['total_unit'];
        $unit = $row['unit'];
        $balance = $row['balance'];
        $remark = $row['remark'];
    }
}

if (isset($_POST['GetTotalUnitValue'])) {
    $GetTotalUnitValue = $_POST['GetTotalUnitValue'];
    $sql = "SELECT COALESCE(SUM(`total_unit`), 0) as `inward` FROM `inward` WHERE `expences` = '$GetTotalUnitValue' ";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $TotalUnitSum['inward'] = $row['inward'];
    $sql = "SELECT COALESCE(SUM(`unit`), 0) as `outward` FROM `outward` WHERE `expences` = '$GetTotalUnitValue' ";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $TotalUnitSum['outward'] = $row['outward'];
    echo $TotalUnitSum['inward'] - $TotalUnitSum['outward'];
    exit;
}

if (isset($_POST['save'])) {
    $outwardno = $_POST['outwardno'];
    $expences = $_POST['expences'];
    $date1 = $_POST['date'];
    $date = new DateTime($date1);
    $timestamp = $date->format('Y-m-d');
    $total_unit = $_POST['total_unit'];
    $unit = $_POST['unit'];
    $balance = $_POST['balance'];
    $remark = $_POST['remark'];
    $cdate = date('y/m/d');
    if ($id) {
        $check = "select * from `outward` where expences='$expences' AND date='$timestamp' AND `total_unit`='$total_unit' AND id !='$id'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "UPDATE `outward` SET `date`='$timestamp',`expences`='$expences',`total_unit`='$total_unit',`unit`='$unit',`balance`='$balance',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            header("Location: outward.php?msg=3");
            exit;
        }
    } else {
        $check = "SELECT * FROM `outward` WHERE `expences` = '$expences' AND `date` = '$timestamp' AND `total_unit`='$total_unit'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            foreach ($expences as $key => $value) {
                $sql = "INSERT INTO `outward`(`outwardno`,`date`, `expences`, `total_unit`,`unit`,`balance`,`remark`,`cby`, `cdate`, `cip`) VALUES ('$outwardno','$timestamp','$expences[$key]','$total_unit[$key]','$unit[$key]','$balance[$key]','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
                $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
            }
            header("Location: outward.php?msg=2");
            exit;
        }
    }
}

if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `outward` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "2";
    }
    header('Location: outward.php?msg=' . $msg);
    exit;
}

if (isset($_POST['tablechange'])) {
    $dates = $_POST['tablechange'];
    $dates = explode("-", $dates);
    $startdate = date("Y-m-d", strtotime($dates[0]));
    $enddate = date("Y-m-d", strtotime($dates[1]));
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th style="text-align: center;">S.No</th>
                <th>Actions</th>
                <th style="text-align: center;">Outward No</th>
                <th style="text-align: center;">Date</th>
                <th>Expenses</th>         
                <th style="text-align: right;">Total Unit</th>     
                <th style="text-align: right;">Unit</th>     
                <th style="text-align: right;">Balance</th>            
                <th>Remark</th>            
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "select * from outward  where date(date) BETWEEN ('$startdate') AND ('$enddate') ORDER BY id DESC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $outwardno = $row['outwardno'];
                $remark = $row['remark'];
                $sql1 = "SELECT max(`id`) as `id` FROM `outward` WHERE `expences`='$row[expences]'";
                $resulr12 = mysqli_query($mysqli, $sql1);
                $dataa = mysqli_fetch_assoc($resulr12);
                $maxidexp = $dataa['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <td class="text-left">   
                        <?php if ($maxidexp == $id) { ?> <a href="outward.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                            <a href="outward.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                        <?php } ?>
                    <td style="text-align: center;"><?php echo $outwardno; ?></td>
                    <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                    <td><?php
                        $expences = explode(",", $row['expences']);
                        foreach ($expences as $key => $value) {
                            echo $get_expences[$value] . '<br><br>';
                        }
                        ?></td>
                    <td style="text-align: right;"><?php echo str_replace(",", " <br><br>", $row['total_unit']); ?></td>
                    <td style="text-align: right;"><?php echo str_replace(",", " <br><br>", $row['unit']); ?></td>
                    <td style="text-align: right;"><?php echo str_replace(",", " <br><br>", $row['balance']); ?></td>
                    <td><?php echo $remark; ?></td>
                </tr>  
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management - Outward</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />   
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Outward Entry</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="Outwardno">&nbsp; &nbsp;Outward Number</label>
                                                    <input type="number" class="form-control" name="outwardno" readonly="true"tabindex="1" value="<?php echo $outwardno; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group date" id="demo-date">
                                                        <label for="date">&nbsp; &nbsp;Date  <sup style="color:red;">*</sup></label>
                                                        <input type="text" class="form-control" required="true" autocomplete="off" name="date" value="<?php
                                                        if (!$id) {
                                                            echo "";
                                                        } else {
                                                            echo $timestamp;
                                                        }
                                                        ?>">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>                                               
                                            </div><br>
                                            <div id="Clonediv">
                                                <?php
                                                if ($id) {
                                                    ?>
                                                    <div class="row button clone1" id="buttonid1">                                    
                                                        <div class="col col-sm-3 ">
                                                            <label for="name">&nbsp; &nbsp;Product  <sup style="color:red;">*</sup></label>
                                                            <select name="expences" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                <option value="">Please Select Product</option>
                                                                <?php
                                                                $sql = "select * from `expense`  order by `expences` ";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id1 = $row['id'];
                                                                    ?>
                                                                    <option  value="<?php echo $row['id'] ?>"<?php
                                                                    if ($expences == $id1) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo $row['expences'] ?></option>
                                                                         <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-3">
                                                            <label for="total_unit">&nbsp; &nbsp;Total Unit<sup style="color:red;">*</sup></label>
                                                            <input readonly="true" type="number" id="total_unit" min="1" class="form-control CostOfProduct" required="true" name="total_unit" tabindex="1" value="<?php echo $total_unit; ?>">
                                                        </div> 
                                                        <div class="col col-sm-3">
                                                            <label for="unit">&nbsp; &nbsp;Used Unit<sup style="color:red;">*</sup></label>
                                                            <input type="number" id="unit" min="0" class="form-control CostOfProduct maxvla" required="true" name="unit" tabindex="1"value="<?php echo $unit; ?>">
                                                        </div>
                                                        <div class="col col-sm-2">
                                                            <label for="balance">&nbsp; &nbsp;Balance<sup style="color:red;">*</sup></label>
                                                            <input readonly="true" type="number" id="balance" min="0" class="form-control CostOfProduct" required="true" name="balance" tabindex="1" value="<?php echo $balance; ?>">
                                                        </div>
                                                        <div class=" form-group AddMoreRow pull-right">                                                               
                                                            <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </div>
                                                    </div><br>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="row button clone1" id="buttonid1">                                    
                                                        <div class="col col-sm-3 ">
                                                            <label for="name">&nbsp; &nbsp;Product  <sup style="color:red;">*</sup></label>
                                                            <select name="expences[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                <option value="">Please Select Product</option>
                                                                <?php
                                                                $sql = "select * from `expense`  order by `expences` ";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id1 = $row['id'];
                                                                    ?>
                                                                    <option  value="<?php echo $row['id'] ?>"> <?php echo $row['expences'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-3">
                                                            <label for="total_unit">&nbsp; &nbsp;Total Unit<sup style="color:red;">*</sup></label>
                                                            <input readonly="true"type="number" id="total_unit" min="1" class="form-control CostOfProduct " required="true" name="total_unit[]" tabindex="1" value="<?php echo $total_unit[$key]; ?>">
                                                        </div> 
                                                        <div class="col col-sm-3">
                                                            <label for="unit">&nbsp; &nbsp;Used Unit<sup style="color:red;">*</sup></label>
                                                            <input type="number" id="unit" min="1" class="form-control CostOfProduct maxvla" required="true" name="unit[]" tabindex="1" value="<?php echo $unit[$key]; ?>">
                                                        </div>
                                                        <div class="col col-sm-2">
                                                            <label for="balance">&nbsp; &nbsp;Balance<sup style="color:red;">*</sup></label>
                                                            <input readonly="true"type="number" id="balance" min="0" class="form-control CostOfProduct blan " required="true" name="balance[]" tabindex="1" value="<?php echo $balance[$key]; ?>">
                                                        </div>
                                                        <div class=" form-group AddMoreRow pull-right">                                                               
                                                            <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </div>
                                                    </div><br>
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="2" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                </div>
                                            </div>
                                    </div>
                                    <br>
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <div class="row text-right">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn ink-reaction btn-raised btn-primary" tabindex="1" id="save" name="save" onClick="return confirm('Are You Sure To Save')">Save</button>
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
                    </div>
                </section>

                <section>
                    <div class="section-body ">
                        <div class="row">
                            <div class=" col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Outward Expenses Entry List</header>
                                    </div>
                                    <div class="card-body">
                                        <div id="regwise_select" class="tbgetsect">
                                            <div class="col-sm-5 col-lg-offset-4  form-group">
                                                <div class="input-group date demo-date-format">
                                                    <div class="row">
                                                        <div id="reportrange" class="pull-center" style="cursor: pointer; width: 100%;">
                                                            <input type="text" value="" class="form-control" name="start" id="start" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <span class="input-group-addon"><i class="fa fa-calendar" style="width: 40px"></i></span>
                                                </div>
                                            </div>
                                            <div id="showtable"></div>
                                        </div>
                                        </form>
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
                format: 'dd-mm-yyyy',
                startDate: '1-3-2019',
                endDate: '+0d',
            });

        </script>   
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script>
            $(function () {
                var start = moment().subtract(6, 'days');
                var end = moment();
                function cb(start, end) {
                    var dates = $('#start').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    var dates1 = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
                    $(document).ajaxStart(function () {
                        $("#loadingmessage").css("display", "block");
                    });
                    $(document).ajaxComplete(function () {
                        $("#loadingmessage").css("display", "none");
                    });

                    $.post('outward.php',
                            {
                                tablechange: dates1,
                            },
                            function (data, status) {
                                console.log(data);
                                $('#showtable').html(data);
//                                  $('#reportrange').val(start.format('D-MM-YYYY') + ' To ' + end.format('D-MM-YYYY'));
                                $('#datatable1').DataTable({
                                    "dom": 'lCfrtip',
                                    "colVis": {
                                        "buttonText": "Hide",
                                        "overlayFade": 0,
                                        "align": "right"
                                    },
                                    "aLengthMenu": [
                                        [10, 25, 50, 100, -1],
                                        [10, 25, 50, 100, "All"]
                                    ],
                                    "iDisplayLength": -1
                                });
                            });
                }
                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'D-MM-YYYY'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);
                cb(start, end);
            })
        </script>
        <script>
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
        </script>
        <script>
            $(".buttonclass").click(function () {//AddMoreRow clone1
                $('#Clonediv .clone1:last').clone().appendTo('#Clonediv').find('input').val('');
                var button = parseInt($('#Clonediv .clone1:last').prop('id').replace("buttonid", "")) + 1;
                $('#Clonediv .clone1:last').prop('id', 'buttonid' + button);
                CostOfProductOnChange();
                change_select();
                RemoveButtonShowHide();
            });

            $(document).on('change', '.CostOfProduct', function () {
                CostOfProductOnChange();
            });

            function CostOfProductOnChange() {
                var sum = 0;
                $('.CostOfProduct').each(function () {
                    sum += parseInt(this.value);
                });
            }
            $("body").on("click", ".remove", function () {
                $(this).parents(".button").remove();
                change_select();
                CostOfProductOnChange();
                RemoveButtonShowHide();
                CostOfProductOnChange();
            });

            $(document).on('change blur', '.name_list', function () {
                change_select();
            });

            function change_select()
            {
                var values = $.map($('.name_list:last option'), function (e) {
                    var data = e.value;
                    if (data) {
                        if ($(".name_list option[value=" + data + "]:selected").length > 0) {
                            $(".name_list option[value=" + data + "]:selected").attr("hidden", true);
                        } else if ($(".name_list option[value=" + data + "]").length > 0) {
                            $(".name_list option[value=" + data + "]").attr("hidden", false);
                        }
                    }
                });
            }
            RemoveButtonShowHide();
            function RemoveButtonShowHide() {
                var RemoveValues = $('#Clonediv .clone1').length;
                if (RemoveValues < 2)
                    $('button.remove').hide();
                else
                    $('button.remove').show();
                change_select();
            }
        </script>
        <script>
            function balance(id, ids)
            {
                var total_unit = $("#" + id).find("#total_unit").val();
                var rate = $("#" + id).find("#unit").val();
                var total_amount = parseInt(total_unit) - parseInt(rate);
                $("#" + id).find("#balance").val(total_amount);
                var vali = $("#" + id).find("#unit").val();
                if (parseInt(vali) > parseInt(total_unit)) {
                    alert("give Valid Input");
                    $("#" + id).find("#unit").val("");
                    $("#" + id).find("#balance").val("");
                }
            }

            $(document).ready(function () {
                $(document).on('keyup', 'input', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    var ids = $(this);
                    balance(id, ids);

                });
                $(document).on('change', 'select[name="expences[]"]', function () {
                    var id = $(this).parent().parent().closest('.button').attr("id");
                    var ids = $(this);
                    $.post("outward.php", {
                        GetTotalUnitValue: $(this).val()}, function (data) {
                        $("#" + id).find("#total_unit").val(data);
                        balance(id, ids);
                    });

                });
            });
        </script>
        <script>
            $(document).on('click', '#save', function (e) {
                $('#Clonediv').find("input,select").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus().select();
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    </body>
</html>

