<?php include_once "check_logged_in.php"; ?>
<?php
session_start();
$_SESSION["currentPage"] = "orders";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";
$email = $_COOKIE['email'];
$userKey = $_COOKIE['userKey'];
$id = $_COOKIE['id'];


$conn = mysqli_connect($host, $user, $pass, $db);
$query = "SELECT `users`.id AS userID, `users`.*, `job_orders`.* FROM job_orders INNER JOIN users ON `job_orders`.customer_id = `users`.id WHERE customer_id = '$id' ORDER BY date_placed";

$result = mysqli_query($conn, $query);

if (isset($_GET['delete']) && $_GET['delete']) {
    $id = $_GET['delete'];
    $status = "Cancelled";

    $sql = "UPDATE job_orders SET status = '$status' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['delete'] = true;

        header('location: /courier_app_web/user/orders/delete.php');
    }
}
if (isset($_GET['delivered']) && $_GET['delivered']) {
    $id = $_GET['delivered'];
    $status = "Delivered";

    $sql = "UPDATE job_orders SET status = '$status' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['delivered'] = true;

        header('location: /courier_app_web/user/orders/delivered.php');
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
    <?php include_once "../components/header.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include_once '../components/users_sidebar.php'; ?>
            <div class="col-10">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="my-4">
                                <h1 class="fs-1">Orders</h1>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['msg_type']) && isset($_SESSION['flash_message'])) : ?>
                            <div class="alert alert-<?php echo $_SESSION["msg_type"]; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION["flash_message"]; ?>
                            </div>
                        <?php endif; ?>
                        <?php unset($_SESSION['msg_type']);
                        unset($_SESSION['flash_message']); ?>
                        <div class="col-12">
                            <table class="table table-striped bg-light">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Date Placed</th>
                                        <th scope=" col">Pickup Address</th>
                                        <th scope="col">Delivery Address</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['date_placed']; ?></td>
                                            <td><?php echo $row['pickup_address']; ?></td>
                                            <td><?php echo $row['delivery_address']; ?></td>
                                            <td>
                                                <?php if ($row['status'] == "Pending") : ?>
                                                    <span class="fs-5 badge text-bg-secondary"><?php echo $row['status']; ?></span>
                                                <?php elseif ($row['status'] == "Ongoing") : ?>
                                                    <span class="fs-5 badge text-bg-info"><?php echo $row['status']; ?></span>
                                                <?php elseif ($row['status'] == "In Transit") : ?>
                                                    <span class="fs-5 badge text-bg-warning"><?php echo $row['status']; ?></span>
                                                <?php elseif ($row['status'] == "Cancelled") : ?>
                                                    <span class="fs-5 badge text-bg-danger"><?php echo $row['status']; ?></span>
                                                <?php elseif ($row['status'] == "Delivered") : ?>
                                                    <span class="fs-5 badge text-bg-success"><?php echo $row['status']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="/courier_app_web/user/orders/order_details.php?order_id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>

                                                    <form action="">
                                                        <?php if ($row['status'] != "Delivered" && $row['status'] != "Cancelled") : ?>
                                                            <button class="btn btn-danger" name="delete" type="submit" value="<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to cancel this order?')">
                                                                Cancel Order
                                                            </button>
                                                        <?php endif; ?>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>