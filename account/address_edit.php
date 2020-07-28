<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1><?= $heading ?></h1>
    <div id="edit_address_form">
        <form action="." method="post" id="">
            <input type="hidden" name="action" value="updateAddress">
            <input type="hidden" name="addressType" value="<?= $addressType ?>">
            <label>Address:</label>
            <input type="text" name="line1" value="<?= htmlspecialchars($line1) ?>">
            <?= $field->getField('line1')->getHTML() ?><br>

            <label>Line2:</label>
            <input type="text" name="line2" value="<?= htmlspecialchars($line2) ?>">
            <?= $field->getField('line1')->getHTML() ?><br>

            <label>City:</label>
            <input type="text" name="city" value="<?= htmlspecialchars($city) ?>">
            <?= $field->getField('city')->getHTML() ?><br>

            <label>State:</label>
            <input type="text" name="state" value="<?= htmlspecialchars($state) ?>">
            <?= $field->getField('state')->getHTML() ?><br>

            <label>Zip:</label>
            <input type="text" name="zip" value="<?= htmlspecialchars($zip) ?>">
            <?= $field->getField('zip')->getHTML() ?><br>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
            <?= $field->getField('phone')->getHTML() ?><br>

            <label>&nbsp;</label>
            <input type="submit" value="<?= htmlspecialchars($heading) ?>">
            <br>
        </form>
        <form action="." method="post">
            <label>&nbsp;</label>
            <input type="submit" value="Cancel">
        </form>
    </div>
</main>
<?php include '../view/footer.php'; ?>