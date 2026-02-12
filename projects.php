<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Projects</title>
    <?php include "components/head.php" ?>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
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
                <tr>
                    <td>Skyblocker</td>
                    <td>SKB</td>
                    <td>25</td>
                    <td><a href="project.php">[View]</a></td>
                </tr>
                </tbody>
            </table>
        </div>
        <button>Create new project</button>
    </div>
</div>
<?php include "components/bottomnav.php" ?>
</body>
</html>