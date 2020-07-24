<?php include 'view/header.php'; ?>
<div id="main">
    <h1>Product List</h1>

    <aside>
        <!-- display a list of categories -->
        <h2>Categories</h2>
        <ul class="nav">
            <?php foreach ($categories as $category) : ?>
                <li>
                    <a href="?categoryId=<?= $category['categoryID'] ?>"><?= $category['categoryName'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <section>
        <!-- display a table of products -->
        <h2><?= $category['categoryName'] ?></h2>
        <table>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="right">Price</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= $product['productCode'] ?></td>
                    <td><?= $product['productName'] ?></td>
                    <td class="right"><?= $product['listPrice'] ?></td>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action" value="deleteProduct">
                            <input type="hidden" name="productId" value="<?= $product['productID'] ?>">
                            <input type="hidden" name="categoryId" value="<?= $product['categoryID'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>
        <p><a href="index.php?action=showAddEditForm">Add Product</a></p>
    </section>
</div>
<?php include 'view/footer.php'; ?>