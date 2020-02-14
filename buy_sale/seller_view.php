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
include_once $prefix . 'db.php';

function message($message, $phone) {
    ob_start();
    //$msg = "OTP:".$otp;
    $msg = $message;
    $ch = curl_init();
    $msg = urlencode($msg);
    //$no="9865951029";
// $url = "http://easyhops.co.in/sendunicodesms?uname=bharath_poly&pwd=PolytecH&senderid=NITHRA&to=" . $phone . "&msg=" . $msg . "%20-ADMIN&route=T";
    //$url = "http://smshorizon.co.in/api/sendsms.php?user=gokul.nithra&apikey=RfOXkuINM7lzds6nCOPV&mobile=" . $phone . "&message=" . $msg . "&senderid=NITHRA&type=uni";
   $url = "http://api.msg91.com/api/sendhttp.php?sender=NITHRA&route=4&mobiles=" . $phone . "&authkey=221068AW6ROwfK5b2782c0&country=91&campaign=vivasayam&message=" . $msg."&unicode=1";    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    ob_end_clean();
}

$date = date_create($ymd);
date_sub($date, date_interval_create_from_date_string("100 days"));
$startdate = date_format($date, "d-m-Y");
if (isset($_GET['delete'])) {
    $pid = $_GET['delete'];
    $sql = "UPDATE `seller_table` SET `isdelete`='1' WHERE  id='$pid'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: seller_view.php?msg=3");
}
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $prid = $_GET['proid'];
    $phone1 = $_GET['phone'];
    $phone2 = explode(',', $phone1);
    $phone = $phone2[0];
    $message = "நீங்கள் சேர்த்த பொருள் நித்ரா மகளிர் மட்டும்  செயலில் விற்கும் பகுதியில் சேர்க்கப்பட்டது.";
    $query = "select id from sb_productname where id='$prid' and isverfy='1'";
    $res = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($res) == 0) {
        $msg = 5;
    } else {
        $sql = "UPDATE `seller_table` SET `isverfiy`='1' WHERE  id='$pid'";
        $result = mysqli_query($mysqli, $sql);
        message($message, $phone);
        header("Location: seller_view.php?msg=4");
    }
}
if (isset($_POST['view_seller_modal'])) {
    $seller_id = $_POST['view_seller_modal'];
//    $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username', r.district 'district1', r.taluk 'taluk',  r.phone 'phone', st.qnt 'qnt', st.rate 'rate', st.cdate 'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='0'  and  st.id = '$seller_id'";
    $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username', r.phone 'phone',r.taluk 'taluk1', r.district 'district1',st.qnt 'qnt', st.rate 'rate',date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st LEFT JOIN  sb_category c ON c.id=st.cid LEFT JOIN sb_productname p ON p.id=st.pid and c.id=p.cid LEFT JOIN registration r ON r.id=st.userid   where  st.isdelete='0' and st.isverfiy='0' and st.id = '$seller_id' ";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $image = explode(',', $row['imageurl']);
        ?>
        <em class="text-success">பெயர்: </em><?php echo $row['name']; ?>, <em class="text-success">தொலைப்பேசி: </em> <?php echo $row['mobile']; ?>, <em class="text-success">வட்டம்: </em> <?php echo $row['taluk']; ?> , <em class="text-success">மாவட்டம்: </em><?php echo $row['district']; ?>@@##QWerty@@##
        <tr>
            <td><span class="text-info">வகை: </span> <?php echo $row['catgory']; ?></td>
            <td><span class="text-info">பொருள் பெயர்: </span><?php echo $row['product']; ?></td>
        </tr>
        <tr>
            <td><span class="text-info">அளவு:  </span><?php echo $row['qnt']; ?></td>
            <td><span class="text-info">விலை: </span><?php echo $row['rate']; ?></td>
        </tr>
        <tr>
            <td><span class="text-info">தொலைப்பேசி:  </span><?php echo $row['mobile']; ?></td>
            <td><span class="text-info">கிடைக்கும் இடம்: </span><?php echo $row['place']; ?></td>
        </td>
        </tr>
        <tr>
            <td><span class="text-info">வட்டம்:</span> <?php echo $row['taluk']; ?></td>
            <td><span class="text-info">மாவட்டம்:</span><?php echo $row['district']; ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="text-info">இதர விபரங்கள்:</span><?php echo $row['details']; ?></td>
        </tr>
        <tr>
            <td rowspan="6" colspan="3">        <?php
                foreach ($image as $value1) {
                    ?>
                    <a href="<?php echo $value1; ?>" target="_blank"><img class="mySlides" alt="No images" src="<?php echo $value1; ?>" width="100px"></a><?php
                }
                ?></td>
        </tr>
        <?php
    }
    echo $seller_id;
    exit;
}

