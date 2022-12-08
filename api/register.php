<?php

if (!empty($_POST['name']) && !empty($_POST['contact_number']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
    if ($_POST['password'] === $_POST['password_confirm']) {
        $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

        $name = $_POST['name'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $role = 'customer';

        if ($conn) {
            $sql = "INSERT into users (name, contact_number, role, email, password) values ('$name', '$contact_number', '$role', '$email', '$password')";

            if (mysqli_query($conn, $sql)) {
                echo "success";
            } else {
                echo "Registration failed";
            }
        } else {
            echo "Database connection failed.";
        }
    } else {
        echo "Password is not the same!";
    }
} else {
    echo "All fields are required";
}
