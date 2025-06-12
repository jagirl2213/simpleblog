<?php
// themes/default/post.php - Single post template
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <main>
        <?php
        require_once __DIR__ . '/../../core/storage.php';
        $storage = new Storage(false); // Set to true for SQLite
        $slug = $_GET['slug'] ?? '';
        $post = $storage->getPost($slug);
        if (!$post) {
            http_response_code(404);
            echo '<h1>Post Not Found</h1><a href="/">Back to Home</a>';
            exit;
        }
        ?>
        <h1><?=htmlspecialchars($post['title'])?></h1>
        <article>
            <p><?=nl2br(htmlspecialchars($post['content']))?></p>
        </article>
        <a href="/">Back to Home</a>
    </main>
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌓</button>
    <script src="/themes/default/theme-toggle.js"></script>
</body>
</html>
