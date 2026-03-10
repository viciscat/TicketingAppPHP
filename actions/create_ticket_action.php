<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Util\Database;
use Util\FormHelper;
use Util\SessionHelper;


$form = new FormHelper();
$form->testParam("name");
$form->testParam("project", function($p) {
    if (!is_numeric($p)) return false;
    return Database::get()->execute("SELECT COUNT(*) FROM projects WHERE id = ?", [(int)$p])->fetchColumn() > 0;
});
$form->testParam("ticket-kind", function($kind) {
    return in_array($kind, ['task', 'issue']);
});
$form->testParam("priority", function($priority) {
    return in_array($priority, ['low', 'medium', 'high', 'urgent']);
});
if ($form->valid) {
    Database::get()->execute("INSERT INTO tickets (project_id, name, type, kind, priority, description) VALUES (:project_id, :name, :type, :kind, :priority, :description)", [
        ":project_id" => $form->get("project"),
        ":name" => $form->get("name"),
        ":type" => $form->get("ticket-type"),
        ":kind" => $form->get("ticket-kind"),
        ":priority" => $form->get("priority"),
        ":description" => $form->get("description")
    ]);
    $ticketID = Database::get()->lastInsertId();
    header("Location: /tickets/view.php?id=$ticketID");
} else {
    $form->putInvalidParamsInPopup();
    SessionHelper::get()->saveAndCloseSession();
    header("location:/tickets/create.php");
}