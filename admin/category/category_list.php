<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main>
    <h1>Category Manager</h1>
    <table id="category_table">
        <?php foreach ($categories as $category) : ?>
            <tr>
                <form action="index.php?action=deleteCategory" method="post">
                    <td>
                        <input type="text" name="name" value="<?= htmlspecialchars($category['categoryName']) ?>">
                    </td>
                    <td>
                        <input type="hidden" name="action" value="updateCategory">

                        <input type="hidden" name="categoryId" value="<?= $category['categoryID']; ?>">
                        <input type="submit" value="Update">
                    </td>
                </form>
                <td>
                    <?php if ($categoryId['productCount'] == 0) : ?>
                        <form action="." method="post">
                            <input type="hidden" name="action" value="deleteCategory">
                            <input type="hidden" name="categoryId" value="<?= $category['categoryID'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Add Category</h2>
    <form action="index.php?action=addCategory" method="post" id="add_category_form">
        <input type="text" name="name" value="">
        <input type="submit" value="Add">
    </form><br>
</main>
<?php include '../../view/footer.php'; ?>