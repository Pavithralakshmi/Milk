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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Milk Management- Login</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
    <?php include_once 'include/headtag.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
         <style>
            .fb { margin-bottom: 50px; }
            .fb th { text-align: center; padding: 5px; font-size:25px;}
            .fb tr td { padding: 5px; font-size: 20px;}
            .card-head header { padding: 18px 24px;}
            .folfb { margin-bottom: 50px;}
            .thd { font-size: 20px;}             
        </style>   
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN HEADER-->
        <?php include_once $prefix .'include/header.php'; ?>
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
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card">
                                <div class="card-body">                                   
                                     <center><table class="fb" border="1" style="border-collapse: collapse;" cellpadding="10" width="75%" >
                                <?php 
                                         $sql2 = "SELECT a.`id`, a.`name`, a.`date`, a.`product`, a.`amount`, a.`phone`, a.`address` FROM `seller`where a.id='$fid' ";                                       
                                         $result2 = mysqli_query($mysqli, $sql2);
                                        while ($row2 = mysqli_fetch_assoc($result2)) {
                                                $id =  $row2['id'];
                                            
                                ?>    
                                <tr bgcolor="#cfcfcf">
                                        <th colspan="3">User  Details</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" width="40%">Name : </td>
                                        <td colspan="2"><?php echo $row2['name']; ?></td>

                                    </tr>
                                    <tr >
                                        <td colspan="2">Father's Name :</td>
                                        <td colspan="2"> <?php echo $row2['date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Region :</td>
                                        <td colspan="2"><?php echo $row2['product']; ?></td>
                                    </tr>                                    
                                    <tr>
                                        <td colspan="2"> Circle/மின் பகிர்மான வட்டம் :</td>
                                        <td colspan="2"><?php echo $row2['amount']; ?></td>
                                    </tr>     
                                     <tr>
                                        <td colspan="2">Division / கோட்டம் :</td>
                                        <td colspan="2"><?php echo $row2['phone']; ?></td>
                                    </tr>    
                                     <tr>
                                        <td colspan="2">Date of Join :</td>
                                        <td colspan="2"><?php echo date('d-m-Y', strtotime($row2['date'])); ?></td>
                                    </tr>     
                                     <tr>
                                        <td colspan="2">K2 Agreement No :</td>
                                        <td colspan="2"><?php echo $row2['address']; ?></td>
                                    </tr>  
                                    <tr>
                                        <td colspan="2">Kit Agreement No :</td>
                                        <td colspan="2"><?php echo $row2['kitagmntno']; ?></td>
                                    </tr>  
                                     <tr>
                                        <td colspan="2">Address :</td>
                                        <td colspan="2"><?php echo $row2['address']; ?></td>
                                    </tr>  
                                      <tr>
                                        <td colspan="2">Mobile No :</td>
                                        <td colspan="2"><?php echo $row2['mobno']; ?></td>
                                    </tr>  
                                      <tr>
                                        <td colspan="2">Whatsapp No :</td>
                                        <td colspan="2"><?php echo $row2['whatsappno']; ?></td>
                                    </tr>  
                                     <tr>
                                        <td colspan="2">E-mail :</td>
                                        <td colspan="2"><?php echo $row2['email']; ?></td>
                                    </tr>  
                                        <?php } } ?>
                                </table>

                            </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div><!--end #content-->
            <!-- END CONTENT -->

            <!-- BEGIN MENUBAR-->
            <?php include_once 'include/menubar.php'; ?>
            <!-- END MENUBAR -->



        </div><!--end #base-->
        <!-- END BASE -->

        <!-- BEGIN JAVASCRIPT -->
                  <?php include_once 'include/js.php';?>
        <!-- END JAVASCRIPT -->
       
       
    </body>
</html>