$getcateid = "";
if (isset($_GET['cateid'])) {
    $getcateid = $_GET['cateid'];
}
if (isset($_GET['dates'])) {
    $filter = $_GET['dates'];
    $dates = explode("a", $filter);
// print_r($dates);
    $date1 = date('Y-m-d', strtotime($dates[0]));
    $date2 = date('Y-m-d', strtotime($dates[1]));
    $getcateid = $dates[2];
    ?> 
    <section class="style-default-bright" id="allvalue">
        <div class="table-responsive">
            <table id="datatable1" class="table table-hover">
                <thead>
                    <tr>
                        <th >வ எண்</th>
                        <th>Action</th>
                        <th >பொருள் வகை மற்றும் பெயர்</th>
                        <th  >பொருள்_விபரம்</th>
                        <th>விற்பவர்_விபரம்</th>
                        <th >புகைப்படம்</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 1;
                    if (empty($getcateid)) {
//                        $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate', st.cdate 'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='0'  and (date(st.cdate) BETWEEN '$date1' AND '$date2') ";
                        $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate', date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name',p.`isverfy` FROM  seller_table st LEFT JOIN  sb_category c ON c.id=st.cid LEFT JOIN sb_productname p ON p.id=st.pid and c.id=p.cid LEFT JOIN registration r ON r.id=st.userid   where  (st.isdelete='0' and st.isverfiy='0' and (date(st.cdate) BETWEEN '$date1' AND '$date2') ) ";
                    } else {
                        // $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate', st.cdate 'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='0'  and (date(st.cdate) BETWEEN '$date1' AND '$date2') and st.cid='$getcateid'";
                        $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate',date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name',p.`isverfy` FROM  seller_table st LEFT JOIN  sb_category c ON c.id=st.cid LEFT JOIN sb_productname p ON p.id=st.pid and c.id=p.cid LEFT JOIN registration r ON r.id=st.userid   where  (st.isdelete='0' and st.isverfiy='0' and (date(st.cdate) BETWEEN '$date1' AND '$date2') and st.cid='$getcateid')";
                    }
                    $result = mysqli_query($mysqli, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = explode(',', $row['imageurl']);
                        ?>
                        <tr>           
                            <td><?php echo $s; ?></td>
                            <td>
                                <?php if ($role == "admin") { ?>
                                    <?php if ($row['isverfy'] == 1) { ?><a href="seller_view.php?pid=<?php echo $row['sid']; ?>&proid=<?php echo $row['pid'] ?>&phone=<?php echo $row['mobile']; ?>"><button type="button" onClick="return confirm('Are you Sure verfiy This Product')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="verfiy"><i class="md md-done"></i></button></a>
                                                        <?php } else { ?><a href="sel_buy_cate.php"><button type="button" onClick="return confirm('இந்த பொருளின் பெயர் இன்னும் சரிபார்க்காமல் உள்ளது , சரிபார்க்கவா?')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="verfiy"><i class="md md-done"></i></button></a><?php } ?>
                                    <a   target="_blank"  href="seller_add.php?edit=<?php echo $row['sid']; ?>"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="buttom" data-original-title="Edit values"><i class="md md-create"></i></button></a>
                                    <a href="seller_view.php?delete=<?php echo $row['sid']; ?>"><button type="button" onClick="return confirm('Are you Sure Delete This Product')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button></a>  <?php } ?>
                                <button type="button" class="btn  btn-accent-bright date_seller_view" data-toggle="tooltip" data-placement="top" value="<?php echo $row['sid']; ?>"  data-original-title="View"><i class="md md-visibility"></i></button>
                            </td>
                            <td class="text-center ">வகை :<?php echo $row['catgory']; ?><br><div class="test-bold text-success text-bold">பொருள்: <?php echo $row['product']; ?></div>
                                <div >தேதி :<?php echo $row['adddate']; ?></div></td>                                         
                            <td><div class="text-sucess">விலை :<?php echo $row['rate']; ?> Rs</div>
                                <div class="text-primary">அளவு :<?php echo $row['qnt']; ?></div></td>
                            <td><?php echo $row['name'] . '<br>' . $row['district'] . ', ' . $row['taluk'] . ',<br>' . $row['mobile']; ?></td>
                            <td> <img src="<?php echo $image[0]; ?>" width="60px"></td>

                        </tr>                                  
                        <?php
                        $s++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).on('click', '.date_seller_view', function (e) {
                var seller_id = $(this).val();
                $.post("seller_view.php",
                        {
                            view_seller_modal: seller_id
                        },
                        function (data, status) {
                            var date_span_modal = data.split('@@##QWerty@@##');
                            $("#seler_detail").html(date_span_modal[0]);
                            $("#View_details").html(date_span_modal[1]);
                            $('#seller_model_openid').modal('show');
                            $("#edit_values").attr("href", "seller_add.php?edit=" + seller_id);
                        });
            });
        </script>
    </section>
    <?php
    exit;
}
?>
<!DOCTYPE html/>
<html lang="en">
    <head>
        <title>NITHRA | மகளிர் மட்டும்</title>
        <link rel="shortcut icon" type="image/png" href="<?php echo $prefix; ?>assets/img/144.png"/>
        <script src='http://lovasoa.github.io/tidy-html5/tidy.js'></script>
        <?php include_once $prefix . 'include/headtag.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style>
            .scroll123{
                height:300px;
                overflow-y: scroll;
            }
            .height-1 {
                height:auto;
                overflow-y: auto;
            }
        h3.text-bold{
            color : #f10a41;
        }
        #demo-date-range1, span.input-group-addon, #demo-date-range2 { 
            display: inline-block; 
            }
        </style>
    </head>
    <body class="menubar-hoverable header-fixed ">
        <?php include_once $prefix . 'include/header.php'; ?>
        <div id="base">
            <div class="offcanvas">
            </div>
            <!-- BEGIN CONTENT-->
            <div id="content">
                <div  class="card " >
                    <div class="card-header ">
                        <h3 class="text-center text-bold text-sucess">சரிபார்க்காத விற்பவர் விபரங்கள்</h3>
                    </div>
                    <div class="card-body">
                        <div class = "row " >
                            <div class = "col-xs-offset-2 col-sm-5 form-group ">
                                <div class="input-daterange input-group" id="demo-date-range1">
                                    <div class="input-group-content">
                                        <input type="text" class="form-control text-bold" value="<?php echo $startdate; ?>" id="date1" name="start">
                                        <label>முதல்</label>
                                    </div>
                                    </div>
                                    <span class="input-group-addon">to</span>
                                    <div class="input-daterange input-group" id="demo-date-range2">
                                    <div class="input-group-content">
                                        <input type="text" class="form-control text-bold" value="<?php echo date('d-m-Y'); ?>" id="date2"  name="end">
                                        <label>வரை</label>
                                        <div class="form-control-line"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 form-group ">
                                <script type = "text/javascript">
            $(document).ready(function () {
                $(".js-example-basic-single").select2();
            });
                                </script>  
                                <select name="category" id="category"  class="form-control js-example-basic-single text-bold" placeholder="பொருள் வகையை தேர்வு செய்க" required="">
                                    <option value="">&nbsp;</option>
                                    <option value="">&nbsp;</option>
                                    <?php
                                    $sql = "select * from sb_category ORDER BY id DESC";
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['id'] ?>"<?php
                                        if (isset($cid)) {
                                            echo ($cid == $row['id']) ? "selected" : "";
                                        };
                                        ?>><?php echo $row['cname']; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                            <button type="button" id="date_selection"  class="btn ink-reaction"><i class="md md-search"></i></button>
                        </div>
                        <div id='loadingmessage' style='display:none'>
                        <center><img src='../assets/img/712.gif' width="100px"/></center>
                    </div>  
                    </div>
                    <!-- END CONTENT -->
                    <div id='loadingmessage' style='display:none'>
                            <center> <img src="../assets/img/712.gif"/></center>
                        </div>
                    <!-- BEGIN MENUBAR-->
                    <div id="viewdiv">
                        <section class="style-default-bright" id="allvalue">
                            <div class="table-responsive">                     
                                <table id="datatable1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th >வ எண்</th>
                                            <th>Action</th>
                                            <th >பொருள் வகை மற்றும் பெயர்</th>
                                            <th  >பொருள்_விபரம்</th>
                                            <th>விற்பவர்_விபரம்</th>
                                            <th >புகைப்படம்</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $s = 1;
                                        $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate',date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  'adddate', st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name',p.`isverfy` FROM  seller_table st LEFT JOIN  sb_category c ON c.id=st.cid LEFT JOIN sb_productname p ON p.id=st.pid and c.id=p.cid LEFT JOIN registration r ON r.id=st.userid   where  (st.isdelete='0' and st.isverfiy='0')";
                                        $result = mysqli_query($mysqli, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $image = explode(',', $row['imageurl']);
                                            $Details = mb_substr(wordwrap($row['details'], 120, "<br>\n"), 0, 50) . '.......';
                                            ?>
                                            <tr>           
                                                <td><?php echo $s; ?></td>
                                                <td>
                                                    <?php if ($role == "admin") { ?>
                                                        <?php if ($row['isverfy'] == 1) { ?><a href="seller_view.php?pid=<?php echo $row['sid']; ?>&proid=<?php echo $row['pid'] ?>&phone=<?php echo $row['mobile']; ?>"><button type="button" onClick="return confirm('Are you Sure verfiy This Product')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="verfiy"><i class="md md-done"></i></button></a>
                                                        <?php } else { ?><a href="sel_buy_cate.php"><button type="button" onClick="return confirm('இந்த பொருளின் பெயர் இன்னும் சரிபார்க்காமல் உள்ளது , சரிபார்க்கவா?')" class="btn ink-reaction btn-success" data-toggle="tooltip" data-placement="top" data-original-title="verfiy"><i class="md md-done"></i></button></a><?php } ?>
                                                        <a   target="_blank"   href="seller_add.php?edit=<?php echo $row['sid']; ?>"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="buttom" data-original-title="Edit values"><i class="md md-create"></i></button></a>
                                                        <a href="seller_view.php?delete=<?php echo $row['sid']; ?>"><button type="button" onClick="return confirm('Are you Sure Delete This Product')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button></a>  <?php } ?>
                                                    <button type="button" class="btn  btn-accent-bright date_seller_view" data-toggle="tooltip" data-placement="top" value="<?php echo $row['sid']; ?>"  data-original-title="View"><i class="md md-visibility"></i></button>
                                                </td>
                                                <td class="text-center ">வகை :<?php echo $row['catgory']; ?><br><div class="test-bold text-success text-bold">பொருள்: <?php
                                                        if ($row['pid'] != 0) {
                                                            echo $row['product'];
                                                        } else {
                                                            echo "பொருளைதேர்வு செய்க";
                                                        }
                                                        ?></div>
                                                    <div >தேதி :<?php echo$row['adddate']; ?></div></td>                                         <td><div class="text-sucess">விலை :<?php echo $row['rate']; ?> Rs</div>
                                                    <div class="text-primary">அளவு :<?php echo $row['qnt']; ?></div></td>

                                                <td><?php echo $row['name'] . '<br>' . $row['district'] . ', ' . $row['taluk'] . ',<br>' . $row['mobile']; ?></td>
                                                <td> <img src="<?php echo $image[0]; ?>" width="60px"></td>
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

                    <div  class=" modal fade align-center" id="seller_model_openid" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="simpleModalLabel">Edit This Product</h4>
                                </div>
                                <div class="modal-header align-center" >
                                    <div id="viedetails" >
                                        <div class="card">
                                            <div class="card-body style-warning height-1">விற்பவர் விபரம்</div>                                                        
                                            <div class="card-body text-lg small-padding text-bold"  id="seler_detail" >
                                            </div>
                                        </div>
                                        <div class="card-body style-info height-1">பொருள் விபரம்</div> 
                                        <div class="table-responsive scroll123"  >
                                            <table broder="1" class="table table-hover" >
                                                <tbody   id="View_details">
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
                                        <a target="_blank"  href="seller_add.php"  id="edit_values"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="buttom" data-original-title="Edit values">Edit Values</button></a>
                                    </div>     
                                </div>

                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div></div>

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
            Command: toastr["success"]("Product Update Sucesssfully", "Sucesss")
<?php } elseif ($msg == '3') {
    ?>
            Command: toastr["success"]("Product Deleted Sucesssfully", "success")
<?php } elseif ($msg == '4') {
    ?>
            Command: toastr["success"]("Product Verfiy Sucesssfully ", "Success")
    <?php
} elseif ($msg == '5') {
    ?>
            Command: toastr["error"]("முதலில் பொருளை சரிபார்க்கவும்", "தவறு")
<?php } elseif ($msg == '6') {
    ?>
            Command: toastr["error"]("முதலில் பொருளை தேர்வு செய்யவும்", "தவறு")
<?php }
?>
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.date_seller_view', function (e) {
        var seller_id = $(this).val();
        $('#loadingmessage').show();
        $.post("seller_view.php",
                {
                    view_seller_modal: seller_id
                },
                function (data, status) {
                    var date_span_modal = data.split('@@##QWerty@@##');
                    $("#seler_detail").html(date_span_modal[0]);
                    $("#View_details").html(date_span_modal[1]);
                    $('#seller_model_openid').modal('show');
                    $("#edit_values").attr("href", "seller_add.php?edit=" + seller_id);
                    $('#loadingmessage').hide();
                });
    });
    $(document).ready(function () {
        $('#demo-date-range1').datepicker({todayHighlight: true, format: "dd-mm-yyyy"});
        $('#demo-date-range2').datepicker({todayHighlight: true, format: "dd-mm-yyyy"});
        $('#date_selection').on("click", function (e) {
            var D1 = $("#date1").val();
            var D2 = $("#date2").val();
            $('#loadingmessage').show();
            var category = $("#category").val();
            if ((new Date(D1).getTime()) <= (new Date(D2).getTime())) {
                var dates = "seller_view.php?dates=" + D1 + 'a' + D2 + 'a' + category;
                $.get(dates, function (data, status) {
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
            } else {
                alert('wrong date selection!');
            }
        });
    });
    $(document).on('change', '#filter', function (e) {
        var category = $(this).val();
        $('#loadingmessage').show();
        $.post("seller_view.php",
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




</script>
</body>
</html>