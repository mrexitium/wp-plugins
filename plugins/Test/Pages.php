<?php
class Pages extends Master {
    public function guestbook(){
        echo 'guestbook is loaded';
    }
    public function guestbook_settings(){
        echo 'settings is loaded';
    }
    public function guestbook_edit(){
        require_once 'view/guestbook-edit.php';
    }
}