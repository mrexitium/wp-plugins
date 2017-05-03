<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
</head>
<body>
	<h1>Test</h1>
	<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php 
			$args = array( 'post_type' => 'events', 'posts_per_page' => 10 );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
				the_title();
				echo '<div class="entry-content">';
				the_content();
				the_post_thumbnail( 'full' );
				echo '<p>Start: '.strftime('%d/%m/%y %H:%M', strtotime(get_post_meta( get_the_ID(), 'event_start' )[0])).'</p>';
				echo '<p>End: '.strftime('%d/%m/%y %H:%M', strtotime(get_post_meta( get_the_ID(), 'event_end' )[0])).'</p>';
				echo '</div>';
				echo '<hr>';
			endwhile;

			 ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
</body>
</html>