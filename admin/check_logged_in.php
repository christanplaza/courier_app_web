<?php
if (!$_COOKIE['userKey']) {
    header('location: /courier_app_web/login.php');
}
