<?php
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];
$pageurl = $_SERVER['REQUEST_URI'];
$prefix = "";
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}

include_once $prefix . 'db.php';

$uname = $fname = $id = $msg = $lname = $email = $pwd = $cpwd = '';
$unam = $fnam = $lnam = $emaill = $pwdd = $cpwdd = $img = $ugrop = '';
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
        $sql = "select * from `nithrausers` where id='$id'";
        $result = mysqli_query($mysqli_nithra, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $unam = $row['username'];
            $ugrop = $row['role'];
            $pwdd = $row['password'];
            $cpwdd = $row['password'];
            
        }
    }
    else if ($action == 'deactive') {
        $sql = "UPDATE `nithrausers` SET `status` = '1' where id='$id'";
        $result = mysqli_query($mysqli_nithra, $sql);       
        accesslog($user,$datetime,"User registration Deactivated");
        header("Location: userreg.php?msg=3");
    } else if ($action == 'active') {
        $sql = "UPDATE `nithrausers` SET `status` = '0' where id='$id'";
        $result = mysqli_query($mysqli_nithra, $sql);
        accesslog($user,$datetime,"User registration activated");
        header("Location: userreg.php?msg=3");
    }
    else if ($action == 'delete') {
        $sql = "DELETE FROM `nithrausers` where id='$id'";
        $result = mysqli_query($mysqli_nithra, $sql);
        accesslog($user,$datetime,"User registration deleted");
        header("Location: userreg.php?msg=4");
    }
}
if (isset($_POST['save'])) {
    $uname = $_POST['uname'];
    $ugroup = $_POST['ugroup'];
    $pwd = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];
   
    if ($id) {
        $sql = "UPDATE `nithrausers` SET  `username` = '$uname', `role` = '$ugroup',`password` = '$pwd' where `id`= '$id' ";
        $result = mysqli_query($mysqli_nithra, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli_nithra));
        accesslog($user,$datetime,"User registration updated");
        header("Location: userreg.php?msg=3");
    } else {
        $sql = "INSERT INTO `nithrausers` (`role`, `username`,`password`,`apps`)"
                . " VALUES ('$ugroup', '$uname','$pwd','all')";
        
        $result = mysqli_query($mysqli_nithra, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($mysqli_nithra));
        accesslog($user,$datetime,"New user added");
        header("Location: userreg.php?msg=2");
    }
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NITHRA - User Registration</title>
        <?php include_once $prefix . 'include/headtag.php'; ?>
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN HEADER-->
        <?php include_once $prefix . 'include/header.php'; ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">

            <!-- BEGIN OFFCANVAS LEFT -->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">                       
                        <div class="row">                                                                        
                            <div class="col-md-8 col-lg-offset-2">
                                <div class="card center-block">
                                    <div class="card-head  style-primary">
                                        <header>Add User</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-validate" role="form" method="POST" onsubmit="validate(event);" enctype="multipart/form-data" >
                                            <div class="col-sm-6 form-group floating-label">
                                                <input tabindex="1" type="text" value="<?php
                                                if ($unam) {
                                                    echo $unam;
                                                }
                                                ?>" name="uname"  class="form-control" required>
                                                <label>User Name*</label>
                                            </div>   
                                            <div class=" col-sm-6  form-group floating-label">
                                                <select tabindex="1" id="category_id" name="ugroup" class="form-control" required>
                                                    <option value="">Choose Group</option>
                                                    <?php
                                                    $sql = "select * from `usergroup`";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = $row['id'];
                                                        $name = $row['name'];
                                                        ?>
                                                        <option value="<?php echo $row['name']; ?>" <?php
                                                        if ($ugrop == $row['name']) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $row['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>                                            
                                                </select>
                                                <label>Select User Group*</label>   
                                            </div>
                                                                                        
                                            <div class="col-sm-6 form-group floating-label">
                                                <input tabindex="1" type="text" value="<?php
                                                if ($pwdd) {
                                                    echo $pwdd;
                                                }
                                                ?>" name="pwd" id="password" class="form-control" required>
                                                <label>Password*</label>
                                            </div> 
                                            <div class="col-sm-6 form-group floating-label">
                                                <input tabindex="1" type="text" value="<?php
                                                if ($cpwdd) {
                                                    echo $cpwdd;
                                                }
                                                ?>" name="cpwd" id="cpassword"  class="form-control" required>
                                                <label>Confirm Password*</label>
                                            </div> 
                                            
                                            <div class="col-sm-12">
                                                <button tabindex="3" type="reset" name="cancel" class="btn btn-flat btn-default-light ink-reaction" onClick="location.href='userreg.php'">Cancel</button>
                                                <button tabindex="2" type="submit" name="save" id="submit-button" class="btn ink-reaction btn-raised btn-primary " >Save</button>
                                            </div>
                                        </form>
                                    </div><!--end .card-body -->
                                </div><!--end .card -->                            
                            </div><!--end .col -->
                        </div><!--end .row -->  
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
                                        <h2 class="text-primary">Edit Users</h2>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-hover">
                                                <thead>
                                                    <tr>                                    
                                                        <th>S.No</th>
                                                        <th>Actions</th>
                                                        <th>User Name</th>
                                                        <th>User Group</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $sql = "SELECT * FROM `nithrausers` ORDER BY id desc";
                                                    $result = mysqli_query($mysqli_nithra, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = encrypt_decrypt('encrypt', $row['id']);
                                                        $ugroup = $row['role'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td class="text-left">
                                                                <a href="userreg.php?<?php echo $action_string . '=' . $edit_string . '&' . $id_string . '=' . $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>                                          
                                                                <button onclick="deletion('<?php echo $action_string . '=' . $delete_string . '&' . $id_string . '=' . $id; ?>')"type="button" class="btn ink-reaction btn-floating-action btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete now" ><i class="fa fa-trash"></i></button>
                                                                <!--<a href="userreg.php?<?php echo $action_string . '=' . $deactive_string . '&' . $id_string . '=' . $id; ?>" type="button" class="btn ink-reaction btn-block-action btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Active now"><i class="fa fa-close"></i> &nbsp; In-Active </a>-->                                                                                                                                                                                                                           
                                                            </td>
                                                            <td><?php echo $row['username'] ?></td>                                                            
                                                            <td><?php echo $ugroup; ?></td>                                                            
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
            <!-- END MENUBAR -->
            <!-- BEGIN JAVASCRIPT -->
            <?php include_once $prefix . 'include/jsfiles.php'; ?>
            <!-- END JAVASCRIPT -->
            <script>
<?php if ($msg == '2') { ?>
                    Command: toastr["success"]("User added sucesssfully", "Sucesss")
<?php } elseif ($msg == '1') {
    ?>
                    Command: toastr["error"]("User already exist", "Error")
<?php } elseif ($msg == '3') { ?>
                    Command: toastr["success"]("User Updated Sucesssfully", "Sucesss")
<?php } elseif ($msg == '4') { ?>
                    Command: toastr["success"]("User deleted Sucesssfully", "Sucesss")
<?php } ?>
            </script>
            <script>
                function deletion(strr) {
                    //alert'hi';
                    if (strr) {
                        var r = confirm("Are You Sure Want To Delete ?");
                        if (r == true) {
                            window.location = "userreg.php?" + strr;
                        }
                    }
                }
            </script>
            <script>
         function validate(event)
         {
            var password =document.getElementById("password").value; 
            var cpassword = document.getElementById("cpassword").value; 
             if(password == cpassword){
                //  $('#submit-button').prop('disabled', false);
                return true;
             }
             else
             {
                 event . preventDefault();

                 alert( "Password didn't match" );
                //   $('#submit-button').prop('disabled', true);
                return false;

             }
         }
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
        //     $( "body" ).animate({
        //   backgroundColor: "#red",
        //   color: "#fff",
        //   width: 500
        // }, 1000 );
        </script>
    </body>
</html>

