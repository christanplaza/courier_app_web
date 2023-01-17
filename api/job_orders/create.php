<?php

if (!empty($_POST['description']) && !empty($_POST['pickup_address']) && !empty($_POST['address']) && !empty($_POST['note']) && !empty($_POST['email']) && !empty($_POST['userKey'])) {
    date_default_timezone_set('Asia/Singapore');
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $description = $_POST['description'];
    $pickup_address = $_POST['pickup_address'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $userKey = $_POST['userKey'];
    $status = 'Pending';
    $today = date('Y-m-d H:i');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);
            $customer_id = $user['id'];

            $sql = "INSERT INTO job_orders (customer_id, description, note, status, delivery_address, pickup_address) values ('$customer_id', '$description', '$note', '$status', '$address', '$pickup_address')";

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
        } else {
            $result = array("status" => "failed", "message" => "Unauthorized Access");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}

echo json_encode($result, JSON_PRETTY_PRINT);
