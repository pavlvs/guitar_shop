<?php include '../../view/header.php' ?>
<?php include '../../view/sidebar.php' ?>
<?php
if (isset($productId)) {
    $headingText = 'Edit Product';
} else {
    $headingText = 'Add Product';
}
?>
<section>
    <h1>Product Manager - <?= $headingText ?></h1>

    <form action="index.php" method="post" id="add_edit_product_form">
        <?php if (isset($productId)) : ?>
            <input type="hidden" name="action" value="updateProduct">
            <input type="hidden" name="productId" value="<?= $productId ?>">
        <?php else : ?>
            <input type="hidden" name="action" value="addProduct" <?php endif; ?> <input type="hidden" name="categoryId" value="<?= $product['categoryID']; ?>">

            <label for="">Category</label>
            <select name="categoryId" id="categoryId">
                <?php foreach ($categories as $category) :
                    if ($category['categoryID'] == $product['categoryID']) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?= $category['categoryID'] ?>">
                        <?= $category['categoryName'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label for="">Code:</label>
            <input type="text" name="code" value="<?= htmlspecialchars($product['productCode']); ?>"><br>

            <label for="">Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['productName']); ?>"><br>

            <label for="">List Price:</label>
            <input type="text" name="price" value="<?= htmlspecialchars($product['listPrice']); ?>"><br>

            <label for="">Percent:</label>
            <input type="text" name="discountPercent" value="<?= htmlspecialchars($product['discountPercent']); ?>"><br>

            <label for="">Description:</label>
            <textarea name="description" rows="10"><?= htmlspecialchars($product['description']);  ?></textarea><br>

            <label for="">&nbsp;</label>
            <input type="submit" value="Submit">
    </form>

    <div id="formatting_directions">
        <h2>How to format the Description entry</h2>
        <ul>
            <li>Use two returns to start a new paragraph</li>
            <li>Use an asterisk to mark items in a bulleted list</li>
            <li>Use one return between items in a bulleted list.</li>
            <li>Use standard HTML tags for bold and italics</li>
        </ul>
    </div>
</section>
<?php include 'view/footer.php' ?>