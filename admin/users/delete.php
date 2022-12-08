<?php
session_start();
if (isset($_SESSION['delete']) && $_SESSION['delete']) {
    $_SESSION['msg_type'] = "success";
    $_SESSION['flash_message'] = "User Successfully Deleted.";

    session_unset($_SESSION['delete']);
    header('location: /courier_app_web/admin/users.php');
} else if (isset($_SESSION['admin']) && $_SESSION['admin']) {
    $_SESSION['msg_type'] = "danger";
    $_SESSION['flash_message'] = "Admin account cannot be deleted.";
    session_unset($_SESSION['admin']);
    header('location: /courier_app_web/admin/users.php');
}
