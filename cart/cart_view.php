<?php include '../view/header.php'; ?>
<main>
    <h1>Your Cart</h1>
    <?php if (cartProductCount() == 0) : ?>
        <p>There are no products in your cart.</p>
    <?php else : ?>
        <p>To remove an item fom your cart, change its quantity to 0.</p>
        <form action="." method="post">
            <input type="hidden" name="action" value="update">
            <table id="cart">
                <tr id="cart_header">
                    <td class="left">Item</td>
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
                            <input type="text" size="3" class="right" name="items[<?= $productId ?>]" value="<?= $item['quantity'] ?>">
                        </td>
                        <td class="right">
                            <?= sprintf('$%.2f', $item['linePrice']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr id="cart_footer">
                    <td colspan="3" class="right"><b>Subtotal</b></td>
                    <td class="right">
                        <?= sprintf('$%.2f', cartSubtotal()) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="right">
                        <input type="submit" value="Update Cart">
                    </td>
                </tr>
            </table>
        </form>

    <?php endif; ?>
    <p>return to: <a href="../">Home</a></p>

    <!-- display most recent category -->
    <?php if (isset($_SESSION['lastCategoryId'])) :
        $categoryUrl = '../catalog' . '?categoryId=' . $_SESSION['lastCategoryId'];
    ?>
        <p>
            return to: <a href="<?= $categoryUrl ?>"><?= $_SESSION['lastCategoryName'] ?></a>
        </p>
    <?php endif; ?>

    <!-- if cart has items, display the checkout list -->
    <?php if (cartProductCount() > 0) : ?>
        <p>
            Proceed to: <a href="../checkout">Checkout</a>
        </p>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>