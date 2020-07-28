<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Edit Account</h1>
    <div id="edit_account_form">
        <form action="." method="post">
            <input type="hidden" name="action" value="update_account">
            <label for="">E-mail</label>
            <input type="text" name="email" value="<?= htmlspecialchars($email); ?>">
            <?= $fields->getField('email')->getHTML(); ?><br>

            <label for="">First Name:</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($firstName); ?>">
            <?= $fields->getField('firstName')->getHTML(); ?><br>

            <label for="">Last Name:</label>
            <input type="text" name="lastName" value="<?= htmlspecialchars($lastName); ?>">
            <?= $fields->getField('lastName')->getHTML(); ?><br>

            <label for="">New Password:</label>
            <input type="text" name="password1" value="<?= htmlspecialchars($password1); ?>">
            <?= $fields->getField('password1')->getHTML(); ?><br>

            <label for="">Retype Password:</label>
            <input type="text" name="password2" value="<?= htmlspecialchars($password2); ?>">
            <?= $fields->getField('password2')->getHTML(); ?><br>

            <label for="">&nbsp;</label>
            <input type="submit" value="Update Account">
        </form>
        <form action="." method="post">
            <label>&nbsp;</label>
            <input type="submit" value="Cancel">
        </form>
    </div>
</main>
<?php include '../view/footer.php'; ?>