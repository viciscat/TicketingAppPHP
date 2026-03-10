<?php

namespace Util;
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use Component\Popup;

class SessionHelper
{
    private static array $SHOULD_FORGET = ["CREATE_POPUP", "FORM_DEFAULTS"];
    private static SessionHelper $instance;

    public static function get(): SessionHelper
    {
        if (!isset(self::$instance)) self::$instance = new SessionHelper();
        return self::$instance;
    }

    private bool $sessionRead = false;
    private bool $sessionOpen = false;
    public array $data = [];

    private function __construct()
    {
    }

    private function openSession(): void
    {
        if (!$this->sessionOpen) {
            $this->sessionOpen = true;
            session_start();
        }
    }

    public function saveAndCloseSession(): void
    {
        if ($this->sessionOpen) {
            $this->sessionOpen = false;
            session_write_close();
        }
    }

    public function start($write = false): void
    {
        if ($write) $this->openSession();
        if (!$this->sessionRead) {
            $this->openSession();
            $this->sessionRead = true;
            $this->data = $_SESSION;
            foreach (self::$SHOULD_FORGET as $value) {
                unset($_SESSION[$value]);
            }
            if (!$write) $this->saveAndCloseSession();
        }
    }

    public function getPopup(): string
    {
        $this->start();
        if (isset($this->data["CREATE_POPUP"])) {
            $popup = $this->data["CREATE_POPUP"];
            return new Popup($popup["title"], $popup["message"], $popup["error"]);
        }
        return "";
    }


    public function popup(Popup $popup, $close = false): void
    {
        $this->start(true);
        $_SESSION["CREATE_POPUP"] = [
            "title" => $popup->title,
            "message" => $popup->message,
            "error" => $popup->isError
        ];
        if ($close) $this->saveAndCloseSession();
    }
}