<?php
// core/storage.php - Content storage abstraction (flat file or SQLite)

class Storage {
    private $use_sqlite;
    private $db;
    private $posts_dir;

    public function __construct($use_sqlite = false) {
        $this->use_sqlite = $use_sqlite;
        $this->posts_dir = __DIR__ . '/../storage/posts';
        if ($use_sqlite) {
            $this->db = new PDO('sqlite:' . __DIR__ . '/../storage/blog.sqlite');
            $this->initSqlite();
        } else {
            if (!is_dir($this->posts_dir)) {
                mkdir($this->posts_dir, 0777, true);
            }
        }
    }

    private function initSqlite() {
        $this->db->exec('CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE,
            title TEXT,
            content TEXT,
            created_at TEXT,
            updated_at TEXT
        )');
    }

    public function getPosts() {
        if ($this->use_sqlite) {
            $stmt = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $posts = [];
            foreach (glob($this->posts_dir . '/*.json') as $file) {
                $posts[] = json_decode(file_get_contents($file), true);
            }
            usort($posts, function($a, $b) { return strcmp($b['created_at'], $a['created_at']); });
            return $posts;
        }
    }

    public function getPost($slug) {
        if ($this->use_sqlite) {
            $stmt = $this->db->prepare('SELECT * FROM posts WHERE slug = ?');
            $stmt->execute([$slug]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $file = $this->posts_dir . '/' . $slug . '.json';
            return file_exists($file) ? json_decode(file_get_contents($file), true) : null;
        }
    }

    public function savePost($slug, $title, $content, $created_at = null, $updated_at = null) {
        $now = date('c');
        if ($this->use_sqlite) {
            $stmt = $this->db->prepare('INSERT OR REPLACE INTO posts (slug, title, content, created_at, updated_at) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$slug, $title, $content, $created_at ?: $now, $updated_at ?: $now]);
        } else {
            $data = [
                'slug' => $slug,
                'title' => $title,
                'content' => $content,
                'created_at' => $created_at ?: $now,
                'updated_at' => $updated_at ?: $now
            ];
            file_put_contents($this->posts_dir . '/' . $slug . '.json', json_encode($data, JSON_PRETTY_PRINT));
        }
    }

    public function deletePost($slug) {
        if ($this->use_sqlite) {
            $stmt = $this->db->prepare('DELETE FROM posts WHERE slug = ?');
            $stmt->execute([$slug]);
        } else {
            $file = $this->posts_dir . '/' . $slug . '.json';
            if (file_exists($file)) unlink($file);
        }
    }
}
