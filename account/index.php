<?php
require_once '../util/main.php';
require_once '../util/secure_conn.php';

require_once 'model/customer_db.php';
require_once 'model/address_db.php';
require_once 'model/order_db.php';
require_once 'model/product_db.php';

require_once 'model/fields.php';
require_once 'model/validate.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'view_login';
        if (isset($_SESSION['user'])) {
            $action = 'view_account';
        }
    }
}

// set up all possible fields to validate
$validate = new Validate();
$fields = $validate->getFields();

// for the Registration page and other pages
$fields->addField('email', 'Must be valid email');
$fields->addField('password1');
$fields->addField('password2');
$fields->addField('firstName');
$fields->addField('lastName');
$fields->addField('shipline1');
$fields->addField('shipLine2');
$fields->addField('shipCity');
$fields->addField('shipState');
$fields->addField('shipZip');
$fields->addField('shipPhone');
$fields->addField('billLine1');
$fields->addField('billLine2');
$fields->addField('billCity');
$fields->addField('billState');
$fields->addField('billZip');
$fields->addField('billPhone');

// for the login page
$fields->addField('password');

// for the Edit address page
$fields->addField('line1');
$fields->addField('line2');
$fields->addField('city');
$fields->addField('state');
$fields->addField('zip');
$fields->addField('phone');

