<?php
session_start();
$user = $_SESSION['user'];
$name = $role = $_SESSION['name'];

$prefix = "../";
$location = $prefix . "index.php";
include_once $prefix . 'db.php';
$datetime1 = date("d/m/Y h:i a");
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
$lastdate = $id = '';
$ch = "select * from registration";
$de = mysqli_query($mysqli, $ch);
while ($data = mysqli_fetch_assoc($de)) {
 $username[$data['id']] = $data['name'];
 $userphone[$data['id']] = $data['phone'];
 $userdistri[$data['id']] = $data['district'];
 $usertaluk[$data['id']] = $data['taluk'];
 $usercdate[$data['id']] = $data['cdate'];
}
$ch1 = "SELECT * FROM `district_t`";
$de1 = mysqli_query($mysqli, $ch1);
while ($data1 = mysqli_fetch_assoc($de1)) {
 $disctiid[$data1['district']] = $data1['id'];
}
$editseller = $cate = '';
if (isset($_GET['edit'])) {
 $editseller = $_GET['edit'];
 $cate = 'edit';
}
// delete single image
if (isset($_GET['imgdel'])) {
 $Imgid = $_GET['imgdel'];
 $Imgurl = $_GET['imgurl'];
 $sql = "select imgurl from seller_table where id='$Imgid'";
 $imdl = mysqli_query($mysqli, $sql);
 while ($row = mysqli_fetch_assoc($imdl)) {
  $imges = $row['imgurl'];
 }
 $imgurl1 = str_replace("$Imgurl", "", $imges);
 $imgurl1 = preg_replace('/,{2,}/', ',', trim($imgurl1, ','));
 $update = "UPDATE `seller_table` SET `imgurl`='$imgurl1' WHERE id='$Imgid'";
 $res = mysqli_query($mysqli, $update);
 header("Location: seller_add.php?edit=$Imgid");
}
// delete singe image work done
// insert seller details
if (isset($_POST['seller'])) {
 $main_folder = str_replace('\\', '/', dirname(__FILE__));
 $document_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
 $main_folder = str_replace($document_root, '', $main_folder);
 if ($main_folder) {
  $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/' . ltrim($main_folder, '/') . '/';
 } else {
  $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . rtrim($_SERVER['SERVER_NAME'], '/') . '/';
 }
 $allurl = '';
 $total = count($_FILES['images']['name']);
 $imagename = '';
 $i = 0;
 for ($j = 1; $j <= $total; $j++) {
  if (file_exists($_FILES["images"]["tmp_name"][$i])) {
   $img_array = explode('.', basename($_FILES["images"]["name"][$i]));
//               print_r($img_array);exit;
   $img_name = $img_array[0] . mt_rand(100000, 999999) . '_' . time() . '.' . $img_array[1];
   $url = $current_url . "vanka_virka_img/" . $img_name;
   $target_path = "vanka_virka_img/" . $img_name;

   @move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_path);
   $allurl .= "," . $url;
  }
//            print_r($allurl); 
  $i++;
 }
 $registation = $nithra_employer_ind;
 $category = $_POST['category'];
 $product = $_POST['product'];
 $alavu = $_POST['qnt'];
 $alavu1 = $_POST['alavu'];
 $quntity = $alavu . $alavu1;
 $discount = $_POST['discount'];
 $rate = $_POST['rate'];
 $rateperqnt = $rate . ' / 1' . $alavu1;
 $district = $_POST['district'];
 $details = $_POST['details'];
 $cells = $_POST['cells'];
 $place = $_POST['place'];
 $taluk = $_POST['taluk'];
 $sname = $_POST['sname'];
 if (empty($editseller)) {
  $allurl = preg_replace('/,{2,}/', ',', trim($allurl, ','));
//  echo $registation.$category.$discount.$place.$quntity.$rate.$district.$details.$cells.$product.$taluk.$uid; exit;
  $sql = "INSERT INTO `seller_table`( `cid`, `pid`, `userid`, `name`, `details`, `qnt`,`qnti`, `rate`,`rateperqnt`, `discount`, `district`, `taluk`,`place`,`imgurl`, `mobile`,`log`, `cdate`, `cip`, `cby`) VALUES ('$category','$product','$registation','$sname','$details','$quntity','$alavu','$rate','$rateperqnt','$discount','$district','$taluk','$place','$allurl','$cells','$datetime1 அன்று பதிவிட்டுள்ளீர்கள்','$datetime','$_SERVER[REMOTE_ADDR]','$user')";
  $result = mysqli_query($mysqli, $sql);
  header("Location: seller_view.php");
 } else {
// echo $registation.$category.$discount.$place.$quntity.$rate.$district.$details.$cells.$product.$taluk.$uid; exit;
  $ser = "select imgurl from seller_table where id='$editseller'";
  $res = mysqli_query($mysqli, $ser);
  while ($get = mysqli_fetch_assoc($res)) {
   $img = $get['imgurl'];
  }
  if (empty($img)) {
   $allurl = preg_replace('/,{2,}/', ',', trim($allurl, ','));
   $sql = "UPDATE `seller_table` SET `cid`='$category',`pid`='$product',`name`='$sname',`details`='$details',`qnt`='$quntity', `qnti`='$alavu' ,`rate`='$rate',`rateperqnt`='$rateperqnt', `discount`='$discount' ,`district`='$district',`taluk`='$taluk',`place`='$place', `imgurl`= CONCAT(imgurl,'$allurl'),  `mobile`='$cells',`mdate`= CONCAT (`mdate`,'|','$datetime'),`mip`= CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]'),`mby`= CONCAT (`mby`,'|','$user') WHERE id='$editseller'";
   $result = mysqli_query($mysqli, $sql);
   header("Location: seller_add.php?msg=4");
  } else {
   $sql = "UPDATE `seller_table` SET `cid`='$category',`pid`='$product',`name`='$sname',`details`='$details',`qnt`='$quntity',`qnti`='$alavu' ,`rate`='$rate',`rateperqnt`='$rateperqnt', `discount`='$discount' ,`district`='$district',`taluk`='$taluk',`place`='$place', `imgurl`= CONCAT(imgurl,'$allurl'),  `mobile`='$cells',`mdate`= CONCAT (`mdate`,'|','$datetime'),`mip`= CONCAT (`mip`,'|','$_SERVER[REMOTE_ADDR]'),`mby`= CONCAT (`mby`,'|','$user') WHERE id='$editseller'";
   $result = mysqli_query($mysqli, $sql);
   header("Location: seller_add.php?msg=4");
  }
 }
}
$questionid = '';
if (isset($_POST['cateid'])) {
 $getcateid = $_POST['cateid'];
 ?>
 <b> <select name="product" class="form-control" required="" >
         <option value="">பொருள் பெயர் தேர்வு செய்க</option>
         <?php
         $sql = "SELECT * FROM `sb_productname` where cid='$getcateid' ";
         $result = mysqli_query($mysqli, $sql);
         while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <option value="<?php echo $row['id'] ?>"><?php echo $row['pname'] ?></option>
         <?php } ?>
     </select></b>
 <?php
 exit;
}
if (isset($_POST['distic'])) {
 $questionid = $_POST['distic'];
 $getid1 = $disctiid[$questionid];
 ?>
 <b> <select id="taluck" onchange="taluck1()" name="taluk" class="form-control" required="" >
         <option value="">வடடத்தை தேர்வு செய்க</option>
         <?php
         $sql = "SELECT * FROM `taluk` where did='$getid1' ";
         $result = mysqli_query($mysqli, $sql);
         while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <option value="<?php echo $row['taluk'] ?>"><?php echo $row['taluk'] ?></option>
         <?php } ?>
     </select></b>
 <?php
 exit;
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
                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>விற்க்கும் பொருள் விபரம்</header>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (!empty($editseller)) {
                                         $sqle = "SELECT * FROM `seller_table` WHERE (isdelete='0' and id='$editseller')";
                                         $resule = mysqli_query($mysqli, $sqle);
                                         while ($get = mysqli_fetch_assoc($resule)) {
                                          $value = $get;
                                          $sid = $get['id'];
                                          $sname = $get['name'];
                                          $userid = $get['userid'];
                                          $cid = $get['cid'];
                                          $pid = $get['pid'];
                                          $qnd = $get['qnt'];
                                          $qnd1 = explode(' ', $qnd);
                                          $qnd2 = $qnd1[0];
                                          $qnd3 = $qnd1[1];
                                          $rate = $get['rate'];
                                          $discount = $get['discount'];
                                          $district = $disctiid[$get['district']];
                                          $taluk = $get['taluk'];
                                          $cell = $get['mobile'];
                                          $place = $get['place'];
                                          $details = $get['details'];
                                          $imgurl = $get['imgurl'];
                                          $imgurl = explode(',', $imgurl);
                                         }
                                        }
                                        ?>
                                        <div id="loading" style="display:none"><center><img src="../assets/img/712.gif"/></center></div>
                                        <form class="form" role="form"  method="post" enctype="multipart/form-data" onsubmit="$('#loading').show(), $(this).hide();">
                                            <div class="form-group floating-label">
                                                <div id="getvalue" >
                                                    <?php
                                                    if (isset($userid)) {
                                                     $sql = "select * from registration where id='$userid'";
                                                     $result = mysqli_query($mysqli, $sql);
                                                     while ($row = mysqli_fetch_assoc($result)) {
                                                      ?>
                                                      <br>
                                                      <div class="card-transparent header-fixed">
                                                          <header style="font-size:15px">
                                                              <span class="text-bold text-accent-dark">Reg Name:</span> <?php echo $username[$row['id']]; ?>,
                                                              <span class="text-bold text-info">User Id:</span> <?php echo $row['id']; ?>, 
                                                              <span class="text-bold text-success">Mobile:</span> <?php echo $userphone[$row['id']]; ?>, 
                                                          </header>
                                                      </div>
                                                      &#9759;விற்ப்பவர் பெயர்&#9759;
                                                      <input type='text' name="sname" class="form-control" value="<?php
                                                      if (isset($sname)) {
                                                       echo $sname;
                                                      }
                                                      ?>"  required>
                                                             <?php
                                                            }
                                                           } else {
                                                            $sql = "select * from registration where id='$nithra_employer_ind'";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                             ?>
                                                      <br>
                                                      <div class="card-transparent header-fixed">
                                                          <header style="font-size:15px">
                                                              <span class="text-bold text-accent-dark">Reg Name:</span> <?php echo $username[$row['id']]; ?>,
                                                              <span class="text-bold text-info">User Id:</span> <?php echo $row['id']; ?>, 
                                                              <span class="text-bold text-success">Mobile:</span> <?php echo $userphone[$row['id']]; ?>, 
                                                          </header>
                                                      </div>
                                                      &#9759;விற்ப்பவர் பெயர்&#9759;
                                                      <input type='text' name="sname" class="form-control" value="<?php
                                                      if (isset($sname)) {
                                                       echo $sname;
                                                      }
                                                      ?>"  required>
                                                             <?php
                                                            }
                                                           }
                                                           ?>
                                                </div>
                                            </div>
                                            <div class = "row">
                                                <div class = "col-sm-6 form-group floating-label">
                                                    <script type = "text/javascript">
                                                     $(document).ready(function () {
                                                         $(".js-example-basic-single").select2();
                                                     });
                                                    </script>  
                                                    <select name="category" id="category" tabindex="1" class="form-control js-example-basic-single"  required="">
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
                                                    <label for="select2">பொருளின் வகை</label>
                                                </div>
                                                <div class="col-sm-6 form-group floating-label">
                                                    <div id="getcateid">
                                                        <?php if (isset($cid)) { ?>
                                                         <select name="product" tabindex="2" class="form-control" required="" >
                                                             <option value="">பொருள் பெயர் தேர்வு செய்க</option>
                                                             <?php
                                                             $sql = "SELECT * FROM `sb_productname` where cid='$cid' ";
                                                             $result = mysqli_query($mysqli, $sql);
                                                             while ($row = mysqli_fetch_assoc($result)) {
                                                              ?>
                                                              <option value="<?php echo $row['id'] ?>"<?php
                                                              if (isset($pid)) {
                                                               echo ($pid == $row['id']) ? "selected" : "";
                                                              };
                                                              ?>><?php echo $row['pname'] ?></option>
                                                                     <?php } ?>
                                                         </select>
                                                        <?php } else { ?>
                                                         <h4>முதலில் வகையை தேர்வு சேய்க</h4>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group floating-label">
                                                    <input tabindex="3" type="number" name="qnt" value="<?php
                                                    if (isset($qnd2)) {
                                                     echo $qnd2;
                                                    }
                                                    ?>" class="form-control" required="">
                                                    <label for="help2">பொருளின் அளவு</label>
                                                </div>
                                                <div class="col-sm-6 form-group floating-label" >
                                                    <select tabindex="4" name="alavu" class="form-control js-example-basic-single" required="" id="getqnty" onChange="check()">
                                                        <option value=""></option>
                                                     <?php
                                                        $sql = "SELECT `name` FROM `unites_table`";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                         ?>
                                                         <option value=" <?php echo $row['name'] ?>"<?php
                                                         if (isset($qnd3)) {
                                                          echo ($qnd3 == $row['name']) ? "selected" : "";
                                                         };
                                                         ?>><?php echo $row['name'] ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="select2">அளவீட்டு தேர்வு செய்க</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3 form-group floating-label">
                                                    <input tabindex="5" type="number" value="<?php
                                                    if (isset($rate)) {
                                                     echo $rate;
                                                    }
                                                    ?>" name="rate"  class="form-control" required="">
                                                    <label for="help2">பொருளின் விலை</label>
                                                </div>
                                                <div class="col-sm-3 form-group floating-label">
                                                    <input tabindex="5" type="text" value="<?php
                                                    if (isset($qnd3)) {
                                                     echo '/ ' . $qnd3;
                                                    }
                                                    ?>" name="ratesym" id="rate" class="form-control" disabled>
                                                </div>
                                                <div class="col-sm-6 form-group floating-label">
                                                    <input type="text" value="<?php
                                                    if (isset($discount)) {
                                                     echo $discount;
                                                    }
                                                    ?> "   name="discount" class="form-control">
                                                    <label for="help2">தள்ளுபடி</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group floating-label">
                                                    <script type="text/javascript">
                                                     $(document).ready(function () {
                                                         $(".js-example-basic-single").select2();
                                                     });
                                                    </script>
                                                    <select tabindex="6" id="district" name="district" name="registation" class="form-control js-example-basic-single"  required="">
                                                        <option value="">&nbsp;</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `district_t`";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                         ?>
                                                         <option value="<?php echo $row['district'] ?>"<?php
                                                         if (isset($district)) {
                                                          echo ($district == $row['id']) ? "selected" : "";
                                                         };
                                                         ?>><?php echo $row['district']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                    <label for="select2">மாவட்டத்தை தேர்வு செய்க</label>
                                                </div>
                                                <div class="col-sm-6 form-group floating-label">
                                                    <div id="destirctview">
                                                        <?php if (isset($district)) { ?>
                                                         <select tabindex="7" id="taluck" onchange="taluck()" name="taluk" class="form-control" required="" >
                                                             <option value="">வடடத்தை தேர்வு செய்க</option>
                                                             <?php
                                                             $sql = "SELECT * FROM `taluk` where did='$district' ";
                                                             $result = mysqli_query($mysqli, $sql);
                                                             while ($row = mysqli_fetch_assoc($result)) {
                                                              ?>
                                                              <option value="<?php echo $row['taluk'] ?>"<?php
                                                              if (isset($taluk)) {
                                                               echo ($taluk == $row['taluk']) ? "selected" : "";
                                                              };
                                                              ?>><?php echo $row['taluk'] ?></option>
                                                                     <?php } ?>
                                                         </select>
                                                         <label for="select2">வட்டத்தை தேர்வு செய்க</label>
                                                        <?php } else { ?>
                                                         <h4>முதலில் மாவட்டத்தை தேர்வு சேய்க</h4>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group floating-label">
                                                    <input tabindex="8" type="text" value="<?php
                                                    if (isset($cell)) {
                                                     echo $cell;
                                                    }
                                                    ?>" name="cells" class="form-control" required="">
                                                    <label for="help2">தொலைப்பேசி</label>
                                                </div>
                                                <div class="col-sm-6 form-group floating-label">
                                                    <input tabindex="9" type="text" value="<?php
                                                    if (isset($place)) {
                                                     echo $place;
                                                    }
                                                    ?>" name="place" id="palce" class="form-control" required="">
                                                    <label for="help2">கிடைக்கும் இடம்</label>
                                                </div>
                                            </div>
                                            <div class="form-group floating-label">
                                                <textarea tabindex="10" name="details" id="textarea2" class="form-control" rows="3" placeholder="" required=""><?php
                                                    if (isset($details)) {
                                                     echo $details;
                                                    }
                                                    ?></textarea>
                                                <label for="textarea2">பொருள் விபரம்</label>
                                            </div>
                                            <div class="form-group floating-label">
                                                <input tabindex="11"  type="file" value="<?php echo $imgurl ?>"  accept="image/webp" name="images[]" id="gallery-photo-add" onclick="myClear()"  multiple>
                                                <label for="textarea2">புகைப்படம்</label><div class="gallery">
                                                    <?php
                                                    if (isset($imgurl)) {
                                                     foreach ($imgurl as $img) {
                                                      ?>
                                                      <a onClick="return confirm(' இந்த புகைபடத்தை நீக்க நீங்கள் உறுதியாக இருக்கிறீர்களா')" href="seller_add.php?imgdel=<?php echo $sid ?>&imgurl=<?php echo $img ?>" ><img src="<?php echo $img; ?>" width="80px"></a>
                                                      <?php
                                                     }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row text-right">
                                                    <div class="col-md-12">
                                                        <button type="submit" onClick="return confirm('இந்த விற்பனை பொருளின் விபரங்களைச் சமர்ப்பிக்க நீங்கள் உறுதியாக இருக்கிறீர்களா')" name="seller" class="btn ink-reaction btn-raised btn-primary">Save</button>
                                                        <div class="col-md-2">
                                                            <button type="reset"  class="btn ink-reaction btn-flat btn-primary">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>
                                        <?php ?>
                                    </div><!--end .card -->
                                </div><!--end .col -->
                            </div><!--end .row -->        
                        </div>  
                    </div>
                    <div class="row"><!--end .col -->
                        <div class=" col-lg-offset-2 col-md-8 col-sm-10">
                            <!--end .col -->
                        </div><!--end .row -->        
                    </div>
            </div><!--end .section-body -->
        </section>
    </div>
</div>
<?php include_once $prefix . 'include/menubar.php'; ?>
<?php include_once $prefix . 'include/jsfiles.php'; ?>
<script type="text/javascript">
 $('#select1').change(function ()
 {
     alert(this.value());
 })

 $(document).on('change', '#cross', function (e) {
     var category = $(this).val();
     $.post("seller_add.php",
             {
                 category_select: category
             },
             function (data, status) {
                 $("#ajaxdiv").html(data);
             });
 });
 $(document).on('change', '#discount', function (e) {
     var userid = $(this).val();
     $.post("seller_add.php",
             {
                 userid: userid,
             },
             function (data, status) {
                 $("#getvalue").html(data);
             });
 });
 $(document).on('change', '#category', function (e) {
     var cateid = $(this).val();
     $.post("seller_add.php",
             {
                 cateid: cateid,
             },
             function (data, status) {
                 $("#getcateid").html(data);
             });
 });
 $(document).on('change', '#district', function (e) {
     var distic = $(this).val();
     $.post("seller_add.php",
             {
                 distic: distic,
             },
             function (data, status) {
                 $("#destirctview").html(data);
             });

 });

 function check() {
     document.getElementById("rate").value = '/ 1 ' + document.getElementById("getqnty").value;
 }
 function taluck1() {
     document.getElementById("palce").value = document.getElementById("taluck").value;
 }

 $(function () {
     // Multiple images preview in browser
     var imagesPreview = function (input, placeToInsertImagePreview) {

         if (input.files) {
             var filesAmount = input.files.length;

             for (i = 0; i < filesAmount; i++) {
                 var reader = new FileReader();

                 reader.onload = function (event) {
                     $($.parseHTML('<img width="80px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                 }
                 reader.readAsDataURL(input.files[i]);
             }
         }

     };

     $('#gallery-photo-add').on('change', function () {
         imagesPreview(this, 'div.gallery');
     });
 });
</script>
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
      Command: toastr["success"]("விற்க்கும் பொருள் விபரம் சேர்க்கப்பட்டது", "வெற்றி")
<?php } elseif ($msg == '4') {
 ?>
      Command: toastr["success"]("விற்க்கும் பொருள் விபரம்  மாற்றப்பட்டது", "வெற்றி")
<?php }
?>
 });
</script>
</body>
</html>