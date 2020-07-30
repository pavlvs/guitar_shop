<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Outstanding Orders</h1>
    <?php if (count($newOrders) > 0) : ?>
        <ul>
            <?php foreach ($newOrders as $order) :
                $orderId = $order['orderId'];
                $orderDate = strtotime($order['orderDate']);
                $orderDate = date('M j, Y', $orderDate);
                $url = $appPath . 'admin/orders' . '?action=viewOrder&amp;orderId=' . $orderId;
            ?>
                <li>
                    <a href="<?= $url ?>">Order #
                        <?= $orderId ?></a> for
                    <?= $order['firstName'] . ' ' . $order['lastName'] ?> placed on
                    <?= $orderDate ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>There are no shipped orders</p>
    <?php endif; ?>
    <h1>Shipped Orders</h1>
    <?php if (count($oldOrders) > 0) : ?>
        <ul>
            <?php foreach ($oldOrders as $order) :
                $orderId = $order['orderId'];
                $orderDate = strtotime($order['orderDate']);
                $orderDate = date('M j, Y', $orderDate);
                $url = $appPath . 'admin/orders' . '?action=viewOrder&amp;orderId=' . $orderId;
            ?>
                <li>
                    <a href="<?= $url ?>">Order #
                        <?= $orderId ?></a> for
                    <?= $order['firstName'] . ' ' . $order['lastName'] ?> placed on
                    <?= $orderDate ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>There are no shipped orders</p>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>