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
$prefix = "../";
$isdelete = $msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['uid'])) {
    $userid = $_GET['uid'];
    $date1 = date('Y-m-d', strtotime($_GET['date1']));
    $date2 = date('Y-m-d', strtotime($_GET['date2']));
}
include_once $prefix . 'db.php';
$username = array();
$ch = "select * from registration";
$de = mysqli_query($mysqli, $ch);
while ($data = mysqli_fetch_assoc($de)) {
    $username[$data['id']] = $data['name'];
    $userphone[$data['id']] = $data['phone'];
    $usertaluk[$data['id']] = $data['taluk'];
}
if (isset($_GET['delete'])) {
    $delid = $_GET['delete'];
    $sql = "UPDATE `yourpage` SET `isdatele`='1' WHERE  id='$delid'";
    $result = mysqli_query($mysqli, $sql);
    $sql = "UPDATE `report` SET `isdelete`='1' WHERE  qaid='$delid' and flag='3'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: yourpage.php?msg=3");
}
if (isset($_POST['update'])) {
    $heading = $_POST['heading'];
    $articles = $_POST['articles'];
    $id = $_POST['quesid'];
    $sql = "UPDATE `yourpage` SET `heading`='$heading', `articles`='$articles' WHERE  id='$id'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: yourpage.php?msg=4");
}
if (isset($_POST['category_s'])) {
    // $filter = $_POST['category_s'];
    $filter = date('Y-m-d', strtotime($_POST['category_s']));
    ?>
    <section class="style-default-bright" id="allvalue">                    
        <div class="table-responsive">
            <table   id="datatable1" class="table dataTable table-striped table-hover">
                <thead>
                    <tr>
                        <th  class="sort-numeric">SLNO</th>
                        <th>Action</th>
                        <th class="sort-alpha">Heading</th>
                        <th class="sort-alpha">Ariticals</th>
                        <th  class="sort-numeric">Aritical By</th>
                        <th class="sort-numeric">Aritical Date</th>
                        <th  class="sort-numeric">Aritical_Likes</th>
                        <th  class="sort-numeric">A_ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 1;
                    $sql = "select * from yourpage where date(cdate)='$filter' and isdatele='0' ORDER by id DESC";
                    $result = mysqli_query($mysqli, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $heading = $row['heading'];
                        $heading = wordwrap($heading, 100, "<br>\n");
                        $articles = $row['articles'];
                        $articles = mb_substr(wordwrap($articles, 100, "<br>\n"), 0, 100) . '.......';
                        ?>
                        <tr>           
                            <td><?php echo $s; ?></td>
                            <td>
                                <button  class="btn  ink-reaction btn-floating-action btn-warning" data-toggle="modal" data-target="#<?php echo $row['id']; ?>" data-original-title="Edit Quetion"><i class="md md-mode-edit"></i></button>
                                <?php if ($role == "admin") { ?> <a href="yourpage.php?delete=<?php echo $row['id']; ?>"><button type="button" onClick="return confirm('Are You Sure Delete this aritical')" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Details"><i class="md md-delete"></i></button></a><?php } ?>
                            </td>
                            <td> 
                                <div><?php echo $heading; ?></div>                                         
                            </td>
                            <td><div><?php echo $articles; ?></div></td>
                            <td><div class="card">
                                    <div class="card-transparent small-padding text-center"><span class="btn-link">Name:</span><?php echo $username[$row['userid']]; ?></div>
                                    <div class="card-transparent text-center"><span class="opacity-50">Phone:</span> <?php echo $userphone[$row['userid']]; ?><BR></div>
                                    <div class="card-transparent text-center"><span class="opacity-50">Address:</span> <?php echo $usertaluk[$row['userid']]; ?><BR></div>
                                </div></td>
                            <td><?php echo $row['cdate']; ?></td>
                            <td><?php echo $row['like']; ?></td>
                            <td><?php echo $row['id']; ?></td>
                        </tr>                                  
                        <?php
                        $s++;
                    }
                    ?>
                </tbody>                
            </table>
        </div>
    </section>
    <?php
    exit;
}
?>
<!DOCTYPE html/>
<html lang="en">
    <head>
        <title>மகளிர் மட்டும் | View Articles</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once $prefix . 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">
            </div>
            <!-- BEGIN CONTENT-->
            <div id="content">
                <section class="style-default-bright">
                    <div class=" contain-lg">
                        <!-- BEGIN VERTICAL FORM FLOATING LABELS -->
                        <div class="row">
                            <div class="col-md-12">
                                <h2>View Ariticles</h2>
                            </div><!--end .col -->
                            <form method="Post"  enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php  if (empty($userid)) { ?>
                                        <div class="row btn-link col-lg-6 col-lg-offset-2  floating-label input-group date "  id="demo-date-format">                                     
                                            <div class="input-group-content">
                                                <input type="text" class="form-control"  id="filter" name="category">
                                                <p class="help-block">yyyy-mm-dd</p>
                                            </div>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <span class="input-group-addon"><B>OR</B></span>
                                            <div class="form-group">  
                                                <select tabindex="1" class="form-control" id="filter" name="category">
                                                    <option value="all">Select Date </option>
                                                    <?php
                                                    $s = 1;
                                                    $sql = "SELECT distinct date(cdate) `date` FROM `yourpage` where isdatele='0' ORDER by `date` DESC ";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>                                                      
                                                        <option value="<?php echo $row['date'] ?>"><?php echo date('d-m-Y', strtotime($row['date']));?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="row btn-link">
                                            <div class="col-lg-4 col-lg-offset-4 "><h3>
                                                <div id='loadingmessage' style='display:none'>
                        <center><img src='../assets/img/712.gif' width="100px"/></center>
                    </div> 
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>
                </section>    
                <!-- END CONTENT -->
                <!-- BEGIN MENUBAR-->
                <div id="viewdiv">
                    <section class="style-default-bright" id="allvalue">
                        <div class="table-responsive">                     
                            <table id="datatable1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th  class="sort-numeric">SLNO</th>
                                        <th>Action</th>
                                        <th class="sort-alpha">Heading</th>
                                        <th class="sort-alpha">Ariticals</th>
                                        <th  class="sort-numeric">Aritical By</th>
                                        <th class="sort-numeric">Aritical Date</th>
                                        <th  class="sort-numeric">Aritical_Likes</th>
                                        <th  class="sort-numeric">A_Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s = 1;
                                    if (empty($userid)) {
                                        $sql = "select * from yourpage where isdatele='0'  and cdate >= ( CURDATE() - INTERVAL 2 DAY ) ORDER BY  id DESC ";
                                    } else {
                                        $sql = "select * from yourpage where isdatele='0'  and userid='$userid'  and date(cdate) BETWEEN '$date1' and '$date2' ORDER BY  id DESC";
                                    }
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $heading = $row['heading'];
                                        $heading = wordwrap($heading, 100, "<br>\n");
                                        $articles = $row['articles'];
                                        $articles = mb_substr(wordwrap($articles, 100, "<br>\n"), 0, 100) . '.......';
                                        ?>
                                        <tr>           
                                            <td><?php echo $s; ?></td>
                                            <td>
                                                <button  class="btn  ink-reaction btn-floating-action btn-warning" data-toggle="modal" data-target="#<?php echo $row['id']; ?>" data-original-title="Edit Quetion"><i class="md md-mode-edit"></i></button>
                                                <?php if ($role == "admin") { ?>  <a href="yourpage.php?delete=<?php echo $row['id']; ?>"><button type="button" onClick="return confirm('Are You Sure Delete this aritical')" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Details"><i class="md md-delete"></i></button></a><?php } ?>
                                            </td>
                                            <td>                                                                                  
                                                <div><?php echo $heading; ?></div>                                         
                                            </td>
                                            <td><div><?php echo $articles; ?></div></td>
                                            <td><div class="card">
                                                    <div class="card-transparent small-padding text-center"><span class="btn-link">Name:</span><?php echo $username[$row['userid']]; ?></div>
                                                    <div class="card-transparent text-center"><span class="opacity-50">Phone:</span> <?php echo $userphone[$row['userid']]; ?><BR></div>
                                                    <div class="card-transparent text-center"><span class="opacity-50">Address:</span> <?php echo $usertaluk[$row['userid']]; ?><BR></div>
                                                </div></td>
                                            <td><?php echo $row['cdate']; ?></td>
                                            <td><?php echo $row['like']; ?></td>
                                            <td><?php echo $row['id']; ?></td>
                                        </tr>                                  
                                        <?php
                                        $s++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <section class="style-default-bright" id="allvalue">
                    <?php
                    $sql = "select * from yourpage where isdatele='0' ORDER BY  id DESC ";
                    $result = mysqli_query($mysqli, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $heading = $row['heading'];
                        $articles = $row['articles'];
                        ?>
                        <div class="modal fade align-center" id="<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <form method="post" >
                                        <div class="modal-header">
                                            <h4 class="text-primary">Edit Heading</h4>
                                            <textarea class="form-control" type="text" rows="4" name="heading" value="<?php echo $heading; ?>"><?php echo $heading; ?></textarea>
                                            <h4 class="text-info">Edit Article</h4>
                                            <textarea class="form-control" type="text" rows="18" cols="80" name="articles" value="<?php echo $articles; ?>"><?php echo $articles; ?></textarea>
                                            <input type="text" name="quesid" value="<?php echo $row['id']; ?>" hidden>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <?php if ($role == "admin") { ?>    <button type="submit" name="update" class="btn btn-primary" onClick="return confirm('Are You Sure Change the Aritical')">Save changes</button><?php } ?>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>                                             
                        <?php
                    }
                    ?>
                </section>
                <!-- END MENUBAR -->
            </div>
            <!--end .row -->
        </div><!--end #base-->
        <!-- END BASE -->
        <!-- BEGIN JAVASCRIPT -->
        <?php include_once $prefix . 'include/menubar.php'; ?>
        <?php include_once $prefix . 'include/jsfiles.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
<?php if ($msg == '1') {
    ?>
                    Command: toastr["error"]("Word allrady Exited", "Error")
<?php } elseif ($msg == '2') {
    ?>
                    Command: toastr["success"]("Game Verfied Sucesssfully", "Sucesss")
<?php } elseif ($msg == '3') {
    ?>
                    Command: toastr["success"]("Aritcal Deleted Sucesssfully", "success")
<?php } elseif ($msg == '4') {
    ?>
                    Command: toastr["success"]("Artical Updated Sucesssfully ", "Success")
<?php }
?>
            });
        </script>
        <script type="text/javascript">
            $(document).on('change', '#filter', function (e) {
                $('#loadingmessage').show();
                var category = $(this).val();
                $.post("yourpage.php",
                        {
                            category_s: category
                        },
                        function (data, status) {
                            $("#viewdiv").html(data);
                            
                            $('#datatable1').DataTable({
                                "dom": 'lCfrtip',
                                "order": [],
                                "colVis": {
                                    "buttonText": "Columns",
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
                            $('#loadingmessage').hide();
                        });
            });
            $('#demo-date-format').datepicker({todayHighlight: true, format: "d-m-yyyy"});
            // When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
        </script>
    </body>
</html>