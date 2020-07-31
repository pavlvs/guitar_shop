<?php

// This function calculates a shipping charge of $5 per item
// but it only charges shipping for the first 5 items
function shippingCost() {
    $itemCount = cartItemCount();
    $itemShipping = 5; // $5 per item
    if ($itemCount > 5) {
        $shippingCost = $itemShipping * 5;
    } else {
        $shippingCost = $itemShipping * $itemCount;
    }
    return $shippingCost;
}

function taxAmount($subtotal) {
    $shippingAdress = getAddress($_SESSION['user']['shipAddressId']);
    $state = $shippingAdress['state'];
    $state = strtoupper($state);
    switch ($state) {
        case 'CA':
            $taxRate = 0.09;
            break;
        default:
            $taxRate = 0;
            break;
    }
    return round($subtotal * $taxRate, 2);
}

function cardName($cardType) {
    switch ($cardType) {
        case 1:
            return 'Mastercard';
        case 2:
            return 'Visa';
        case 3:
            return 'Discover';
        case 4:
            return 'American Express';
        default:
            return 'Unknown Card Type';
    }
}

function addOrder($cardType, $cardNumber, $cardCVV, $cardExpires) {
    global $db;
    $customerId = $_SESSION['user']['customerID'];
    $billingId = $_SESSION['user']['billinrgAddressID'];
    $shippingId = $_SESSION['user']['shipAddressID'];
    $shippingCost = shippingCost();
    $tax = taxAmount(cartSubtotal());
    $orderDate = date("Y-m-d H:i:s");

    $sql = 'INSERT INTO orders (customerID, orderDate, shipAmount, taxAmount, shipAddressID, cardType, cardNumber, cardExpires, billingAddressID)
    VALUES (:customerId, :orderDate, :shipAmount, :taxAmount, :shippingId, :cardType, :cardNumber, :cardExpires, :$billingId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->bindValue(':orderDate', $orderDate);
    $stmt->bindValue(':shipAmount', $shippingCost);
    $stmt->bindValue(':taxAmount', $tax);
    $stmt->bindValue(':shippingId', $shippingId);
    $stmt->bindValue(':cardType', $cardType);
    $stmt->bindValue(':cardNumber', $cardNumber);
    $stmt->bindValue(':cardExpires', $cardExpires);
    $stmt->bindValue(':billingId', $billingId);
    $stmt->execute();
    $orderId = $db->lastInsertId();
    $stmt->closeCursor();
    return $orderId;
}

function addOrderItem($orderId, $productId, $itemPrice, $discount, $quantity) {
    global $db;
    $sql = 'INSERT INTO OrderItems (orderID, productID, itemPrice, discountAmount, quantity)
            VALUES (:orderId, :productId, :itemPrice, :discount, :quantity)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->bindValue(':productId', $productId);
    $stmt->bindValue(':itemPrice', $itemPrice);
    $stmt->bindValue(':discount', $discount);
    $stmt->bindValue(':quantity', $quantity);
    $stmt->execute();
    $stmt->closeCursor();
}

function getOrder($orderId) {
    global $db;
    $sql = 'SELECT *
            FROM orders
            WHERE orderID = :orderId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    $order = $stmt->fetch();
    $stmt->closeCursor();
    return $order;
}

function getOrderItems($orderId) {
    global $db;
    $sql = 'SELECT *
            FROM OrderItems
            WHERE orderID = :orderId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    $orderItems = $stmt->fetchAll();
    $stmt->closeCursor();
    return $orderItems;
}

function getOrdersByCustomerId($customerId) {
    global $db;
    $sql = 'SELECT *
            FROM orders
            WHERE customerID = :customerId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->execute();
    $order = $stmt->fetchAll();
    $stmt->closeCursor();
}

function getUnfilledOrders() {
    global $db;
    $sql = 'SELECT *
            FROM orders
            INNER JOIN customers
            ON customers.customerID = orders.customerID
            WHERE shipDate IS NULL
            ORDER BY orderDate';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
    $stmt->closeCursor();
    return $orders;
}

function getFilledOrders() {
    global $db;
    $sql = 'SELECT *
            FROM orders
            INNER JOIN customers
            ON customers.customerID = orders.customerID
            WHERE shipDate IS NOT NULL
            ORDER BY orderDate';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll();
    $stmt->closeCursor();
    return $orders;
}

function setShipDate($orderId) {
    global $db;
    $shipDate = date('Y-m-d H:i:s');
    $sql = 'UPDATE orders
            SET shipDate = :shipDate
            WHERE orderID = :orderId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':shipDate', $shipDate);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    $stmt->closeCursor();
}

function deleteOrder($orderId) {
    global $db;
    $sql = 'DELETE
            FROM orders
            WHERE orderID = :orderid';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    $stmt->closeCursor();
}
