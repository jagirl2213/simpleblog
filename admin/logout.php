<?php
// admin/logout.php - Log out and destroy session
session_start();
session_destroy();
header('Location: /admin/login.php');
exit;
