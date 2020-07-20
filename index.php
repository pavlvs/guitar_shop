<?php
require 'model/database.php';
require 'model/product_db.php';
require 'model/category_db.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listProducts';
}

if ($action == 'listProducts') {
    // Get the current category Id
    $categoryId = $_GET['categoryId'];
    if (!isset($categoryId)) {
        $categoryId = 1;
    }

    // Get the product and category data
    $categoryName = getCategoryName($categoryId);
    $categories = getCategories();
    $products = getProductsByCategory($categoryId);

    // Display the products list
    include 'product_list.php';
} else if ($action == 'deleteProduct') {
    // Get the IDs and delete the product
    $productId = $_POST['productId'];
    $categoryId = $_POST['categoryId'];
    deleteProduct($productId);

    // Display the Product List page for the current category
    header('location: .?categoryId=$categoryId');
} else if ($action == 'showAddForm') {
    $categories = getCategories();
    include 'product_add.php';
} else if ($action == 'addProduct') {
    $categoryId = $_POST['categoryId'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if (empty($code) || empty($Name) || empty($price)) {
        $error = 'Invalid product data. Check all fields and try again.';
        include 'error.php';
    } else {
        addProduct($categoryId, $code, $name, $price);

        // Display the Product List page for the current category
    }
}
