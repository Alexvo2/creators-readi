<?php

final class FullScreenOverlayCongtent
{
	static private $module_settings;
	static private $module_id;

	/**
	 * Init method.
	 */ 
	static public function init()
	{
		add_filter( "theme_fl-builder-template_templates", 	__CLASS__ .'::fsoc_fl_builder_template_templates', 1008 );
		add_filter( 'template_include', 					__CLASS__ . '::fsoc_template_include', 1010 );
	}

	/**
	 * Adds template into fl-builder-template post type
	 */
	static public function fsoc_fl_builder_template_templates( $templates )
	{
		$templates['tpl-fsoc.php'] = __( 'Full Screen Overlay Content', 'fullscreen-overlay-content' );
		return $templates;
	}

	/**
	 * Includes template
	 */
	static public function fsoc_template_include( $template )
	{
		$tpl_attr = get_post_meta( get_the_ID(), '_wp_page_template', true );

		if( ! empty( $tpl_attr ) && $tpl_attr === 'tpl-fsoc.php' ) 
		{
			return FSOC_DIR . 'tmpl/' . $tpl_attr;
		}

		return $template;
	}

	/**
	 * Rendering the BB template at footer
	 */
	static public function fsoc_render_content($settings, $module_id)
	{		
		if( ! is_object( $settings ) )
			return;

		if( empty($settings->content) || $settings->content == "none" )
			return;

		$close_icon = apply_filters( 'fsoc_close_btn', '<i class="fa fa-close"></i>', $settings );

		echo '<div class="clear"></div>' . "\n";

		if( $settings->anim_style == "genie" )
			echo '<div class="fsoc-' . $module_id . '-content fsoc-content fullscreen-overlay overlay-' . $settings->anim_style . '" data-steps="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">
			<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
				<path class="overlay-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z"/>
			</svg>' . "\n";
		else
			echo '<div class="fsoc-' . $module_id . '-content fsoc-content fullscreen-overlay overlay-' . $settings->anim_style . '">' . "\n";

		echo '<div class="fsoc-' . $module_id . '-close-btn fsoc-close-btn">' . $close_icon . '</div>' . "\n";

			add_filter( 'fl_builder_do_render_content', __CLASS__. '::fsoc_do_render_content' );
			FLBuilder::render_query(array(
				'post_type' 		=> get_post_types(),
				'post__in' 			=> array( (int) $settings->content ),
				'posts_per_page' 	=> 1
			));
			remove_filter( 'fl_builder_do_render_content', __CLASS__. '::fsoc_do_render_content' );

		echo '</div>' . "\n";
	}

	/**
	 * Giving permission to display the template
	 */
	static public function fsoc_do_render_content( $bool )
	{
		return true;
	}
}

FullScreenOverlayCongtent::init();