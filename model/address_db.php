<?php
function addAddress($customerId, $line1, $line2, $city, $state, $zipCode, $phone) {
    global $db;
    $sql = 'INSERT INTO addresses (customerID, line1, line2, city, state, zipCode, phone)
            VALUES (:customerId, :line1, :line2, :city, :state, :zipCode, :phone)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customerId', $customerId);
    $stmt->bindValue(':line1', $line1);
    $stmt->bindValue(':line2', $line2);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':state', $state);
    $stmt->bindValue(':zipCode', $zipCode);
    $stmt->bindValue(':phone', $phone);
    $stmt->execute();
    $addressId = $db->lastInsertId();
    $stmt->closeCursor();
    return $addressId;
}

function getAddress($addressId) {
    global $db;
    $sql  = 'SELECT * FROM addresses WHERE addressID = :addressId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':addressId', $addressId);
    $stmt->execute();
    $address = $stmt->fetch();
    $stmt->closeCursor();
    return $address;
}

function updateAddress($addressId, $line1, $line2, $city, $state, $zipCode, $phone) {
    global $db;
    $sql = 'UPDATE addresses
            SET line1   = :line1,
                line2   = :line2,
                city    = :city,
                state   = :state,
                zipCode = :zipCode,
                phone   = :phone
            WHERE addressID = :addressId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':addressId', $addressId);
    $stmt->bindValue(':line1', $line1);
    $stmt->bindValue(':line2', $line2);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':state', $state);
    $stmt->bindValue(':zipCode', $zipCode);
    $stmt->bindValue(':phone', $phone);
    $stmt->execute();
    $stmt->closeCursor();
}

function disableOrDeleteAddress($addressId) {
    global $db;
    if (isUsedAddressId($addressId)) {
        $sql = 'UPDATE addresses
                SET disabled = 1
                WHERE addressID = :addressId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':addressId', $addressId);
        $stmt->execute();
        $stmt->closeCursor();
    } else {
        $sql = 'DELETE FROM addresses WHERE addressID = :addressId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':addressId', $addressId);
        $stmt->execute();
        $stmt->closeCursor();
    }
}

function isUsedAddressId($addressId) {
    global $db;

    // Check if the address is used as a billing addresses
    $sql1 = 'SELECT COUNT(*) FROM orders WHERE billingAddressID = :value';
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':value', $addressId);
    $stmt1->execute();
    $result1 = $stmt1->fetch();
    $billingCount = $result1[0];
    $stmt1->closeCursor();
    if ($billingCount > 0) {
        return true;
    }

    // Check if the address is used as a shipping address
    $sql2 = 'SELECT COUNT(*) FROM orders WHERE shipAddressID = :value';
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(':value', $addressId);
    $stmt2->execute();
    $result2 = $stmt2->fetch();
    $shipCount = $result2[0];
    $stmt2->closeCursor();
    if ($shipCount > 0) {
        return true;
    }
    return false;
}
