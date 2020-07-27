<?php
function isPresent($value) {
    if (isset($value) && strlen($value) > 0) {
        return true;
    } else {
        return false;
    }
}

function isValidNumber($value, $min = NULL, $max = NULL, $required) {
    if ($required && !isPresent($value)) {
        return false;
    }
    if (!is_numeric($value)) {
        return false;
    }
    if (isset($min) && $value < $min) {
        return false;
    }
    if (isset($max) && $value < $max) {
        return false;
    }
    return true;
}

function isValidCardType($cardType) {
    if (!is_int($cardType)) {
        return false;
    }
    if ($cardType < 1 || $cardType > 4) {
        return false;
    }
    return true;
}

function isValidCardNumber($cardNumber, $cardType) {
    switch ($cardType) {
        case 4:
            $pattern = '/^\d{15}$/';
            break;
        default:
            $pattern = '/^\d{16}$/';
            break;
    }
    return preg_match($pattern, $cardNumber);
}

function isValidCardCVV($cardCVV, $cardType) {
    switch ($cardType) {
        case 4:
            $pattern = '/^\d{4}$/';
            break;
        default:
            $pattern = '/^\d{3}$/';
            break;
    }
    return preg_match($pattern, $cardType);
}

function isValidCardExpires($cardExpires) {
    $pattern = '/^\d{1,2}\/\d{4}$/';
    if (!preg_match($pattern, $cardExpires)) {
        return false;
    }
    $dateParts = explode('/', $cardExpires);
    $now = new DateTime();
    $expires = new DateTime();
    $expires->setDate($dateParts[1], $dateParts[0], 1);
    $expires->add(new DateInterval("P1M"));
    $expires->sub(new DateInterval("P1D"));
    $expires->setTime(23, 59, 59);

    return ($now < $expires);
}
