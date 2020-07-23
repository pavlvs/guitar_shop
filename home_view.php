<?php include 'view/header.php'; ?>
<?php include 'view/sidebar.php'; ?>
<section>
    <h1>Featured products</h1>
    <p>My Guitar Shop has a great selection of musical instruments including guitars, basses, and drums. And we're constantly adding more to give you the best selection possible!
    </p>
    <table>
        <?php foreach ($products as $product) :
            // Get product data
            $listPrice = $product['listPrice'];
            $discountPercent = $product['discountPercent'];
            $description = $product['description'];

            // Calculate unit price
            $discountAmount = round($listPrice * ($discountPercent / 100), 2);
            $unitPrice = $listPrice - $discountAmount;

            // get first paragraph of description
            $descriptionWithTags = addTags($description);
            $i = strpos($descriptionWithTags, "</p>");
            $descriptionParagraph = substr($descriptionWithTags, 3, $i - 3)
        ?>
            <tr>
                <td class="product_image_cell">
                    <img src="images/<?= $product['productCode']; ?>_s.png" alt="&nbsp;">
                </td>
                <td class="product_info_cell">
                    <p>
                        <a href="catalog?action=viewProduct&amp;productId=<?= $product['productID'] ?>">
                            <?= $product['productName'] ?>
                        </a>
                    </p>
                    <p>
                        <b>Your price: </b>
                        <?= number_format($unitPrice, 2) ?>
                    </p>
                    <p>
                        <?= $descriptionParagraph; ?>
                    </p>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php include 'view/footer.php'; ?>