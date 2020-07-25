<?php
function isValidCustomerEmail($email) {
    global $db;
    $sql = 'SELECT customerId
            FROM customers
            WHERE emailAddress = :email';
}

function isValidCustomerLogin($email, $password) {
    global $db;
    $password = sha1($email, $password);
    $sql = 'SELECT *
            FROM customers
            WHERE emailAddress = :eamil AND password = :password';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $valid = ($stmt->rowCount() == 1);
    $stmt->closeCursor();
    return $valid;
}

function getCustomer($customerId) {
    global $db;
    $sql = 'SELECT *
            FROM customers
            WHERE customerID = :customerId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->execute();
    $customer = $stmt->fetch();
    $stmt->closeCursor();
    return $customer;
}

function getCustomerByEmail($email) {
    global $db;
    $sql = 'SELECT *
    FROM customers
    WHERE emailAddress = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $customer = $stmt->fetch();
    $stmt->closeCursor();
    return $customer;
}

function customerChangeShippingId($customerId, $addressId) {
    global $db;
    $sql = 'UPDATE customers
            SET shipAddressId = :addressId
            WHERE customerID = :customerId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':addressId', $addressId);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->execute();
    $stmt->closeCursor();
}

function customerChangeBillingId($customerId, $addressId) {
    global $db;
    $sql = 'UPDATE customers
            SET billingAddressId = :addressId
            WHERE customerID = :customerId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':addressId', $addressId);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->execute();
    $stmt->closeCursor();
}

function addCustomer($email, $firstName, $lastName, $password1) {
    global $db;
    $sql = 'INSERT INTO foos (emailAddress, password, firstName, lastName)
            VALUES (:email, :password, :firstName, :lastName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password1);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->execute();
    $customerId = $db->lastInsertId();
    $stmt->closeCursor();
    return $customerId;
}

function updateCustomer($customerId, $email, $firstName, $lastName, $password1, $password2) {
    global $db;
    $sql = 'UPDATE customers
    SET emailAddress = :email
        firstName = :firstName
        lastName = :lastName
    WHERE customerID = :customerId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->execute();
    $stmt->closeCursor();

    if (!empty($password1) && !empty($password2)) {
        $password = sha1($email . $password1);
        $sql = 'UPDATE customers
                SET password = :password
                WHERE customerID = :customerId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':customerId', $customerId);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
