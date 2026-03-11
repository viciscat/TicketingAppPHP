<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Dashboard</title>
    <?php include "components/head.php" ?>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Dashboard</div>
    </div>
    <div class="window-body">
        UNIMPLEMENTED
        <div style="display: flex; flex-direction: row; gap: 8px; flex-wrap: wrap; margin: 16px">
            <div class="dashboard-statistic window">
                <img alt="Icon" class="statistic-icon" src="assets/icons/ticket.png"/>

                <div class="statistic-text">
                    <div class="statistic-title">New Tickets</div>
                    <div class="statistic-number">10</div>
                </div>
            </div>
            <div class="dashboard-statistic window">
                <img alt="Icon" class="statistic-icon" src="assets/icons/ticket_due.png"/>

                <div class="statistic-text">
                    <div class="statistic-title">Tickets Past Due</div>
                    <div class="statistic-number">1</div>
                </div>
            </div>
        </div>
        <b>Your assigned tickets:</b>
        <div class="sunken-panel ticket-list">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">SKB-1</a></td>
                    <td>In progress</td>
                    <td>Ticket Name Go Here :)</td>
                    <td><a href="tickets/view.php">[View]</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="window bottom-nav-bar">
    <button class="start-menu-button" onclick="startMenuClick()"><img alt="Start Icon"
                                                                      src="assets/icons/windows-0.png"><span><b>Start Menu</b></span>
    </button>
</div>
</body>
</html>