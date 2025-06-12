<?php
// themes/default/page.php - Static page template
require_once __DIR__ . '/../../core/pages.php';
$pages = new Pages();
$slug = $_GET['slug'] ?? '';
$page = $pages->getPage($slug);
if (!$page) {
    http_response_code(404);
    echo '<h1>Page Not Found</h1><a href="/">Back to Home</a>';
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($page['title'])?></title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <header>
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌓</button>
    </header>
    <main>
        <h1><?=htmlspecialchars($page['title'])?></h1>
        <article>
            <p><?=nl2br(htmlspecialchars($page['content']))?></p>
        </article>
        <a href="/">Back to Home</a>
    </main>
    <script src="/themes/default/theme-toggle.js"></script>
</body>
</html>
