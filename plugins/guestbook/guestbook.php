<?php 
/**
 * Plugin Name: Guestbook
 * Description: Guestbook plugin
 * Version: 0.0.1
 */

class Guestbook 
{
	public function __construct() 
	{
		add_shortcode('show_guestbook', [$this, 'show_guestbook']);
		add_shortcode('add_guestbook_post', [$this, 'add_guestbook_post']);
		add_action('admin_menu', [$this, 'set_admin_menu']);
	}

	public function show_guestbook($attr)
	{
		global $wpdb;

		$user = wp_get_current_user();
		$userID = $user->id;

		if($_SERVER['REQUEST_METHOD'] == 'POST' && is_user_logged_in()) {
			$wpdb->insert($wpdb->prefix . 'guestbook', [
				'title' => sanitize_title($_POST['title']),
				'body'  => sanitize_text_field($_POST['body']),
				'user_id' => $userID
			], [
				'%s',
				'%s',
				'%d'
			]);
		} 

		if($_SERVER['REQUEST_METHOD'] == 'POST' && !is_user_logged_in()) {
			$wpdb->insert($wpdb->prefix . 'guestbook', [
				'title' => sanitize_title($_POST['title']),
				'body'  => sanitize_text_field($_POST['body']),
				'email' => sanitize_email($_POST['email']),
				'name' 	=> sanitize_title($_POST['name'])
			], [
				'%s',
				'%s',
				'%s',
				'%s'
			]);
		} 

		$results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'guestbook ORDER BY c_at ASC LIMIT ' . $attr['max']);
		
		foreach ($results as $result) {
			echo '<h1>' . esc_html($result->title) . '</h1>';
			echo '<em>' . esc_html($result->c_at) . '</em>';
			echo '<p>' . esc_html($result->body) . '</p>';
			if($result->name){
				echo '<em>By: ' . esc_html($result->name) . '</em>';
			}
		}	
	}

	public function add_guestbook_post() 
	{
		if(is_user_logged_in()) {
			require_once('form.php');
		} else {
			require_once('login-form.php');
		}
		
	}

	public function custom_admin_page() 
	{
		global $wpdb;
		echo '<h1>My admin page</h1>';
		require_once('admin-page.php');
	}

	public function set_admin_menu() 
	{
		$page_title = 'Guestbook plugin';
		$menu_title = 'Guestbook';
		$cap = 'manage_options';
		$slug = 'my-custom-page';
		$cb = [$this, 'custom_admin_page'];
		$icon = null;
		$position = 31;

		add_menu_page($page_title, $menu_title, $cap, $slug, $cb, $icon, $position);
	}
}

new Guestbook();