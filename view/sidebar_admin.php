<aside>
    <h2>Links</h2>
    <ul>
        <li>
            <?php
            // Check if user is logged in and display appropiate account links
            $accountUrl = $appPath . 'admin/account';
            $logoutUrl = $appPath . '?action=$logoutUrl';
            if (isset($_SESSION['admin'])) :
            ?>
                <a href="<?= $logouturl ?>">Logout</a>
            <?php else : ?>
                <a href="<?= $accounturl ?>">Login</a>
            <?php endif; ?>
        </li>

        <li><a href="<?= $appPath ?>">Home</a></li>
        <li><a href="<?= $appPath . 'admin' ?>">Admin</a></li>
    </ul>
    <?php if (isset($categories)) : ?>
        <!--  display links for all categories -->
        <h2>Categories</h2>
        <ul>
            <!-- display links for all categories -->
            <?php foreach ($categories as $category) : ?>
                <li>
                    <a href="<?= $appPath . 'admin/product?action=listProducts' .
                                    '&amp;categoryId=' . $category['categoryID']; ?>">
                        <?= $category['categoryName']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside>