<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<section>
    <h1>Product Manager - List Products</h1>
    <p>To view, edit or delete a product, select the product.</p>
    <p>To add a product, select the "Add Product" link.</p>
    <?php if (count($products) == 0) : ?>
        <ul>
            <li>There are no products in this category</li>
        </ul>
    <?php else : ?>
        <h2><?= $currentCategory['categoryName'] ?></h2>
        <ul>
            <?php foreach ($products as $product) : ?>
                <li>
                    <a href="?action=viewProduct&amp;productId=
            <?= $product['productID'] ?>">
                        <?= $product['productName'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Links</h2>
    <p>
        <a href="index.php?action=showAddEditForm">Add Product</a>
    </p>
    <p class="last_paragraph">
        <a href="../category?action=listCategories">List Categories</a>
    </p>
</section>
<?php include '../../view/footer.php'; ?>