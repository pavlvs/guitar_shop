<?php include '../../view/header.php'; ?>
<?php include '../..view/sidebar.php'; ?>
<main>
    <h1>Edit Account`</h1>
    <div id="edit_account_form">
        <form action="." method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="adminId" value="<?= $adminId; ?>">

            <label>Email:</label>
            <input type="text" name="email" value="<?= htmlspecialchars($email); ?>">
            <?= $fields->getField('email')->getHTML(); ?><br>

            <label>First Name:</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($firstName); ?>">
            <?= $fields->getField('firstName')->getHTML(); ?><br>

            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastName); ?>">
            <?= $fields->getField('lastName')->getHTML(); ?><br>

            <label>New Password:</label>
            <input type="password" name="password1" value="<?= htmlspecialchars($password1); ?>">
            <?= $fields->getField('password1')->getHTML(); ?><br>

            <label>Retype Password:</label>
            <input type="password" name="password2" value="<?= htmlspecialchars($password2); ?>">
            <?= $fields->getField('password2')->getHTML(); ?><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update Account">
            <span class="error">
                <?= htmlspecialchars($passwordMessage) ?>
            </span><br>
        </form>
        <form action="." method="post">
            <label>&nbsp;</label>
            <input type="submit" value="Cancel">
        </form>
    </div>
</main>
<?php include '../../view/footer.php'; ?>