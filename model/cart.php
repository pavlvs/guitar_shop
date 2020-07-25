<?php
// Create an empty cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// add an item to the cart
function cartAddItem($productId, $quantity) {
    $_SESSION['cart'][$productId] = round($quantity, 0);

    // Set last category added to cart
    $product = getProduct($productId);
    $_SESSION['lastCategoryId'] = $product['categoryId'];
    $_SESSION['lastCategoryName'] = $product['categoryName'];
}

// Update an item in the cart
function cartUpdateItem($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = round($quantity, 0);
    }
}

// Remove an item from the cart
function cartRemoveItem($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// get an array of items for the cart
function cartGetItems() {
    $items = [];
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        // Get product data from db
        $product = getProduct($productId);
        $listPrice = $product['listPrice'];
        $discountPercent = $product['discountPercent'];
        $quantity = intval($quantity);

        // Calculate discount
        $discountAmount = round($listPrice * ($discountPercent / 100.0), 2);
        $unitPrice = $listPrice - $discountAmount;
        $linePrice = round($unitPrice * $quantity, 2);

        // Store the data in items array
        $items[$productId]['name'] = $product['productName'];
        $items[$productId]['description'] = $product['description'];
        $items[$productId]['listPrice'] = $listPrice;
        $items[$productId]['discountPercent'] = $discountPercent;
        $items[$productId]['discountAmount'] = $discountAmount;
        $items[$productId]['unitPrice'] = $unitPrice;
        $items[$productId]['quantity'] = $quantity;
        $items[$productId]['linePrice'] = $linePrice;
    }
    return $items;
}

// Get the number of products in the cart
function cartProductCount() {
    return count($_SESSION['cart']);
}

// Get the number of items in the cart
function cartItemCount() {
    $count = 0;
    $cart = cartGetitems();
    foreach ($cart as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

// Get the subtotal for the cart
function cartSubtotal() {
    $subtotal = 0;
    $cart = cartGetItems();
    foreach ($cart as $item) {
        $subtotal += $item['unitPrice'] * $item['quantity'];
    }
    return $subtotal;
}

// Remove all items from the cart
function clearCart() {
    $_SESSION['cart'] = [];
}

// Set the category for the last item added to the cart
function setLastCategory($categoryId, $categoryName) {
    $_SESSION['lastCategoryId'] = $categoryId;
    $_SESSION['lastCategoryname'] = $categoryName;
}

// Set the product for the last item added to the cart
function setLastProduct($productId, $productName) {
    $_SESSION['lastProductId'] = $productId;
    $_SESSION['lastProductName'] = $productName;
}

// Get the correct word for the number of items
function cartGetItemWord() {
    if (cartProductCount() == 1) {
        $itemWord = 'Item';
    } else {
        $itemWord = 'Items';
    }
    return $itemWord;
}
