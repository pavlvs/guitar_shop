<aside>
    <h2>Links</h2>
    <ul>
        <li>
            <a href="<?= $appPath . 'cart' ?>">View Cart</a>
        </li>
        <?php
        // check if user is logged in and dispalay appropiate account links
        $accountUrl = $appPath . 'account';
        $logoutUrl = $appPath . '?action=logout';
        if (isset($_SESSION['user'])) :
        ?>
            <li>
                <a href="<?= $accountUrl; ?>">My Account</a>
            </li>
            <li>
                <a href="<?= $logoutUrl; ?>">Logout</a>
            </li>
        <?php else : ?>
            <li>
                <a href="<?= $accountUrl ?>">Login/Register</a>
            </li>
        <?php endif; ?>
        <li>
            <a href="<?= $appPath ?>">Home</a>
        </li>
    </ul>

    <h2>Categories</h2>
    <ul>
        <!-- display links for all categories -->
        <?php
        require_once 'model/database.php';
        require_once 'model/category_db.php';

        $categories = getCategories();
        foreach ($categories as $category) :
            $name = $category['categoryName'];
            $id = $category['categoryID'];
            $url = $appPath . 'catalog?categoryId=' . $id;
        ?>
            <li>
                <a href="<?= $url; ?>">
                    <?= htmlspecialchars($name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Temp Link</h2>
    <li>
        <!-- For testing only. Remove it from a production application. -->
        <a href="<?= $appPath ?>admin">Admin</a>
    </li>
</aside>