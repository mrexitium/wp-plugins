<p><strong>Guestbook posts</strong></p>
<table class="widefat">
	<thead>
	<tr>
		<th class="row-title"><?php esc_attr_e( 'Title', 'wp_admin_style' ); ?></th>
		<th><?php esc_attr_e( 'Body', 'wp_admin_style' ); ?></th>
		<th><?php esc_attr_e( 'Delete', 'wp_admin_style' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'guestbook ORDER BY c_at ASC');

		foreach ($results as $result) {
			$title = $result->title;
			$body = $result->body;
			$id = $result->id;
	 ?>
		<tr>
			<td class="row-title"><label for="tablecell"><?php esc_attr_e(
						$title, 'wp_admin_style'
					); ?></label></td>
			<td><?php esc_attr_e( $body, 'wp_admin_style' ); ?></td>
			<td><?php esc_attr_e( 'Delete', 'wp_admin_style' ); ?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
		<th class="row-title"><?php esc_attr_e( 'Title', 'wp_admin_style' ); ?></th>
		<th><?php esc_attr_e( 'Body', 'wp_admin_style' ); ?></th>
		<th><?php esc_attr_e( 'Delete', 'wp_admin_style' ); ?></th>
	</tr>
	</tfoot>
</table>