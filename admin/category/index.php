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
        $action = 'listCategories';
    }
}
switch ($action) {
    case 'listCategories':
        $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
        if ($categoryId == FALSE) {
            $categoryId = 1;
        }
        $currentCategory = getCategory($categoryId);
        $categories = getCategories();
        $products = getProductsByCategory($categoryId);
        include 'category_list.php';
        break;
    case 'deleteCategory':
        $categories = getCategories();
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
        $productCount = count(productsInCategory($categoryId));
        if ($productCount == 0) {
            deleteCategory($categoryId);
            // re-display updated category list
            $categories = getCategories();
            include 'category_list.php';
        } else {
            $errorMessage = 'Category contains products and cannot be deleted';
            include '../../errors/db_error.php';
        }
        break;
    case 'addCategory':
        $categoryName = filter_input(INPUT_POST, 'categoryName');
        if (
            $categoryName == NULL
        ) {
            $error = 'Invalid category data. Check all fields and try again.';
            include '../../errors/error.php';
        } else {
            $categoryId = addCategory($categoryName);
            $categories = getCategories();
            include 'category_list.php';
        }
        break;
    case 'updateCategory':
        $categoryName = filter_input(INPUT_POST, 'categoryName');
        if (
            $categoryName == NULL
        ) {
            $error = 'Invalid product data. Check all fields and try again.';
            include '../../errors/error.php';
        } else {
            $categories = getCategories();
            updateCategory($categoryName);
        }
        include 'category_list.php';
        break;
}
