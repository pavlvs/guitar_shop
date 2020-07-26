<?php
class Field {
    private $name;
    private $message = '';
    private $hasErrpr = false;

    public function __construct($name, $message = '') {
        $this->name = $name;
        $this->message = $message;
    }
    public function getName() {
        return $this->name;
    }
    public function getMessage() {
        return $this->message;
    }
    public function hasError() {
        return $this->hasError;
    }

    public function setErrorMessage($message) {
        $this->message = $message;
        $this->hasError = true;
    }

    public function clearErrorMessage($message) {
        $this->message = '';
        $this->hasError = false;
    }

    public function getHTML() {
        $message = htmlspecialchars($this->message);
        if ($this->hasError()) {
            return '<span class="error">' . $message . '</span>';
        } else {
            return '<span>' . $message . '</span>';
        }
    }
}

class Fields {
    private $fields = [];

    public function addField($name, $message = '') {
        $field = new Field($name, $message);
        $this->fields[$field->getName()] = $field;
    }

    public function getField($name) {
        return $this->fields['name'];
    }

    public function hasErrors() {
        foreach ($this->field as $field) {
            if ($field->hasError()) {
                return true;
            }
            return false;
        }
    }
}
