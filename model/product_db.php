<?php
function getProductsByCategory($categoryId) {
    global $db;
    $sql = 'SELECT * FROM products
            WHERE categoryID = ' . $categoryId . ' ORDER BY productID';
    $result = $db->query($sql);
    return $result;
}

function getProduct($productId) {
    global $db;
    $sql = 'SELECT * FROM products
            WHERE productID =' . $productId;
    $result = $db->query($sql);
    $product = $result->fetch();
    return $product;
}

function deleteProduct($productId) {
    global $db;
    $sql = 'DELETE FROM products
            WHERE productID =' . $productId;
    $db->exec($sql);
}

function addProduct($categoryId, $code, $name, $price) {
    global $db;
    $sql = 'INSERT INTO products
            (categoryID, productCode, productName, listPrice)
             VALUES ("$categoryId", "$code", "$name", "$price")';
    $db->exec($sql);
}
