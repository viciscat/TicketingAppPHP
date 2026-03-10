<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Component\Popup;
use Util\Database;
use Util\FormHelper;
use Util\SessionHelper;

$form = new FormHelper();

$form->testParam("name");
$form->testParam("issue-prefix", [function ($prefix) {
    return strlen($prefix) > 0 && strlen($prefix) < 5;
}]);
$parsedCollaborators = [];
$form->testParam("collaborators", function ($collaborators) use (&$parsedCollaborators) {
    if ($collaborators) {
        foreach (explode(";", $collaborators) as $collaborator) {
            if (!FormHelper::isEmailValid($collaborator)) return false;
            $parsedCollaborators[] = $collaborator;
        }
    }
    return true;
});
$form->testParam("included-hours", function ($hours): bool {
    $hours = str_replace(",", ".", $hours);
    return filter_var($hours, FILTER_VALIDATE_INT) && (int)$hours >= 0;
});
$form->testParam("extra-hourly-rate", function ($hours): bool {
    $hours = str_replace(",", ".", $hours);
    return filter_var($hours, FILTER_VALIDATE_FLOAT) && (float)$hours >= 0;
});
$form->testFile("contract");
if ($form->valid) {
    try {
        // Check collaborators
        $unknownCollaborators = [];
        foreach ($parsedCollaborators as $collaborator) {
            if (Database::get()->execute("SELECT COUNT(*) FROM users WHERE email = ?", [$collaborator])->fetchColumn() == 0) {
                $unknownCollaborators[] = $collaborator;
            }
        }
        if (count($unknownCollaborators) > 0) {
            array_filter($parsedCollaborators, function ($collaborator) use ($unknownCollaborators) {
                return !in_array($collaborator, $unknownCollaborators);
            });
            $form->invalidate("collaborators");
            $form->putValidParamsInFormDefaults(false);
            $form->defaultValues["collaborators"] = $parsedCollaborators;
            $form->saveDefaultsToSession();
            $errorMessage = "Unknown collaborators: <br/>" . implode("<br/> ", $unknownCollaborators);
            SessionHelper::get()->popup(new Popup("Prefix already used!", $errorMessage, true), true);
            header("location:/projects/create.php");
            exit;
        }
        // Check prefix
        if (Database::get()->execute("SELECT COUNT(*) FROM projects WHERE issue_prefix = :prefix", [":prefix" => $form->get("issue-prefix")])->fetchColumn() > 0) {
            $form->invalidate("issue-prefix");
            $form->putValidParamsInFormDefaults();
            SessionHelper::get()->popup(new Popup("Prefix already used!", "A project already uses this prefix! <br/> Please use another one.", true), true);
            header("location:/projects/create.php");
            exit;
        }
        // We good!
        $contractFile = $_SERVER['DOCUMENT_ROOT'] . "/uploaded_content/" . time() . $_FILES["contract"]["name"];
        move_uploaded_file($_FILES["contract"]["tmp_name"], $contractFile);
        Database::get()->execute("INSERT INTO contracts (file, included_hours, extra_hourly_rate) VALUES (:file, :included_hours, :extra_hourly_rate)", [
            ":file" => $contractFile,
            ":included_hours" => $form->get("included-hours"),
            ":extra_hourly_rate" => $form->get("extra-hourly-rate")
        ]);
        $contractID = Database::get()->lastInsertId();
        Database::get()->execute("INSERT INTO projects (name, issue_prefix, contract_id) VALUES (:name, :prefix, :contract_id)", [
                ":name" => $form->get("name"),
                ":prefix" => $form->get("issue-prefix"),
                ":contract_id" => $contractID
            ]
        );
        $projectID = Database::get()->lastInsertId();
        foreach ($parsedCollaborators as $collaborator) {
            Database::get()->execute("INSERT INTO project_members (project_id, user_id) SELECT ?, id FROM users WHERE email = ?", [$projectID, $collaborator]);
        }
        // TODO put the collaborators in the project_members table
        header("location:/projects/view.php?id=$projectID");

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    $form->putInvalidParamsInPopup();
    SessionHelper::get()->saveAndCloseSession();
    header("location:/projects/create.php");
}