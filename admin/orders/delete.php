<?php
session_start();
if (isset($_SESSION['delete']) && $_SESSION['delete']) {
    $_SESSION['msg_type'] = "success";
    $_SESSION['flash_message'] = "Job Order Successfully Cancelled.";
    header('location: /courier_app_web/admin/orders.php');
}
