<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Util\Database;
use Util\FormHelper;
use Util\SessionHelper;
SessionHelper::get()->start();
$form = new FormHelper();
$form->getDefaultsFromSession();

$projects = [];
Database::get()->execute("SELECT id, name FROM projects")->fetchAll(PDO::FETCH_FUNC, function ($id, $name) use (&$projects) {
    $projects[$id] = $name;
})
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - New Ticket</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php include "../components/head.php" ?>
    <script src="../js/formHelper.js"></script>
</head>
<body class="common-body">
<?php require_once("../components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Ticket Wizard</div>
    </div>
    <div class="window-body" style="display: flex; flex-direction: column; align-items: flex-start">
        <h4 style="flex-shrink: 0">Ticket Wizard</h4>
        <div class="window-content">
            <form id="create-ticket-form" class="basic-form" method="post" action="../actions/create_ticket_action.php">
                <div class="field-row-stacked">
                    <label for="project">Target Project</label>
                    <?= FormHelper::createSelectOption("project", $projects, "Select Project", $form->default("project")); ?>
                    <?= FormHelper::errorDiv("project-error") ?>
                </div>

                <div class="field-row-stacked">
                    <label for="name">Ticket Name</label>
                    <input id="name" type="text" name="name" value="<?=$form->default("name");?>" />
                    <?= FormHelper::errorDiv("name-error") ?>
                </div>

                <!-- Dropdowns -->
                <div class="field-row-stacked">
                    <label for="ticket-kind">Ticket Kind</label>
                    <?= FormHelper::createSelectOption("ticket-kind", ["task" => "Task", "issue" => "Issue"], "Select Kind" , $form->default("ticket-kind")); ?>
                    <?= FormHelper::errorDiv("ticket-kind-error") ?>
                </div>
                <div class="field-row-stacked">
                    <label for="priority">Priority</label>
                    <?= FormHelper::createSelectOption("priority", ["low" => "1 - Low", "medium" => "2 - Medium", "high" => "3 - High", "urgent" => "4 - Urgent"], "Select Priority", $form->default("priority")); ?>
                    <?= FormHelper::errorDiv("priority-error") ?>
                </div>
                <div class="field-row-stacked">
                    <label for="ticket-type">Type</label>
                    <?= FormHelper::createSelectOption("ticket-type", ["included" => "Included", "billed" => "Billed"], "Unset"); ?>
                    <?= FormHelper::errorDiv("ticket-type-error") ?>
                </div>
                <div class="field-row-stacked" style="width: 300px">
                    <label for="description">Description</label>
                    <textarea id="description" rows="8" name="description"><?= $form->default("description") ?></textarea>
                </div>
            </form>

        </div>
        <input form="create-ticket-form" type="submit" value="Create Ticket"/>
    </div>
</div>
<?php include "../components/bottomnav.php" ?>
<?= SessionHelper::get()->getPopup() ?>
</body>
<script>
    document.getElementById('create-ticket-form').addEventListener('submit', (e) => {
        let valid = true;
        valid &= checkInput('project', 'project-error', [emptyCondition("A ticket must be linked to a project!")]);
        valid &= checkInput('name', 'name-error', [emptyCondition("A ticket must have a name!")]);
        valid &= checkInput('ticket-kind', 'ticket-kind-error', [emptyCondition("A ticket must have a kind!")]);
        valid &= checkInput('priority', 'priority-error', [emptyCondition("A ticket must have to a priority!")]);
        if (!valid) e.preventDefault();
        return valid;
    })
</script>
</html>