<?php
ini_set('display_errors', 0);
$mysqli_nithra = $mysqli = new mysqli('localhost', 'root', 'root', 'milk');
$mysqli_nithra = new mysqli('localhost', 'root', 'root', 'nithrausers');
$folder_depth = substr_count($_SERVER["PHP_SELF"], "/");

if ($folder_depth == false)
    $folder_depth = 1;

if ($mysqli->connect_errno)
    echo "Error - Failed to connect to MySQL: " . $mysqli->connect_error;
if ($mysqli_nithra->connect_errno)
    echo "Error - Failed to connect to MySQL: " . $mysqli_nithra->connect_error;
mysqli_query($mysqli, "set character_set_client='utf8'");
mysqli_query($mysqli, "set character_set_results='utf8'");
mysqli_query($mysqli, "set collation_connection='utf8mb4_general_ci'");
date_default_timezone_set("Asia/Kolkata");

$datetime = date("Y-m-d-H:i:s");
$ymd = date("Y-m-d");
$date = date("d-m-Y");
$time = date("H:i:s");
$newDate = date('d/m/Y h:i:s A');

function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'No One Can Hack Me'; //This is my secret key
    $secret_iv = 'If You Have Dare Touch Me'; //This is my secret key
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function accesslog($uu, $dd, $desc) {
    $content = $dd . "<==>" . $_SERVER['REQUEST_URI'] . "<==>" . $desc . " by " . $uu . "<==>" . $_SERVER['REMOTE_ADDR'] . "<==>" . $_SERVER ['HTTP_USER_AGENT'] . PHP_EOL;
    $fp = fopen("log.txt", "a+");
    fwrite($fp, $content);
    fclose($fp);
}

function accesslogin($uu, $dd, $desc) {
    $content = $uu . " logged on " . "<==>" . $dd . " using " . $desc . PHP_EOL;
    $fp = fopen("login.txt", "a+");
    fwrite($fp, $content);
    fclose($fp);
}

$template_prefix = $prefix . "../templeteV2/";
$nithra_employer_number = "9597215816";
$nithra_employer_ind = "3";
?>
