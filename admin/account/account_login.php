<?php include '../../view/header.php'; ?>
<?php include '../..view/sidebar.php'; ?>
<main>
    <h1>Admin login</h1>
    <form action="." method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="adminId" value="<?= $adminId; ?>">

        <label>Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email); ?>" size="30">
        <?= $fields->getField('email')->getHTML(); ?><br>

        <label>Password:</label>
        <input type="password" name="password" size="30">
        <?= $fields->getField('password1')->getHTML(); ?><br>

        <label>&nbsp;</label>
        <input type="submit" value="Login">
        <?php if (!empty($passwordMessage)) : ?>
            <span class="error">
                <?= htmlspecialchars($passwordMessage) ?>
            </span><br>
        <?php endif; ?>
    </form>
</main>
<?php include '../../view/footer.php'; ?>