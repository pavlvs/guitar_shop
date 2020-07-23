<?php
function getCategories() {
    global $db;
    $sql    = 'SELECT * FROM categories
               ORDER BY categoryID';
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    } catch (PDOException $e) {
        displayDBError($e->getMessage());
    }
}

function getCategory($categoryId) {
    global $db;
    $sql = 'SELECT * FROM categories
            WHERE categoryID = :categoryId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    } catch (PDOException $e) {
        displayDBError($e->getMessage());
    }
}
