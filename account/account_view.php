<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>My Account</h1>
    <p><?= $customerName . ' (' . $email . ')'; ?></p>

    <form action="." method="post" id="">
        <input type="hidden" name="action" value="viewAccountEdit">
        <input type="submit" value="Edit Account">
    </form>
    <h2>Shipping Address</h2>
    <p>
        <?= htmlspecialchars($shippingAddress['line1']) ?><br>
        <?php if (strlen($shippingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($shippingAddress['line2']) ?>
        <?php endif; ?>
        <?= htmlspecialchars($shippingAddress['city']) ?>,
        <?= htmlspecialchars($shippingAddress['state']) ?>
        <?= htmlspecialchars($shippingAddress['zip']) ?><br>
        <?= htmlspecialchars($shippingAddress['phone']) ?>
    </p>
    <form action="." method="post">
        <input type="hidden" name="action" value="viewAddressEdit">
        <input type="hidden" name="addressType" value="shipping">
        <input type="submit" value="Edit Shipping Address">
    </form>

    <h2>Billing Address</h2>
    <p>
        <?= htmlspecialchars($billingAddress['line1']) ?><br>
        <?php if (strlen($billingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($billingAddress['line2']) ?>
        <?php endif; ?>
        <?= htmlspecialchars($billingAddress['city']) ?>,
        <?= htmlspecialchars($billingAddress['state']) ?>
        <?= htmlspecialchars($billingAddress['zip']) ?><br>
        <?= htmlspecialchars($billingAddress['phone']) ?>
    </p>
    <form action="." method="post">
        <input type="hidden" name="action" value="viewAddressEdit">
        <input type="hidden" name="addressType" value="billing">
        <input type="submit" value="Edit Billing Address">
    </form>
    <h2>Shipping Address</h2>
    <p>
        <?= htmlspecialchars($shippingAddress['line1']) ?><br>
        <?php if (strlen($shippingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($shippingAddress['line2']) ?>
        <?php endif; ?>
        <?= htmlspecialchars($shippingAddress['city']) ?>,
        <?= htmlspecialchars($shippingAddress['state']) ?>
        <?= htmlspecialchars($shippingAddress['zip']) ?><br>
        <?= htmlspecialchars($shippingAddress['phone']) ?>
    </p>
    <form action="." method="post">
        <input type="hidden" name="action" value="viewAddressEdit">
        <input type="hidden" name="addressType" value="shipping">
        <input type="submit" value="Edit Shipping Address">
    </form>
    <?php if (count($orders) > 0) : ?>
        <h2>Your orders</h2>
        <ul>
            <?php foreach ($orders as $order) :
                $orderId = $order['$orderID'];
                $orderDate = strtotime($order['orderDate']);
                $orderDate = date('M j, Y', $orderDate);
                $url = $appPath . 'account' . '?action=viewOrder&orderId=' . $orderId;
            ?>
                <li>
                    Order # <a href="<?= $url ?>"><?= $orderId ?></a> placed on <?= $orderDate ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>