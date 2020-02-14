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
                                        <header>Buyer Details</header>
                                    </div>
                                    <div class="card-body">
                                        <form class="form  form-validate" role="form" method="POST">
                                                                                                                  
                                                <div id="regwise_select" class="tbgetsect">
                                                    <table id="datatable1" class="table diagnosis_list">
                                                        <thead>
                                                            <tr>                                    
                                                                <th>SlNo</th>
                                                                <th>Actions</th>
                                                                <th>Name</th>     
                                                                <th>Date</th>     
                                                                <th>Product</th> 
                                                                <th>Amount</th> 
                                                                 <th>Paid</th> 
                                                                  <th>Balance</th> 
                                                                <th>Phoneno</th> 
                                                                <th>Address</th>            
                                                            </tr>
                                                        </thead>
                                                        <tbody class="ui-sortable" >
                                                            <?php
                                                            $i = 1;
                                                            $sql = "select * from buyer ";
                                                            $result = mysqli_query($mysqli, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $id = $row['id'];
                                                                ?>
                                                                <tr  id="<?php echo $row['id']; ?>"  >
                                                                    <td><?php echo $i; ?></td>
                                                                    <td class="text-left">   
                                                                        <a href="buyer.php?id=<?php echo $id; ?>"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit row"><i class="fa fa-pencil"></i></button></a>
                                                                        <!--<a href="form_view.php?f_id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn ink-reaction btn-floating-action btn-info" data-toggle="modal" data-target="#modal-publish<?php echo $id; ?>" data-placement="top" data-original-title="View row"><i class="fa fa-fw fa-eye"></i></button></a>-->

                                                                        <a href="buyer.php?id=<?php echo $id; ?>&operation=delete"><button  style="margin-bottom: 3px;" type="button" class="btn ink-reaction btn-floating-action btn-danger"    data-toggle="tooltip" onclick="return confirm('Are you sure to delete?')" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash"></i></button></a>
                                          
                                                                    </td>
                                                                    <td><?php echo $row['name']; ?></td>
                                                                    <!-- <td><?php echo $row['gender']; ?></td> -->
                                                                    <td><?php echo $row['date']; ?></td>
                                                                    <td><?php echo $row['product']; ?></td>
                                                                    <td><?php echo $row['amount']; ?></td>
                                                                    <td><?php echo $row['paid']; ?></td>
                                                                    <td><?php echo $row['balance']; ?></td>
                                                                    <td><?php echo $row['phoneno']; ?></td>
                                                                    <!-- <td><?php echo $row['el']; ?></td>
                                                                    <td><?php echo $row['sold']; ?></td>
                                                                    <td><?php echo $row['father']; ?></td>
                                                                    <td><?php echo $row['mother']; ?></td>
                                                                    <td><?php echo $row['age']; ?></td>
                                                                    <td><?php echo $row['teeth']; ?></td>
                                                                     -->
                                                                     <td><?php echo $row['address']; ?></td>
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
