<?php
require_once '../util/main.php';
require_once '../util/secure_conn.php';
require_once '../util/validation.php';

require_once '../model/cart.php';
require_once '../model/product_db.php';
require_once '../model/order_db.php';
require_once '../model/customer_db.php';
require_once '../model/address_db.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['checkout'] = true;
    redirect('../account');
    exit();
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'confirm';
    }
}

switch ($action) {
    case 'confirm':
        $cart = cartGetItems();
        if (cartProductCount() == 0) {
            redirect('../cart/');
        }
        $subtotal = cartSubtotal();
        $itemCount = cartItemCount();
        $itemShipping = 0;
        $shippingCost = shippingCost();
        $shippingAddress = getAddress($_SESSION['user']['shipAddressID']);
        $state = $shippingAddress['state'];
        $tax = taxAmount($subtotal);
        $total = $subtotal + $tax + $shippingCost;
        include 'checkout_confirm.php';
        break;
    case 'payment':
        if (cartProductCount() == 0) {
            redirect($appPath . 'cart');
        }
        $cardNumber = '';
        $cardCVV = '';
        $cardExpires = '';

        $ccNumberMessage = '';
        $ccCCVMessage = '';
        $ccExpirationmessage = '';

        $billingAddress = getAddress($_SESSION['user']['billingAddressID']);
        include 'checkout_payment.php';
        break;
    case 'process':
        if (cartProductCount() == 0) {
            redirect('Location: ' . $appPath . 'cart');
        }
        $cart = cartGetItems();
        $cartType = filter_input(INPUT_POST, 'cardType', FILTER_VALIDATE_INT);
        $cardNumber = filter_input(INPUT_POST, 'cardNumber');
        $cardCVV = filter_input(INPUT_POST, 'cardCVV');
        $cardExpires = filter_input(INPUT_POST, 'cardExpires');

        $billingAddress = getAddress($_SESSION['user']['billingAddressID']);

        // Validate card date
        // Note: this uses functions from the util/validation.php file
        if ($cardType === false) {
            displayError('Card type is required');
        } elseif (!isValidCardType($cardType)) {
            displayError('Card type: ' . $cardType . ' is invalid.');
        }

        $ccNumberMessage = '';
        if ($cardNumber == NULL) {
            $ccNumberMessage = 'Required';
        } elseif (!isValidCardNumber($cardNumber, $cardType)) {
            $ccNumberMessage = 'Invalid';
        }

        $ccCCVMessage = '';
        if ($cardCVV == NULL) {
            $ccCCVMessage = 'Required';
        } elseif (!isValidCardCVV($cardCVV, $cardType)) {
            $ccCCVMessage = 'Invalid';
        }

        $ccExpirationMessage = '';
        if ($cardExpires == NULL) {
            $ccExpirationMessage = 'Required';
        } elseif (!isValidCardExpires($cardExpires)) {
            $ccExpirationMessage = 'Invalid';
        }

        // if error messages are not empty, redisplay Checkout page and exit controller
        if (
            !empty($ccNumberMessage) ||
            !empty($ccCCVMessage) ||
            !empty($ccExpirationMessage)
        ) {
            include 'checkout/checkout_payment.php';
            break;
        }
        $orderId = addOrder($cardType, $cardNumber, $cardCVV, $cardExpires);

        foreach ($cart as $$productId => $item) {
            $itemPrice = $item['listPrice'];
            $discount = $item['discountAmount'];
            $quantity = $item['$quantity'];
            addOrderItem($orderId, $productId, $itemPrice, $discount, $quantity);
        }
        clearCart();
        redirect('../account?action=viewOrder&orderId=' . $orderId);
        break;
    default:
        displayError('Unknonw action: ' . $action);
        break;
}
