<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Util\Database;

$ticketInfo = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        $var = Database::get()->execute(
                "SELECT issue_prefix, tickets.*, COALESCE(SUM(time_spent), 0) AS total_time_spent FROM tickets
                        JOIN projects on projects.id = tickets.project_id
                        LEFT JOIN time_logs on tickets.id = time_logs.ticket_id
                        WHERE tickets.id = ?", [$_GET['id']])->fetch(PDO::FETCH_ASSOC);
        if ($var) {
            $ticketInfo = $var;
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Ticket Info</title>
    <?php include "../components/head.php" ?>
</head>
<body class="common-body">
<?php require_once("../components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Ticket Information</div>
    </div>
    <div class="window-body">
        <?php if (isset($ticketInfo)) : ?>
        <div class="title-container">
            <div class="ticket-icon-number-container">
                <img class="icon" src="../assets/icons/ticket.png" alt="Ticket Icon"/>
                <span><?=$ticketInfo["issue_prefix"]."-".$ticketInfo["local_id"]?></span>
            </div>
            <div class="field-border" style="padding: 8px; width: 30%; min-width: 200px">
                <?=$ticketInfo["name"]?>
            </div>
            <div>
                <?=$ticketInfo["kind"]?>
            </div>

        </div>
        <br>
        <div style="gap: 4px; display: flex; flex-wrap: wrap">
            <span class="status-field-border" style="padding: 6px">
                Status: <span class="status-value"><?=$ticketInfo["status"]?></span>
            </span>
            <span class="status-field-border" style="padding: 6px">
                Priority: <span class="status-value" style="color: yellow"><?=$ticketInfo["priority"]?></span>
            </span>
            <span class="status-field-border" style="padding: 6px">
                Type: <span class="status-value" style="color: darkred"><?=$ticketInfo["type"] ?? "Unset"?></span>
            </span>
            <span class="status-field-border" style="padding: 6px">
                Total Time Spent: <span class="status-value" style="color: darkred"><?=$ticketInfo["total_time_spent"]?> m</span>
            </span>
        </div>
        <br>
        <div class="field-border" style="padding: 8px; min-height: 10rem; max-width: 300px">
            <?=$ticketInfo["description"]?>
        </div>
        <br/>
        <b>Assigned collaborators:</b>
        <br/>
        <div class="sunken-panel small-sunken-table">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Time Spent</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Jason John</td>
                    <td>5h 32m</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br/>
        <b>Attachments:</b>
        <br/>
        <div class="sunken-panel small-sunken-table">
            <table>
                <thead>
                <tr>
                    <th>File name</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>latest.log</td>
                    <td>4.1ko</td>
                    <td><a href="#">Download</a><span style="width: 8px; display: inline-block"></span><a
                            href="#">[x]</a></td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php else : ?>
        Ticket not found.
        <?php endif; ?>
    </div>
</div>
<?php include "../components/bottomnav.php" ?>
</body>
</html>