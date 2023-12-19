<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <button id="theme-toggle"> </button>
    <h1>Welcome to our store!</h1>

</header>


<form action="Enter/login.php" method="post">
    <h2>Enter</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <button type="submit">login to account</button>
</form>


<p class="center-text">Not registered yet? <a href="Enter/register-form.php">Register here</a>.</p>
<script src="theme.js"></script>
</body>
</html>
