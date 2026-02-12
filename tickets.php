<?php
$tickets = [
        [
                "id" => "SKB-1",
                "type" => "Included",
                "status" => "In progress",
                "title" => "Ticket Name Go Here :)",
        ],
        [
                "id" => "SKB-2",
                "type" => "Billed",
                "status" => "In progress",
                "title" => "Ticket Name Go Here 2 :)",
        ],
        [
                "id" => "SKB-3",
                "type" => "Included",
                "status" => "Finished",
                "title" => "Ticket Name Go Here 3 :)",
        ],
        [
                "id" => "SKB-4",
                "type" => "Billed",
                "status" => "Finished",
                "title" => "Ticket Name Go Here 4 :)",
        ],
        [
                "id" => "SKB-5",
                "type" => "Billed",
                "status" => "Finished",
                "title" => "Ticket Name Go Here 5 :)",
        ]
];

function shouldDisplay($ticket)
{
    $type = $_GET["filter-type"];
    $status = $_GET["filter-status"];
    $typeGood = is_null($type) || strtolower($type) == "all" || strtolower($type) == strtolower($ticket["type"]);
    $statusGood = is_null($status) || strtolower($status) == "all" || strtolower($status) == strtolower($ticket["status"]);
    return $typeGood && $statusGood;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Tickets</title>
    <?php include "components/head.php" ?>
    <script src="js/ticketListFilter.js"></script>
</head>
<body class="common-body">
<?php require_once("components/sidenav.php"); ?>
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
                <?php foreach ($tickets as $ticket) : if (shouldDisplay($ticket)) : ?>
                <tr>
                    <td><a href="project.php" title="View Project"><?= $ticket["id"] ?></a></td>
                    <td><?= $ticket["type"] ?></td>
                    <td><?= $ticket["status"] ?></td>
                    <td><?= $ticket["title"] ?></td>
                    <td><a href="ticket.php">[View]</a></td>
                </tr>
                <?php endif; endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="create_ticket.php">
            <button>Create new ticket</button>
        </a>
    </div>
</div>
<?php require_once("components/bottomnav.php"); ?>
</body>
</html>