<?php

/*
 * Plugin Name: Event Manager
 * Version 1.0
 */

class Event
{    
    public function __construct() 
    {
    	add_action('init', [$this, 'set_cpt_events']);
    	add_action('add_meta_boxes', [$this, 'set_meta_boxes']);
        add_action('save_post', [$this, 'save_custom_post_type']);
    }

    public function set_cpt_events()
    {
    	register_post_type('events', [
            'hierarrchical' => true,
            'label'         => 'Events', 
            'public'        => TRUE,
            'supports'      => ['title', 'editor','thumbnail']
        ]);
    }

    public function set_meta_boxes() 
    {
        add_meta_box(
            'event_data',
            'Event Data',
            [$this, 'event_data_view'],
            'events',
            'advanced',
            'default'
        );
    }

    public function event_data_view($data) 
    {
        $startdate = get_post_meta($data->ID, 'event_start', true);
        $enddate = get_post_meta($data->ID, 'event_end', true);
        require_once('views/event-data.php');
    }

    public function save_custom_post_type($post_id)
    {
        if (isset($_POST['startdate']) && !empty($_POST['startdate'])) 
        {
            update_post_meta(
                $post_id, 
                'event_start', 
                $_POST['startdate']
                );
        }

        if (isset($_POST['enddate']) && !empty($_POST['enddate'])) 
        {
            update_post_meta(
                $post_id, 
                'event_end', 
                $_POST['enddate']
                );
        }
    }
}

new Event();