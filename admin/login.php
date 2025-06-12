<?php
// admin/login.php - Simple login form (placeholder)
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        $error = 'Invalid CSRF token';
    } else {
        // Secure authentication logic
        $users = [
            'admin' => '$2y$10$REPLACE_WITH_HASHED_PASSWORD' // Replace with real hash
        ];
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        if (isset($users[$username]) && password_verify($password, $users[$username])) {
            $_SESSION['user'] = $username;
            header('Location: /admin');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <main>
        <h1>Login</h1>
        <?php if (!empty($error)): ?><p style="color:red;"><?=$error?></p><?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($_SESSION['csrf_token'] = bin2hex(random_bytes(16)))?>">
            <input type="text" name="username" placeholder="Username" required autofocus><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
