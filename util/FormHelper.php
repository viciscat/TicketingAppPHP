<?php

namespace Util;
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use Component\Popup;


class FormHelper
{
    public bool $valid = true;
    public array $invalidValues = [];
    public array $defaultValues = [];
    private array $params;

    public function __construct($p = null)
    {
        $this->params = is_null($p) ? $_POST : $p;
    }

    public function invalidate($culprit): void
    {
        $this->valid = false;
        if (!in_array($culprit, $this->invalidValues)) $this->invalidValues[] = $culprit;
    }

    public function testParam($parameterName, $verifier = null): bool
    {
        if (!isset($this->params[$parameterName])) {
            $this->invalidate($parameterName);
            return false;
        }
        if ($verifier === null) {
            if (empty($this->params[$parameterName])) {
                $this->invalidate($parameterName);
                return false;
            }
        } else if (is_array($verifier)) {
            foreach ($verifier as $function) {
                if (!$function($this->params[$parameterName])) {
                    $this->invalidate($parameterName);
                    return false;
                }
            }
        } else {
            if (!$verifier($this->params[$parameterName])) {
                $this->invalidate($parameterName);
                return false;
            }
        }
        return true;
    }

    public function testFile($parameterName): bool
    {
        if (empty($_FILES[$parameterName])) {
            $this->invalidate($parameterName);
            return false;
        }
        return true;
    }

    public function getDefaultsFromSession(): void {
        SessionHelper::get()->start();
        if (isset(SessionHelper::get()->data["FORM_DEFAULTS"])) {
            $this->defaultValues = SessionHelper::get()->data["FORM_DEFAULTS"];
        }
    }

    public function putValidParamsInFormDefaults($saveToSession = true): void
    {
        foreach ($this->params as $key => $param) {
            if (!in_array($key, $this->invalidValues)) {
                $this->defaultValues[$key] = $param;
            }
        }
        if ($saveToSession) $this->saveDefaultsToSession();
    }

    public function saveDefaultsToSession(): void
    {
        SessionHelper::get()->start(true);
        $_SESSION["FORM_DEFAULTS"] = $this->defaultValues;
    }

    public function putInvalidParamsInPopup(): void
    {
        ob_start();
        ?>
        Wuh Oh! It seems the server didn't accept this form for some reason! <br>
        These inputs seemed to contain to invalid data: <br>
        <?php foreach ($this->invalidValues as $invalid_value) : ?>
        <span><?= $invalid_value ?></span>
    <?php endforeach; ?>
        <?php
        $message = ob_get_clean();
        SessionHelper::get()->popup(new Popup("Form error!", $message, true));
    }

    // TODO select element support, those don't have a value attribute :(
    public function default($parameterName): string
    {
        return $this->defaultValues[$parameterName] ?? "";
    }

    public function get($parameterName): string
    {
        return $this->params[$parameterName] ?? "";
    }

    public static function isEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function createSelectOption(string $id, array $options, string $placeholder, string $defaultKey = ""): string
    {
        ob_start();
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <select id="<?= $id ?>" name="<?= $id ?>">
            <?php if (empty($defaultKey)) : ?>
                <option value="" selected hidden><?= $placeholder ?></option>
            <?php endif; ?>
            <?php foreach ($options as $key => $value) : ?>
                <option value="<?= $key ?>" <?= ($key == $defaultKey) ? "selected" : "" ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <?php
        return ob_get_clean();
    }

    public static function errorDiv(string $id, string $alt = "", string $extraClasses = ""): string
    {
        ob_start();
        ?>
        <div id="<?= $id ?>" class="hidden font-13px error-message <?= $extraClasses ?>">
            <img src="../assets/icons/msg_error-2.png" alt="Error <?= $alt ?>" width="16" height="16">
            <span></span>
        </div>
        <?php
        return ob_get_clean();
    }
}