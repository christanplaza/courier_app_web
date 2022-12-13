<?php include_once "check_logged_in.php"; ?>

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
            <?php include_once '../components/users_sidebar.php'; ?>
            <div class="col">
                <div class="mt-4">
                    <h1>Request an Order</h1>


                    <?php if (isset($_SESSION['msg_type']) && isset($_SESSION['flash_message'])) : ?>
                        <div class="alert alert-<?php echo $_SESSION["msg_type"]; ?> alert-dismissible fade show fs-1" role="alert">
                            <?php echo $_SESSION["flash_message"]; ?>
                        </div>
                    <?php endif; ?>
                    <?php unset($_SESSION['msg_type']);
                    unset($_SESSION['flash_message']); ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="/courier_app_web/user/orders/form_submit.php" method="post" class="book-form">
                                <div class="row mt-4">
                                    <div class="mb-3">
                                        <label class="form-label">Pickup address :</label>
                                        <input class="form-control" type="text" placeholder="enter your pickup address" name="pickup_address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Delivery address :</label>
                                        <input class="form-control" type="text" placeholder="enter your delivery address" name="delivery_address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Note :</label>
                                        <input class="form-control" type="text" placeholder="delivery notes" name="note" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description :</label>
                                        <textarea class="form-control" name="description" id="description" rows="10" style="resize: none;"></textarea>
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn w-100 btn-dark fs-1" name="send">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>