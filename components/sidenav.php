<?php
function button($link, $name)
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
    button("/TicketingAppPHP/dashboard.php", "Dashboard");
    button("/TicketingAppPHP/projects.php", "Projects");
    button("/TicketingAppPHP/tickets.php", "Tickets");
    button("/TicketingAppPHP/profile.php", "Profile");
    button("/TicketingAppPHP/settings.php", "Settings");
    ?>

</div>
</div>