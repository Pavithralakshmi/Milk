<?php
session_start();
$user = $_SESSION['user'];
$name = $role = $_SESSION['name'];
$prefix = "../";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
$select = $id = $msg = $category =$getid= "";
$prefix = "../";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$qnt = "_qnt";
$mmdate = '_date';
include_once $prefix . 'db.php';
$getid = '';
if (isset($_GET['verfiy'])) {
    $vid = $_GET['verfiy'];
    $ver = "UPDATE `sb_productname` SET `isverfy`='1' WHERE id='$vid'";
    $res = mysqli_query($mysqli, $ver);
    header("Location: sel_buy_cate.php?msg=8");
}
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $sql = "DELETE  FROM `sb_productname` WHERE id='$pid'";
    $result = mysqli_query($mysqli, $sql);
    $sql = "UPDATE `seller_table` SET`pid`='0' WHERE pid='$pid'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: sel_buy_cate.php?msg=9");
}
if (isset($_POST['categorys'])) {
    $category = $_POST['category'];
    $cate_img = $_POST['cate_img123'];
     $getid = $_POST['getid'];
    $sql = "SELECT * FROM `sb_category` WHERE  cname='$category' and `id`!='$getid'";
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result)) {
        $msg = 1;
    } else {
       
        if (empty($getid)) {
            $sql = "INSERT INTO `sb_category`(`cname`, `imag_url`, `cdate`, `cip`, `cby`) VALUES ('$category', '$cate_img', '$datetime', '$_SERVER[REMOTE_ADDR]', '$user' )";
            $result = mysqli_query($mysqli, $sql);
            header("Location: sel_buy_cate.php?msg=2");
        } else {
            $sql = "UPDATE `sb_category` SET `cname`='$category',`imag_url`='$cate_img', `cdate`='$datetime',`cip`='$_SERVER[REMOTE_ADDR]',`cby`='$user' WHERE id='$getid'";
            $result = mysqli_query($mysqli, $sql);
            header("Location: sel_buy_cate.php?msg=3");
        }
    }
}
if (isset($_POST['itemnames'])) {
    $category = $_POST['category'];
    $itemname = $_POST['itemname'];
    $itemimage = $_POST['itemimages'];
    $sql = "SELECT * FROM `sb_productname` WHERE  pname='$itemname' and cid ='$category' and imgurl='$itemimage'";
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result)) {
        $msg = 1;
    } else {
        $itemimage = $_POST['itemimages'];
        $getid = $_POST['getid'];
        if (empty($getid)) {
            $sql = "INSERT INTO `sb_productname`(`cid`, `pname`, `imgurl`,`cdate`,`cip`, `cby`,`mdate`,`mip`, `mby`) VALUES ('$category', '$itemname', '$itemimage', '$datetime', '$_SERVER[REMOTE_ADDR]', '$user', '$datetime', '$_SERVER[REMOTE_ADDR]', '$user' )";
            $result = mysqli_query($mysqli, $sql);
            header("Location: sel_buy_cate.php?msg=6");
        } else {
            $sql = "UPDATE `sb_productname` SET `cid`='$category',`pname`='$itemname',`imgurl`='$itemimage',`mdate`= CONCAT (`mip`,'|','$datetime'),`mip`= CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]'),`mby`= CONCAT (`mby`,'|','$user') WHERE id='$getid'";
            $result = mysqli_query($mysqli, $sql);

            header("Location: sel_buy_cate.php?msg=7");
        }
    }
}
if (isset($_POST['category_select'])) {
    $category = $_POST['category_select'];
    $select = $_POST['categoryvice'];
    if ($category == '' or $select == '') {
        $cid = 1;
        $verfiy = ' `sp`.`isverfy`=0';
    } else {
        $cid = ' `sp`.`cid`=' . $category;
    }
    if ($select == 2) {
        $verfiy = 1;
        $cid = 1;
    } else if ($select == 3) {
        $verfiy = ' `sp`.`isverfy`=1';
    } else if ($select == 4) {
        $verfiy = '`sp`.`isverfy`=0';
    }
    if ($select == 'raj') {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <?php if ($role == "admin") { ?>  <th>Action</th> <?php } ?>
                                <th class="sort-alpha">Category</th>
                                <th class="sort-numeric">Images</th>
                                <th class="sort-numeric">Category id</th>
                                <th class="sort-alpha">Add Date</th>
                                <th class="sort-alpha">Add by</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php
                            $s = 1;
                            $sql = "SELECT * FROM `sb_category` ORDER BY id  DESC";
                            $result = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $s; ?></td>
                                    <?php if ($role == "admin") { ?> <td>
                                        <button class="btn btn-warning btn-raised" value="<?php echo $row['id']; ?>@#@<?php echo $row['cname']; ?>@#@<?php echo $row['imag_url']; ?>"  onclick="edit_category_modalopen(this.value)"><i class="md md-edit"></i></button>                                
                                    </td><?php 
                                    } ?>
                                    <td>  <?php echo $row['cname']; ?></td>
                                    <td><a target="_blank" href="<?php echo $row['imag_url']; ?>"><img src="<?php echo $row['imag_url']; ?>" width="80px"></a></td>
                                    <td>   <?php echo $row['id']; ?></td> 
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
    <?php } else {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <?php if ($role == "admin") { ?>  <th>Action</th> <?php } ?>
                                <th class="sort-alpha">item Name</th>
                                <th class="sort-alpha">images</th>
                                <th class="sort-alpha">Category Name</th>
                                <th class="sort-alpha">item id</th>
                                <th class="sort-alpha">Add Date</th>
                                <th class="sort-alpha">Add by</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php
                            $s = 1;
                            $sql = "SELECT `sp`.`cby`,`sp`.`cid`,`sp`.`cdate`,`sp`.`isverfy`, `sp`.`id`,`sc`.`cname`,`sp`.`pname`,`sp`.`imgurl` FROM `sb_productname` `sp` CROSS JOIN  `sb_category` `sc` ON `sp`.`cid`=`sc`.`id`  WHERE  `sp`.`isdelete`='0' and $cid and $verfiy ORDER by  `sp`.`id` ASC";
                            $result = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $s; ?></td>
                                     <?php if ($role == "admin") { ?><td>
                                        <?php if ($row['isverfy'] == 0) { ?>
                                            <a href="sel_buy_cate.php?verfiy=<?php echo $row['id']; ?>"> <button class="btn btn-success btn-raised"  onClick="return confirm('இந்த பொருளை சரிபார்க்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')"><i class="md md-done"></i></button> </a>                              
                                        <?php } ?>
                                        <button class="btn btn-warning btn-raised"  value="<?php echo $row['id']; ?>@#@<?php echo $row['cid']; ?>@#@<?php echo $row['pname']; ?>@#@<?php echo $row['imgurl']; ?>"  onclick="edit_modalopen(this.value)"  ><i class="md md-edit"></i></button>                                
                                        <a href="sel_buy_cate.php?pid=<?php echo $row['id']; ?>"> <button class="btn btn-danger btn-raised"  onClick="return confirm('இந்த பொருளை நீக்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')"><i class="md md-delete"></i></button> </a>                              
                                    </td><?php 
                                    } ?>
                                    <td><?php echo $row['pname']; ?></td>
                                    <td><a target="_blank" href="<?php echo $row['imgurl']; ?>"><img src="<?php echo $row['imgurl']; ?>" width="80px"></a></td>
                                    <td><?php echo $row['cname']; ?></td> 
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
    }
    exit;
}
//edit Functionalaty
$img2 = $img1 = $cate = $word = $id = $category = "";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NITHRA | மகளிர் மட்டும்</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
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
        <?php include_once $prefix . 'include/header.php'; ?>
        <!-- END HEADER-->
        <!-- END BASE -->
        <div id="base">
            <div class="offcanvas">
            </div>
            <div id="content">
                <section class="style-default-bright">
                    <br><br>
                    <div><h3 class="text-center text-bold">பொருளின் வகை மற்றும் பொருளை சேர்க்கும் பகுதி</h3></div>
                    <div class="card-body style-info">
                        <div class="row col-lg-12 col-lg-offset-3">
                            <div class="style-default-bright">
                                <div class="col-lg-3 ">
                                    <button class="btn btn-default-bright btn-raisedb text-bold" onclick="add_category_modalopen()" >பொருளின் வகை சேர்க்க <i class="md md- md-group-work"></i></button>                                
                                </div>     
                                <div class="col-lg-2 ">
                                    <button class="btn btn-default-bright btn-raised" onclick="add_modalopen()"  ><b>பொருளை சேர்க்க</b> <i class="md md- md-add-to-photos"></i></button>                                
                                </div>   
                            </div>       
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row col-lg-offset-2">
                            <div class="col-lg-4 "><h3>
                                    <div class="form-group">                                                                                                                                                 
                                        <b><select tabindex="1"  class="select2-container form-control text-bold" id="category" name="category" required>
                                                <option  value="4">Select View Type</option>      
                                                <option  value="4">View to be Verify SubCategory </option>
                                                <option  value="3">View  Verified SubCategory</option>
                                                <option  value="raj">View All Category</option>
                                            </select></b>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-lg-4 "><h3>
                                    <div class="form-group">                                                                                                                                                 
                                        <b><select tabindex="1"  class="select2-container form-control text-bold" id="cross" required>
                                                <option  value="">Select Category view</option>
                                                <?php
                                                $sql = "select `id`, `cname` from sb_category ";
                                                $result = mysqli_query($mysqli, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['cname'] ?></option>
                                                <?php } ?>
                                            </select></b>
                                    </div>
                                </h3>
                            </div>   

                        </div>    
                    </div>
                    <div class="row">
                        <br>  
                        <div id='loadingmessage' style='display:none'>
                            <center> <img src="../assets/img/712.gif"/></center>
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
                                                    <th class="sort-alpha">item Name</th>
                                                    <th class="sort-alpha">Images</th>
                                                    <th class="sort-alpha">Category Name</th>
                                                    <th class="sort-alpha">item id</th>
                                                    <th class="sort-alpha">Add Date</th>
                                                    <th class="sort-alpha">Add by</th>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                <?php
                                                $s = 1;
                                                $sql = "SELECT `sp`.`cby`,`sp`.`cid`,`sp`.`imgurl`,`sp`.`cdate`,`sp`.`isverfy`, `sp`.`id`,`sc`.`cname`,`sp`.`pname` FROM `sb_productname` `sp` CROSS JOIN  `sb_category` `sc` ON `sp`.`cid`=`sc`.`id`  WHERE  `sp`.`isdelete`='0' and  `sp`.`isverfy`='0' ORDER by `sp`.`id` ASC";
                                                $result = mysqli_query($mysqli, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $s; ?></td>
                                                        <?php if ($role == "admin") { ?><td>
                                                            <?php if ($row['isverfy'] == 0) { ?>
                                                                <a href="sel_buy_cate.php?verfiy=<?php echo $row['id']; ?>"> <button class="btn btn-success btn-raised"  onClick="return confirm('இந்த பொருளை சரிபார்க்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')"><i class="md md-done"></i></button> </a>                              
                                                            <?php } ?>
                                                            <button class="btn btn-warning btn-raised"  value="<?php echo $row['id']; ?>@#@<?php echo $row['cid']; ?>@#@<?php echo $row['pname']; ?>@#@<?php echo $row['imgurl']; ?>"  onclick="edit_modalopen(this.value)"  ><i class="md md-edit"></i></button>                                
                                                            <a href="sel_buy_cate.php?pid=<?php echo $row['id']; ?>"> <button class="btn btn-danger btn-raised"  onClick="return confirm('இந்த பொருளை நீக்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')"><i class="md md-delete"></i></button> </a>                              
                                                            </td><?php } ?>
                                                        <td><?php echo $row['pname']; ?></td>
                                                        <td><a target="_blank" href="<?php echo $row['imgurl']; ?>"><img src="<?php echo $row['imgurl']; ?>" width="80px"></a></td>
                                                        <td><?php echo $row['cname']; ?></td> 
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
                        </div>                              
                    </div>
            </div>
            <div class="modal fade" id="category123" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title text-bold text-primary" id="simpleModalLabel">Save category</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group floating-label">
                                    <h4  class="text-bold text-info">Add Category</h4>
                                    <input  name="category"  type="text" class="form-control" id="categoryedit" placeholder="add Category name here"  required="">    
                                    <input type="text" id="cate_editid" hidden name="getid" value="">
                                </div>  
                                <div class="form-group floating-label">
                                    <h4  class="text-bold text-warning">Add Category Image url</h4>
                                    <input  type="text" class="form-control" name="cate_img123" id="categoryeditimg" placeholder="Add Catgory Image" required="">             
                                </div>  
                            </div>  
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" onClick="return confirm('இந்த பொருளின் வகையை சேர்க்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')" name="categorys" class="btn btn-primary">Save Category</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
        <div class="modal fade" id="itemname" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="simpleModalLabel">Save item </h4>
                        </div>
                        <div class="modal-body">
                            <h4  class="text-bold text-success">select category</h4>
                            <select tabindex="1" id="category_id"  class="select2-container form-control text-bold" name="category" required>
                                <?php
                                $sql = "select * from sb_category ";
                                $result = mysqli_query($mysqli, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['cname'] ?></option>
                                <?php } ?>
                            </select>               
                            <div class="form-group floating-label">
                                <h4  class="text-bold text-info">Add Product name</h4>
                                <input  type="text"   class="form-control" name="itemname" id="prod_name" placeholder="add item name here">    
                                <input type="text" id="edit_id" hidden name="getid" value="">
                            </div>  
                            <div class="form-group floating-label">
                                <h4  class="text-bold text-warning">Add Product Image url</h4>
                                <input  type="text" class="form-control" name="itemimages" id="image_url" placeholder="add item name here">             
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" onClick="return confirm('இந்த பொருளின் பெயர் சேர்க்க நீங்கள் உறுதியாக இருக்கிறீர்களா?')" name="itemnames" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-dialog -->
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
<?php } elseif ($msg == '2') {
    ?>
            Command: toastr["success"]("பொருளின் வகை வெற்றிகரமாக சேர்க்கப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '3') {
    ?>
            Command: toastr["success"]("பொருளின் வகை வெற்றிகரமாக மாற்றப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '4') {
    ?>
            Command: toastr["success"]("சந்தை வெற்றிகரமாக சேர்க்கப்பட்டது ", "வெற்றி")
    <?php
} elseif ($msg == '5') {
    ?>
            Command: toastr["success"]("சந்தை வெற்றிகரமாக பெயர் மாற்றப்பட்டது ", "வெற்றி")
<?php } elseif ($msg == '6') {
    ?>
            Command: toastr["success"]("பொருளின் பெயர் வெற்றிகரமாக சேர்க்கப்பட்டது ", "வெற்றி")
    <?php
} elseif ($msg == '7') {
    ?>
            Command: toastr["success"]("பொருளின் பெயர் மாற்றப்பட்டது ", "வெற்றி")
<?php } elseif ($msg == '8') {
    ?>
            Command: toastr["success"]("பொருள் வெற்றிகரமாக சரிபார்க்கபட்டது", "வெற்றி")
    <?php
} elseif ($msg == '9') {
    ?>
            Command: toastr["success"]("பொருள் நீக்கப்பட்டது", "வெற்றி")
<?php }
?>
    });
