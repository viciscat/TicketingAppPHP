<?php

class FormHelper
{
    public $valid = true;
    public $is_request;
    public $invalid_values = [];
    private $params;

    public function __construct()
    {
        $this->is_request = count($_POST) > 0 || count($_FILES) > 0;
        $this->params = $_POST;
    }

    private function invalidate($culprit) {
        $this->valid = false;
        if (!in_array($culprit, $this->invalid_values)) $this->invalid_values[] = $culprit;
    }

    // TODO stuff like the client side checks
    public function testParam($parameterName, $verifier = null) {
        if ($verifier === null) {
            if (empty($this->params[$parameterName])) {
                $this->invalidate($parameterName);
                return false;
            }
        } else {
            if (!$verifier($this->params[$parameterName])) {
                $this->invalidate($parameterName);
                return false;
            }
        }
        return true;
    }

    public function testFile($parameterName) {
        if (empty($_FILES[$parameterName])) {
            $this->invalidate($parameterName);
            return false;
        }
        return true;
    }

    // TODO select element support, those don't have a value attribute :(
    public function get($parameterName) {
        if (!$this->is_request || $this->valid) return "";
        if (in_array($parameterName, $this->invalid_values)) return "";
        return $this->params[$parameterName];
    }
}
