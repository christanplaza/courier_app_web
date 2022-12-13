<?php
session_start();
if (!empty($_POST['description']) && !empty($_POST['pickup_address']) && !empty($_POST['delivery_address']) && !empty($_POST['note']) && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['contact_number'])) {
   $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

   $name = $_POST['name'];
   $contact_number = $_POST['contact_number'];
   $email = $_POST['email'];
   $description = $_POST['description'];
   $pickup_address = $_POST['pickup_address'];
   $delivery_address = $_POST['delivery_address'];
   $note = $_POST['note'];
   $status = 'Pending';
   $role = 'customer';
   $password = md5('password');
   $result = array();

   if ($conn) {
      // we will check if there is already a user with that email.

      $sql = "SELECT * FROM users WHERE email = '$email'";

      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) != 0) {
         $user = mysqli_fetch_assoc($res);
         $customer_id = $user['id'];

         $sql = "INSERT INTO job_orders (customer_id, description, note, status, delivery_address, pickup_address) values ('$customer_id', '$description', '$note', '$status', '$delivery_address', '$pickup_address')";
         if (mysqli_query($conn, $sql)) {
            $result = array("status" => "success", "message" => "Job Order Created");
         } else {
            $result = array("status" => "failed", "message" => "Something went wrong.");
         }
      } else {
         // First we will create an account for the user with a temporary default password
         $sql = "INSERT into users (name, contact_number, role, email, password) values ('$name', '$contact_number', '$role', '$email', '$password')";
         if (mysqli_query($conn, $sql)) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) != 0) {
               $user = mysqli_fetch_assoc($res);
               $customer_id = $user['id'];
               $sql = "INSERT INTO job_orders (customer_id, description, note, status, delivery_address, pickup_address) values ('$customer_id', '$description', '$note', '$status', '$delivery_address', '$pickup_address')";
               if (mysqli_query($conn, $sql)) {
                  $result = array("status" => "success", "message" => "Job Order Created");
               } else {
                  $result = array("status" => "failed", "message" => "Something went wrong.");
               }
            } else {
               $result = array("status" => "failed", "message" => "Something went wrong.");
            }
         } else {
            $result = array("status" => "failed", "message" => "Account Creation failed.");
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
header('location: /courier_app_web/book.php');
