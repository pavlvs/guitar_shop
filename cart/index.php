<?php
require_once '../util/main.php';
require_once '../util/validation.php';
require_once '../model/cart.php';
require_once '../model/product_db.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'view';
    }
}

switch ($action) {
    case 'view':
        $cart = cartGetItems();
        break;
    case 'add':
        $productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_GET, 'quantity');

        // validate the quantity entry
        if ($quantity == NULL) {
            displayError('You must enter a quantity.');
        } elseif (!isValidNumber($quantity, 1)) {
            displayError('Quantity must be 1 or more.');
        }

        cartAddItem($productId, $quantity);
        $cart = cartGetItems();
        break;
    case 'update':
        $items = filter_input(INPUT_POST, 'items', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        foreach ($items as $productId => $quantity) {
            if ($quantity == 0) {
                cartRemoveItem($productId);
            } else {
                cartUpdateItem($productId, $quantity);
            }
        }
        $cart = cartGetItems();
        break;
    default:
        displayError('Unknown cart action: ' . $action);
        break;
}

include './cart_view.php';
