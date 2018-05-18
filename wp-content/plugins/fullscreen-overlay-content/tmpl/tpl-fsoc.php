<?php 

/*
Template Name: Full Screen Overlay Content
Template Post Type: fl-builder-template
*/

add_filter( 'fl_topbar_enabled', 		'__return_false' );
add_filter( 'fl_fixed_header_enabled', 	'__return_false' );
add_filter( 'fl_header_enabled', 		'__return_false' );
add_filter( 'fl_footer_enabled', 		'__return_false' );

get_header(); 

?>

<div class="fl-content-full container">
	<div class="fsoc-content">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<?php the_content() ?>
		<?php endwhile; endif; ?>
	</div>
</div>

<?php get_footer(); ?>