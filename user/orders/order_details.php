<?php include_once "../check_logged_in.php"; ?>
<?php
session_start();
$_SESSION["currentPage"] = "orders";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";
$order = [];

if (isset($_GET['order_id'])) {
    $id = $_GET['order_id'];
    $conn = mysqli_connect($host, $user, $pass, $db);
    $query = "SELECT c.id AS userID, c.*, j.* FROM job_orders j INNER JOIN users c ON j.customer_id = c.id WHERE j.id='$id';";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) != 0) {
        $order = $result->fetch_assoc();
        if ($order['status'] == "Ongoing" || $order['status'] == "Delivered") {
            $driverID = $order['courier_id'];
            $query = "SELECT * FROM users WHERE id = '$driverID'";
            $res = mysqli_query($conn, $query);
            $driver = $res->fetch_assoc();
            $order['driverName'] = $driver['name'];
            $order['driverNumber'] = $driver['contact_number'];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier App | Orders</title>
    <?php include_once "../../components/header.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include_once '../../components/users_sidebar.php'; ?>
            <div class="col-10">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="my-4">
                                <h1 class="fs-1">Order Details</h1>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($order['status'] == "Ongoing" || $order['status'] == "Delivered") : ?>
                                        <tr>
                                            <td>Driver Name</td>
                                            <td><b><?php echo $order['driverName']; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Driver Number</td>
                                            <td><b><?php echo $order['driverNumber']; ?></b></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <?php if ($order['status'] == "Pending") : ?>
                                                <span class="fs-6 badge text-bg-secondary"><?php echo $order['status']; ?></span>
                                            <?php elseif ($order['status'] == "Ongoing") : ?>
                                                <span class="fs-6 badge text-bg-info"><?php echo $order['status']; ?></span>
                                            <?php elseif ($order['status'] == "Delivered") : ?>
                                                <span class="fs-6 badge text-bg-success"><?php echo $order['status']; ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date Placed </td>
                                        <td><b><?php echo $order['date_placed']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Estimated Date</td>
                                        <td>
                                            <b>
                                                <?php if ($order['estimated_time'] == "") : ?>
                                                    Date not yet set
                                                <?php else : ?>
                                                    <?php echo $order['estimated_time']; ?>
                                                <?php endif; ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pickup Address</td>
                                        <td><b><?php echo $order['pickup_address']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Address</td>
                                        <td><b><?php echo $order['delivery_address']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Note</td>
                                        <td><b><?php echo $order['note']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            <p><b><?php echo $order['description']; ?></b></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <div class="flex">
                                <a href="/courier_app_web/user/orders.php" class="btn btn-secondary px-4">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>