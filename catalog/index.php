<?php
require_once '../util/main.php';
require_once '../model/product_db.php';
require_once '../model/category_db.php';

$categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
$productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action');
if ($categoryId !== null) {
    $action = 'category';
} elseif ($productId !== null) {
    $action = 'product';
} else {
    $action = '';
}

switch ($action) {
    case 'category':
        // get category data
        $category = getCategory($categoryId);
        $categoryName = $category['categoryName'];
        $products = getProductsByCategory($categoryId);

        // display category
        include './category_view.php';
        break;
    case 'product':
        // get product data
        $product = getProduct($productId);

        // display product
        include 'product_view.php';
        break;
    default:
        $error = 'Unknown catalog action: ' . $action;
        include 'errors/error.php';
        break;
}
