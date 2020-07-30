<?php
require_once '../../util/main.php';
require_once '../../util/secure_conn.php';
require_once '../../util/valid_admin.php';
require_once '../../util/images.php';
require_once '../../model/product_db.php';
require_once '../../model/category_db.php';

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'listProducts';
    }
}

switch ($action) {
    case 'listProducts':
        $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
        if (empty($categoryId)) {
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
        $productOrderCount = getProductOrderCount($productId);
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

        // validate inputs
        if (
            empty($code) ||
            empty($name) ||
            empty($description) ||
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
            empty($code) ||
            empty($name) ||
            empty($description) ||
            $price === FALSE  ||
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
    case 'uploadImage':
        $productId = filter_input(INPUT_POST, 'productId');
        $product = getProduct($productId);
        $productCode = $product['productCode'];

        $imageFilename = $productCode . '.png';
        $imageDir = $docRoot . $appPath . 'images';

        if (isset($_FILES['file1'])) {
            $source = $_FILES['file1']['tmp_name'];
            $target = $imageDir . DIRECTORY_SEPARATOR . $imageFilename;

            // save uploaded file with correct fileName
            move_uploaded_file($source, $target);

            // add code that creates the medium and small versions of the image
            processImage($imageDir, $imageFilename);

            // display product with new image
            include 'product_view.php';
        }
        break;
}
