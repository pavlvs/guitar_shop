<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<section>
    <h1><?= $currentCategory['categoryName'] ?></h1>
    <?php if (count($products) == 0) : ?>
        <ul>
            <li>There are no products in this category</li>
        </ul>
    <?php else : ?>
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
</section>
<?php include '../view/footer.php'; ?>