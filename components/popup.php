<?php

function createPopup($title, $message, $is_error) {
    ob_start();
    ?>
<div id="popup-container">
    <div id="popup-window" class="window">
        <div class="title-bar">
            <div class="title-bar-text"><?= $title ?></div>

        </div>
        <div class="window-body">
            <div class="message">
                <img src="<?= $is_error ? "../icons/msg_error-0.png" : "../icons/msg_information-0.png" ?>" alt="Error Icon" width="32" height="32" />
                <p>
                    <?= $message ?>
                </p>
            </div>
            <button onclick="document.getElementById('popup-container').remove()" style="float: right">Ok</button>
        </div>
    </div>
</div>
<?php
    return ob_get_clean();
}