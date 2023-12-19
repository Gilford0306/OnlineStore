<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "127.0.0.1";
    $username =  "root";
    $password =  "";
    $dbname = "online_store";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $check_user_query = "SELECT * FROM users WHERE username='$username'";
    $check_user_result = $conn->query($check_user_query);

    if ($check_user_result->num_rows > 0) {
        $user_row = $check_user_result->fetch_assoc();//what it this ?

        if (password_verify($password, $user_row['hashed_password'])) {
            $_SESSION['user_id'] = $user_row['id'];
            $_SESSION['username'] = $user_row['username'];
            $_SESSION['role'] = $user_row['role'];

            if  ($_SESSION['role'] =='admin')
            {
                header("Location: ../Admin/admin.php");
            }
            else
            header("Location: ../User/user.php");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "A user with this name was not found.";
    }

    $conn->close();
}
?>
