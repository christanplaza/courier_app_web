<?php
$msg_type = $_GET['msg_type'];
$flash_message = $_GET['flash_message'];
$loc = $_GET['loc'];

session_start();
$_SESSION['msg_type'] = $msg_type;
$_SESSION['flash_message'] = $flash_message;

header("location: $loc");
