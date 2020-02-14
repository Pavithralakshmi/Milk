<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = $pre = $pre_name = $pre_address = $pre_mobile = $sequence_id = $company_id = "";
$reduce_quantity = 0;
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
include_once $prefix . 'db.php';

$getid = '';
if (isset($_POST['categorys'])) {
    $category = $_POST['category'];
    $type_id = $_POST['type_id'];
    $getid = $_POST['getid'];
    if (empty($getid)) {
        $sql = "INSERT INTO `unites_table`(`name`, `type_id`, `cdate`, `cip`, `cby`) VALUES ('$category','$type_id', '$datetime', '$_SERVER[REMOTE_ADDR]', '$user' )";
        $result = mysqli_query($mysqli, $sql);
        header("Location: addunits.php?msg=2");
    } else {
        $sql = "UPDATE `unites_table` SET `name`='$category', `type_id`='$type_id', `cdate`='$datetime',`cip`='$_SERVER[REMOTE_ADDR]',`cby`='$user' WHERE id='$getid'";
        $result = mysqli_query($mysqli, $sql);
        header("Location: addunits.php?msg=3");
    }
}
if (isset($_POST['Phone'])) {
    $filter = $_POST['Phone'];
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="datatable1" class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <?php if ($role == "admin") { ?>  <th>Action</th> 
                            <?php } ?>
                            <th class="sort-alpha">Unit Name</th>
                            <th class="sort-alpha">Unit id</th>
                            <th class="sort-alpha">Add Date</th>
                            <th class="sort-alpha">Add by</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php
                        $s = 1;
                        $sql = "SELECT * FROM `unites_table` where  name LIKE '%$filter%'";
                        $result = mysqli_query($mysqli, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $s; ?></td>
                                <?php if ($role == "admin") { ?><td>
                                    <button class="btn btn-warning btn-raised" data-toggle="modal" data-target="#<?php echo $row['id']; ?>_category"><i class="md md-edit"></i></button>                                
                                </td><?php 
                                } ?>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['cdate']; ?></td>
                                <td><?php echo $row['cby']; ?></td> 
                            </tr>
                            <?php
                            $s++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <?php
    exit;
}
//edit Functionalaty
$img2 = $img1 = $cate = $word = $id = $category = "";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Milk Management  - Category</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
        <style>
        h3.text-bold{
            color : #f10a41;
        }
        </style>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
        <?php include_once  'include/header.php'; ?>
        <!-- END HEADER-->
        <!-- END BASE -->
        <div id="base">
            <div class="offcanvas">
            </div>
            <div id="content">
                <section class="style-default-bright">
                    <br><br>
                    <div><h3 class="text-center text-bold text-success">
                        Add Quentity 
                    </h3></div>
                    <div class="card-body style-info">
                        <div class="row col-lg-12 col-lg-offset-3">
                            <div class="style-default-bright">
                                <div class="col-lg-3 ">
                                    <button class="btn btn-default-bright btn-raisedb text-bold"  onclick="add_new()">
                                    quentity size <i class="md md- md-group-work"></i></button>                                
                                </div>     
                            </div>       
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row col-lg-offset-2">
                            <div class="row">
                                <div class="card-body">
                                    <div class = "row  col-lg-offset-3" >
                                        <div class="col-md-5 form-control floating-label ">
                                            <input type="text" class="form-control text-bold" value="" id="date1" name="start" placeholder="Enter Unit Keyword(in tamil)">
                                        </div>
                                        <div class="col-md-3 ">
                                            <button type="button" id="date_selection"  class="btn ink-reaction btn-success"><i class="md md-search"></i>&nbsp;Find Units</button>
                                        </div>
                                    </div>
                                </div>
                                <div id='loadingmessage' style='display:none'>
                                    <center> <img src="../assets/img/712.gif"/></center>
                                </div>
                            </div>   
                        </div>    
                    </div>
                    <div class="row">
                        <br>  
                        <div id='loadingmessage' style='display:none'>
                            <center><img src="../assets/img/712.gif"/></center>
                        </div>
                        <div id = "ajaxdiv">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="datatable1" class="table table-striped table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>Slno</th>
                                                    <?php if ($role == "admin") { ?>  <th>Action</th> <?php } ?>
                                                    <th class="sort-alpha">Unit Name</th>
                                                    <th class="sort-alpha">Category</th>
                                                    <th class="sort-alpha">Unit id</th>
                                                    <th class="sort-alpha">Add Date</th>
                                                    <th class="sort-alpha">Add by</th>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                <?php
                                                $s = 1;
//                                                $sql = "SELECT cu.*, DATE_FORMAT(cu.cdate,'%d-%m-%Y  %r') as datess , ct.name as `type` FROM `unites_table` cu CROSS JOIN `cow_type` ct ON ct.id=cu.type_id order by cu.id desc limit 0,100";
                                                $sql = "SELECT *,DATE_FORMAT(cdate,'%d-%m-%Y  %r') as datess  FROM `unites_table`  order by  id desc limit 0,100 ";
                                                $result = mysqli_query($mysqli, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $sa = "SELECT  `id`, `cname`  FROM `sb_category` WHERE id='$row[type_id]' ";
                                                    $re = mysqli_query($mysqli, $sa);
                                                    while ($da = mysqli_fetch_assoc($re)) {
                                                        $cname = $da['cname'];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $s; ?></td>
                                                        <?php if ($role == "admin") { ?><td>
                                                            <button class="btn btn-warning btn-raised" onclick="edit_function('<?php echo $row['id']; ?>', '<?php echo $row['type_id']; ?>', '<?php echo $row['name']; ?>')" ><i class="md md-edit"></i></button>                                
                                                        </td>
                                                        <?php } ?>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php if ($cname) {
                                                                echo $cname;
                                                            } else {
                                                                echo "<span style='color:red'>Not Assign</span>";
                                                            } ?></td>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['datess']; ?></td>
                                                        <td><?php echo $row['cby']; ?></td> 
                                                    </tr>
                                                    <?php
                                                    $s++;
                                                    $cname = '';
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
            <div class="modal fade" id="category123" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formId" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title text-bold text-primary" id="simpleModalLabel">Save Units</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group floating-label">
                                    <h4  class="text-bold text-info">Select Category</h4>
                                    <select  class="form-control" id="cow_type" name="type_id" required="" >
                                        <option>-- Select Category--</option>
                                        <?php
                                        $sql = "SELECT `id`, `cname` FROM `sb_category` ";
                                        $result = mysqli_query($mysqli, $sql);
                                        while ($data = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $data['id']; ?>"><?php echo $data['cname']; ?></option>
<?php 
} ?>
                                    </select>
                                </div>  
                                <div class="form-group floating-label">
                                    <h4  class="text-bold text-info">Quentity</h4>
                                    <input  name="category" type="text" class="form-control" id="units" placeholder="add unit name here">             
                                    <input  name="getid" type="text" class="form-control" id="edit_id"  style="display:none">             
                                </div>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" onClick="return confirm('இந்த அளவீட்டை சேர்க்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')" name="categorys" class="btn btn-primary">Save unit</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
        <!--        edit seccsion start-->
    </section>     <!--end #content-->
</div>
</div><!--end #base-->
<!-- END BASE -->
<!-- BEGIN JAVASCRIPT -->
<?php include_once $prefix . 'include/menubar.php'; ?>
<?php include_once $prefix . 'include/jsfiles.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($msg == '1') {
    ?>
            Command: toastr["error"]("word allrady Exited", "Error")
<?php 
} elseif ($msg == '2') {
    ?>
            Command: toastr["success"]("பொருளின் வகை வெற்றிகரமாக சேர்க்கப்பட்டது", "வெற்றி")
<?php 
} elseif ($msg == '3') {
    ?>
            Command: toastr["success"]("பொருளின் வகை வெற்றிகரமாக மாற்றப்பட்டது", "வெற்றி")
<?php 
} elseif ($msg == '4') {
    ?>
            Command: toastr["success"]("சந்தை வெற்றிகரமாக சேர்க்கப்பட்டது ", "வெற்றி")
    <?php

} elseif ($msg == '5') {
    ?>
            Command: toastr["success"]("சந்தை வெற்றிகரமாக பெயர் மாற்றப்பட்டது ", "வெற்றி")
<?php 
} elseif ($msg == '6') {
    ?>
            Command: toastr["success"]("பொருளின் பெயர் வெற்றிகரமாக சேர்க்கப்பட்டது ", "வெற்றி")
    <?php

} elseif ($msg == '7') {
    ?>
            Command: toastr["success"]("பொருளின் பெயர் மாற்றப்பட்டது ", "வெற்றி")
<?php 
} elseif ($msg == '8') {
    ?>
            Command: toastr["success"]("பொருள் வெற்றிகரமாக சரிபார்க்கபட்டது", "வெற்றி")
    <?php

} elseif ($msg == '9') {
    ?>
            Command: toastr["success"]("பொருள் நீக்கப்பட்டது", "வெற்றி")
<?php 
}
?>
    });
</script>
<script type="text/javascript">
    function edit_function(id, type_id, name)
    {
        console.log(id + type_id + name);
        $('#category123').modal('show');
        $("#edit_id").val(id);
        $("#units").val(name);
        $("#cow_type").val(type_id);
    }
    function add_new()
    {
        $('#category123').modal('show');
        $("#formId")[0].reset()
    }

    $('#date_selection').on("click", function (e) {
        var D1 = $("#date1").val();
        $('#loadingmessage').show();
        $.post("add_units.php",
                {
                    Phone: D1,
                },
                function (data, status) {
                    $("#ajaxdiv").html(data);
                    $('#loadingmessage').hide();
                    $('#datatable1').DataTable({
                        "dom": 'lCfrtip',
                        "colVis": {
                            "buttonText": "Hide",
                            "overlayFade": 0,
                            "align": "right"
                        },
                        "language": {
                            "lengthMenu": '_MENU_ entries per page',
                            "search": '<i class="fa fa-search"></i>',
                            "paginate": {
                                "previous": '<i class="fa fa-angle-left"></i>',
                                "next": '<i class="fa fa-angle-right"></i>'
                            }
                        }
                    });
                });
    });


</script>       
</body>
</html>