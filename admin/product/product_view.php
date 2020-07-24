<?php include '../../view/header.php'; ?>;
<?php include '../../view/sidebar.php'; ?>;

<section>
    <h1>Product Manager - View Product</h1>
    <!-- display product -->
    <?php include '../../view/product.php'; ?>;

    <!-- display buttons -->
    <div class="last_paragraph">
        <form action="." method="post" id="edit_button_form">
            <input type="hidden" name="action" value="showAddEditForm">
            <input type="hidden" name="productId" value="<?= $product['productID'] ?>">
            <input type="hidden" name="categoryId" value="<?= $product['categoryID'] ?>">
            <input type="submit" value="Edit Product">
        </form>
        <form action="." method="post">
            <input type="hidden" name="action" value="deleteProduct">
            <input type="hidden" name="productId" value="<?= $product['productID'] ?>">
            <input type="hidden" name="categoryId" value="<?= $product['categoryID'] ?>">
            <input type="submit" value="Delete Product">
        </form>
    </div>
</section>
<?php include '../../view/footer.php'; ?>;