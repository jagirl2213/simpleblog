<?php
// admin/page_editor.php - Static page editor
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /admin/login.php');
    exit;
}
require_once __DIR__ . '/../core/pages.php';
$pages = new Pages();
$slug = $_GET['slug'] ?? '';
$page = $slug ? $pages->getPage($slug) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $slug = $slug ?: strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    $pages->savePage($slug, $title, $content);
    header('Location: /admin/page_editor.php?slug=' . urlencode($slug));
    exit;
}
if (isset($_GET['delete']) && $slug) {
    $pages->deletePage($slug);
    header('Location: /admin/pages.php');
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page ? 'Edit' : 'New' ?> Page</title>
    <link rel="stylesheet" href="/themes/default/style.css">
    <style>
        textarea { width: 100%; min-height: 200px; font-family: monospace; }
        label { display: block; margin-top: 1em; }
    </style>
</head>
<body>
    <main>
        <h1><?= $page ? 'Edit' : 'New' ?> Page</h1>
        <form method="post">
            <label>Title
                <input type="text" name="title" value="<?= htmlspecialchars($page['title'] ?? '') ?>" required>
            </label>
            <label>Content (Markdown)
                <textarea name="content" required><?= htmlspecialchars($page['content'] ?? '') ?></textarea>
            </label>
            <button type="submit">Save</button>
            <?php if ($page): ?>
                <a href="/admin/page_editor.php?slug=<?=urlencode($slug)?>&delete=1" style="color:red;">Delete</a>
            <?php endif; ?>
        </form>
        <a href="/admin/pages.php">Back to Pages</a>
    </main>
</body>
</html>
