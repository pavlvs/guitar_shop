<?php
function getCategories() {
    global $db;
    $sql    = 'SELECT * FROM categories ORDER BY categoryID';
    $result = $db->query($sql);
    return $result;
}

function getCategoryName($categoryId) {
    global $db;
    $sql = 'SELECT * FROM categories WHERE categoryID = ' . $categoryId;
    $result = $db->query($sql);
    $category = $result->fetch();
    $categoryName = $category['categoryName'];
    return $categoryName;
}
