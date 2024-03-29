<?php
session_start();
date_default_timezone_set('Asia/Singapore');
if (!empty($_POST['description']) && !empty($_POST['pickup_address']) && !empty($_POST['delivery_address']) && !empty($_POST['note'])) {
   $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

   $name = $_COOKIE['name'];
   $userKey = $_COOKIE['userKey'];
   $contact_number = $_COOKIE['contact_number'];
   $email = $_COOKIE['email'];
   $description = $_POST['description'];
   $pickup_address = $_POST['pickup_address'];
   $delivery_address = $_POST['delivery_address'];
   $note = $_POST['note'];
   $status = 'Pending';
   $role = 'customer';
   $password = md5('password');
   $result = array();
   $today = date('Y-m-d H:i');

   if ($conn) {
      $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) != 0) {
         $user = mysqli_fetch_assoc($res);
         $customer_id = $user['id'];

         $sql = "INSERT INTO job_orders (customer_id, description, note, status, delivery_address, pickup_address) values ('$customer_id', '$description', '$note', '$status', '$delivery_address', '$pickup_address')";
         if (mysqli_query($conn, $sql)) {
            $id = $conn->insert_id;

            $sql = "INSERT INTO job_order_status (job_order_id, status, status_message, datetime) values ('$id', 'Order Received', 'Order is currently under review.', '$today');";
            if (mysqli_query($conn, $sql)) {
               $result = array("status" => "success", "message" => "Job Order Created");
            } else {
               $sql = "DELETE FROM job_orders WHERE id = $id";
               mysqli_query($conn, $sql);

               $result = array("status" => "failed", "message" => "Something went wrong.");
            }
         } else {
            $result = array("status" => "failed", "message" => "Something went wrong.");
         }
      }
   } else {
      $result = array("status" => "failed", "message" => "Database connection failed.");
   }
} else {
   $result = array("status" => "failed", "message" => "All fields are required");
}

$_SESSION['msg_type'] = $result['status'];
$_SESSION['flash_message'] = $result['message'];
header('location: /courier_app_web/user/orders.php');
