<?php

use Util\Database;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$tickets = [];
$filter = require "../util/ticket_filter.php";
$condition = $filter["condition"];
$fetched = Database::get()->execute("SELECT issue_prefix, tickets.* FROM tickets JOIN projects on projects.id = tickets.project_id WHERE $condition", $filter["params"])->fetchAll(PDO::FETCH_ASSOC);
if ($fetched) $tickets = $fetched;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Tickets</title>
    <?php include "../components/head.php" ?>
    <script src="../js/ticketListFilter.js"></script>
</head>
<body class="common-body">
<?php require_once("../components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Tickets List</div>
    </div>
    <div class="window-body">
        <h4>Tickets</h4>
        <div class="filter-row">
            <div class="field-stacked">
                <label for="ticket-type-filter">Ticket Type</label>
                <select id="ticket-type-filter" onchange="updateFilters()">
                    <option value="all">All</option>
                    <option value="included">Included</option>
                    <option value="billed">Billed</option>
                </select>
            </div>
            <div class="field-stacked">
                <label for="ticket-status-filter">Ticket Status</label>
                <select id="ticket-status-filter" onchange="updateFilters()">
                    <option value="all">All</option>
                    <option value="new">New</option>
                    <option value="in progress">In progress</option>
                    <option value="finished">Finished</option>
                </select>
            </div>
        </div>
        <div class="sunken-panel ticket-list">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tickets as $ticket) : ?>
                <tr>
                    <td><a href="../projects/view.php?id=<?=$ticket['project_id']?>" title="View Project"><?= $ticket["issue_prefix"] . "-" . $ticket["local_id"] ?></a></td>
                    <td><?= $ticket["type"] ?? "Unset" ?></td>
                    <td><?= $ticket["status"] ?></td>
                    <td><?= $ticket["name"] ?></td>
                    <td><a href="view.php?id=<?=$ticket['id']?>">[View]</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="create.php">
            <button>Create new ticket</button>
        </a>
    </div>
</div>
<?php require_once("../components/bottomnav.php"); ?>
</body>
</html>