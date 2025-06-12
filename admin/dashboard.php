<?php
// admin/dashboard.php - Admin dashboard (placeholder)
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /admin/login.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <main>
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?=htmlspecialchars($_SESSION['user'])?>!</p>
        <a href="/admin/editor.php">New Post</a> |
        <a href="/admin/upload.php">Upload Media</a> |
        <a href="/admin/pages.php">Manage Pages</a>
        <h2>Your Posts</h2>
        <?php
        require_once __DIR__ . '/../core/storage.php';
        $storage = new Storage(false); // Set to true for SQLite
        $posts = $storage->getPosts();
        if ($posts):
            echo '<ul>';
            foreach ($posts as $post):
                echo '<li><a href="/<?=urlencode($post['slug'])?>"><?=htmlspecialchars($post['title'])?></a> <small>(<?=date('Y-m-d', strtotime($post['created_at']))?>)</small></li>';
            endforeach;
            echo '</ul>';
        else:
            echo '<p>No posts yet.</p>';
        endif;
        ?>
        <a href="/admin/logout.php">Logout</a>
    </main>
</body>
</html>
