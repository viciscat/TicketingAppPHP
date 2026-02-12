<?php
require 'util/util.php';
require 'util/FormHelper.php';
require 'components/popup.php';

$form = new FormHelper();
$form->testParam("name");
$form->testParam("issue-prefix");
$form->testParam("collaborators", function ($collaborators) {
    if ($collaborators) {
        foreach (explode(";", $collaborators) as $collaborator) {
            $temp = explode(":", $collaborator);
            $email = $temp[0];
            if (!isEmailValid($email)) {
                return false;
            }
        }
    }
    return true;
});
$form->testFile("contract");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Create Project</title>
    <?php include "components/head.php" ?>
    <script src="js/formHelper.js"></script>
    <!-- redirect if valid -->
    <?php if ($form->is_request && $form->valid) : ?>
        <meta http-equiv="refresh" content="0; url=project.php" />
    <?php endif; ?>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Project Wizard</div>
    </div>
    <div class="window-body" style="display: flex; flex-direction: column; align-items: flex-start">
        <h4 style="flex-shrink: 0">Project Wizard</h4>
        <div class="window-content">
            <form class="basic-form" id="create-project-form" method="post" enctype="multipart/form-data">
                <div class="field-row-stacked">
                    <label for="name">Project Name</label>
                    <input id="name" type="text" name="name" value="<?= $form->get("name") ?>"/>
                    <div class="hidden font-13px error-message" id="name-error">
                        <img alt="Error Name" height="16" src="icons/msg_error-2.png" width="16">
                        <span>A project must have a name!</span>
                    </div>
                </div>
                <div class="field-row-stacked">
                    <label for="issue-prefix">Issue Prefix</label>
                    <input id="issue-prefix" maxlength="4" required style="max-width: 10ch" type="text" name="issue-prefix" value="<?= $form->get("issue-prefix") ?>"/>
                    <div class="hidden font-13px error-message" id="prefix-error">
                        <img alt="Error Prefix" height="16" src="icons/msg_error-2.png" width="16">
                        <span>A project must have a prefix!</span>
                    </div>
                </div>


                <div class="field-row-stacked">
                    <label for="contract">Contract</label>
                    <input accept="application/pdf" id="contract" required type="file" value="Contract" name="contract"/>
                    <div class="hidden font-13px error-message" id="contract-error">
                        <img alt="Error Contract" height="16" src="icons/msg_error-2.png" width="16">
                        <span>A project must have a prefix!</span>
                    </div>
                </div>
                <div class="field-row-stacked">
                    <input type="hidden" id="collaborators" name="collaborators" />
                    <span>Collaborators</span>
                    <div class="collaborators-input-container">
                        <div class="sunken-panel" style="min-height: 8rem; min-width: 150px">
                            <table id="collaborators-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="field-row">
                                <label for="collaborator-email">Email</label>
                                <input id="collaborator-email" type="email"/>
                                <div class="hidden font-13px error-message" id="collaborator-email-error">
                                    <img alt="Error Collaborator Email" height="16" src="icons/msg_error-2.png"
                                         width="16">
                                    <span></span>
                                </div>
                            </div>
                            <div class="field-row">
                                <label for="collaborator-role">Role</label>
                                <select id="collaborator-role">
                                    <option hidden value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="developer">Developer</option>
                                </select>
                                <div class="hidden font-13px error-message" id="collaborator-role-error">
                                    <img alt="Error Collaborator Role" height="16" src="icons/msg_error-2.png"
                                         width="16">
                                    <span></span>
                                </div>
                            </div>
                            <input id="add-collaborator" onclick="addCollaborator()" type="button"
                                   value="Add collaborator"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <p>These options can be modified later on.</p>
        <input form="create-project-form" type="submit" value="Create Project"/>
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
    let collaborators = {}

    function addCollaborator() {
        let collaborator = document.getElementById('collaborator-email');
        let role = document.getElementById('collaborator-role');
        let valid = true;

        valid &= checkInput(collaborator, 'collaborator-email-error', [
            emptyCondition("Collaborator must not be empty!"),
            emailCondition("Email is invalid!"),
            {
                errorPredicate: input => input.value in collaborators,
                message: "Collaborator already exists!"
            }
        ]);
        valid &= checkInput(role, 'collaborator-role-error', [emptyCondition("A role is required!")]);

        if (valid) {
            let collaboratorTable = document.querySelector("#collaborators-table tbody");
            const row = `
                        <tr>
                            <td>${collaborator.value}</td>
                            <td>${role.value}</td>
                        </tr>
                        `
            collaboratorTable.insertAdjacentHTML('beforeend', row);
            collaborators[collaborator.value] = role.value;
            collaborator.value = ""
            role.value = ""
        }
    }

    document.getElementById('create-project-form').addEventListener('submit', (e) => {
        let valid = true;
        //valid &= checkInput('name', 'name-error', [emptyCondition("Name is required!")]);
        valid &= checkInput('contract', 'contract-error', [emptyCondition("A contract is required!")]);

        valid &= checkInput('issue-prefix', 'prefix-error', [emptyCondition("Issue prefix is required!"), lengthCondition(4, "Prefix must be at most 4 characters long!")]);
        document.getElementById("collaborators").value = Object.entries(collaborators).map(entry => `${entry[0]}:${entry[1]}`).join(";");
        if (!valid) e.preventDefault();
        return valid;
    })
</script>
</html>