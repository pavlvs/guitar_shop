<?php
function addAdmin($email, $password) {
    global $db;
    $password = sha1($email . $password);
    $sql = 'INSERT INTO administrators (emailAddress, password)
            VALUES (:email, :password)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $stmt->closeCursor();
}

function isValidAdminLogin($email, $password) {
    global $db;
    $sql = 'SELECT adminID
            FROM administrators
            WHERE emailAddress = :email
            AND `password` = :password';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $valid = ($stmt->rowCount() == 1);
    $stmt->closeCursor();
    return $valid;
}
