<?php

if (!empty($_POST['email']) && !empty($_POST['userKey']) && !empty($_POST['date']) && !empty($_POST['courier'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $courier = $_POST['courier'];
    $date = $_POST['date'];
    $orderID = $_POST['orderID'];
    $deliveryFee = $_POST['delivery_fee'];

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $sql = "UPDATE job_orders SET estimated_time = '$date', courier_id = '$courier', status = 'Ongoing', delivery_fee = '$deliveryFee' WHERE id = '$orderID'";

            if (mysqli_query($conn, $sql)) {
                $result = array("status" => "success", "message" => "Order Updated");
            } else {
                $result = array("status" => "failed", "message" => "Something went wrong");
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
