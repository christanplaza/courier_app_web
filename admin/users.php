<?php include_once "check_logged_in.php"; ?>
<?php
session_start();
$_SESSION["currentPage"] = "users";
$host = "localhost";
$user = "root";
$pass = "";
$db = "courier_app";

$conn = mysqli_connect($host, $user, $pass, $db);
$query = "SELECT * FROM users WHERE role != 'customer' AND deleted = '0'";

$result = mysqli_query($conn, $query) or die($conn->error);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    if ((int)$id == 1) {
        $_SESSION['admin'] = true;

        header('location: /courier_app_web/admin/users/delete.php');
    } else {
        $query = "UPDATE users SET deleted = '1' WHERE id = $id";
        $result = mysqli_query($conn, $query) or die($conn->error);

        $_SESSION['delete'] = true;

        header('location: /courier_app_web/admin/users/delete.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier App | Users</title>
    <?php include_once "../components/header.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include_once '../components/sidebar.php'; ?>
            <div class="col-10">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="my-4">
                                <h1 class="fs-1">Users</h1>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="/courier_app_web/admin/users/create.php" class="btn btn-success float-end mb-4">Add User</a>
                        </div>
                        <?php if (isset($_SESSION['msg_type']) && isset($_SESSION['flash_message'])) : ?>
                            <div class="alert alert-<?php echo $_SESSION["msg_type"]; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION["flash_message"]; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        unset($_SESSION['msg_type']);
                        unset($_SESSION['flash_message']);
                        ?>
                        <div class="col-12">
                            <table class="table table-striped bg-light">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email Address</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <?php
                                                if ($row['role'] == "admin") {
                                                    echo "Admin";
                                                } else {
                                                    echo "Truck Driver - " . $row['truck'];
                                                };
                                                ?>
                                            </td>
                                            <td class="d-flex gap-2">
                                                <a href="/courier_app_web/admin/users/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
                                                    Edit User
                                                </a>
                                                <?php if ($row['role'] != "admin") : ?>
                                                    <form action="">
                                                        <button class="btn btn-danger" name="delete" type="submit" value="<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                                                            Delete User
                                                        </button>
                                                    </form>
                                                <?php endif ?>
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

</html>