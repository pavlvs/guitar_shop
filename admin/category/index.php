<?php
require_once '../../util/main.php';
require_once '../../util/secure_conn.php';
require_once '../../util/valid_admin';

require_once '../../model/admin_db.php';
require_once '../../model/product_db.php';
require_once '../../model/category_db.php';

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'listCategories';
    }
}
switch ($action) {
    case 'listCategories':
        $categories = getCategories();

        include 'category_list.php';
        break;
    case 'deleteCategory':
        $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);

        deleteCategory($categoryId);

        header("location: .");
        break;
    case 'addCategory':
        $name = filter_input(INPUT_POST, 'name');
        // validate inputs
        if (empty($name)) {
            displayError('You must include a name for this category. Please try again.');
        } else {
            $categoryId = addCategory($name);
        }

        header("Location: .");
        break;
    case 'updateCategory':
        $categoryId = filter_input(INPUT_POST, 'categoryId');
        $name = filter_input(INPUT_POST, 'name');

        // validate inputs
        if (empty($name)) {
            displayError('You must include a name for the category.')
        } else {
            updateCategory($categoryId, $name);
        }
        header("Location: .");
        break;
}
