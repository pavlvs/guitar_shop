<?php include 'view/header.php' ?>
<div id="main">
    <h1>Add Product</h1>
    <form action="index.php" method="post" id="add_product_form">
        <input type="hidden" name="action" value="addProduct">

        <label for="">Category</label>
        <select name="categoryId" id="">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['categoryID'] ?>"><?= $category['categoryName'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="">Code</label>
        <input type="text" name="code">
        <br>

        <label for="">Name:</label>
        <input type="text" name="name">
        <br>

        <label for="">List Price</label>
        <input type="text" name="price">
        <br>

        <label for="">&nbsp;</label>
        <input type="submit" name="Add Product">
        <br>
    </form>
    <p><a href="index.php?action=listProducts">ViewProduct List</a></p>
</div>
<?php include 'view/footer.php' ?>