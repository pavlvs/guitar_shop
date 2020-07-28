<?php include 'view/header.php'; ?>
<?php include 'view/sidebar.php'; ?>
<main class="nofloat">
    <h1>Featured products</h1>
    <p>We have a great selection of musical instruments including guitars, basses, and drums. And we're constantly adding more to give you the best selection possible!
    </p>
    <table>
        <?php foreach ($products as $product) :
            // Get product data
            $listPrice = $product['listPrice'];
            $discountPercent = $product['discountPercent'];
            $description = $product['description'];

            // Calculate unit price
            $discountAmount = round($listPrice * ($discountPercent / 100.0), 2);
            $unitPrice = $listPrice - $discountAmount;

            // get first paragraph of description
            $descriptionWithTags = addTags($description);
            $i = strpos($descriptionWithTags, "</p>");
            $firstParagraph = substr($descriptionWithTags, 3, $i - 3)
        ?>
            <tr>
                <td class="product_image_column">
                    <img src="images/<?= htmlspecialchars($product['productCode']); ?>_s.png" alt="&nbsp;">
                </td>
                <td class="product_info_cell">
                    <p>
                        <a href="catalog?action=viewProduct&amp;productId=<?= $product['productID'] ?>">
                            <?= htmlspecialchars($product['productName']) ?>
                        </a>
                    </p>
                    <p>
                        <b>Your price: </b>
                        <?= number_format($unitPrice, 2) ?>
                    </p>
                    <p>
                        <?= $firstParagraph; ?>
                    </p>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php include 'view/footer.php'; ?>