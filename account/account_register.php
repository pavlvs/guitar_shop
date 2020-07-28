<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<?php
if (!isset($passwordMessage)) {
    $passwordMessage = '';
}
?>
<main>
    <form action="." method="post" id="register_form">

        <h2>Customer Information:</h2>
        <input type="hidden" name="action" value="register">

        <label>E-mail:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>" size="30">
        <?= $fields->getField('email')->getHTML(); ?><br>

        <label>Password:</label>
        <input type="password" name="password1" value="<?= htmlspecialchars($password1) ?>" size="30">
        <?= $fields->getField('password1')->getHTML(); ?><br>

        <label>Retype Password:</label>
        <input type="password" name="password2" value="<?= htmlspecialchars($password2) ?>" size="30">
        <?= $fields->getField('password1')->getHTML(); ?><br>

        <label>First Name:</label>
        <input type="text" name="firstName" value="<?= htmlspecialchars($firstName) ?>" size="30">
        <?= $fields->getField('firstName')->getHTML(); ?><br>

        <label>Last Name:</label>
        <input type="text" name="lastName" value="<?= htmlspecialchars($lastName) ?>" size="30">
        <?= $fields->getField('lastName')->getHTML(); ?><br>

        <h2>Shipping Address:</h2>

        <label>Address:</label>
        <input type="text" name="shipLine1" value="<?= htmlspecialchars($shipLine1) ?>" size="30">
        <?= $fields->getField('shipLine1')->getHTML(); ?><br>

        <label>Line 2:</label>
        <input type="text" name="shipLine2" value="<?= htmlspecialchars($shipLine2) ?>" size="30">
        <?= $fields->getField('shipLine2')->getHTML(); ?><br>

        <label>City:</label>
        <input type="text" name="shipCity" value="<?= htmlspecialchars($shipCity) ?>" size="30">
        <?= $fields->getField('shipCity')->getHTML(); ?><br>

        <label>State:</label>
        <input type="text" name="shipState" value="<?= htmlspecialchars($shipState) ?>" size="30">
        <?= $fields->getField('shipState')->getHTML(); ?><br>

        <label>Zip:</label>
        <input type="text" name="shipZip" value="<?= htmlspecialchars($shipZip) ?>" size="30">
        <?= $fields->getField('shipZip')->getHTML(); ?><br>

        <label>Phone:</label>
        <input type="text" name="shipPhone" value="<?= htmlspecialchars($shipPhone) ?>" size="30">
        <?= $fields->getField('shipPhone')->getHTML(); ?><br>

        <h2>Billing Address:</h2>
        <label>&nbsp;</label>
        <input type="checkbox" name="useShipping" <?php if ($useShipping) : ?>checked<?php endif; ?> size="30">Use shipping address
        <br>

        <label>Address:</label>
        <input type="text" name="billLine1" value="<?= htmlspecialchars($billLine1) ?>" size="30">
        <?= $fields->getField('billLine1')->getHTML(); ?><br>

        <label>Line 2:</label>
        <input type="text" name="billLine2" value="<?= htmlspecialchars($billLine2) ?>" size="30">
        <?= $fields->getField('billLine2')->getHTML(); ?><br>

        <label>City:</label>
        <input type="text" name="billCity" value="<?= htmlspecialchars($billCity) ?>" size="30">
        <?= $fields->getField('billCity')->getHTML(); ?><br>

        <label>State:</label>
        <input type="text" name="billState" value="<?= htmlspecialchars($billState) ?>" size="30">
        <?= $fields->getField('billState')->getHTML(); ?><br>

        <label>Zip:</label>
        <input type="text" name="billZip" value="<?= htmlspecialchars($billZip) ?>" size="30">
        <?= $fields->getField('billZip')->getHTML(); ?><br>

        <label>Phone:</label>
        <input type="text" name="billPhone" value="<?= htmlspecialchars($billPhone) ?>" size="30">
        <?= $fields->getField('billPhone')->getHTML(); ?><br>

        <label>&nbsp;</label>
        <input type="submit" value="Register">
    </form>
</main>
<?php include '../view/footer.php'; ?>