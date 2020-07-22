<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=my_guitar_shop1;charset=utf8', 'mgs_user', 'pa55word');
    // echo '<p>You are connected to the database';
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    include 'database_error.php';
    exit();
}