switch ($action) {
    case 'view_register':
        // Clear user data
        $email = '';
        $firstName = '';
        $lastName = '';
        $shipline1 = '';
        $shipline2 = '';
        $shipCity = '';
        $shipState = '';
        $shipZip = '';
        $shipPhone = '';

        include 'account_register.php';
        break;
    case 'register':
        // Store user data in local variabls
        $email = filter_input(INPUT_POST, 'email');
        $password1 = filter_input(INPUT_POST, 'password1');
        $password2 = filter_input(INPUT_POST, 'password2');
        $firstname = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $shipLine1 = filter_input(INPUT_POST, 'shipLine1');
        $shipLine2 = filter_input(INPUT_POST, 'shipLine2');
        $shipCity = filter_input(INPUT_POST, 'shipCity');
        $shipState = filter_input(INPUT_POST, 'shipState');
        $shipZip = filter_input(INPUT_POST, 'shipZip');
        $shipPhone = filter_input(INPUT_POST, 'shipPhone');
        $useShipping = filter_input(INPUT_POST, 'useShipping');
        $billLine1 = filter_input(INPUT_POST, 'billLine1');
        $billLine2 = filter_input(INPUT_POST, 'billLine2');
        $billCity = filter_input(INPUT_POST, 'billCity');
        $billState = filter_input(INPUT_POST, 'billState');
        $billZip = filter_input(INPUT_POST, 'billZip');
        $billPhone = filter_input(INPUT_POST, 'billPhone');

        // Validate user data
        $validate->email('email', $email);
        $validate->text('password1', $password1, true, 6, 30);
        $validate->text('password2', $password2, true, 6, 30);
        $validate->text('firstName', $firstName);
        $validate->text('lastName', $lastName);
        $validate->text('shipLine1', $shipLine1);
        $validate->text('shipLine2', $shipLine2, false);
        $validate->text('shipCity', $shipCity);
        $validate->text('shipState', $shipState);
        $validate->text('shipZip', $shipZip);
        $validate->text('shipPhone', $shipPhone, false);
        if (!$useShipping) {
            $validate->text('billLine1', $billLine1);
            $validate->text('billLine2', $billLine2, false);
            $validate->text('billCity', $billCity);
            $validate->text('billState', $billState);
            $validate->text('billZip', $billZip);
            $validate->text('billPhone', $billPhone, false);
        }

        // if necessary, clear billing address data
        if ($useShipping) {
            $billLine1 = '';
            $billLine2 = '';
            $billCity = '';
            $billState = '';
            $billZip = '';
            $billPhone = '';
        }

        //if validation errors, redisplay Register page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_register.php';
            break;
        }
        // add the customer data to the database
        $customerId = addCustomer($email, $firstName, $lastName, $password1);

        // add the shipping address
        $shippingId = addAddress($customerId, $shipLine1, $shipLine2, $shipCity, $shipState, $shipZip, $shipPhone);
        customerChangeShippingId($customerId, $billingId);

        //Add the billing address
        if ($useShipping) {
            $billingId = addAddress($customerId, $shipLine1, $shipLine2, $shipCity, $shipState, $shipZip, $shipPhone);
        } else {
            $billingId = addAddress($customerId, $billLine1, $billLine2, $billCity, $billState, $billZip, $billPhone);
        }
        customerChangeBillingId($customerId, $billingId);

        // store user data in session
        $_SESSION['user'] = getCustomer($customerId);

        // redirect to the checkout application if necessary
        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }
        break;
    case 'view_login':
        // clear login data
        $email = '';
        $password = '';
        $passwordMessage = '';

        include 'account_login_register.php';
        break;
    case 'login':
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        // validate user data
        $validate->email('email', $email);
        $validate->text('password', $password, true, 6, 30);

        // if validation errors, redisplay login page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_login_register.php';
            break;
        }

        // check email and password in database
        if (isValidCustomerLogin($email, $password)) {
            $_SESSION['user'] = getCustomerByEmail($email);
        } else {
            $passwordMessage = 'Login failed. Invalid email or password.';
            include 'account/account_login_register.php';
            break;
        }

        // If necessary, redirect to the checkout app
        // Redirect to the checkout application

        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }
        break;
    case 'viewAccount':
        $customerName = $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName'];
        $email = $_SESSION['user']['emailAddress'];

        $shippingAddress = getAddress($_SESSION['user']['shipAddressId']);
        $billingAddress = getAddress($_SESSION['user']['billingAddressId']);

        $orders = getOrdersByCustomerId($_SESSION['user']['customerId']);
        if (!isset($orders)) {
            $orders = [];
        }
        include 'account_view.php';
        break;
    case 'viewOrder':
        $orderId = filter_input(INPUT_GET, 'orderId', FILTER_VALIDATE_INT);
        $order = getOrder($orderId);
        $orderDate = strtotime($order['orderDate']);
        $orderDate = date('M j Y', $orderDate);
        $orderitems = getOrderItems($orderId);

        $shippingAddress = getAddress($order['shipAddressId']);
        $billingAddress = getAddress($order['billingAddressId']);

        include 'account_view_order.php';
        break;
    case 'viewAccountEdit':
        $email = $_SESSION['user']['emailAddress'];
        $firstName = $_SESSION['user']['firstName'];
        $lastName = $_SESSION['user']['lastName'];
        $shippingId = $_SESSION['user']['shipAddressId'];
        $billingId = $_SESSION['user']['billingAddressId'];

        $passwordMessage = '';

        include 'account_edit.php';
        break;
    case 'updateAccount':
        // get the customer data
        $customerId = $_SESSION['customerID'];
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $password1 = filter_input(INPUT_POST, 'password1');
        $password2 = filter_input(INPUT_POST, 'password2');
        $passwordMessage = '';

        // Get the old data for the customer
        $oldCustomer = getCustomer($customerId);

        // Validate user data
        $validate->email('email', $email);
        $validate->text('password1', $password1, false, 6, 30);
        $validate->text('password2', $password2, false, 6, 30);
        $validate->text('firstName', $firstName);
        $validate->text('lastName', $lastName);

        //check email change and display message if necessary
        if ($email != $oldCustomer['emailAddress']) {
            displayError('You can\'t change the email address for an account');
        }

        // if validation errors, redisplay Login page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_edit.php';
            break;
        }

        // Only validate the passwords if they are not  empty
        if (!empty($password1) && !empty($password2)) {
            if ($password1 !== $password2) {
                $passwordMessage = 'Passwords do not match';
                include 'account/account_edit.php';
                break;
            }
        }

        // update the customer data
        $updateCustomer($customerId, $email, $firstName, $lastName, $password1, $password2);

        // set the new customer data in the session
        $_SESSION['user'] = getCustomer($customerId);

        redirect('.');
        break;
    case 'viewAddressEdit':
        // set the variables for address type
        $addressType = filter_input(INPUT_POST, 'addressType');
        if ($addressType == 'billing') {
            $addressId = $_SESSION['user']['billingAddressId'];
            $heading = 'Update Billing Address';
        } else {
            $addressId = $_SESSION['user']['shipAddressId'];
            $heading = 'Update Shipping Address';
        }

        // Get the data for the address
        $address = getAddress($addressId);
        $line1 = $address['line1'];
        $line2 = $address['line2'];
        $city = $address['$city'];
        $state = $address['s$tate'];
        $zip = $address['zip'];
        $phone = $address['phone'];

        // Display the data on the page
        include 'address_edit.php';
        break;
    case 'updateAddress':
        $customerId = $_SESSION['user']['customerId'];

        // set up variables for address type
        $addressType = filter_input(INPUT_POST, 'addressType');
        if ($addressType == 'billing') {
            $addressId = $_SESSION['user']['billingAddressId'];
            $heading = 'Update Billing Address';
        } else {
            $addressId = $_SESSION['user']['shipAddressId'];
            $heading = 'Update Shipping Address';
        }

        // Get the data for the address
        $line1 = $address['line1'];
        $line2 = $address['line2'];
        $city = $address['$city'];
        $state = $address['s$tate'];
        $zip = $address['zip'];
        $phone = $address['phone'];

        // Validate the data
        $validate->text('line1', $line1);
        $validate->text('line2', $line2, false);
        $validate->text('city', $city);
        $validate->text('state', $state);
        $validate->text('zip', $zip);
        $validate->text('phone', $phone, false);

        // if validation errors, redisplay login page and exit controller
        if ($fields->hasErrors()) {
            include 'account/address_edit.php';
            break;
        }

        // if the old address has orders disable it. Otherwise delete it
        disableOrDeleteAddress($addressId);

        // add the new address
        $addressID = addAddress($customerId, $line1, $line2, $city, $state, $zip, $phone);

        // Relate the address to the customer account
        if ($address == 'billing') {
            customerChangeBillingId($customerId, $addressId);
        } else {
            customerChangeShippingId($customerId, $addressId);
        }

        // set the user data in the session
        $_SESSION['user'] = getCustomer($customerId);

        redirect('.');
        break;
    case 'logout':
        unset($_SESSION['user']);
        redirect('.');
        break;
    default:
        displayError("Unknown account action: " . $action);
        break;
}
