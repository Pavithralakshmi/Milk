<?php
session_start();
$user = $_SESSION['user'];
$name = $role = $_SESSION['name'];

$prefix = "../";
$ques = $userid = $a_answer = '';
$location = $prefix . "index.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
$select = $id = $msg = "";
$prefix = "../";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
include_once $prefix . 'db.php';
if (isset($_POST['artical'])) {
    $userid = $_POST['uid'];
    $heading = $_POST['head'];
    $articles = $_POST['art'];
    $sql = "INSERT INTO `yourpage`(`userid`, `heading`, `articles`, `cdate`, `cip`) VALUES ('$userid', '$heading', '$articles', '$datetime', '$_SERVER[REMOTE_ADDR]')";
    $result = mysqli_query($mysqli, $sql);
    header("Location: add_articals.php?msg=2");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NITHRA | மகளிர் மட்டும்</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
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
                <section >
                    <br><br>
                    <div class="col-lg-offset-1 col-md-10 col-sm-12" >
                        <form class="form" method="post">
                            <div class="card">
                                <div class="card-head style-primary">
                                    <header>கட்டுரை சேர்க்கும் பகுதி</header>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label  class="col-sm-2 text-bold text-info " >தொலைபேசி</label>
                                        <div class="col-sm-12">
                                            <b><select id="discount"  name="uid" class="form-control" required="" >
                                                    <option value="">தொலைபேசி எண் தேர்ந்தெடுக்கவும்</option>
                                                    <?php
                                                    $sql = "select * from registration where state='active' and status='2' and phone IN($nithra_employer_number) ORDER BY id DESC ";
                                                    $result = mysqli_query($mysqli, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php if ($row['phone'] == $nithra_employer_number) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                                ?>><?php echo $row['name'] ?>-<?php echo $row['phone'] ?></option>
                                                    <?php } ?>
                                                </select></b><div class="form-control-line"></div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label for="textarea13" class="col-sm-2 text-bold text-info " >தலைப்பு:</label>
                                        <div class="col-sm-12">
                                            <textarea name="head" id="textarea13" class="form-control" rows="4" placeholder="இங்கே உங்கள் தலைப்பை சேர்க்கவும்" required=""></textarea><div class="form-control-line"></div>
                                        </div>
                                    </div> <br><br><br><br><br>
                                    <div class="form-group">
                                        <label for="textarea13" class="col-sm-2 text-bold text-info" >கட்டுரை:</label>
                                        <div class="col-sm-12">
                                            <textarea name="art" id="textarea13" class="form-control" rows="13" placeholder="இங்கே உங்கள் கட்டுரையை சேர்க்கவும்" required=""></textarea><div class="form-control-line"></div>
                                        </div>
                                    </div><br><br>
                                </div>
                                <div class="card-actionbar">
                                    <div class="card-actionbar-row">
                                        <button type="submit" name="artical" class="btn  btn-primary " onClick="return confirm('இந்த கட்டுரையை வெளியிட நீங்கள் உறுதியாக இருக்கிறீர்களா?')">கட்டுரையை சேமி</button>
                                        <button type="reset" class="btn btn-flat btn-primary ink-reaction">ரத்து</button>                            

                                    </div>
                                </div>
                            </div><!--end .card-body -->
                        </form>
                    </div>      
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
                    Command: toastr["error"]("Word allrady Exited", "Error")
<?php } elseif ($msg == '2') {
    ?>
                    Command: toastr["success"]("கட்டுரை வெற்றிகரமாக சேர்க்கப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '3') {
    ?>
                    Command: toastr["success"]("பதில் வெற்றிகரமாக சேர்க்கப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '4') {
    ?>
                    Command: toastr["success"]("கேள்வி  பதில் வெற்றிகரமாக சேர்க்கப்பட்டது ", "வெற்றி")
<?php }
?>
            });
        </script>

    </body>
</html>

