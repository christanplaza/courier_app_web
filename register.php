<?php
session_start();
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center form-signin">
                        <h1 class="h3 mb-3 fw-normal">Create Account</h1>
                        <?php if (isset($_SESSION['msg_type']) && isset($_SESSION['flash_message'])) : ?>
                            <div class="alert alert-<?php echo $_SESSION["msg_type"]; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION["flash_message"]; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        unset($_SESSION['msg_type']);
                        unset($_SESSION['flash_message']);
                        ?>
                        <form method="POST" action="/courier_app_web/user/register_form.php">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="contact_number" class="form-control" placeholder="John Doe" required>
                                <label for="floatingInput">Contact Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" placeholder="johndoe27@gmail.com" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password_confirm" class="form-control" placeholder="password_confirm" required>
                                <label for="password">Confirm Password</label>
                            </div>
                            <div class="mb-3">
                                <p>Already have an account? <a href="login.php">Login here.</a></p>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>