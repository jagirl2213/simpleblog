<?php
// core/pages.php - Static page management
class Pages {
    private $pages_dir;
    public function __construct() {
        $this->pages_dir = __DIR__ . '/../storage/pages';
        if (!is_dir($this->pages_dir)) {
            mkdir($this->pages_dir, 0777, true);
        }
    }
    public function getPages() {
        $pages = [];
        foreach (glob($this->pages_dir . '/*.json') as $file) {
            $pages[] = json_decode(file_get_contents($file), true);
        }
        return $pages;
    }
    public function getPage($slug) {
        $file = $this->pages_dir . '/' . $slug . '.json';
        return file_exists($file) ? json_decode(file_get_contents($file), true) : null;
    }
    public function savePage($slug, $title, $content) {
        $data = [
            'slug' => $slug,
            'title' => $title,
            'content' => $content
        ];
        file_put_contents($this->pages_dir . '/' . $slug . '.json', json_encode($data, JSON_PRETTY_PRINT));
    }
    public function deletePage($slug) {
        $file = $this->pages_dir . '/' . $slug . '.json';
        if (file_exists($file)) unlink($file);
    }
}
