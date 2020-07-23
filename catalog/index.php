<?php
require_once '../util/main.php';
require_once '../util/tags.php';
require_once '../model/database.php';
require_once '../model/product_db.php';
require_once '../model/category_db.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'listProducts';
    }
}

switch ($action) {
    case 'listProducts':
        // get current category
        $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
        if ($categoryId == NULL || $categoryId === FALSE) {
            $categoryId = 1;
        }
        // get categories and products
        $currentCategory = getCategory($categoryId);
        $categories = getCategories();
        $products = getProductsByCategory($categoryId);

        // display view
        include 'product_list.php';
        break;
    case 'viewProduct':
        $categories = getCategories();

        // get product data
        $productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT);
        $product = getProduct($productId);

        // display product
        include 'product_view.php';
        break;
}
