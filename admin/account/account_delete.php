<?php include '../..view/header.php'; ?>
<?php include '../../view/sidebar.php'; ?>
<main class="nofloat">
    <h1> Delete Account</h1>
    <p>Are you sure you want to delete the account for
        <?= htmlspecialchars($lastName) . ', ' . htmlspecialchars($firstName) . ' (' . htmlspecialchars($email) . ')'; ?>?
    </p>
    <form action="." method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="adminId" value="<?= $adminId; ?>">
        <input type="submit" value="Delete Account">
    </form>
    <form action="." method="post">
        <input type="submit" value="Cancel">
    </form>
</main>
<?php include '../view/footer.php'; ?>