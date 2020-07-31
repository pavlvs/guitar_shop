<?php include '../view/header.php'; ?>
<main>
    <h1>Confirm Order</h1>
    <table id="cart">
        <tr id="cart_header">
            <td class="right">Item</td>
            <td class="right">Price</td>
            <td class="right">Quantity</td>
            <td class="right">Total</td>
        </tr>
        <?php foreach ($cart as $productId => $item) : ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td class="right">
                    <?= sprintf('$%.2f', $item['unitPrice']) ?>
                </td>
                <td class="right">
                    <?= $item['quantity'] ?>
                </td>
                <td class="right">
                    <?= sprintf('$%.2f', $item['linePrice']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="right">Subtotal</td>
            <td class="right"><?= sprintf('$%.2f', $subtotal) ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right"><?= $state ?> Tax</td>
            <td class="right"><?= sprintf('$%.2f', $tax) ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Shipping</td>
            <td class="right"><?= sprintf('$%.2f', $shippingCost) ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Total</td>
            <td class="right"><?= sprintf('$%.2f', $total) ?></td>
        </tr>

    </table>
    <p>
        Proceed to: <a href="<?= '?action=payment' ?>">Payment</a>
    </p>
</main>
<?php include '../view/footer.php'; ?>