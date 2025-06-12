<?php
// core/router.php - Simple routing logic for clean URLs

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        require __DIR__ . '/../themes/default/home.php';
        break;
    case '/admin':
        require __DIR__ . '/../admin/dashboard.php';
        break;
    default:
        // Check if the slug matches a post
        require_once __DIR__ . '/storage.php';
        $storage = new Storage(false); // Set to true for SQLite
        $slug = ltrim($uri, '/');
        if ($slug && $storage->getPost($slug)) {
            $_GET['slug'] = $slug;
            require __DIR__ . '/../themes/default/post.php';
        } elseif (preg_match('#^page/([a-zA-Z0-9\-]+)$#', $slug, $matches)) {
            $_GET['slug'] = $matches[1];
            require __DIR__ . '/../themes/default/page.php';
        } else {
            http_response_code(404);
            require __DIR__ . '/../themes/default/404.php';
        }
        break;
}
