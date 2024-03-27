<?php ob_start(); ?>
<?php
session_start();
$_SESSION = array();
session_destroy(); //clear all session
header("Location: index.php"); //redictect to home page (index.php)
