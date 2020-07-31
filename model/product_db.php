<?php
function getProductsByCategory($categoryId) {
    global $db;
    $sql = 'SELECT *
            FROM products p
            INNER JOIN categories c
            ON p.categoryID = c.categoryID
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

function getProductOrderCount($productId) {
    global $db;
    $sql = 'SELECT COUNT(*)
            AS orderCount
            FROM orderitems
            WHERE  productID = :productId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':productId', $productId);
        $stmt->execute();
        $product = $stmt->fetch();
        $orderCount = $product['orderCount'];
        $stmt->closeCursor();
        return $orderCount;
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function getProduct($productId) {
    global $db;
    $sql = 'SELECT *
            FROM products p
            INNER JOIN categories c
            ON p.categoryID = c.categoryID
            WHERE productID = :productId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':productId', $productId);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function addProduct($categoryId, $code, $name, $description, $price, $discountPercent) {
    global $db;
    $sql = 'INSERT
            INTO products
            (categoryID, productCode, productName, description, listPrice, discountPercent, dateAdded)
             VALUES (:categoryId, :code, :name, :description, :price, :discountPercent, NOW())';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':discountPercent', $discountPercent);
        $stmt->execute();
        $stmt->closeCursor();

        // get the last product id that was automatically generated
        $productId = $db->lastInsertId();
        return $productId;
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}

function updateProduct($productId, $code, $name, $description, $price, $discountPercent, $categoryId) {
    global $db;
    $sql = 'UPDATE products
            SET productName     = :name,
                productCode     = :code,
                description     = :desc,
                listPrice       = :price,
                discountPercent = :discount,
                categoryId      = :categoryId
            WHERE productID= :productId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':desc', $description);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':discount', $discountPercent);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->bindValue(':productId', $productId);
        $stmt->closeCursor();
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}
function deleteProduct($productId) {
    global $db;
    $sql = 'DELETE
            FROM products
            WHERE productID = :productId';
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':productId', $productId);
        $stmt->execute();
        $stmt->closeCursor();
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        displayDBError($errorMessage);
    }
}
