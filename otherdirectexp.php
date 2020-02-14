<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $particularexp = $date = $timestamp = $total_amount = $id = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

$gh = "select max(otherwardno)as otherwardno from otherdirectexp";
$result1 = mysqli_query($mysqli, $gh);
if (mysqli_num_rows($result1) > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $otherwardno = $row1['otherwardno'];
    }
    $otherwardno = $otherwardno + 1;
} else {
    $otherwardno = 1;
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$sql1 = "SELECT `id`, `particularexp` FROM `particularexp`";
$result = mysqli_query($mysqli, $sql1);
while ($row = mysqli_fetch_assoc($result)) {
    $get_particularexp[$row['id']] = $row['particularexp'];
// echo $get_particularexp[$row['particularexp']];exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `otherdirectexp` where`id` = '$id'";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $otherwardno = $row['otherwardno'];
        $date = $row['date'];
        $timestamp = date("d-m-Y", strtotime($date));
        $particularexp = explode(",", $row['particularexp']);
        $total_amount = explode(",", $row['total_amount']);
        $balance = $row['balance'];
        $remark = $row['remark'];
    }
}


if (isset($_POST['openmodel'])) {
    $id1 = $_POST['openmodel'];
    ?>
    <table class="w3-table-all w3-large">
        <?php
        $sql = "SELECT * FROM `otherdirectexp` where id=$id1 order by `id` desc";
        $result = mysqli_query($mysqli, $sql1);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
//                print_r($row);
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $date = $row['date'];
                $otherwardno = $row['otherwardno'];
                $timestamp = date("d-m-Y", strtotime($date));
                $particularexp = explode(",", $row['particularexp']);
                $total_amount = explode(",", $row['total_amount']);
                $balance = $row['balance'];
                $remark = $row['remark'];
//    }
                ?>
                <?php if ($i == 1) { ?>
                    <tr>
                        <th style="text-align: right;">Other Expence No:</th> <td style="text-align: left;"> <?php echo $otherwardno; ?></td>
                        <th style="text-align: right;">Date:</th> <td style="text-align: left;"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                    </tr>
                    <tr>  
                        <th style="text-align: center;">Expenses</th>
                        <th></th>
                        <th></th>
                        <th style="text-align: center;">Amount Per Product</th>

                    </tr>
                <?php } ?>
                <tr> 
                    <td style="text-align: center;"><?php
                        $particularexp = explode(",", $row['particularexp']);
                        foreach ($particularexp as $key => $value) {
                            echo $get_particularexp[$value] . '<br><br>';
                        }
                        ?></td>
                    <td style="text-align: right;"> </td>
                    <td style="text-align: right;"> </td>
                    <td style="text-align: center;"><?php echo str_replace(",", " <br><br>", $row['total_amount']); ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tfoot>
            <th style="text-align: right;" colspan="3">Total Amount</th>
            <td style="text-align: center;"><?php echo $balance; ?></td>
        </tfoot>
        </table>  <?php
    }
    exit;
}

if (isset($_POST['save'])) {
    $otherwardno = $_POST['otherwardno'];
    $particularexp = implode(',', $_POST['particularexp']);
    $date1 = $_POST['date'];
    $date = new DateTime($date1);
    $timestamp = $date->format('Y-m-d');
    $total_amount = implode(',', $_POST['total_amount']);
    $balance = $_POST['balance'];
    $remark = $_POST['remark'];
    $cdate = date('y/m/d');
    if ($id) {
        $sql = "UPDATE `otherdirectexp` SET `date`='$timestamp',`particularexp`='$particularexp',`total_amount`='$total_amount',`balance`='$balance',`remark`='$remark', `mby` = CONCAT (`mby`,'|','$user'), `mdate` = CONCAT (`mdate`,'|','$datetime'), `mip` = CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]') WHERE id='$id'";
        $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        header("Location: otherdirectexp.php?msg=3");
        exit;
//        }
    } else {
        $check = "select * from `otherdirectexp` where particularexp='$particularexp' AND total_amount='$total_amount'";
        $res = mysqli_query($mysqli, $check);
        if (mysqli_num_rows($res)) {
            $msg = 1;
        } else {
            $sql = "INSERT INTO `otherdirectexp`(`otherwardno`,`date`, `particularexp`, `total_amount`,`balance`,`remark`,`cby`, `cdate`, `cip`) VALUES ('$otherwardno','$timestamp','$particularexp','$total_amount','$balance','$remark','$user','$cdate','$_SERVER[REMOTE_ADDR]')";
            $result = mysqli_query($mysqli, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli));
        }
        header("Location: otherdirectexp.php?msg=2");
        exit;
    }
}


