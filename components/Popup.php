<?php

namespace Component;

class Popup
{
    public string $title;
    public string $message;
    public bool $isError;

    public function __construct(string $title, string $message, bool $isError)
    {
        $this->title = $title;
        $this->message = $message;
        $this->isError = $isError;
    }

    public function __toString(): string
    {
        ob_start();
        ?>
        <div id="popup-container">
            <div id="popup-window" class="window">
                <div class="title-bar">
                    <div class="title-bar-text"><?= $this->title ?></div>

                </div>
                <div class="window-body">
                    <div class="message">
                        <img src="<?= $this->isError ? "../assets/icons/msg_error-0.png" : "../assets/icons/msg_information-0.png" ?>" alt="Error Icon" width="32" height="32" />
                        <p>
                            <?= $this->message ?>
                        </p>
                    </div>
                    <button onclick="document.getElementById('popup-container').remove()" style="float: right">Ok</button>
                </div>
            </div>
        </div>
        <?php
        $popup = ob_get_clean();
        if (is_bool($popup)) return "error";
        return $popup;
    }
}