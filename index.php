<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

        if ($conn) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $sql = "SELECT * FROM users WHERE email = '$email'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) != 0) {
                $user = mysqli_fetch_assoc($res);

                if ($email == $user['email'] && $password == $user['password']) {
                    try {
                        $userKey = bin2hex(random_bytes(23));
                    } catch (Exception $e) {
                        $userKey = bin2hex(uniqid($email, true));
                    }

                    $sql = "UPDATE users SET userKey = '$userKey' WHERE email = '$email'";

                    if (mysqli_query($conn, $sql)) {
                        $role = $user['role'];
                        $name = $user['name'];

                        setcookie("userKey", $userKey, time() + (86400), "/"); // 86400 = 1 day
                        setcookie("email", $email, time() + (86400), "/"); // 86400 = 1 day
                        setcookie("role", $role, time() + (86400), "/"); // 86400 = 1 day
                        setcookie("name", $name, time() + (86400), "/"); // 86400 = 1 day

                        if ($role == "admin") {
                            header('location: /courier_app_web/admin/dashboard.php');
                        } else {
                            header('location: /courier_app_web/home.php');
                        }
                    } else {
                        $result = array("status" => "failed", "message" => "Login failed, try again.");
                    }
                } else {
                    $result = array("status" => "failed", "message" => "Incorrect email/password.");
                }
            }
        } else {
            echo "Database connection failed.";
        }
    } else {
        echo "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier App | Login</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center form-signin">
                        <h1 class="h3 mb-3 fw-normal">Courier App</h1>
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" placeholder="johndoe27@gmail.com" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>