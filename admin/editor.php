<?php
// admin/editor.php - Simple Markdown content editor for posts
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /admin/login.php');
    exit;
}
require_once __DIR__ . '/../core/storage.php';
$storage = new Storage(false); // Set to true for SQLite

$slug = $_GET['slug'] ?? '';
$post = $slug ? $storage->getPost($slug) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $slug = $slug ?: strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    $storage->savePost($slug, $title, $content, $post['created_at'] ?? null);
    header('Location: /admin/editor.php?slug=' . urlencode($slug));
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post ? 'Edit' : 'New' ?> Post</title>
    <link rel="stylesheet" href="/themes/default/style.css">
    <style>
        textarea { width: 100%; min-height: 200px; font-family: monospace; }
        label { display: block; margin-top: 1em; }
    </style>
</head>
<body>
    <main>
        <h1><?= $post ? 'Edit' : 'New' ?> Post</h1>
        <form method="post">
            <label>Title
                <input type="text" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required>
            </label>
            <label>Content (Markdown)
                <textarea name="content" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
            </label>
            <button type="submit">Save</button>
            <?php if ($post): ?>
                <a href="/admin/editor.php?slug=<?=urlencode($slug)?>&delete=1" style="color:red;">Delete</a>
            <?php endif; ?>
        </form>
        <a href="/admin">Back to Dashboard</a>
    </main>
</body>
</html>
<?php
if (isset($_GET['delete']) && $slug) {
    $storage->deletePost($slug);
    header('Location: /admin');
    exit;
}
