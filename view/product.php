<?php
// Parse data
$categoryId = $product['categoryID'];
$productCode = $product['productCode'];
$productName = $product['productName'];
$description = $product['description'];
$listPrice = $product['listPrice'];
$discountPercent = $product['discountPercent'];

// Add HTML tags to the description
$descriptionTags = addTags($description);

// Calculate discounts
$discountAmount = round($listPrice * ($discountPercent / 100), 2);
$unitPrice = $listPrice - $discountAmount;
