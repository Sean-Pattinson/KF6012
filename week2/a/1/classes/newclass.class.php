<?php
class NewClass {

    private $message;

    public function __construct($text) {
        $this->setMessage($text);
    }

    public function setMessage($text) {
        $this->message = $text;
    }

    public function getMessage() {
        return "<p>" . $this->message . "<p>";
    }
}
?>