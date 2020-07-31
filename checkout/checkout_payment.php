<?php include '../view/header.php'; ?>
<main>
    <h2>Billing Address</h2>
    <p>
        <?= htmlspecialchars($billingAddress['line1']) ?><br>
        <?php if (strlen($billingAddress['line2']) > 0) : ?>
            <?= htmlspecialchars($billingAddress['line2']) ?><br>
        <?php endif; ?>
        <?= htmlspecialchars($billingAddress['city'] . ', ' . $billingAddress['state'] . ' ' . $billingAddress['zipCode']) ?><br>
        <?= htmlspecialchars($billingAddress['phone']) ?>
    </p>
    <form action="../account" method="post">
        <input type="hidden" name="action" value="editBilling">
        <input type="submit" value="Edit Billing Address">
    </form>
    <h2>Payment Information</h2>
    <form action="." method="post" id="payment_form">
        <input type="hidden" name="action" value="process">
        <label>Card Type:</label>
        <select name="cardType">
            <option value="1">Mastercard</option>
            <option value="2">Visa</option>
            <option value="3">Discover</option>
            <option value="4">American Express</option>
        </select>
        <br>

        <label>Card Number:</label>
        <input type="text" name="cardNumber" value="<?= htmlspecialchars($cardNumber) ?>">
        <span class="error"><?= $ccNumberMessage ?></span>
        <span>No dashes or spaces</span>
        <br>

        <label>CVV:</label>
        <input type="text" name="cardCCV" value="<?= htmlspecialchars($cardCCV) ?>">
        <span class="error"><?= $ccCCVMessage ?></span>
        <br>

        <label>Expiration:</label>
        <input type="text" name="cardExpires" value="<?= htmlspecialchars($cardExpires) ?>">
        <span class="error"><?= $ccExpirationMessage ?></span>
        <span>MM/YYYY</span>
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Place Order">&nbsp;&nbsp;
        <span>Click only once.</span>
    </form>
    <form action="../cart" method="post">
        <input type="submit" value="CancelPayment Entry">
    </form>
</main>
<?php include '../view/footer.php'; ?>