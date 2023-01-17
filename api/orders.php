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
            $customer_id = $user['id'];
            $data = [];

            $sql = "SELECT `users`.name, `users`.contact_number, `job_orders`.* FROM job_orders LEFT JOIN users ON `job_orders`.courier_id = `users`.id WHERE customer_id = '$customer_id' ORDER BY date_placed DESC";

            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    // Get latest status
                    $orderID = $row['id'];

                    $sql = "SELECT * FROM job_order_status WHERE job_order_id = $orderID ORDER BY datetime DESC LIMIT 1";
                    $statusRes = mysqli_query($conn, $sql);

                    if ($statusRes) {
                        while ($status_row = $statusRes->fetch_assoc()) {
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
