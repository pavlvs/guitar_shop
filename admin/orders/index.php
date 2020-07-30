<?php
require_once '../../util/main.php';
require_once '../../util/secureu_conn.php';
require_once '../../util/valid_admin.php';
require_once '../../model/customer_db.php';
require_once '../../model/address_db';
require_once '../../model/order_db';
require_once '../../model/product_db';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'viewOrders';
    }
}

switch ($action) {
    case 'vieOrders':
        $newOrders = getUnfilledOrders();
        $oldOrders = getFilledOrders();
        include 'orders.php';
        break;
    case 'viewOrder':
        $orderId = filter_input(INPUT_GET, 'orderId', FILTER_VALIDATE_INT);

        // Get order date
        $order = getOrder($orderId);
        $orderDate = date('M j, Y', strtotime($order['$orderDate']));
        $orderItems = getOrderItems($orderId);

        // Get customer data
        $customer = getCustomer($order['customerId']);
        $name = $customer['firstName'] . ' ' . $customer['lastName'];
        $email = $customer['emailAddress'];
        $cardNumber = $customer['cardNumber'];
        $cardExpires = $customer['cardExpires'];
        $cardName = $customer['cardType'];

        $shippingAddress = getAddress($order['shipAddressId']);
        $shipLine1  = $shippingAddress['line1'];
        $shipLine2  = $shippingAddress['line2'];
        $shipCity  = $shippingAddress['city'];
        $shipState  = $shippingAddress['state'];
        $shipZip  = $shippingAddress['zipCode'];
        $shipPhone  = $shippingAddress['phone'];

        $billingAddress = getAddress($order['billingAddressId']);
        $billLine1  = $billingAddress['line1'];
        $billLine2  = $billingAddress['line2'];
        $billCity  = $billingAddress['city'];
        $billState  = $billingAddress['state'];
        $billZip  = $billingAddress['zipCode'];
        $billPhone  = $billingAddress['phone'];

        include 'order.php';
        break;
    case 'setShipDate':
        $orderId = filter_input(INPUT_POST, 'orderId', FILTER_VALIDATE_INT);
        setShipDate($orderId);
        $url = '?action=viewOrder&orderId=' . $orderId;
        redirect($url);
    case 'confirmDelete':
        // Get order data
        $orderId = filter_input(INPUT_POST, 'orderId', FILTER_VALIDATE_INT);
        $order = getOrder($orderId);
        $orderDate = date('M j, Y', strtotime($order['$orderDate']));

        // Get customer data
        $customer = getCustomer($order['customerId']);
        $customerName = $customer['lastName'] . ' ' . $customer['firstName'];
        $email = $customer['emailAddress'];

        include 'confirm_delete.php';
        break;
    case 'delete':
        $orderId = filter_input(INPUT_POST, 'orderId', FILTER_VALIDATE_INT);
        deleteOrder($orderId);
        redirect('.');
        break;
    default:
        displayError('Unknown order action' . $action);
        break;
}
