<aside>
    <!-- Thes are for testing only.
    Remove them from the application -->
    <h2>Links</h2>
    <ul>
        <li><a href="<?= $appPath ?>">Home</a></li>
        <li><a href="<?= $appPath . 'admin' ?>">Admin</a></li>
    </ul>
    <h2>Categories</h2>
    <ul>
        <!-- display links for all categories -->
        <?php foreach ($categories as $category) : ?>
            <li>
                <a href="<?= $appPath . 'admin/product' . '?action=listProducts' .
                                '&amp;categoryId=' . $category['categoryID']; ?>">
                    <?= $category['categoryName']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>