if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
    $sql = "DELETE FROM `otherdirectexp` where `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql);
    $affected_rows = mysqli_affected_rows($mysqli);
    if ($affected_rows > 0) {
        $msg = "4";
    } else {
        $msg = "2";
    }
    header('Location: otherdirectexp.php?msg=' . $msg);
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
                <th>S.No</th>
                <th>Actions</th>
                <th>Other Expenses No</th>
                <th>Expenses</th>     
                <th>Date</th>     
                <th>Total Amount</th>            
                <th>Remarks</th>            
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "select * from otherdirectexp  where date(date) BETWEEN ('$startdate') AND ('$enddate') ORDER BY id DESC";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $otherwardno = $row['otherwardno'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="otherdirectexp.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <a href="otherdirectexp.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                        <button type="button" onclick="openmodel(<?php echo $id; ?>)" class="btn ink-reaction btn-floating-action btn-info" id="modal" ><i class="fa fa-fw fa-eye"></i></button></td>
                    <td style="text-align:center"><?php echo $otherwardno; ?></td>
                    <td><?php
                        $particularexp = explode(",", $row['particularexp']);
                        foreach ($particularexp as $key => $value) {
                            echo $get_particularexp[$value] . '<br>';
                        }
                        ?></td>

                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                    <td style="text-align:right"><?php echo $row['balance']; ?></td>
                    <td><?php echo $row['remark']; ?></td>
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
        <title>Milk Management - Other Direct Expenses</title>
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
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Other Expenses</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="Otherwardno">&nbsp; &nbsp;Other Expense Number</label>
                                                    <input type="number" class="form-control" name="otherwardno" readonly="true"tabindex="1" value="<?php echo $otherwardno; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <!--<div class="col col-sm-4 col-lg-offset-4">-->
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
                                                    foreach ($particularexp as $key => $value) {
                                                        ?>
                                                        <div class="row button clone1" id="buttonid1">                                    
                                                            <div class="col col-sm-6 ">
                                                                <label for="name">&nbsp; &nbsp;Particulars <sup style="color:red;">*</sup></label>
                                                                <select name="particularexp[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                    <option value="">Please Select Particular</option>
                                                                    <?php
                                                                    $sql = "select * from `particularexp`  order by `particularexp` ";
                                                                    $result = mysqli_query($mysqli, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $id1 = $row['id'];
                                                                        ?>
                                                                        <option  value="<?php echo $row['id'] ?>"<?php
                                                                        if ($particularexp[$key] == $id1) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $row['particularexp'] ?></option>
                                                                             <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col col-sm-5">
                                                                <label for="total_amount">&nbsp; &nbsp;Cost <sup style="color:red;">*</sup></label>
                                                                <input type="number" id="total_amount" min="1" class="form-control CostOfProduct" required="true" name="total_amount[]" tabindex="1" value="<?php echo $total_amount[$key]; ?>">
                                                            </div>  
                                                            <div class=" col-sm-1 form-group AddMoreRow">                                                               
                                                                <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="row button clone1" id="buttonid1">                                    
                                                        <div class="col col-sm-6 ">
                                                            <label for="name">&nbsp; &nbsp;Particulars  <sup style="color:red;">*</sup></label>
                                                            <select name="particularexp[]" id="name" tabindex="1" required="true" class="form-control js-example-basic-single form-control name_list">
                                                                <option value="">Please Select Particular</option>
                                                                <?php
                                                                $sql = "select * from `particularexp`  order by `particularexp` ";
                                                                $result = mysqli_query($mysqli, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $id1 = $row['id'];
                                                                    ?>
                                                                    <option  value="<?php echo $row['id'] ?>"><?php echo $row['particularexp'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-5">
                                                            <label for="total_amount">&nbsp; &nbsp;Cost Of Particulars<sup style="color:red;">*</sup></label>
                                                            <input type="number" id="total_amount" min="1" class="form-control CostOfProduct" required="true" name="total_amount[]" tabindex="1" >
                                                        </div>  <br>
                                                        <div class=" col-sm-1 form-group AddMoreRow">                                                               
                                                            <button class="btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row form-group pull-right AddMoreRow">                                                               
                                                <button type="button" name="add" id="add" class="btn btn-success buttonclass">Add More</button>
                                            </div>
                                            <div class="row"><br>
                                                <div class="col-lg-offset-5 col-md-5 form-group">
                                                    <label for="balance">Total Amount:</label>
                                                    <input readonly type="number" id="balance" min="1" class="form-control" name="balance" tabindex="1" value="<?php echo $balance; ?>">
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-sm-12 form-group">                        
                                                    <textarea name="remark" id="remark" tabindex="1" class="form-control"  rows="4" style="resize:none;"  placeholder=""  ><?php echo $remark; ?></textarea>
                                                    <label for="remark">&nbsp; &nbsp;Remark</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">
                                                    <div class="row text-right">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" id="save" tabindex="1" name="save" onClick="return confirm('Are You Sure To Save')">Save</button>
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
                                        <header>Other Expenses Entry</header>
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
        <div class="modal fade" id="mymodal" role="dialog" >
            <div class="modal-dialog modal-lg" style="max-width:60%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Other Expenses details</h4>
                    </div>
                    <div class="modal-body" id="openmodel1">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'include/menubar.php'; ?>
        <?php include_once 'include/jsfiles.php'; ?>
        <script>
<?php if ($msg == '2') { ?>
                Command: toastr["success"]("Added Sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                Command: toastr["error"]("Same entry already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                Command: toastr["success"]("Entry Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                Command: toastr["success"]("Entry Deleted Sucesssfully", "Sucesss")
<?php } ?>
        </script>
        <script>
            $("#demo-date").datepicker({
                format: 'dd-mm-yyyy',
                startDate: '1-3-2019',
                endDate: '+0d',
            });
        </script>       
        <script>
            function goBack() {
                event.preventDefault();
                history.back(1);
            }
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

                    $.post('otherdirectexp.php',
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
                $('#balance').val(sum);
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
            function openmodel(id) {
                $.post("otherdirectexp.php", {openmodel: id}, function (data) {
                    $("#mymodal").modal("show");
                    $('#openmodel1').html(data);
                });
            }
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

