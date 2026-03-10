<?php

use Util\Database;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$projects = Database::get()->execute("
SELECT projects.*, COUNT(tickets.id) AS open_ticket_count 
FROM projects 
LEFT JOIN tickets on projects.id = tickets.project_id AND tickets.status NOT IN ('finished', 'refused')
GROUP BY projects.id")->fetchAll();
if (!$projects) $projects = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Projects</title>
    <?php include "../components/head.php" ?>
</head>
<body class="common-body">
<?php require_once("../components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Projects List</div>
    </div>
    <div class="window-body">
        <h4>Projects</h4>
        <div class="sunken-panel">
            <table>
                <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Issue Prefix</th>
                    <th>Open Issues</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?=$project["name"]?></td>
                    <td><?=$project["issue_prefix"]?></td>
                    <td><?=$project["open_ticket_count"]?></td>
                    <td><a href="view.php?id=<?=$project["id"]?>">[View]</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button onclick="location.href = 'create.php'">Create new project</button>
    </div>
</div>
<?php include "../components/bottomnav.php" ?>
</body>
</html>