<?php
require_once '../../util/main.php';
require_once '../../util/tags.php';
require_once '../../model/database.php';
require_once '../../model/product_db.php';
require_once '../../model/category_db.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'listProducts';
    }
}

switch ($action) {
    case 'listProducts':
        $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
        if ($categoryId == FALSE) {
            $categoryId = 1;
        }
        $currentCategory = getCategory($categoryId);
        $categories = getCategories();
        $products = getProductsByCategory($categoryId);
        include 'product_list.php';
        break;
    case 'viewProduct':
        $categories = getCategories();
        $productId = filter_input(INPUT_GET,  'productId', FILTER_VALIDATE_INT);
        $product = getProduct($productId);
        include 'product_view.php';
        break;
    case 'deleteProduct':
        $productId = filter_input(INPUT_POST,  'productId', FILTER_VALIDATE_INT);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
        deleteProduct($productId);

        // display product list for the current category
        header("Location: .?categoryId=$categoryId");
        break;
    case 'showAddEditForm':
        $productId = filter_input(INPUT_GET,  'productId', FILTER_VALIDATE_INT);
        if ($productId == NULL) {
            $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
        }
        $product = getProduct($productId);
        $categories = getCategories();
        include 'product_add_edit.php';
        break;
    case 'addProduct':
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $discountPercent = filter_input(INPUT_POST, 'discountPercent');

        if (
            $categoryId === FALSE ||
            $code == NULL ||
            $name == NULL ||
            $description == NULL ||
            $price === FALSE  ||
            $discountPercent === FALSE
        ) {
            $error = 'Invalid product data. Check all fields and try again.';
            include '../../errors/error.php';
        } else {
            $categories = getCategories();
            $productId = addProduct($categoryId, $code, $name, $description, $price, $discountPercent);
            $product = getProduct($productId);
            include 'product_view.php';
        }
        break;
    case 'updateProduct':
        $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $discountPercent = filter_input(INPUT_POST, 'discountPercent');

        if (
            $productId === FALSE ||
            $categoryId === FALSE ||
            $code == NULL ||
            $name == NULL ||
            $description == NULL ||
            $price === FALSE ||
            $discountPercent === FALSE
        ) {
            $error = 'Invalid product data. Check all fields and try again.';
            include '../../errors/error.php';
        } else {
            $categories = getCategories();
            updateProduct($productId, $code, $name, $description, $price, $discountPercent, $categoryId);
            $product = getProduct($productIds);
            include 'product_view.php';
        }
        break;
}
