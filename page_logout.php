<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: page_login.php');
?>
