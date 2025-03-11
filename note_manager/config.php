<?php
$host = 'localhost';
$dbname = 'note_manager';
$username = 'root';
$password = '4289';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Errore di connessione: " . $e->getMessage();
    die();
}
?>