</script>
<script type="text/javascript">
    function edit_modalopen(value)
    {
        $('#itemname').modal('show');
        var id_cid_pname = value.split('@#@')
        $('#edit_id').val(id_cid_pname[0]);
        $('#category_id').val(id_cid_pname[1]);
        $('#prod_name').val(id_cid_pname[2]);
        $('#image_url').val(id_cid_pname[3]);
    }
    
    function edit_category_modalopen(value)
    {
        $('#category123').modal('show');
        var id_cid_pname = value.split('@#@')
        $('#cate_editid').val(id_cid_pname[0]);
        $('#categoryedit').val(id_cid_pname[1]);
        $('#categoryeditimg').val(id_cid_pname[2]);
    }
    function add_category_modalopen()
    {
        $('#category123').modal('show');
        $('#cate_editid').val('');
        $('#categoryedit').val('');
        $('#categoryeditimg').val('');
    }

    function add_modalopen()
    {
        $('#itemname').modal('show');
        $('#edit_id').val('');
        $('#category_id').val('');
        $('#prod_name').val('');
        $('#image_url').val('');
    }
    
    $('select').on('change', function (e) {
        var category = $('#cross').val();
        var categoryvice1 = $('#category').val();
        $('#loadingmessage').show();
        $.post("sel_buy_cate.php",
                {
                    category_select: category,
                    categoryvice: categoryvice1
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