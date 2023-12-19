<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <h1>Registration</h1>
</header>

<form action="register.php" method="post">
    <label for="username_reg">Username:</label>
    <input type="text" name="username_reg" required>
    <label for="password_reg">Password:</label>
    <input type="password" name="password_reg" required>
    <button type="submit">Register</button>
</form>
</body>
</html>
