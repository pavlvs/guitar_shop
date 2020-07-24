<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?><section>
    <h1>Product Manager - Category List</h1>
    <table id="category_table">
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
            <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?= $category['categoryName'] ?></td>
            <td>
                <form action="index.php?action=deleteCategory" method="post">
                    <input type="hidden" name="categoryId" value="<?= $category['categoryID']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>

    <?php endforeach; ?>
    </tr>
    </table><br>

    <h2>Add Category</h2>
    <form action="index.php?action=addCategory" method="post" id="add_category_form">
        <input type="text" name="categoryName" value="">
        <input type="submit" value="Add">
    </form><br>

    <p class="last_paragraph">
        <a href="../category?action=listCategories">List Products</a>
    </p>
</section>
<?php include '../../view/footer.php'; ?>