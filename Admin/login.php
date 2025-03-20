<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Ensure this file initializes $pdo properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) { // Check if a matching record exists
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <section class="admin">
            <div class="login-container">
                <h2>Admin Login</h2>
                <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </section>
    </body>
</html>