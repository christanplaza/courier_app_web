<?php
if (!empty($_POST['email']) && !empty($_POST['userKey'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);
            $data = [];

            $sql = "SELECT c.name, c.contact_number, j.*, d.name as driverName, d.contact_number as driverNumber FROM job_orders j LEFT JOIN users c ON c.id = j.customer_id LEFT JOIN users d on d.id = j.courier_id ORDER BY date_placed DESC";

            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    // Get latest status
                    $orderID = $row['id'];

                    $sql = "SELECT * FROM job_order_status WHERE job_order_id = $orderID ORDER BY datetime DESC LIMIT 1";
                    $res = mysqli_query($conn, $sql);

                    if ($res) {
                        while ($status_row = $res->fetch_assoc()) {
                            $row['recent_status'] = $status_row;
                        }
                    }
                    $data[] = $row;
                }
                $result = array("status" => "success", "orders" => $data);
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
