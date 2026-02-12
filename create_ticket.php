<?php
require 'util/util.php';
require 'util/FormHelper.php';
require 'components/popup.php';

$form = new FormHelper();
$form->testParam("name");
$form->testParam("kind");
$form->testParam("priority");
$form->testParam("issue-prefix");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - New Ticket</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php include "components/head.php" ?>
    <!-- redirect if valid -->
    <?php if ($form->is_request && $form->valid) : ?>
        <meta http-equiv="refresh" content="0; url=ticket.php" />
    <?php endif; ?>
    <script src="js/formHelper.js"></script>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Ticket Wizard</div>
    </div>
    <div class="window-body" style="display: flex; flex-direction: column; align-items: flex-start">
        <h4 style="flex-shrink: 0">Ticket Wizard</h4>
        <div class="window-content">
            <form id="create-ticket-form" class="basic-form">
                <div class="field-row-stacked">
                    <label for="project">Target Project</label>
                    <select id="project" name="project">
                        <option hidden value="">Select Project</option>
                        <option>Skyblocker</option>
                        <option>Other</option>
                    </select>
                    <div id="project-error" class="hidden font-13px error-message">
                        <img src="icons/msg_error-2.png" alt="Error Project" width="16" height="16">
                        <span>A ticket must be linked to a project!</span>
                    </div>
                </div>

                <div class="field-row-stacked">
                    <label for="name">Ticket Name</label>
                    <input id="name" type="text" name="name" value="<?= $form->get("name") ?>"/>
                    <div id="name-error" class="hidden font-13px error-message">
                        <img src="icons/msg_error-2.png" alt="Error Name" width="16" height="16">
                        <span>A ticket must have a name!</span>
                    </div>
                </div>

                <!-- Dropdowns -->
                <div class="field-row-stacked">
                    <label for="ticket-kind">Ticket Type</label>
                    <select id="ticket-kind" name="kind">
                        <option hidden value="">Select Kind</option>
                        <option>Task</option>
                        <option>Issue</option>
                    </select>
                    <div id="ticket-kind-error" class="hidden font-13px error-message">
                        <img src="icons/msg_error-2.png" alt="Error Ticket Kind" width="16" height="16">
                        <span>A ticket must have a kind!</span>
                    </div>
                </div>
                <div class="field-row-stacked">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <option hidden value="">Select Priority</option>
                        <option>3 - Must</option>
                        <option>2 - Should</option>
                        <option>1 - Could</option>
                    </select>
                    <div id="priority-error" class="hidden font-13px error-message">
                        <img src="icons/msg_error-2.png" alt="Error Priority" width="16" height="16">
                        <span>A ticket must have a priority!</span>
                    </div>
                </div>
                <div class="field-row-stacked" style="width: 300px">
                    <label for="description">Description</label>
                    <textarea id="description" rows="8" name="description"></textarea>
                </div>
            </form>

        </div>
        <p>This will create a ticket for the 'Skyblocker' project.</p>
        <input form="create-ticket-form" type="submit" value="Create Ticket"/>
    </div>
</div>
<?php include "components/bottomnav.php" ?>
<?php if ($form->is_request && !$form->valid) {
    ob_start();
    ?>
    Wuh Oh! It seems the server didn't accept this form for some reason! <br>
    These inputs seemed to contain to invalid data: <br>
    <?php foreach ($form->invalid_values as $invalid_value) : ?>
        <span><?= $invalid_value ?></span>
    <?php endforeach; ?>
    <?php
    $message = ob_get_clean();
    echo createPopup("Form error!", $message, true);
} ?>
</body>
<script>
    document.getElementById('create-ticket-form').addEventListener('submit', (e) => {
        let valid = true;
        valid &= checkInput('project', 'project-error', [emptyCondition("A ticket must be linked to a project!")]);
        valid &= checkInput('name', 'name-error', [emptyCondition("A ticket must have a name!")]);
        valid &= checkInput('ticket-kind', 'ticket-kind-error', [emptyCondition("A ticket must have a kind!")]);
        valid &= checkInput('priority', 'priority-error', [emptyCondition("A ticket must have to a priority!")]);
        if (!valid) e.preventDefault();
    })
</script>
</html>