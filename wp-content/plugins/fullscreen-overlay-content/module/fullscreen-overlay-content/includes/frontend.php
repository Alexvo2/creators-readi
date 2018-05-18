<div class="fsoc-cta-wrapper">
	<?php if( $settings->btn_type == 'icon') : ?>
	<div class="fsoc-icon-wrap">
		<i id="trigger-overlay-<?php echo $id; ?>" class="fsoc-icon <?php echo $settings->fsoc_icon;?>" aria-hidden="true" role="button"></i>
	</div>
	<?php endif;

		if( $settings->btn_type == 'button') :
			echo '<div id="trigger-overlay-' . $id .'" class="fsoc-btn-wrap">';
			FLBuilder::render_module_html( 'button', apply_filters( 'fsoc_btn_html',
				array(
					'bg_color'          => $settings->btn_bg_color,
					'bg_hover_color'    => $settings->btn_bg_hover_color,
					'bg_opacity'        => $settings->btn_bg_opacity,
					'bg_hover_opacity'  => $settings->btn_bg_hover_opacity,
					'button_transition' => $settings->btn_button_transition,
					'border_radius'     => $settings->btn_border_radius,
					'border_size'       => $settings->btn_border_size,
					'font_size'         => $settings->btn_font_size,
					'icon'              => $settings->btn_icon,
					'icon_position'     => $settings->btn_icon_position,
					'link'              => 'JavaScript: void(0);',
					'link_target'       => '_self',
					'padding'           => $settings->btn_padding,
					'style'             => $settings->btn_style,
					'text'              => $settings->btn_text,
					'text_color'        => $settings->btn_text_color,
					'text_hover_color'  => $settings->btn_text_hover_color,
					'width'             => $settings->btn_width,
					'align'				=> $settings->btn_align,
					'icon_animation'	=> $settings->btn_icon_animation
				)
			), $module );
			echo '</div>';
		endif; 
	?>
</div>

<?php FullScreenOverlayCongtent::fsoc_render_content( $settings, $id ); ?>