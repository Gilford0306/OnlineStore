<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "online_store";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $username_reg = $_POST["username_reg"];
    $password_reg = password_hash($_POST["password_reg"], PASSWORD_DEFAULT); // Hash fuction


    $check_user_query = "SELECT * FROM users WHERE username='$username_reg'";
    $check_user_result = $conn->query($check_user_query);

    if ($check_user_result->num_rows > 0) {
        echo "A user with the same name already exists. Choose a different name.";
    } else {
        $register_query = "INSERT INTO users (username, hashed_password, role) VALUES ('$username_reg', '$password_reg', 'user')";
        if ($conn->query($register_query) === TRUE) {
            echo "Registration successful. You can now log in.";
            echo '<br><br><a href="logout.php">Back to Login screen</a>';
        } else {
            echo "Registration error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
