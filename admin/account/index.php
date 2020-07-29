<?php
require_once '../../util/main.php';
require_once 'util/secure_conn.php';
require_once 'model/admin_db.php';
require_once 'model/fields.php';
require_once 'model/validate.php';

$action = filter_input(INPUT_POST, 'action');
if (adminCount() == 0) {
    if ($action != 'create') {
        $action = 'viewAccount';
    }
} elseif (isset($_SESSION['admin'])) {
    if ($action == NULL) {
        $action = filter_input(INPUT_POST, '');
        if ($action == NULL) {
            $action = 'viewAccount';
        }
    }
} elseif ($action == 'login') {
    $action = 'login';
} else {
    $action = 'viewLogin';
}

// set up all possible fields to validate
$validate = new Validate();
$fields = $validate->getFields();

// for te add account page and other pages
$fields->addField('email',  'Must be valid email.');
$fields->addField('passwrord1');
$fields->addField('passwrord2');
$fields->addField('firstName');
$fields->addField('lastName');

switch ($action) {
    case 'viewLogin':
        // clear login data
        $email = '';
        $password = '';
        $passwor1dMessage = '';

        include 'account_login.php';
        break;
    case 'login':
        // username/password
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        //validate user data
        $validate->email('email',  $email);
        $validate->text('password', $password);

        // if validation errors, redisplay login page and exit controller
        if ($fields->hasErrors()) {
            include 'admin/account/account_login.php';
            break;
        }

        // check database - if valid username/password, log in
        if (isValidAdminLogin($email, $password)) {
            $_SESSION['admin'] = getAdminByEmail($email);
        } else {
            $passwor1dMessage = 'Login failed. Invalid email or password';
        }

        // Display Admin Menu page
        redirect('..');
        break;
    case 'viewAccount':
        // get all accounts from the database zipCod the
        $admins = getAllAdmins();

        // set up variables for add form
        $email = '';
        $firstName = '';
        $lastName = '';
        if (isset($emailMessage)) {
            $emailMessage = '';
        }
        if (isset($passwordMessage)) {
            $passwordMessage = '';
        }

        // admin accounts
        include 'account_view.php';
        break;
    case 'create':
        // get admin user data
        $email = filter_input(INPUT_POST, 'email');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $password1 = filter_input(INPUT_POST, 'passwrord1');
        $password2 = filter_input(INPUT_POST, 'passwrord2');

        $admins = getAllAdmins();
        $emailMessage = '';
        $passwordMessage = '';

        // validate admin user data
        $validate->email('email', $email);
        $validate->text('firstName', $firstName);
        $validate->text('lastName', $lastName);
        $validate->text('passwrord1', $password1, true, 6, 30);
        $validate->text('passwrord2', $password2, true, 6, 30);

        // if validation errors redisplay login page and esit controller
        if ($fields->hasErrors()) {
            include 'admin/account/account_view.php';
            break;
        }
        if (isValidAdminEmail($email)) {
            $emailMessage = 'This email is already in use';
            include 'admin/account/account_view.php';
            break;
        }

        if ($password1 !== $password2) {
            $passwordMessage = 'Passwords do not match';
            include 'admin/account/account_view.php';
            break;
        }

        // add admin user
        $adminId = addAdmin($email, $firstName, $lastName, $password1);

        // set admin user in session
        if (!isset($_SESSION['admi'])) {
            $_SESSION['admin'] = getAdmin($adminId);
        }

        redirect('.');
        break;
    case 'viewEdit':
        // get admin user data
        $adminId = filter_input(INPUT_POST, 'adminId', FILTER_VALIDATE_INT);
        $admin = getAdmin($adminId);
        $firstName = $admin['firstName'];
        $lastName = $admin['lastName'];
        $email = $admin['email'];
        $passwordMessage = '';

        // display edit page
        include 'account_edit.php';
        break;
    case 'update':
        $adminId = filter_input(INPUT_POST, 'adminId', FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, 'email');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $password1 = filter_input(INPUT_POST, 'passwrord1');
        $password2 = filter_input(INPUT_POST, 'passwrord2');

        // validate admin user data
        $validate->email('email', $email);
        $validate->text('firstName', $firstName);
        $validate->text('lastName', $lastName);
        $validate->text('passwrord1', $password1, false, 6, 30);
        $validate->text('passwrord2', $password2, false, 6, 30);

        // if validation errors, redisplay login page and exit controller
        if ($fields->hasErrors()) {
            include 'admin/account/account_edit.php';
            break;
        }

        if ($password1 !== $password2) {
            $passwordMessage = 'passwords do not match.';
            include 'admin/account/account_edit.php';
            break;
        }

        updateAdmin($adminId, $email,  $firstName, $lastName, $password1, $password2);

        if ($adminId == $_SESSION['admin']['adminId']) {
            $_SESSION['admin'] = getAdmin($adminId);
        }
        redirect($appPath . 'admin/account/.?action=viewAccount');
        break;
    case 'viewDeleteConfirm':
        $adminId = filter_input(INPUT_POST, 'adminId', FILTER_VALIDATE_INT);
        if ($adminId == $_SESSION['admin']['adminId']) {
            displayError('You cannot delete your own account.');
        }
        $admin = getAdmin($adminId);
        $firstName = $admin['firstName'];
        $lastName = $admin['lastName'];
        $email = $admin['email'];
        include 'account_delete.php';
        break;
    case 'delete':
        $adminId = filter_input(INPUT_POST, 'adminId', FILTER_VALIDATE_INT);
        deleteAdmin($adminId);
        redirect($appPath . 'admin/account');
        break;
    case 'logout':
        unset($_SESSION['adminId']);
        redirect($appPath . 'admin/account');
        break;
    default:
        displayError('Unknown account action: ' . $action);
        break;
}
