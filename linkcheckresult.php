<?php
class LinkCheckResult
{
    public $error_text;
    public $http_code;
    public $redirect_location;
    
    public function __construct($error_text, $http_code, $redirect_location) {
        $this->error_text = $error_text;
        $this->http_code = $http_code;
        $this->redirect_location = $redirect_location; 
        return true;
    }
    
}