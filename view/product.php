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

// Format discounts
$discountPercentF = number_format($discountPercent, 0);
$discountAmountF = number_format($discountAmount, 2);
$unitPriceF = number_format($unitPrice, 2);

// Get image URL and alternate text
$imageFilename = $productCode . '_m.png';
$imagePath = $appPath . 'images/' . $imageFilename;
$imageAlt = 'Image filename: ' . $imageFilename;
?>

<h1><?= $productName ?></h1>
<div id="left_column">
    <p><img src="<?= $imagePath ?>" alt="<?= $imageAlt ?>"></p>
</div>

<div id="right_column">
    <p><b>List Price:</b><?= $listPrice ?></p>
    <p><b>Discount:</b><?= '$' . $discountPercentF . '%' ?></p>
    <p><b>Your Price:</b><?= '$' . $unitPriceF ?>(You save <?= '$' . $discountAmountF ?>)</p>
    <form action="<?= $appPath . 'cart' ?>" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="productId" value="<?= $productId; ?>">
        <b>Quantity</b>
        <input type="text" name="quantity" value="1" size="2">
        <input type="submit" value="Add to Cart">
    </form>
    <h2 class="no_bottom_margin">Description</h2>
    <?= $descriptionTags ?>
</div>