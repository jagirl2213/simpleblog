<?php
// themes/default/home.php - Blog homepage template
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimalist Blog</title>
    <meta name="description" content="A minimalist, modern blog CMS.">
    <meta property="og:title" content="Minimalist Blog" />
    <meta property="og:description" content="A minimalist, modern blog CMS." />
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <header>
        <h1>Minimalist Blog</h1>
        <nav><a href="/admin">Admin</a></nav>
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌓</button>
    </header>
    <main>
        <h2>Recent Posts</h2>
        <?php
        require_once __DIR__ . '/../../core/storage.php';
        $storage = new Storage(false); // Set to true for SQLite
        $posts = $storage->getPosts();
        if ($posts):
            foreach ($posts as $post): ?>
                <article>
                    <h3><a href="/<?=htmlspecialchars($post['slug'])?>"><?=htmlspecialchars($post['title'])?></a></h3>
                    <p><?=htmlspecialchars(mb_substr(strip_tags($post['content']),0,120))?>...</p>
                    <small>Published: <?=date('F j, Y', strtotime($post['created_at']))?></small>
                </article>
            <?php endforeach;
        else:
            echo '<p>No posts yet.</p>';
        endif;
        ?>
    </main>
    <footer>
        <small>&copy; <?=date('Y')?> Minimalist Blog</small>
    </footer>
    <script src="/themes/default/theme-toggle.js"></script>
</body>
</html>
