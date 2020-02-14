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

$region = $id = $msg = $buyer = $region1 = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from `buyer` where id='$id'";
    echo $sql;
    exit;
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
//            $region1 = $row['region'];
//            $section = $row['section'];
    }
}

if (isset($_POST['buyer'])) {
    $tabregselect = $_POST['buyer'];
    if ($tabregselect == 'all') {
        $tabregselect = 1;
    } else {
//                $tabregselect = 'a.region='.$tabregselect;
    }
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>     
                <!--<th>Gender</th>-->
                <th>Date</th>     
    <!--                <th>Cow Type</th>
                <th>Breed Type</th>     
                <th>Mornig Milk </th>
                <th>Evening Milk</th>     
                <th>Father</th>
                <th>Mother</th>
                <th>Age</th>
                <th>Teeth</th>-->
                <th>Product</th> 
                <th>Amount</th> 
                <th>Phoneno</th> 
                <th>Remark</th> 
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            $sql = "SELECT* FROM `buyer` ORDER BY id DESC";
            $result = mysqli_query(mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="cc.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                    </td>
                    <td><?php echo $row['name']; ?></td>
                     <!--<td><?php echo $row['gender']; ?></td>-->
                    <td><?php echo $row['date']; ?></td>
        <!--                    <td><?php echo $row['cowtype']; ?></td>
                    <td><?php echo $row['breedtype']; ?></td>
                    <td><?php echo $row['ml']; ?></td>
                    <td><?php echo $row['el']; ?></td>
                    <td><?php echo $row['sold']; ?></td>
                    <td><?php echo $row['father']; ?></td>
                    <td><?php echo $row['mother']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['teeth']; ?></td>-->
                    <td><?php echo $row['product']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
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

if (isset($_POST['buyer'])) {
    $tabsec = $_POST['buyer'];
    ?>
    <div class="col-sm-4">        
        <select id="buyer" class="form-control" tabindex="1" name="section">
            <option value="all">Please select Circle/மின் பகிர்மான வட்டம்</option>
            <?php if ($tabsec != 'all') { ?>
                <option value="all">--View all--</option>
            <?php } ?>
            <?php
            $sql = "SELECT * FROM `section` WHERE `region` = '$tabsec' ";
            $res = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $sid = $row['id'];
                $section = $row['section'];
                ?>                                                   
                <option value="<?php echo $sid; ?>"<?php
                if ($section == $sid) {
                    echo "selected";
                }
                ?>><?php echo $section; ?></option>  
                    <?php } ?>
        </select>
    </div>

    <?php
    exit;
}

if (isset($_POST['sect_select']) && isset($_POST['regtab_select'])) {
    $sectselect = $_POST['sect_select'];
    $regtabselect = $_POST['regtab_select'];
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>     
                <!--<th>Gender</th>-->
                <th>Date</th>     
    <!--                <th>Cow Type</th>
                <th>Breed Type</th>     
                <th>Mornig Milk </th>
                <th>Evening Milk</th>     
                <th>Father</th>
                <th>Mother</th>
                <th>Age</th>
                <th>Teeth</th>-->
                <th>Product</th> 
                <th>Amount</th> 
                <th>Phoneno</th> 
                <th>Remark</th> 
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            if ($sectselect == 'all') {
                $regtabselect = 'a.region=' . $regtabselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $regtabselect ORDER BY a.id asc";
            } else {
                $sectselect = 'a.section=' . $sectselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $sectselect ORDER BY a.id asc";
            }
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="cc.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                    </td>
                    <td><?php echo $row['name']; ?></td>
                   <!--<td><?php echo $row['gender']; ?></td>-->
                    <td><?php echo $row['date']; ?></td>
        <!--                    <td><?php echo $row['cowtype']; ?></td>
                    <td><?php echo $row['breedtype']; ?></td>
                    <td><?php echo $row['ml']; ?></td>
                    <td><?php echo $row['el']; ?></td>
                    <td><?php echo $row['sold']; ?></td>
                    <td><?php echo $row['father']; ?></td>
                    <td><?php echo $row['mother']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['teeth']; ?></td>-->
                    <td><?php echo $row['product']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
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



if (isset($_POST['tabsect_select'])) {
    $tabdist = $_POST['tabsect_select'];
    ?>
    <div class="col-sm-4">        
        <select id="tab_dist_select" class="form-control" tabindex="1" name="section">
            <option value="all">Please select Division / கோட்டம்</option>
            <?php if ($tabdist != 'all') { ?>
                <option value="all">--View all--</option>
            <?php } ?>
            <?php
            $sql = "SELECT * FROM `distribution` WHERE `section` = '$tabdist' ";
            $res = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $did = $row['distid'];
                $distribution = $row['distribution'];
                ?>                                                   
                <option value="<?php echo $did; ?>"<?php
                if ($distribution == $did) {
                    echo "selected";
                }
                ?>><?php echo $distribution; ?></option>  
                    <?php } ?>
        </select>
    </div>

    <?php
    exit;
}

if (isset($_POST['disttab_select']) && isset($_POST['secttab_select']) && isset($_POST['regtab1_select'])) {
    $distselect = $_POST['disttab_select'];
    $sectselect = $_POST['secttab_select'];
    $regselect = $_POST['regtab1_select'];
    ?>
    <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>     
                <!--<th>Gender</th>-->
                <th>Date</th>     
    <!--                <th>Cow Type</th>
                <th>Breed Type</th>     
                <th>Mornig Milk </th>
                <th>Evening Milk</th>     
                <th>Father</th>
                <th>Mother</th>
                <th>Age</th>
                <th>Teeth</th>-->
                <th>Product</th> 
                <th>Amount</th> 
                <th>Phoneno</th> 
                <th>Remark</th> 
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
            if ($distselect == 'all') {
                $sectselect = 'a.section=' . $sectselect;
                $sql = "SELECT * FROM `cowreg` ";
            } else {
                $distselect = 'a.distribution=' . $distselect;
                $sql = "SELECT * FROM `cowreg` ";
            }
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                ?>
                <tr  id="<?php echo $row['id']; ?>"  >
                    <td><?php echo $i; ?></td>
                    <td class="text-left">   
                        <a href="cc.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                        <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                    </td>
                    <td><?php echo $row['name']; ?></td>
                   <!--<td><?php echo $row['gender']; ?></td>-->
                    <td><?php echo $row['date']; ?></td>
        <!--                    <td><?php echo $row['cowtype']; ?></td>
                    <td><?php echo $row['breedtype']; ?></td>
                    <td><?php echo $row['ml']; ?></td>
                    <td><?php echo $row['el']; ?></td>
                    <td><?php echo $row['sold']; ?></td>
                    <td><?php echo $row['father']; ?></td>
                    <td><?php echo $row['mother']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['teeth']; ?></td>-->
                    <td><?php echo $row['product']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
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
        <title>Milk Management- Login</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/144.png"/>
        <?php include_once 'include/headtag.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>     
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- BEGIN HEADER-->
        <?php include_once 'include/header.php'; ?>
        <!-- END HEADER-->
        <!-- END BASE -->


        <div id="base">
            <div class="offcanvas">  </div>
            <div id="content">
                <section>
                    <div class="section-body contain-lg">
                        <div class="row"><!--end .col -->
                            <div class=" col-md-12 col-sm-12">
                                <!--<h2 class="text-primary">Please Fill the Details</h2>-->
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Buyer DETAILS</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                            <div class="row">
                                                <div class="col-sm-4 form-group ">
                                                    <select name="breedtype" id="breedtype" tabindex="1" class="form-control js-example-basic-single"  required="">
                                                        <option value="all">Please Slect BreedType</option>
                                                        <option value="all">View All</option>
                                                        <?php
                                                        $sql = "select * from breedtype ORDER BY id DESC";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>"<?php
                                                            if (isset($cid)) {
                                                                echo ($cid == $row['id']) ? "selected" : "";
                                                            };
                                                            ?>><?php echo $row['breedtype']; ?></option>
                                                                <?php } ?>
                                                    </select>                                                
                                                </div>                                       
                                                <div id="tabgetsection">   
                                                    <div class="col-sm-4 form-group "> 
                                                        <select name="cowtype" id="cowtype" tabindex="1" class="form-control js-example-basic-single"  required="">
                                                            <option value="all">Please Select Cow Type</option>
                                                            <option value="all">View All</option>
                                                            <?php
                                                            $sql = "select * from cowtype ORDER BY id DESC";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if (isset($cid)) {
                                                                    echo ($cid == $row['id']) ? "selected" : "";
                                                                };
                                                                ?>><?php echo $row['cowtype']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        </select>                                                                                                                                                              
                                                    </div>
                                                </div>
                                                <div id="tabgetdistribution">   
                                                    <div class="col-sm-4 form-group "> 
                                                        <select id="select1" class="form-control" name="name" tabindex="1" required>
                                                            <option value="all">Please select Cow Name</option>                                                       
                                                            <?php
                                                            $sql = "select * from cowreg ORDER BY id DESC";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>"<?php
                                                                if (isset($cid)) {
                                                                    echo ($cid == $row['id']) ? "selected" : "";
                                                                };
                                                                ?>><?php echo $row['name']; ?></option>
                                                                    <?php } ?>
                                                        </select>                                                                                                                                                              
                                                    </div>
                                                </div>                                                                        
                                                <div id="regwise_select" class="tbgetsect">
                                                    <table id="datatable1" class="table diagnosis_list">
                                                        <thead>
                                                            <tr>                                    
                                                                <th>SlNo</th>
                                                                <th>Actions</th>
                                                                <th>Name</th>     
                                                                <!--<th>Gender</th>-->
                                                                <th>Date</th>     
                                                <!--                <th>Cow Type</th>
                                                                <th>Breed Type</th>     
                                                                <th>Mornig Milk </th>
                                                                <th>Evening Milk</th>     
                                                                <th>Father</th>
                                                                <th>Mother</th>
                                                                <th>Age</th>
                                                                <th>Teeth</th>-->
                                                                <th>Product</th> 
                                                                <th>Amount</th> 
                                                                <th>Phoneno</th> 
                                                                <th>Remark</th>                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody class="ui-sortable" >
                                                            <?php
                                                            $i = 1;
                                                            $sql = "select * from cowreg ORDER BY a.id asc";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id = $row['id'];
                                                                ?>
                                                                <tr  id="<?php echo $row['id']; ?>"  >
                                                                    <td><?php echo $i; ?></td>
                                                                    <td class="text-left">   
                                                                        <a href="cc.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                        <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                                                                    </td>
                                                                    <td><?php echo $row['name']; ?></td>
                    <!--<td><?php echo $row['gender']; ?></td>-->
                                                                    <td><?php echo $row['date']; ?></td>
                                                        <!--                    <td><?php echo $row['cowtype']; ?></td>
                                                                    <td><?php echo $row['breedtype']; ?></td>
                                                                    <td><?php echo $row['ml']; ?></td>
                                                                    <td><?php echo $row['el']; ?></td>
                                                                    <td><?php echo $row['sold']; ?></td>
                                                                    <td><?php echo $row['father']; ?></td>
                                                                    <td><?php echo $row['mother']; ?></td>
                                                                    <td><?php echo $row['age']; ?></td>
                                                                    <td><?php echo $row['teeth']; ?></td>-->
                                                                    <td><?php echo $row['product']; ?></td>
                                                                    <td><?php echo $row['amount']; ?></td>
                                                                    <td><?php echo $row['phoneno']; ?></td>
                                                                    <td><?php echo $row['remark']; ?></td>
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
                        </div>

                </section>
            </div>
        </div>
        <?php include_once 'include/menubar.php'; ?>
        <?php include_once 'include/jsfiles.php'; ?>
        <script>
            $(document).on('change', '#tab_reg_select', function (e) {
                var reg = $(this).val();
                $.post("cc.php",
                        {
                            tab_reg_select: reg,
                        },
                        function (data, status) {
                            $("#regwise_select").html(data);
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
                $.post("viewreport.php",
                        {
                            tabsection_select: reg,
                        },
                        function (data, status) {
                            $("#tabgetsection").html(data);
                        });
            });
            $(document).on('change', '#tab_sect_select', function (e) {
                var sect = $(this).val();
                var reg = $('#tab_reg_select').val();
                $.post("viewreport.php",
                        {
                            sect_select: sect,
                            regtab_select: reg,
                        },
                        function (data, status) {
                            $(".tbgetsect").html(data);
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
                $.post("viewreport.php",
                        {
                            tabsect_select: sect,
                        },
                        function (data, status) {
                            $("#tabgetdistribution").html(data);
                        });
            });

            $(document).on('change', '#tab_dist_select', function (e) {
                var dist = $(this).val();
                var sect = $('#tab_sect_select').val();
                var reg = $('#tab_reg_select').val();
                //alert(dist);
                $.post("viewreport.php",
                        {
                            disttab_select: dist,
                            secttab_select: sect,
                            regtab1_select: reg,
                        },
                        function (data, status) {
                            $(".tbgetsect").html(data);
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

            });
        </script>     
    </body>
</html>
