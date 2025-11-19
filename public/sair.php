<?php
ob_start();               
if (!isset($_SESSION)) {
    
}
unset($_SESSION["admin"]);
header("Location: index.php");
exit;
