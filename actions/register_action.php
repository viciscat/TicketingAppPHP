<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

use Component\Popup;
use Util\Database;
use Util\FormHelper;
use Util\SessionHelper;

$form = new FormHelper();
$form->testParam("first-name");
$form->testParam("last-name");
$form->testParam("email", function ($email) {
    return FormHelper::isEmailValid($email);
});
$form->testParam("password");
$form->testParam("confirm-password", function ($password) use ($form) {
    return $password === $form->get('password');
});
if ($form->valid) {
    $password_hashed = password_hash($form->get('password'), PASSWORD_BCRYPT);
    try {
        if (Database::get()->execute(
            "SELECT COUNT(*) FROM users WHERE email = :email",
            [":email" => $form->get('email')]
        )->rowCount() > 0) {
            SessionHelper::get()->popup(new Popup("Email already in use!", "A user already exists with this email! <br/> Please use another one.", true), true);
            header("location:/register.php");
        } else {
            Database::get()->execute(
                "INSERT INTO users (first_name, last_name, email, password_hash) VALUES (:first_name, :last_name, :email, :password_hash)",
                [
                    ":first_name" => $form->get("first-name"),
                    ":last_name" => $form->get("last-name"),
                    ":email" => $form->get("email"),
                    ":password_hash" => $password_hashed
                ]
            );
            SessionHelper::get()->popup(new Popup("User created!", "User created successfully! You can now login with it!", false), true);
            header("location:/login.php");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

} else {
    //die(implode(",", $form->invalid_values) . " , " . $form->get("password") . " , " . $form->get("confirm-password"));
    $form->putInvalidParamsInPopup();
    SessionHelper::get()->saveAndCloseSession();
    header("location:/register.php");
}