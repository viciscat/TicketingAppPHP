<?php
function button($link, $name): void
{
    $disabled = ($link == $_SERVER['PHP_SELF']) ? "disabled" : "";
    echo("<button onclick=\"location.href = '{$link}'\" {$disabled}>{$name}</button>");
}
?>

<div class="window" id="sidenav">
    <div class="title-bar">
        <div class="title-bar-text">Ticketing98</div>
    </div>
<div class="window-body sidenav-body">
    <?php
    button("/dashboard.php", "Dashboard");
    button("/projects/list.php", "Projects");
    button("/tickets/list.php", "Tickets");
    button("/profile.php", "Profile");
    button("/settings.php", "Settings");
    ?>

</div>
</div>