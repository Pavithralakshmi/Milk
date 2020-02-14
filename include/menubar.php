<?php
$ugroup = $_SESSION['name'];
$foldername = 'dashboard';
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/Milk/', '', $url);
include_once $prefix . 'db.php';
?>
<div id="menubar" class="menubar-inverse ">
    <div class="menubar-fixed-panel">
        <div>
            <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
    <div class="menubar-scroll-panel"  style="background-color:#0aa89e;">

        <ul id="main-menu" class="gui-controls">
            <?php
            $sql = "SELECT * FROM `usergroup` WHERE `name` ='$ugroup'";
            $res = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $name = $row['name'];
                $accper = $row['access_per'];
            }
            $sql1 = "SELECT * FROM `usermodules` WHERE parent = '0' AND status = '0' AND  `id` IN ($accper) ORDER BY `position` asc ";
            $res1 = mysqli_query($mysqli, $sql1);
//             echo $sql1;
            while ($row1 = mysqli_fetch_assoc($res1)) {
                $mname = $row1['mname'];
                $id = $row1['id'];
                $sql2 = "SELECT * FROM `usermodules` WHERE parent != '0' AND status = '0'  AND parent='$id' AND `id` IN ($accper) ORDER BY `position` asc ";
                $res2 = mysqli_query($mysqli, $sql2);
                $number = mysqli_num_rows($res2);
                //echo $sql2;
                ?>

                <li class="gui-folder <?php
                if (strpos($url, $row1['url']) !== false) {
                    echo ' active expanded';
                }
                ?>">
                    <a <?php
                    if ($number < 1) {
                        echo "href=" . str_repeat("../", $folder_depth - 2) . $row1['url'];
                    }
                    ?> >
                            <div class="gui-icon"style="background-color:black;"><i class="md <?php echo $row1['icons']; ?>"></i></div>
                        <span class="title" style="color:white;font-size: 40;"><?php echo $mname; ?></span>
                    </a>
                    <ul>
                        <?php
                        while ($row2 = mysqli_fetch_assoc($res2)) {
                            $date30 = new DateTime(date('Y-m-d'));
                            $date30->modify('-29 day');
                            $last30 = $date30->format('Y-m-d');
                            $cdate = new DateTime($row2['cdate']);
                            $cdate = $cdate->format('Y-m-d');
                            ?>
                            <li 
                            <?php
                            if ($row2['submenu'] == '1') {
                                echo 'class="gui-folder"';
                            }
                            ?>><a href="<?php
                                    if ($row2['submenu'] == '0') {
                                        echo str_repeat("../", $folder_depth - 2) . $row2['url'];
                                    } else {
                                        echo "javascript:void(0);";
                                    }
                                    
                                    ?>" >
                                    <span class="title" id="flag" style="white-space: normal;color:white;text:shadow;">
                                        <?php
                                        echo $row2['mname'];
                                         if ($row2['cdate'] >= $last30 && $row2['submenu'] == 0 && $row2['parent'] != 0) {
                                            ?>
                                            <span class="badge flag-yellow" style="color : red;background-color: yellow;text-shadow: none;position: relative;"><?php echo "New"; ?></span>
                                        <?php }
                                        ?> 
                                    </span>
                                </a>
                                <?php
                                if ($row2['submenu'] == '1') {
                                    ?>
                                    <ul>
                                        <?php
                                        $sql4 = "SELECT * FROM `usermodules` WHERE parent='$row2[id]' AND status = '0'  AND `id` IN ($accper) ORDER BY `position` asc ";
//                                        echo $sql4;
                                        $res4 = mysqli_query($mysqli, $sql4);
                                        while ($row4 = mysqli_fetch_assoc($res4)) {
                                            $mname4 = $row4['mname'];
                                            ?>
                                        <li><a href="<?php echo str_repeat("../", $folder_depth - 2) . $row4['url']; ?>"><span class="title" ><?php echo $mname4; ?></span></a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                }
                                ?>                                
                            </li>
                            <?php //echo $folder_depth;     ?>
    <?php } ?>
                    </ul>
                </li>
<?php } ?>
        </ul>
        <div class="menubar-foot-panel">
            <small class="no-linebreak hidden-folded">
                <span class="opacity-75" style="color:white">Copyright &copy; <?php echo Date('Y'); ?></span> <strong style="color: black;">Nithra Edu Solutions</strong>
            </small>
        </div>
    </div>
</div>