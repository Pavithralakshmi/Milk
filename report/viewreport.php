<?php
$prefix = '../';
session_start();
$user=$_SESSION['user']; 
include_once $prefix.'db.php';
$location = $prefix . "login.php";
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: $location");
    exit;
}
$region = $id = $msg = $section=$region1= '';
if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
}

if (isset($_GET['id'])) {
        $id=$_GET['id'];    
        $sql = "select * from `section` where id='$id'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $region1 = $row['region'];
            $section = $row['section'];
       } 
}

if (isset($_POST['tab_reg_select'])) {
        $tabregselect = $_POST['tab_reg_select'];
        if ($tabregselect == 'all') {
                $tabregselect = 1;
        } else {
                $tabregselect = 'a.region='.$tabregselect;
        }
        ?>
       <table id="datatable1" class="table diagnosis_list">
                <thead>
                    <tr>                                    
                        <th>SlNo</th>
                        <th>Actions</th>
                        <th>Name</th>                                                  
                        <th>Region</th>
                        <th>Circle/மின் பகிர்மான வட்டம்</th>
                        <th>Division / கோட்டம்</th>
                        <th>Mobile No</th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" >
                    <?php
                    $i = 1;
                    $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $tabregselect ORDER BY a.id asc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                            $id =  $row['id'];
                            ?>
                            <tr  id="<?php echo $row['id']; ?>"  >
                                <td><?php echo $i; ?></td>
                                <td class="text-left">   
                                    <a href="../master/addform.php?id=<?php echo  $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                    <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                                </td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['rgn']; ?></td>
                                <td><?php echo $row['sctn']; ?></td>
                                <td><?php echo $row['dstn']; ?></td>
                                <td><?php echo $row['mobno']; ?></td>
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

if (isset($_POST['tabsection_select'])) {
        $tabsec = $_POST['tabsection_select'];
        ?>
          <div class="col-sm-4">        
                        <select id="tab_sect_select" class="form-control" tabindex="1" name="section">
                                <option value="all">Please select Circle/மின் பகிர்மான வட்டம்</option>
                                   <?php if($tabsec != 'all') { ?>
                                <option value="all">--View all--</option>
                                   <?php } ?>
                                 <?php
                                 $sql="SELECT * FROM `section` WHERE `region` = '$tabsec' ";
                                 $res= mysqli_query($conn, $sql);                                        
                                 while($row= mysqli_fetch_assoc($res)){
                                     $sid=$row['id'];
                                     $section=$row['section'];     

                                 ?>                                                   
                                 <option value="<?php echo $sid;?>"<?php if($section==$sid){echo "selected";}?>><?php echo $section;?></option>  
                                 <?php } ?>
                     </select>
               </div>
 
<?php
exit;

}

if (isset($_POST['sect_select']) && isset($_POST['regtab_select'])) {
        $sectselect=$_POST['sect_select'];
        $regtabselect=$_POST['regtab_select'];
        ?>
        <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>                                                  
                <th>Region</th>
                <th>Circle/மின் பகிர்மான வட்டம்</th>
                <th>Division / கோட்டம்</th>
                <th>Mobile No</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
              if ($sectselect == 'all') {
                $regtabselect = 'a.region='.$regtabselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $regtabselect ORDER BY a.id asc";            
                
              }
              else {
                $sectselect = 'a.section='.$sectselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $sectselect ORDER BY a.id asc";              
                }
                $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                    $id =  $row['id'];
                    ?>
                    <tr  id="<?php echo $row['id']; ?>"  >
                        <td><?php echo $i; ?></td>
                        <td class="text-left">   
                            <a href="../master/addform.php?id=<?php echo  $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                            <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['rgn']; ?></td>
                        <td><?php echo $row['sctn']; ?></td>
                        <td><?php echo $row['dstn']; ?></td>
                        <td><?php echo $row['mobno']; ?></td>
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
                                <?php if($tabdist != 'all') { ?>
                                <option value="all">--View all--</option>
                                <?php } ?>
                                 <?php
                                 $sql="SELECT * FROM `distribution` WHERE `section` = '$tabdist' ";                                 
                                 $res= mysqli_query($conn, $sql);                                        
                                 while($row= mysqli_fetch_assoc($res)){
                                     $did=$row['distid'];
                                     $distribution=$row['distribution'];     

                                 ?>                                                   
                                 <option value="<?php echo $did;?>"<?php if($distribution==$did){echo "selected";}?>><?php echo $distribution;?></option>  
                                 <?php } ?>
                     </select>
               </div>
 
<?php
exit;

}

if (isset($_POST['disttab_select']) && isset($_POST['secttab_select']) && isset($_POST['regtab1_select'])) {
        $distselect=$_POST['disttab_select'];
        $sectselect=$_POST['secttab_select'];
        $regselect=$_POST['regtab1_select'];       
        ?>
        <table id="datatable1" class="table diagnosis_list">
        <thead>
            <tr>                                    
                <th>SlNo</th>
                <th>Actions</th>
                <th>Name</th>                                                  
                <th>Region</th>
                <th>Circle/மின் பகிர்மான வட்டம்</th>
                <th>Division / கோட்டம் </th>
                <th>Mobile No</th>
            </tr>
        </thead>
        <tbody class="ui-sortable" >
            <?php
            $i = 1;
              if ($distselect == 'all') {                    
                $sectselect = 'a.section='.$sectselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $sectselect ORDER BY a.id asc";                                    
              }
              else {
                $distselect = 'a.distribution='.$distselect;
                $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid AND $distselect ORDER BY a.id asc";              
                }
                $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                    $id =  $row['id'];
                    ?>
                    <tr  id="<?php echo $row['id']; ?>"  >
                        <td><?php echo $i; ?></td>
                        <td class="text-left">   
                            <a href="../master/addform.php?id=<?php echo  $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                            <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['rgn']; ?></td>
                        <td><?php echo $row['sctn']; ?></td>
                        <td><?php echo $row['dstn']; ?></td>
                        <td><?php echo $row['mobno']; ?></td>
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
        <title>TNEB - View Report</title>

        <!-- BEGIN META -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="your,keywords">
        <meta name="description" content="Short explanation about this website">
        <!-- END META -->

        <!-- BEGIN STYLESHEETS -->
                   <?php include_once $prefix . 'include/css.php'; ?>
        <!-- END STYLESHEETS -->

        
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN HEADER-->
        <?php include_once $prefix . 'include/header.php'; ?>
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
                                    <h2 class="text-primary">View Details</h2>
                                    <div class="table-responsive">
                                          <div class="row">
                                            <div class="col-sm-4 form-group ">
                                                <select id="tab_reg_select" class="form-control" name="region" tabindex="1" required>
                                                    <option value="all">Please select region</option>
                                                    <option value="all">--View All--</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `region` ORDER BY `region` asc";
                                                    $res = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                            $id1 = $row['id'];
                                                            $region = $row['region'];
                                                            ?>                                                   
                                                            <option value="<?php echo $id1; ?>"<?php if ($region1 == $id1) {
                                                            echo "selected";
                                                    } ?>><?php echo $region; ?></option>  
                                                    <?php } ?>
                                                </select>                                                            
                                            </div>                                       
                                                <div id="tabgetsection">   
                                                    <div class="col-sm-4 form-group "> 
                                                       <select id="select1" class="form-control" name="section" tabindex="1" required>
                                                       <option value="all">Please select Circle/மின் பகிர்மான வட்டம்</option>                                                       
                                                        <?php
                                                        $sql="SELECT * FROM `section` where region='$rgn' ORDER BY `section` asc ";                                                                                                               
                                                        $res= mysqli_query($conn, $sql);                                        
                                                        while($row= mysqli_fetch_assoc($res)){
                                                            $sid=$row['id'];
                                                            $section=$row['section'];     
                                                         ?>                                                   
                                                        <option value="<?php echo $sid;?>"<?php if($scn==$sid){echo "selected";}?>><?php echo $section;?></option>  
                                                        <?php } ?>
                                                    </select>                                                                                                                                                              
                                                   </div>
                                            </div>
                                                <div id="tabgetdistribution">   
                                                    <div class="col-sm-4 form-group "> 
                                                       <select id="select1" class="form-control" name="section" tabindex="1" required>
                                                       <option value="all">Please select Division / கோட்டம் </option>                                                       
                                                        <?php
                                                        $sql="SELECT * FROM `section` where region='$rgn' ORDER BY `section` asc ";                                                                                                               
                                                        $res= mysqli_query($conn, $sql);                                        
                                                        while($row= mysqli_fetch_assoc($res)){
                                                            $sid=$row['id'];
                                                            $section=$row['section'];     
                                                         ?>                                                   
                                                        <option value="<?php echo $sid;?>"<?php if($scn==$sid){echo "selected";}?>><?php echo $section;?></option>  
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
                                                            <th>Region</th>
                                                            <th>Circle/மின் பகிர்மான வட்டம்</th>
                                                            <th>Division / கோட்டம் </th>
                                                            <th>Mobile No</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" >
                                                        <?php
                                                        $i = 1;
                                                        $sql = "SELECT a.`id`, a.`name`, a.`fathersname`, a.`region`, a.`section`, a.`distribution`, a.`date`, a.`k2agmntno`, a.`kitagmntno`, a.`address`, a.`mobno`, a.`whatsappno`, a.`email`, r.region as rgn,s.section as sctn,d.distribution as dstn FROM `regform` a CROSS JOIN `region` r CROSS JOIN `section` s CROSS JOIN `distribution` d where  a.region=r.id AND a.section=s.id AND a.`distribution`=d.distid ORDER BY a.id asc";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                $id =  $row['id'];
                                                                ?>
                                                                <tr  id="<?php echo $row['id']; ?>"  >
                                                                    <td><?php echo $i; ?></td>
                                                                    <td class="text-left">   
                                                                        <a href="../master/addform.php?id=<?php echo  $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                        <a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>                                          
                                                                    </td>
                                                                    <td><?php echo $row['name']; ?></td>
                                                                    <td><?php echo $row['rgn']; ?></td>
                                                                    <td><?php echo $row['sctn']; ?></td>
                                                                    <td><?php echo $row['dstn']; ?></td>
                                                                    <td><?php echo $row['mobno']; ?></td>
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
            </div><!--end #content-->
            <!-- END CONTENT -->

            <!-- BEGIN MENUBAR-->
            <?php include_once $prefix . 'include/menubar.php'; ?>
            <!-- END MENUBAR -->



        </div><!--end #base-->
        <!-- END BASE -->

        <!-- BEGIN JAVASCRIPT -->
                 <?php include_once $prefix.'include/js.php';?>
        <!-- END JAVASCRIPT -->
        <script>           
                    $(document).on('change', '#tab_reg_select', function (e) {
                                var reg = $(this).val();
                        $.post("viewreport.php",
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
                        var dist= $(this).val();   
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
