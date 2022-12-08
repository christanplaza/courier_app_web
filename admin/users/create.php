<?php
session_start();
$_SESSION["currentPage"] = "users";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";

$conn = mysqli_connect($host, $user, $pass, $db);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $truck = $_POST['truck'];

    if ($password == $confirm_password) {
        $password = md5($password);
        $sql = "INSERT into users (name, contact_number, role, email, password, truck) values ('$name', '$contact_number', '$role', '$email', '$password', '$truck')";
        if (mysqli_query($conn, $sql)) {
            $msg_type = "success";
            $flash_message = "User successfully created.";
            $loc = "/courier_app_web/admin/users.php";

            header("location: ../components/alert.php?msg_type=$msg_type&flash_message=$flash_message&loc=$loc");
        } else {
            $msg_type = "danger";
            $flash_message = "Something went wrong.";
            $loc = "/courier_app_web/admin/users.php";

            header("location: ../components/alert.php?msg_type=$msg_type&flash_message=$flash_message&loc=$loc");
        }
    } else {
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
                        <div class="col-6">
                            <form method="POST">
                                <div class="row my-4">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="role">Role</label>
                                            <select name="role" id="role" class="form-select" required>
                                                <option value="driver" selected>Driver</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="truck">Truck (Write '-' for admins)</label>
                                            <input type="text" class="form-control" id="truck" name="truck" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success w-100" name="submit">Add User</button>
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