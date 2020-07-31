<?php
function addAdmin($email, $firstName, $lastName, $password1) {
    global $db;
    $password = sha1($email . $password1);
    $sql = 'INSERT INTO administrators (emailAddress, password, firstName, lastName)
            VALUES (:email, :password, :firstName, :lastName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->execute();
    $adminId = $db->lastInsertId();
    $stmt->closeCursor();
    return $adminId;
}

function isValidAdminLogin($email, $password) {
    global $db;
    $password = sha1($email, $password);
    $sql = 'SELECT *
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

function admincount() {
    global $db;
    $sql = 'SELECT COUNT(*) AS adminCount FROM administrators';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $stmt->closeCursor();
    return $result['adminCount'];
}

function getAllAdmins() {
    global $db;
    $sql = 'SELECT * FROM administrators ORDER BY lastName, firstName';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $admins = $stmt->fetchAll();
    $stmt->closeCursor();
    return $admins;
}

function getAdmin($adminId) {
    global $db;
    $sql = 'SELECT * FROM administrators WHERE adminID = :adminId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':adminId', $adminId);
    $stmt->execute();
    $admin = $stmt->fetch();
    $stmt->closeCursor();
    return $admin;
}

function getAdminByEmail($email) {
    global $db;
    $sql = 'SELECT * FROM administrators WHERE emailAddress = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch();
    $stmt->closeCursor();
    return $admin;
}

function isValidAdminEmail($email) {
    global $db;
    $sql = 'SELECT * FROM administrators WHERE emailAddress = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $valid = ($stmt->rowCount() == 1);
    $stmt->closeCursor();
    return $valid;
}

function updateAdmin($adminId, $email, $firstName, $lastName, $password1, $password2) {
    global $db;
    $sql = 'UPDATE administrators
            SET emailAddress = :email,
                firstName    = :firstName,
                lastName     = :lastName,
            WHERE adminID    = :adminId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->bindValue(':adminId', $adminId);
    $stmt->execute();
    $stmt->closeCursor();

    if (!empty($password1) && !empty($password2)) {
        if ($password1 !== $password2) {
            displayError('Passwords do not match.');
        } elseif (strlen($password1 < 6)) {
            displayError('Password must be at least six characters');
        }
        $password = sha1($email . $password1);
        $sql = 'UPDATE administrators
                SET password = :password
                WHERE adminID = :adminId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':adminId', $adminId);
        $stmt->execute();
        $stmt->closeCursor();
    }
}

function deleteAdmin($adminId) {
    global $db;
    $sql = 'DELETE FROM administrators WHERE adminID = :adminId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':adminid', $adminId);
    $stmt->execute();
    $stmt->closeCursor();
}
