<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Order Information</h1>
    <p>Order Number: <?= $orderId ?></p>
    <p>Order Date: <?= $orderDate ?></p>
    <p>Customer: <?= htmlspecialchars($name) . ' (' . htmlspecialchars($email) . ')'; ?></p>
    <h2>Shipping</h2>
    <?php if ($order['orderDate'] === NULL) : ?>
        <p>ship Date: Not Yet shipped</p>
        <form action="." method="post">
            <input type="hidden" name="action" value="setShipDate">
            <input type="hidden" name="orderId" value="<?= $orderId ?>">
            <input type="submit" value="Ship Order">
        </form>
        <form action="." method="post">
            <input type="hidden" name="action" value="confirmDelete">
            <input type="hidden" name="orderId" value="<?= $orderId ?>">
            <input type="submit" value="Delete Order">
        </form>
    <?php else :
        $shipDate = date('M j Y', strtotime($order['shipDate'])); ?>
        <p>Ship Date: <?= $shipDate ?></p>
    <?php endif; ?>
    <p>
        <?= htmlspecialchars($shipLine1) ?><br>
        <?php if (strlen($shipLine2) > 0) : ?>
            <?= htmlspecialchars($shipLine2) ?><br>
        <?php endif; ?>
        <?= htmlspecialchars($shipCity) ?><br>
        <?= htmlspecialchars($shipState) ?><br>
        <?= htmlspecialchars($shipZip) ?><br>
        <?= htmlspecialchars($shipPhone) ?><br>
    </p>
    <h2>Billing</h2>
    <p>Card Number: <?= htmlspecialchars($cardNumber) . ' (' . htmlspecialchars($cardName) ?></p>
    <p>Card Expires: <?= htmlspecialchars($cardExpires) ?></p>
    <p>
        <?= htmlspecialchars($billLine1) ?><br>
        <?php if (strlen($billLine2) > 0) : ?>
            <?= htmlspecialchars($billLine2) ?><br>
        <?php endif; ?>
        <?= htmlspecialchars($billCity) ?><br>
        <?= htmlspecialchars($billState) ?><br>
        <?= htmlspecialchars($billZip) ?><br>
        <?= htmlspecialchars($billPhone) ?><br>
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
            $productId = $item['productId'];
            $product = getProduct($productId);
            $itemName = $product['productName'];
            $listPrice = $item['itemPrice'];
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
            <td colspan="5" class="right">Subtotal:</td>
            <td class="right">
                <?= sprintf('$%.2f', $subtotal) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">
                <?= htmlspecialchars($shipState) ?>Tax:
            </td>
            <td class="right">
                <?= sprintf('$%.2f', $order['taxAmount']) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">Shipping:</td>
            <td class="right">
                <?= sprintf('$%.2f', $order['shipAmount']) ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">Total:</td>
            <td class="right">
                <?php
                $total = $subtotal + $order['taxAmount'] + $order['shipAmount'];
                echo sprintf('$%.2f', $subtotal);
                ?>
            </td>
        </tr>
    </table>
</main>
<?php include '../view/footer.php'; ?>