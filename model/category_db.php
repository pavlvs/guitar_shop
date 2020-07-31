<?php
function getCategories() {
    global $db;
    $sql    = 'SELECT *,
                    (SELECT COUNT(*)
                    FROM products
                    WHERE Products.categoryID = Categories.categoryID)
                    AS productCount
               FROM categories
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
    $sql = 'SELECT *
            FROM categories
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

function addCategory($name) {
    global $db;
    $sql = 'INSERT
            INTO categories (categoryName)
            VALUES (:name)';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
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
        $stmt->closeCursor();
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function updateCategory($categoryId, $name) {
    global $db;
    $sql = 'UPDATE categories
            SET categoryName = :name
            WHERE categoryID = :categoryId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->execute();
        $stmt->closeCursor();
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}
