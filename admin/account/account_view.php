<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Administrator Accounts</h1>
    <h2>My Account</h2>
    <p><?php if (isset($_SESSION['admin'])) : ?>
            <?= $_SESSION['admin']['firstName'] . $_SESSION['admin']['lastName'] . ' (' . $_SESSION['admin']['emailAddress'] . ')'; ?></p>
    <form action="." method="post">
        <input type="hidden" name="action" value="viewEdi">
        <input type="hidden" name="adminId" value="<?= $_SESSION['admin']['adminId'] ?>">
        <input type="submit" value="Edit">
    </form>
<?php endif; ?>
<?php if (count($admins) > 1) : ?>
    <h2>Other Administrators</h2>
    <table>
        <?php foreach ($admins as $admin) :
            if ($admin['adminId'] != $_SESSION['admin']['adminId']) : ?>
                <tr>
                    <td>
                        <?= $admin['lastName'] . ', ' . $admin['firstName'] ?>
                    </td>
                    <td>
                        <form action="." method="post" class="inline">
                            <input type="hidden" name="action" value="vieEdit">
                            <input type="hidden" name="adminId" value="<?= $admin['adminId'] ?>">
                            <input type="submit" value="Edit">
                        </form>
                        <form action="." method="post" class="inline">
                            <input type="hidden" name="action" value="viewDeleteConfirm">
                            <input type="hidden" name="adminId" value="<?= $admin['adminId'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<h2>Add an Administrator</h2>
<form action="." method="post" id="add_admin_user_form" class="">
    <input type="hidden" name="action" value="create">
    <label for="">Email:</label>
    <input type="text" name="Email" id="" class="" value="<?= htmlspecialchars($email) ?>">
    <span class="error"><?= $emailMessage ?></span>
    <?= $fields->getField('email')->getHTML() ?>

    <label for="">First Name:</label>
    <input type="text" name="firstName" id="" class="" value="<?= htmlspecialchars($firstName) ?>">
    <?= $fields->getField('firstName')->getHTML() ?>

    <label for="">Last Name:</label>
    <input type="text" name="lastName" id="" class="" value="<?= htmlspecialchars($lastName) ?>">
    <?= $fields->getField('lastName')->getHTML() ?>

    <label for="">Password:</label>
    <input type="text" name="password1" id="" class="" value="<?= htmlspecialchars($password1) ?>">
    <span class="error"><?= $passwordMessage ?></span>
    <?= $fields->getField('password1')->getHTML() ?>

    <label for="">Retype Password:</label>
    <input type="text" name="password2" id="" class="" value="<?= htmlspecialchars($password2) ?>">
    <?= $fields->getField('password2')->getHTML() ?>
    <label>&nbsp;</label>
    <input type="submit" value="Add Admin User">
</form>
</main>
<?php include '../view/footer.php'; ?>