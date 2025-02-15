<?php
// db.php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'compta_db';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>