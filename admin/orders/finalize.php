<?php include_once "../check_logged_in.php"; ?>
<?php
session_start();
$_SESSION["currentPage"] = "orders";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";
$order = [];
$drivers = [];
$today = date('Y-m-d');

if (isset($_GET['order_id'])) {
    $id = $_GET['order_id'];
    $conn = mysqli_connect($host, $user, $pass, $db);
    $query = $sql = "SELECT `users`.id AS userID, `users`.*, `job_orders`.* FROM job_orders INNER JOIN users ON `job_orders`.customer_id = `users`.id WHERE `job_orders`.id='$id';";

    $result = mysqli_query($conn, $query) or die($conn->error);

    if (mysqli_num_rows($result) != 0) {
        $order = $result->fetch_assoc();
    }

    $sql = "SELECT * FROM users WHERE role = 'driver' AND deleted = '0'";

    $res = mysqli_query($conn, $sql);
    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            while ($row = $res->fetch_assoc()) {
                $driverId = $row['id'];
                $sql = "SELECT * FROM job_orders WHERE (courier_id = '$driverId') AND status = 'Ongoing'";

                $job_order_res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($job_order_res) == 0) {
                    $data[] = $row;
                }
            }
            $drivers = $data;
        } else {
            $drivers = null;
        }
    }

    if (isset($_POST['submit'])) {
        $driver = $drivers[$_POST['driver']];
        $driver_id = $driver['id'];
        $date = $_POST['estimated_date'];

        $sql = "UPDATE job_orders SET estimated_time = '$date', courier_id = '$driver_id', status = 'Ongoing' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['msg_type'] = "success";
            $_SESSION['flash_message'] = "Order Updated.";

            header('location: /courier_app_web/admin/orders.php');
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
    <style>
        label {
            width: 100%;
        }

        .card-input-element {
            display: none;
        }

        .card-input:hover {
            cursor: pointer;
        }

        .card-input-element:checked+.card-input {
            box-shadow: 0 0 2px 2px #2ecc71;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include_once '../../components/sidebar.php'; ?>
            <div class="col-10">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="my-4">
                                <h1 class="fs-1">Order Details</h1>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row my-4">
                                <form method="POST">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="estimated_date">Estimated Date</label>
                                            <input id="estimated_date" name="estimated_date" class="form-control" type="date" min="<?php echo $today; ?>" required>
                                        </div>
                                    </div>
                                    <?php if ($drivers != null) : ?>
                                        <?php foreach ($drivers as $key => $driver) : ?>
                                            <div class="col-12 mb-4">
                                                <label>
                                                    <input type="radio" name="driver" value="<?php echo $key; ?>" class="card-input-element" required />
                                                    <div class="card card-input">
                                                        <div class="card-body">
                                                            <h4><?php echo $driver['name']; ?></h4>
                                                            <h6><?php echo $driver['truck']; ?></h6>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <div class="col-12">
                                            <div class="fs-4">
                                                <div class="alert alert-warning" role="alert">
                                                    There are no available Truck Drivers
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary w-100" name="submit">Assign and mark as Ongoing</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>