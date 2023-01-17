<?php

if (!empty($_POST['email']) && !empty($_POST['userKey']) && !empty($_POST['orderID'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $orderID = $_POST['orderID'];
    $data = [];

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            // Get all status of particular job order
            $sql = "SELECT * FROM job_order_status WHERE job_order_id = $orderID ORDER BY datetime DESC";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $date = date_create($row['datetime']);
                    $row['date'] = date_format($date, "Y-m-d");
                    $row['time'] = date_format($date, "H:i");
                    $data[] = $row;
                }
                $result = array("status" => "success", "status_list" => $data);
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
