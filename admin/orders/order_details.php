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
    $query = $sql = "SELECT `users`.id AS userID, `users`.*, `job_orders`.* FROM job_orders INNER JOIN users ON `job_orders`.customer_id = `users`.id WHERE `job_orders`.id='$id';";

    $result = mysqli_query($conn, $query) or die($conn->error);

    if (mysqli_num_rows($result) != 0) {
        $order = $result->fetch_assoc();
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
            <?php include_once '../../components/sidebar.php'; ?>
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
                                    <tr>
                                        <td>Customer Name</td>
                                        <td><b><?php echo $order['name']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number</td>
                                        <td><b><?php echo $order['contact_number']; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <?php if ($order['status'] == "Pending") : ?>
                                                <span class="fs-6 badge text-bg-secondary"><?php echo $order['status']; ?></span>
                                            <?php elseif ($order['status'] == "Ongoing") : ?>
                                                <span class="fs-6 badge text-bg-info"><?php echo $order['status']; ?></span>
                                            <?php elseif ($order['status'] == "In Transit") : ?>
                                                <span class="fs-6 badge text-bg-warning"><?php echo $order['status']; ?></span>
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
                                    <tr>
                                        <td>Delivery Fee</td>
                                        <td>
                                            <p><b><?php echo $order['delivery_fee']; ?></b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rating</td>
                                        <td>
                                            <p><b><?php echo $order['rating']; ?></b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Feedback</td>
                                        <td>
                                            <p><b><?php echo $order['customer_feedback']; ?></b></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <div class="flex">
                                <?php if ($order['status'] == 'Pending') : ?>
                                    <a href="/courier_app_web/admin/orders/finalize.php?order_id=<?php echo $id; ?>" class="btn btn-success">Assign Driver & Estimate</a>
                                <?php endif; ?>
                                <?php if ($order['status'] != 'Delivered') : ?>

                                    <a href="#" class="btn btn-danger">Cancel Order</a>
                                <?php endif; ?>
                                <a href="/courier_app_web/admin/orders.php" class="btn btn-secondary px-4">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>