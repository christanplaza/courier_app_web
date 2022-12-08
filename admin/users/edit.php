<?php
session_start();
$_SESSION["currentPage"] = "users";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";
$userObj = [];

$conn = mysqli_connect($host, $user, $pass, $db);
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = '$id'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) != 0) {
        $userObj = mysqli_fetch_assoc($res);
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $truck = $_POST['truck'];

    if (isset($password) && !empty($password) && ($password == $confirm_password)) {
        $password = md5($password);
        $query = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = $id;";

        mysqli_query($conn, $query) or die($conn->error);
    } else {
        $query = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id;";

        mysqli_query($conn, $query) or die($conn->error);
    }

    $msg_type = "success";
    $flash_message = "User successfully Updated.";
    $loc = "/courier_app_web/admin/users.php";
    header("location: ../components/alert.php?msg_type=$msg_type&flash_message=$flash_message&loc=$loc");
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
                        <div class="col-6">
                            <form method="POST">
                                <div class="row my-4">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $userObj['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $userObj['contact_number']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $userObj['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="role">Role</label>
                                            <select name="role" id="role" class="form-select" required>
                                                <option value="driver" <?php echo $userObj['role'] == 'driver' ? 'selected' : ''; ?>>Driver</option>
                                                <option value="admin" <?php echo $userObj['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="contact_number">Truck (Write '-' for admins)</label>
                                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $userObj['truck']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success w-100" name="submit">Update User</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>