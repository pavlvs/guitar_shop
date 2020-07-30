<?php include '../../view/header.php'; ?>;
<?php include '../../view/sidebar.php'; ?>;

<main>
    <h1>Product Manager - View Product</h1>
    <!-- display product -->
    <?php include '../../view/product.php'; ?>;

    <!-- display buttons -->
    <div id="edit_and_delete_buttons">
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
    <div id="image_manager">
        <h1>Image Manager</h1>
        <form action="." method="post" id="upload_image_form" enctype="multipart/form-data">
            <input type="hidden" name="action" value="uploadImage">
            <input type="file" name="file1" id=""><br>
            <input type="hidden" name="productId" value="<?= $product['productId'] ?>">
            <input type="submit" value="Upload Image">
        </form>
        <p><a href="../../images/<?= $product['productCode'] ?>.png">View large image</a></p>
        <p><a href="../../images/<?= $product['productCode'] ?>_s.png">View small image</a></p>
    </div>
</main>
<?php include '../../view/footer.php'; ?>;