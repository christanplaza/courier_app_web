<?php
session_start();
$_SESSION["currentPage"] = "dashboard";
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>