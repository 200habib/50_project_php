<?php
// Note: The MySQL extension is deprecated as of PHP 5.5.0
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '4289');
define('DB_NAME', 'blog_db');

// Application configuration
define('SITE_NAME', 'My Blog');
define('BASE_URL', 'http://localhost/blog_post');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
?>
