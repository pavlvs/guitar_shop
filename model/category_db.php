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

function addCategory($categoryName) {
    global $db;
    $sql = 'INSERT
            INTO categories (categoryName)
            VALUES (:categoryName)';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryName', $categoryName);
        $stmt->execute();
        $stmt->closeCursor();

        // get the last product id that was automatically generated
        $categoryId = $db->lastInsertId();
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function deleteCategory($categoryId) {
    global $db;
    $sql = 'DELETE FROM categories
            WHERE categoryID = :categoryId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId);
        $rowCount = $stmt->execute();
        $stmt->closeCursor();
        return $rowCount;
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function updateCategory() {
}

function productsInCategory($categoryId) {
    global $db;
    $sql = 'SELECT productId
            FROM products
            WHERE categoryID = :categoryId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}
