<?php
if (!empty($_POST['email']) && !empty($_POST['userKey']) && !empty($_POST['orderID']) && !empty($_POST['feedback']) && !empty($_POST['rating'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $orderID = $_POST['orderID'];
    $data = [];

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            // Get all status of particular job order
            $sql = "UPDATE job_orders SET rating = '$rating', customer_feedback = '$feedback' WHERE id = '$orderID'";
            if (mysqli_query($conn, $sql)) {
                $result = array("status" => "success", "message" => "Review Submitted");
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
