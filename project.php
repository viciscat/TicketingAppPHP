<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Project Info</title>
    <?php include "components/head.php" ?>
    <script src="js/ticketListFilter.js"></script>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Project Info</div>
    </div>
    <div class="window-body">
        <div class="title-container">
            <img class="icon" src="icons/computer-2.png" alt="Ticket Icon"/>
            <div class="field-border" style="padding: 8px; width: 30%; min-width: 200px">
                Skyblocker
            </div>
        </div>
        <b>Collaborators:</b>
        <br/>
        <div class="sunken-panel small-sunken-table">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Jason John</td>
                    <td>Developer</td>
                </tr>
                </tbody>
            </table>
        </div>
        <b>Contract:</b>
        <div class="contract-container">
            <button>View contract</button>
            <button>Update contract</button>
            <span>Last Updated: 05/02/2026 at 12:45</span>
        </div>
        <b>Tickets:</b>
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
                <tr>
                    <td><a href="project.html" title="View Project">SKB-1</a></td>
                    <td>Included</td>
                    <td>In progress</td>
                    <td>Ticket Name Go Here :)</td>
                    <td><a href="ticket.php">[View]</a></td>
                </tr>
                <tr>
                    <td><a href="project.html" title="View Project">SKB-2</a></td>
                    <td>Billed</td>
                    <td>Finished</td>
                    <td>Add cool particle effects!!!</td>
                    <td><a href="ticket.php">[View]</a></td>
                </tr>
                </tbody>
            </table>
        </div>
        <a href="create_ticket.php"><button>Create new ticket</button></a>
    </div>
</div>
<?php include "components/bottomnav.php" ?>
</body>
</html>