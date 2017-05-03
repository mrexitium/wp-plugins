<?php

/*
 * Plugin Name: Test
 * Version 0.8
 */

require_once 'Master.php';

class Test extends Master{
    
    public function __construct() 
    {
        parent:: __construct();
        add_action('admin_menu', [$this, 'add_pages']);
        add_action('admin_enqueue_scripts', [$this, 'styles']);
        add_action('init', [$this, 'set_cpt_books']);
        add_action('add_meta_boxes', [$this, 'set_meta_boxes']);
        add_action('save_post', [$this, 'save_custom_post_type']);
    }

    public function add_pages() 
    {
        require_once 'Pages.php';
        $pages = new Pages();

        add_menu_page(
            'Guestbook', 
            'Guestbook', 
            'moderate_comments', 
            'guestbook.php', 
            [$pages, 'guestbook'], 
            null, 
            100
        );

        add_submenu_page(
            'guestbook.php', 
            'Settings', 
            'Settings', 
            'manage_options', 
            'guestbook-settings.php', 
            [$pages, 'guestbook_settings']
        );
    
        add_submenu_page(
            '', 
            'Edit Post', 
            'Edit Post', 
            'moderate_comments', 
            'guestbook-edit.php', 
            [$pages, 'guestbook_edit']
        );
    }

    public function styles() 
    {
        $this->set_styles();
        $this->set_scripts();
    }
    
    public function set_cpt_books()
    {
        register_post_type('books', [
            'hierarrchical' => true,
            'label'         => 'Books', 
            'public'        => TRUE
        ]);
    }

    public function set_meta_boxes() 
    {
        add_meta_box(
            'book_data',
            'Book Data',
            [$this, 'book_data_view'],
            'books',
            'advanced',
            'default'
        );
    }

    public function book_data_view($data) 
    {
        $author = get_post_meta($data->ID, 'book_author', true);
        $isbn = get_post_meta($data->ID, 'book_isbn', true);
        // echo '<pre>';
        // print_r($author);
        // die();
        require_once('views/book-data.php');
    }

    public function save_custom_post_type($post_id)
    {
        if (isset($_POST['author']) && !empty($_POST['author'])) 
        {
            update_post_meta(
                $post_id, 
                'book_author', 
                $_POST['author']
                );
        }

        if (isset($_POST['isbn']) && !empty($_POST['isbn'])) 
        {
            update_post_meta(
                $post_id, 
                'book_isbn', 
                $_POST['isbn']
                );
        }
    }

    private function set_styles()
    {
        wp_enqueue_style(
            'test-main', 
            $this->url . 'assets/css/main.css', 
            [], 
            null, 
            'screen'
        );        
    }

    private function set_scripts()
    {
        
    }

}

new Test();
