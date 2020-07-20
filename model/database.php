<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=my_guitar_shop1;charset=utf8', 'root', 'pr0t3ct3d');
    // echo '<p>You are connected to the database';
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    echo '<p>An error occurred while connecting to the database: ' . $errorMessage . '</p>';
}
