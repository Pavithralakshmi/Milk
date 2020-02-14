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
$image = array();
include_once $prefix . 'db.php';
$datetime1 = date("d/m/Y h:i a");
$isexpire = "UPDATE `seller_table` SET `isexpire`='1'  WHERE  date(cdate)<=(CURRENT_DATE - INTERVAL 15 day)";
$result = mysqli_query($mysqli, $isexpire);
$date = date_create($ymd);
date_sub($date, date_interval_create_from_date_string(" 3 days"));
$startdate = date_format($date, "d-m-Y");
$username = array();
$ch = "select * from registration";
$de = mysqli_query($mysqli, $ch);
while ($data = mysqli_fetch_assoc($de)) {
    $username[$data['id']] = $data['name'];
    $userphone[$data['id']] = $data['phone'];
    $usertaluk[$data['id']] = $data['taluk'];
    $userdistri[$data['id']] = $data['district'];
}
$ch = "SELECT * FROM `sb_category`";
$de = mysqli_query($mysqli, $ch);
while ($data = mysqli_fetch_assoc($de)) {
    $catename[$data['id']] = $data['cname'];
}
$ch = "SELECT * FROM `sb_productname`";
$de = mysqli_query($mysqli, $ch);
while ($data = mysqli_fetch_assoc($de)) {
    $productname[$data['id']] = $data['pname'];
}
if (isset($_GET['delete'])) {
    $pid = $_GET['delete'];
    $sql = "UPDATE `seller_table` SET `isdelete`='1' WHERE  id='$pid'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: seller_verified.php?msg=3");
}
if (isset($_GET['repost'])) {
    $sid = $_GET['repost'];
    $re_sql = "INSERT INTO `seller_table`( `cid`, `pid`,`userid`, `name`, `details`, `qnt`, `rate`,`rateperqnt`,`discount`, `district`, `taluk`,`place`, `imgurl`, `mobile`,`isverfiy`,`oldpostid`,`log`,`cdate`,`cip`) SELECT `cid`, `pid`, `userid`,`name`,`details`,`qnt`,`rate`,`rateperqnt`,`discount`,`district`,`taluk`,`place`,`imgurl`,`mobile`,'1','$sid',CONCAT(`log`,'\n','$datetime1 அன்று மறுபதிவிட்டுள்ளீர்கள்'),'$datetime','$_SERVER[REMOTE_ADDR]' FROM `seller_table` WHERE id='$sid'";
    $result = mysqli_query($mysqli, $re_sql);
    $usql = "UPDATE `seller_table` SET `isexpire_show`='1',`isexpire`='1',mdate='$datetime', mip='$_SERVER[REMOTE_ADDR]' WHERE id='$sid'";
    $result = mysqli_query($mysqli, $usql);
    header("Location: seller_verified.php?msg=5");
}
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $sql = "UPDATE `seller_table` SET `isverfiy`='1' WHERE  id='$pid'";
    $result = mysqli_query($mysqli, $sql);
    header("Location: seller_verified.php?msg=4");
}
if (isset($_POST['view_seller_modal'])) {
    $seller_id = $_POST['view_seller_modal'];
    $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username', r.district 'district1', r.taluk 'taluk',  r.phone 'phone', st.qnt 'qnt', st.rate 'rate', date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  adddate, st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='1'  and  st.id = '$seller_id'";
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
            <td rowspan="6" colspan="3"><?php
                foreach ($image as $value1) {
                        ?>
                        <a href="<?php echo $value1; ?>" target="_blank"><img class="mySlides" alt="No images" src="<?php echo $value1; ?>" width="100px"></a><?php
                }
                ?></td>
        </tr>
        <?php
    }
    ?>

    <?php
    echo $seller_id;
    exit;
}
if (isset($_GET['dates'])) {
    $filter = $_GET['dates'];
    $dates = explode("a", $filter);
    $date1 = date('Y-m-d', strtotime($dates[0]));
    $date2 = date('Y-m-d', strtotime($dates[1]));
    $getcateid = $dates[2];
    $repost = $dates[3];
    if (empty($getcateid)) {
        $getcateid = 'and st.`isexpire_show`=0';
    } else {
        $getcateid = 'and st.`isexpire_show`=0 and st.`cid`=' . $getcateid;
    }
    if (empty($repost)) {
        $repost = 'and st.`isexpire_show`=0';
    } else {
        if ($repost == 111) {
            $repost = 'and st.`isexpire`=1 and st.`isexpire_show`=0';
        }
        if ($repost == 222) {
            $repost = 'and st.`isexpire`=0';
        }
    }
    ?>
    <section  id="allvalue" class="style-default-bright">                    
        <div class="table-responsive">
            <table id="datatable1" class="table table-hover">
                <thead>
                    <tr>
                        <th >வ எண்</th>
                        <th>Action</th>
                        <th >பொருள்_வகை_மற்றும்_பெயர்</th>
                        <th  >பொருள்_விபரம்</th>
                        <th>விற்ப்பவர்_விபரம்</th>
                        <th >புகைப்படம்</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 1;
                    $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate', st.cdate 'adddate', date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  date, st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='1'  and (date(st.cdate) BETWEEN '$date1' AND '$date2')  $getcateid $repost  ORDER BY st.id DESC ";
//                    $sql = "SELECT `id`,`cid`,`pid`,`cdate`, date(cdate) `date`, `rate`,`qnt`,`details`,`name`,`district`,`taluk`, `mobile`, `imgurl`  FROM `seller_table` where isdelete='0' and isverfiy='1' and (date(cdate) BETWEEN '$date1' AND '$date2')  $getcateid $repost ORDER by id desc ";
                    $result = mysqli_query($mysqli, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = explode(',', $row['imageurl']);
                        $date1 = date_create($row['date']);
                        $date2 = date_create($ymd);
                        $diff = date_diff($date1, $date2);
                        $datycont = $diff->format("%a");
                        $remin = 15 - $datycont;
                        $Details = mb_substr(wordwrap($row['details'], 120, "<br>\n"), 0, 50) . '.......';
                        ?>
                        <tr>           
                            <td><?php echo $s; ?></td>
                            <td>
                                <a    target="_blank"   href="seller_add.php?edit=<?php echo $row['sid']; ?>"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="buttom" data-original-title="Edit values"><i class="md md-create"></i></button></a>
                                <a href="seller_verified.php?delete=<?php echo $row['sid']; ?>"><button type="button" onClick="return confirm('Are you Sure Delete This Product')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button></a>  
                                <button type="button" class="btn  btn-accent-bright date_seller_view" data-toggle="tooltip" data-placement="top" value="<?php echo $row['sid']; ?>"  data-original-title="View"><i class="md md-visibility"></i></button>
                                <?php if ($remin <= 0) {
                                    ?>
                                    <a href="seller_verified.php?repost=<?php echo $row['sid']; ?>"><button type="button" onClick="return confirm('இந்த விபரத்தை மறுபதிவு செய்ய நீங்கள் தயாரா')"  class="btn ink-reaction btn-info" data-toggle="tooltip" data-placement="top" data-original-title="மிதமுள்ள நாட்க்கள்"><i class="md md-autorenew"></i></button></a>
                                <?php } ?>
                            </td>
                            <td class="text-center ">வகை :<?php echo $row['catgory']; ?><br><div class="test-bold text-success text-bold">பொருள்: <?php echo $row['product']; ?></div>
                                <div >தேதி :<?php echo $row['adddate']; ?></div><div >SID :<?php echo $row['sid']; ?></div></td>                                         <td><div class="text-sucess">விலை :<?php echo $row['rate']; ?> Rs</div>
                                <div class="text-primary">அளவு :<?php echo $row['qnt']; ?></div></td>
                            <td><?php echo $row['name'] . '<br>' . $row['district'] . ', ' . $row['taluk'] . ',<br>' . $row['mobile']; ?></td>
                            <td> <?php
                                foreach ($image as $value1) {
                                    if (empty($value1)) {
                                        
                                    } else {
                                        ?><img src="<?php echo $value1; ?>" width="60px"><?php
                                    }
                                }
                                ?></td>
                        </tr>                                  
                        <?php
                        $s++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
      $(document).on('click', '.date_seller_view', function (e) {
                var seller_id = $(this).val();
                $('#loadingmessage').show();
                $.post("seller_verified.php",
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
    </script>
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
                <div>
                    <div class="card" style="margin-bottom:0px">
                        <div class="card-header ">
                            <h3 class="text-center text-bold">சரிபார்க்கப்பட்ட விற்பவர் விபரங்கள்</h3></div>
                        <div class="card-body card-collapsed">
                            <div class = "row " >
                                <div class = "col-sm-5 form-group ">
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
                                <div class="col-sm-3 form-group ">
                                    <select name="repost" id="repost"  class="form-control js-example-basic-single text-bold" placeholder="மறுபதிவை பார்க்க" required="">
                                        <option value="">&nbsp;</option>
                                        <option value="">&nbsp;</option>
                                        <option value="111">மறுபதிவைபார்க்க</option>
                                        <option value="222">பதிவைபார்க்க</option>
                                    </select>
                                </div>
                                <button type="button" id="date_selection"  class="btn ink-reaction"><i class="md md-search"></i></button>
                            </div>
                            </div>
                               <div id='loadingmessage' style='display:none'>
                            <center> <img src="../assets/img/712.gif"/></center>
                        </div>
                            </div>
                </div>
              
                </section>    
               
                <!-- END CONTENT -->
                <!-- BEGIN MENUBAR-->
                <div id="viewdiv" >
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
                                    // $sql = "SELECT `id`,`cid`,`pid`,`cdate`, date(cdate) `date`, `rate`,`qnt`,`details`,`name`,`district`,`taluk`, `mobile`, `imgurl` FROM `seller_table` where isdelete='0' and isverfiy='1' and `isexpire`='0' and date(cdate)>=(CURRENT_DATE - INTERVAL 2 day) ORDER by id desc ";
                                    $sql = "SELECT st.id 'sid', st.pid 'pid', c.cname 'catgory',p.pname 'product', st.userid 'userid', r.name 'username',  st.qnt 'qnt', st.rate 'rate', date_format(`st`.`cdate`,'%d-%m-%Y  %r' ) as  adddate, date(st.cdate) `date`, st.discount 'discount', st.imgurl 'imageurl', st.district 'district', st.taluk 'taluk', st.details 'details', st.mobile 'mobile', st.place 'place' ,st.log 'log',st.name 'name' FROM  seller_table st, sb_productname p, sb_category c, registration r  where c.id=st.cid and p.id=st.pid and c.id=p.cid  and  r.id=st.userid and st.isdelete='0' and st.isverfiy='1' and st.`isexpire`='0' and date(st.cdate)>=(CURRENT_DATE - INTERVAL 15 day)  ORDER BY st.id DESC ";
//                                    echo $sql; exit;
                                    $result = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $image = explode(',', $row['imageurl']);
                                        $date1 = date_create($row['date']);
                                        $date2 = date_create($ymd);
                                        $diff = date_diff($date1, $date2);
                                        $datycont = $diff->format("%a");
                                        $remin = 15 - $datycont;
                                        ?>
                                        <tr>           
                                            <td><?php echo $s; ?></td>
                                            <td>
                                                <a    target="_blank"   href="seller_add.php?edit=<?php echo $row['sid']; ?>"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="buttom" data-original-title="Edit values"><i class="md md-create"></i></button></a>
                                                <a href="seller_verified.php?delete=<?php echo $row['sid']; ?>"><button type="button" onClick="return confirm('Are you Sure Delete This Product')" class="btn ink-reaction btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="md md-delete"></i></button></a>  
                                                <button type="button" class="btn  btn-accent-bright date_seller_view" data-toggle="tooltip" data-placement="top" value="<?php echo $row['sid']; ?>"  data-original-title="View"><i class="md md-visibility"></i></button>
                                                <?php if ($remin < 0) {
                                                    ?>
                                                    <a href="seller_verified.php?repost=<?php echo $row['sid']; ?>"><button type="button"  onClick="return confirm('இந்த விபரத்தை மறுபதிவு செய்ய நீங்கள் தயாரா')"  class="btn ink-reaction btn-info" data-toggle="tooltip" data-placement="top" data-original-title="மிதமுள்ள நாட்க்கள்"><i class="md md-autorenew"></i></button></a>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center ">வகை :<?php echo $row['catgory']; ?><br><div class="test-bold text-success text-bold">பொருள்: <?php echo$row['product']; ?></div>
                                                <div >தேதி :<?php echo $row['adddate']; ?></div><div >SID :<?php echo $row['sid']; ?></div></td>                                         <td><div class="text-sucess">விலை :<?php echo $row['rate']; ?> Rs</div>
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
                <div id="allvalue" >
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
            </div>

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
<?php } elseif ($msg == '5') {
    ?>
                Command: toastr["success"]("பொருள் மறுபதிவு செய்யப்பட்டது நன்றி", "வெற்றி")
<?php }
?>
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#demo-date-range1').datepicker({todayHighlight: true, format: "dd-mm-yyyy"});
            $('#demo-date-range2').datepicker({todayHighlight: true, format: "dd-mm-yyyy"});
            $('#date_selection').on("click", function (e) {
                var D1 = $("#date1").val();
                var D2 = $("#date2").val();
                var category = $("#category").val();
                var repost = $("#repost").val();
                   $('#loadingmessage').show();
                if ((new Date(D1).getTime()) <= (new Date(D2).getTime())) {
                    var dates = "seller_verified.php?dates=" + D1 + 'a' + D2 + 'a' + category + 'a' + repost;
                    $.get(dates, function (data, status) {
                        $("#viewdiv").html(data);
                          $('#loadingmessage').hide();
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
                    });
                } else {
                    alert('wrong date selection!');
                }
            });
        });

       $(document).on('click', '.date_seller_view', function (e) {
                var seller_id = $(this).val();
                $('#loadingmessage').show();
                $.post("seller_verified.php",
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
    </script>
</body>
</html>