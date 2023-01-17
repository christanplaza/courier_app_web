<?php include_once "check_logged_in.php"; ?>

<?php
session_start();
$_SESSION["currentPage"] = "dashboard";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";

$ongoingOrders = 0;
$pendingOrders = 0;
$availableDrivers = 0;
$registeredUsers = 0;

$conn = mysqli_connect($host, $user, $pass, $db);

$sql = "SELECT COUNT(*) FROM job_orders WHERE status = 'Pending'";

$res = mysqli_query($conn, $sql);
if ($res) {
    $pendingOrders = mysqli_fetch_assoc($res)['COUNT(*)'];
}

$sql = "SELECT COUNT(*) FROM job_orders WHERE (status = 'Ongoing' OR status = 'In Transit')";

$res = mysqli_query($conn, $sql);
if ($res) {
    $ongoingOrders = mysqli_fetch_assoc($res)['COUNT(*)'];
}

$sql = "SELECT * FROM users WHERE role = 'driver'";

$res = mysqli_query($conn, $sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $driverId = $row['id'];
        $sql = "SELECT * FROM job_orders WHERE (courier_id = '$driverId') AND (status = 'Ongoing' OR status = 'In Transit')";

        $job_order_res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($job_order_res) == 0) {
            $availableDrivers += 1;
        }
    }
}

$sql = "SELECT COUNT(*) FROM users WHERE role = 'customer'";
$res = mysqli_query($conn, $sql);
if ($res) {
    $registeredUsers = mysqli_fetch_assoc($res)['COUNT(*)'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier App | Dashboard</title>
    <?php include_once "../components/header.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include_once '../components/sidebar.php'; ?>
            <div class="col">
                <div class="mt-4">
                    <h1>Dashboard</h1>
                    <div class="row mt-5">
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="card-body">
                                    <h3 class="card-title">Ongoing Orders</h3>
                                    <h1><?php echo $ongoingOrders; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="card-body">
                                    <h3 class="card-title">Pending Orders</h3>
                                    <h1><?php echo $pendingOrders; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="card-body">
                                    <h3 class="card-title">Available Drivers</h3>
                                    <h1><?php echo $availableDrivers; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-3 widget-content">
                                <div class="card-body">
                                    <h3 class="card-title">Registered Customers</h3>
                                    <h1><?php echo $availableDrivers; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>