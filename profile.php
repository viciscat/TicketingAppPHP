<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Profile</title>
    <?php include "components/head.php" ?>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
    <div class="title-bar">
        <div class="title-bar-text">Profile Info</div>
    </div>
    <div class="window-body">
        <b>Name</b>
        <p>Jason John</p>
        <b>Role</b>
        <p>Administrator</p>
        <b>Email</b>
        <p><a href="mailto:jason.john@company.com">jason.john@company.com</a></p>
        <b>Phone</b>
        <p>123-456-7890</p>
        <b>Time Zone</b>
        <p>UTC+2</p>
        <button>Edit Profile</button>
    </div>
</div>
<?php include "components/bottomnav.php" ?>

</body>
</html>