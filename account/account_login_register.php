<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Login</h1>
    <form action="." method="post" id="login_form">
        <input type="hidden" name="action" value="login">

        <label>E-Mail:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>" size="30">
        <?= $fields->getField('email')->getHTML() ?><br>

        <label>Password:</label>
        <input type="password" name="password" value="<?= htmlspecialchars($password) ?>" size="30">
        <?= $fields->getField('password')->getHTML() ?><br>

        <input type="submit" value="Login">
        <?php if (!empty($passwordMessage)) : ?>
            <span class="error"><?= htmlspecialchars($passwordMessage) ?></span><br>
        <?php endif; ?>
    </form>

    <h1>Register</h1>
    <form action="." method="post">
        <input type="hidden" name="action" value="viewRegister">
        <input type="submit" value="Register">
    </form>
</main>
<?php include '../view/footer.php'; ?>