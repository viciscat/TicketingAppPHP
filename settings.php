<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticketing98 - Settings</title>
    <?php include "components/head.php" ?>
</head>
<body class="common-body">
<?php require_once ("components/sidenav.php"); ?>
<div class="window" id="main">
  <div class="title-bar">
    <div class="title-bar-text">Settings</div>
  </div>
  <div class="window-body" style="width: fit-content">
      <div class="field-row">
        <label for="language">Language</label>
        <select id="language">
          <option value="en">English</option>
          <option value="fr">French</option>
        </select>
      </div>
      <div class="field-row">
      <label>Bumpscosity:</label>
      <label for="bumpscosity">Low</label>
      <input id="bumpscosity" type="range" min="1" max="11" value="5" />
      <label>High</label>
      </div>
  </div>
</div>
<div class="window bottom-nav-bar">
  <button class="start-menu-button" onclick="startMenuClick()">
    <img alt="Start Icon" src="icons/windows-0.png">
    <span><b>Start Menu</b></span>
  </button>
</div>

</body>
</html>