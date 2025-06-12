<?php
// admin/pages.php - Manage static pages
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /admin/login.php');
    exit;
}
require_once __DIR__ . '/../core/pages.php';
$pages = new Pages();
$list = $pages->getPages();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages</title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <main>
        <h1>Pages</h1>
        <a href="/admin/page_editor.php">New Page</a>
        <ul>
            <?php foreach ($list as $page): ?>
                <li><a href="/admin/page_editor.php?slug=<?=urlencode($page['slug'])?>"><?=htmlspecialchars($page['title'])?></a></li>
            <?php endforeach; ?>
        </ul>
        <a href="/admin">Back to Dashboard</a>
    </main>
</body>
</html>
