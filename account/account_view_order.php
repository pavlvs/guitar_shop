<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Your Order</h1>
    <p>Order Number: <?= $orderId; ?></p>
    <p>Order Date: <?= $orderDate; ?></p>
    <h2>Shipping</h2>
    <p>
        Ship Date:
        <?php
        if ($order['shipDate'] == NULL) {
            echo 'Not shipped yet';
        } else {
            $shipDate = strtotime($order['shipDate']);
            echo date('M j, Y', $shipDate);
        }
        ?>
    </p>
    <p>
        <?= htmlspecialchars($shippingAddress['line1']); ?><br>
        <?php if (strlen($shippingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($shippingAddress['line2']); ?><br>
        <?php endif; ?>
        <?= htmlspecialchars($shippingAddress['city']) ?>,
        <?= htmlspecialchars($shippingAddress['state']) ?>
        <?= htmlspecialchars($shippingAddress['zip']) ?><br>
        <?= htmlspecialchars($shippingAddress['phone']) ?>
    </p>
    <h2>Billing</h2>
    <p>Card Number:...<?= substr($order['cardNumber'], -4) ?></p>
    <p><?php if (strlen($billingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($billingAddress['line2']); ?><br>
        <?php endif; ?>
        <?= htmlspecialchars($billingAddress['city']) ?>,
        <?= htmlspecialchars($billingAddress['state']) ?>
        <?= htmlspecialchars($billingAddress['zip']) ?><br>
        <?= htmlspecialchars($billingAddress['phone']) ?>
    </p>
    <h2>Order Items</h2>
    <table id="cart">
        <tr id="cart_header">
            <th class="left">Item</th>
            <th class="right">List Price</th>
            <th class="right">Savings</th>
            <th class="right">Your Cost</th>
            <th class="right">Quantity</th>
            <th class="right">Line Total</th>
        </tr>
        <?php
        $subtotal = 0;
        foreach ($orderItems as $item) :
            $productId = $item['productID'];
            $product = getProduct($productId);
            $itemName = $product['productName'];
            $listPrice = $item['listPrice'];
            $savings = $item['discountAmount'];
            $yourCost = $listPrice - $savings;
            $quantity = $item['quantity'];
            $lineTotal = $yourCost * $quantity;
            $subtotal += $lineTotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($itemName) ?></td>
                <td class="right"><?= sprintf('$%.2f', $listPrice) ?></td>
                <td class="right"><?= sprintf('$%.2f', $savings) ?></td>
                <td class="right"><?= sprintf('$%.2f', $yourCost) ?></td>
                <td class="right"><?= $quantity ?></td>
                <td class="right"><?= sprintf('$%.2f', $lineTotal) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr id="cart_footer">
            <td colspan="5" class="right">Subtotal</td>
            <td class="right">
                <?= sprintf('$%.2f', $subtotal) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">
                <?= htmlspecialchars($shippingAddress['state']) ?>Tax:
            </td>
            <td class="right">
                <?= sprintf('$%.2f', $order[' taxAmount']) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">Shipping</td>
            <td class="right">
                <?= sprintf('$%.2f', $order['shipAmount']) ?>
            </td>
        </tr>
        <tr>
            <td class="right">Total</td>
            <td class="right">
                <?php
                $total = $subtotal + $order['taxAmount'] + $order['shipAmount'];
                echo sprintf('$%.2f', $total);
                ?>
            </td>
        </tr>
    </table>
</main>
<?php include '../view/footer.php'; ?>