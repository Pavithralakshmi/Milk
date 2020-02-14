<?php
    session_start();
    setcookie("mm_admin",FALSE,-1,"/");
    unset($_COOKIE["mm_admin"]);
    session_destroy();
    header("Location: index.php");
    ?>