<?php
class Master{
    protected $url;
    
    public function __construct() {
        $this->url = plugins_url('test');
    }
}