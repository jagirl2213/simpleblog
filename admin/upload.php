<?php
// admin/upload.php - Media upload handler
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit('Forbidden');
}
$upload_dir = __DIR__ . '/../storage/media/';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    $file = $_FILES['media'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowed)) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = uniqid('img_', true) . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $upload_dir . $name);
        $url = '/storage/media/' . $name;
    } else {
        $error = 'Invalid file or upload error.';
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media</title>
    <link rel="stylesheet" href="/themes/default/style.css">
</head>
<body>
    <main>
        <h1>Upload Media</h1>
        <?php if (!empty($error)): ?><p style="color:red;"><?=$error?></p><?php endif; ?>
        <?php if (!empty($url)): ?><p>Uploaded: <a href="<?=$url?>" target="_blank">View File</a></p><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="media" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
        <a href="/admin">Back to Dashboard</a>
    </main>
</body>
</html>
