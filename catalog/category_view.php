<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1><?= htmlspecialchars($categoryName) ?></h1>
    <?php if (count($products) == 0) : ?>
        <p>There are no products in this category.</p>
    <?php else : ?>
        <?php foreach ($products as $product) : ?>
            <p>
                <a href="<?= '?productId=' . $product['productID'] ?>">
                    <?= htmlspecialchars($product['productName']) ?>
                </a>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>