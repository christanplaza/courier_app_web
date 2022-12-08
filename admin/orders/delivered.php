<?php
session_start();
if (isset($_SESSION['delivered']) && $_SESSION['delivered']) {
    $_SESSION['msg_type'] = "success";
    $_SESSION['flash_message'] = "Job Order Marked as Delivered.";
    header('location: /courier_app_web/admin/orders.php');
}
