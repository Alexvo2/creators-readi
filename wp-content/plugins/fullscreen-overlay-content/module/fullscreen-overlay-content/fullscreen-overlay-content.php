<?php

/**
 * FullScreenOverlayContentModule
 */
class FullScreenOverlayContentModule extends FLBuilderModule
{	
	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          	=> __('Full Screen Overlay Content', 'fullscreen-overlay-content'),
			'description'   	=> __('Display a full screen overlay content.', 'fullscreen-overlay-content'),
			'category'      	=> __('WP Beaver World', 'fullscreen-overlay-content'),
			'group'      		=> __('WP Beaver World', 'fullscreen-overlay-content'),
			'dir' 				=> FSOC_DIR . 'module/fullscreen-overlay-content/',
			'url' 				=> FSOC_URL . 'module/fullscreen-overlay-content/',
			'partial_refresh'	=> true,
			'icon' 				=> FSOC_DIR . 'module/fullscreen-overlay-content/icon.svg'
		));
	}

	/**
	 * Enqueue styles and scripts files
	 *
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		if( empty($this->settings->content) || $this->settings->content == "none" )
			return;
			
		$js_url = FSOC_URL . 'module/fullscreen-overlay-content/js/';

		$this->add_js( 'fsoc-classie', $js_url . 'classie.js', array(), FSOC_VERSION, true );

		if($this->settings->anim_style == 'genie')
			$this->add_js( 'fsoc-snap-svg', $js_url . 'snap.svg-min.js', array(), FSOC_VERSION );

		$this->add_js( 'fsoc-modernizr', $js_url . 'modernizr.custom.js', array(), FSOC_VERSION );
	}

	/**
	 * Getting all full screen overlay content templates
	 *
	 * @method fsoc_builder_templates
	 */
	static public function fsoc_builder_templates()
	{
		global $wpdb;

		$choices['none'] = __( 'None', 'fullscreen-overlay-content' );

		$templates = $wpdb->get_results (
			"
			SELECT ID, post_title 
			FROM $wpdb->posts 
			INNER JOIN {$wpdb->postmeta} ON {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID
			WHERE {$wpdb->posts}.post_status = 'publish'
				AND {$wpdb->posts}.post_type = 'fl-builder-template'
				AND {$wpdb->postmeta}.meta_key = '_wp_page_template' 
				AND {$wpdb->postmeta}.meta_value = 'tpl-fsoc.php'
			ORDER BY {$wpdb->posts}.post_title
			LIMIT 999
			"
		);

		if( $templates )
		{
			foreach( $templates as $tpl)
			{
				$choices[$tpl->ID] = ucfirst( $tpl->post_title );
			}
		}

		return $choices;
	}

	static public function fsoc_animation_style()
	{
		$options = array(
			'corner' 		=> __( 'Corner', 'fullscreen-overlay-content' ),
			'door' 			=> __( 'Door', 'fullscreen-overlay-content' ),
			'genie' 		=> __( 'Genie', 'fullscreen-overlay-content' ),
			'hugeinc' 		=> __( 'Huge Inc', 'fullscreen-overlay-content' ),
			'scale' 		=> __( 'Scale', 'fullscreen-overlay-content' ),
			'simple-genie' 	=> __( 'Simple Genie', 'fullscreen-overlay-content' ),
			'slide-down' 	=> __( 'Slide Down', 'fullscreen-overlay-content' ),
			'contentpush' 	=> __( 'Slide Left to Right', 'fullscreen-overlay-content' )
		);

		return $options;
	}
}

/**
 * Register the module and its settings.
 */
FLBuilder::register_module('FullScreenOverlayContentModule', array(
	'general' 		=> array(
		'title' 		=> __('General', 'fullscreen-overlay-content'),
		'sections' 		=> array(
			'general' 		=> array(
				'title' 		=> '',
				'fields' 		=> array(
					'anim_style' 	=> array(
						'type' 			=> 'select',
						'label' 		=> __( 'Animation Style', 'fullscreen-overlay-content' ),
						'default' 		=> 'door',
						'options' 		=> FullScreenOverlayContentModule::fsoc_animation_style()
					),

					'content'	=> array(
						'type'		=> 'select',
						'label'		=> __('Select Overlay Content', 'fullscreen-overlay-content'),
						'default'	=> 'none',
						'options'	=> FullScreenOverlayContentModule::fsoc_builder_templates()
					),

					'btn_type' 		=> array(
						'type' 			=> 'select',
						'label' 		=> __( 'Call to Action Type', 'fullscreen-overlay-content' ),
						'default' 		=> 'icon',
						'options'		=> array( 'icon' => __( 'Icon', 'fullscreen-overlay-content'), 'button' => __('Button', 'fullscreen-overlay-content' ) ),
						'toggle'  		=> array(
							'icon'			=> array(
								'sections' 		=> array( 'structure', 'icon_style', 'border' ),
								'fields' 		=> array( 'fsoc_icon' )
							),
							'button'		=> array(
								'sections' 		=> array( 'btn_colors', 'btn_style', 'btn_structure' ),
								'fields'		=> array( 'btn_text', 'btn_icon', 'btn_icon_position', 'btn_icon_animation' )
							)
						)
					),

					'fsoc_icon'		=> array(
						'type'          => 'icon',
						'label'         => __('Icon', 'fullscreen-overlay-content'),
						'default' 		=> 'fa fa-bars',
						'show_remove' 	=> true 
					),

					'btn_text'		 => array(
						'type' 			=> 'text',
						'label' 		=> __( 'Button Text', 'fullscreen-overlay-content' ),
						'default' 		=> __( 'Contact', 'fullscreen-overlay-content' )
					),
					
					'btn_icon'		 => array(
						'type'		  => 'icon',
						'label'		  => __( 'Button Icon', 'fullscreen-overlay-content' ),
						'show_remove'	  => true
					),
					
					'btn_icon_position' => array(
						'type'		  => 'select',
						'label'		  => __('Icon Position', 'fullscreen-overlay-content'),
						'default'		  => 'after',
						'options'		  => array(
							'before' 		=> __('Before Text', 'fullscreen-overlay-content'),
							'after' 		=> __('After Text', 'fullscreen-overlay-content')
						)
					),

					'btn_icon_animation' => array(
						'type'		  => 'select',
						'label'		  => __('Icon Visibility', 'fullscreen-overlay-content'),
						'default'		  => 'disable',
						'options'		  => array(
							'disable'		=> __('Always Visible', 'fullscreen-overlay-content'),
							'enable'		=> __('Fade In On Hover', 'fullscreen-overlay-content')
						)
					)
				)
			),

			'structure'		=> array(
				'title'         => __('Structure', 'fullscreen-overlay-content'),
				'fields'        => array(
					'icon_size' 	=> array(
						'type' 			=> 'unit',
						'label' 		=> __('Size', 'fullscreen-overlay-content'),
						'default' 		=> '30',
						'maxlength' 	=> '3',
						'size' 			=> '4',
						'description'   => 'px'
					),

					'icon_align' 	=> array(
						'type'          => 'select',
						'label'         => __('Alignment', 'fullscreen-overlay-content'),
						'default'       => 'center',
						'options'       => array(
							'center'        => __('Center', 'fullscreen-overlay-content'),
							'left'          => __('Left', 'fullscreen-overlay-content'),
							'right'         => __('Right', 'fullscreen-overlay-content')
						)
					)
				)
			),
		)
	),
	
	'styel' 		=> array(
		'title'			=> __('Style', 'fullscreen-overlay-content'),
		'sections' 		=> array(
			'container' 	=> array(
				'fields' 		=> array(
					'cnt_bg_color'	 => array(
						'type'		  => 'color',
						'label'		  => __( 'Wrapper Background Color', 'fullscreen-overlay-content' ),
						'default'		  => '000000',
						'show_reset'	  => true
					),

					'cnt_bg_opacity' => array(
						'type' 			=> 'text',
						'label'         => __( 'Opacity', 'fullscreen-overlay-content' ),
						'default'       => '70',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'preview'         => array(
							'type'            => 'none',
						),
					),
				)
			),

			'icon_style'	=> array(
				'title'         => __('Icon Style', 'fullscreen-overlay-content'),
				'fields'        => array(
					'icon_color'         => array(
						'type'          => 'color',
						'label'         => __('Color', 'fullscreen-overlay-content'),
						'show_reset'    => true
					),

					'icon_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Hover Color', 'fullscreen-overlay-content'),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),
					
					'icon_bg_color'      => array(
						'type'          => 'color',
						'label'         => __('Background Color', 'fullscreen-overlay-content'),
						'show_reset'    => true
					),
					
					'icon_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Background Hover Color', 'fullscreen-overlay-content'),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					)
				)
			),

			'border' 	=> array(
				'title' 	=> __('Border', 'fullscreen-overlay-content'),
				'fields' 	=> array(
					'height'        => array(
						'type'          => 'unit',
						'label'         => __('Height', 'fullscreen-overlay-content'),
						'default'       => '1',
						'maxlength'     => '2',
						'size'          => '3',
						'description'   => 'px',
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.fsoc-icon',
							'property'      => 'border-width',
							'unit'          => 'px'
						)
					),
					
					'border_style'         => array(
						'type'          => 'select',
						'label'         => __('Style', 'fullscreen-overlay-content'),
						'default'       => 'solid',
						'options'       => array(
							'solid'         => _x( 'Solid', 'Border type.', 'fullscreen-overlay-content' ),
							'dashed'        => _x( 'Dashed', 'Border type.', 'fullscreen-overlay-content' ),
							'dotted'        => _x( 'Dotted', 'Border type.', 'fullscreen-overlay-content' ),
							'double'        => _x( 'Double', 'Border type.', 'fullscreen-overlay-content' )
						),
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.fsoc-icon',
							'property'      => 'border-style'
						),
						'help'          => __('The type of border to use. Double borders must have a height of at least 3px to render properly.', 'fullscreen-overlay-content'),
					),

					'border_color' 			=> array(
						'type'          => 'color',
						'label'         => __('Color', 'fullscreen-overlay-content'),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.fsoc-icon',
							'property'      => 'border-color'
						)
					),

					'border_hover_color' 	=> array(
						'type'          => 'color',
						'label'         => __('Hover Color', 'fullscreen-overlay-content'),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none'
						)
					),

					'border_radius' => array(
						'type'		  	=> 'unit',
						'label'		  	=> __( 'Round Corners', 'fullscreen-overlay-content' ),
						'default' 		=> '4',
						'maxlength'	  	=> '3',
						'size'		  	=> '4',
						'description' 	=> 'px'
					)
				)
			),

			'btn_colors'		=> array(
				'title'			=> __( 'Button Colors', 'fullscreen-overlay-content' ),
				'fields'		=> array(
					'btn_bg_color'	 => array(
						'type'		  => 'color',
						'label'		  => __( 'Background Color', 'fullscreen-overlay-content' ),
						'default'		  => '',
						'show_reset'	  => true
					),

					'btn_bg_hover_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Background Hover Color', 'fullscreen-overlay-content' ),
						'default'		  => '',
						'show_reset'	  => true,
						'preview'		  => array(
							'type'		   => 'none'
						)
					),

					'btn_text_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Text Color', 'fullscreen-overlay-content' ),
						'default'		  => '',
						'show_reset'	  => true
					),

					'btn_text_hover_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Text Hover Color', 'fullscreen-overlay-content' ),
						'default'		  => '',
						'show_reset'	  => true,
						'preview'		  => array(
							'type'		   => 'none'
						)
					)
				)
			),

			'btn_style'	   => array(
				'title'			=> __( 'Button Style', 'fullscreen-overlay-content' ),
				'fields'		=> array(
					'btn_style'	 => array(
						'type'		  => 'select',
						'label'		  => __( 'Style', 'fullscreen-overlay-content' ),
						'default'		  => 'flat',
						'options'		  => array(
							'flat'		   => __( 'Flat', 'fullscreen-overlay-content' ),
							'gradient'	   => __( 'Gradient', 'fullscreen-overlay-content' ),
							'transparent'   => __( 'Transparent', 'fullscreen-overlay-content' )
						),
						'toggle'		  => array(
							'transparent'   => array(
								'fields'		=> array( 'btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size' )
							)
						)
					),

					'btn_border_size' => array(
						'type'		  => 'text',
						'label'		  => __( 'Border Size', 'fullscreen-overlay-content' ),
						'default'		  => '2',
						'description'	  => 'px',
						'maxlength'	  => '3',
						'size'		  => '5',
						'placeholder'	  => '0'
					),

					'btn_bg_opacity' => array(
						'type' 			=> 'unit',
						'label' 		=> __( 'Background Opacity', 'fullscreen-overlay-content' ),
						'default' 		=> '0',
						'description' 	=> '%',
						'maxlength' 	=> '3',
						'size' 			=> '5',
						'placeholder' 	=> '0'
					),

					'btn_bg_hover_opacity' => array(
						'type' 					=> 'unit',
						'label' 				=> __('Background Hover Opacity', 'fullscreen-overlay-content'),
						'default' 				=> '0',
						'description' 			=> '%',
						'maxlength' 			=> '3',
						'size' 					=> '5',
						'placeholder' 			=> '0'
					),

					'btn_button_transition' => array(
						'type' 			=> 'select',
						'label' 		=> __('Transition', 'fullscreen-overlay-content'),
						'default' 		=> 'disable',
						'options' 		=> array(
							'disable'		=> __('Disabled', 'fullscreen-overlay-content'),
							'enable' 		=> __('Enabled', 'fullscreen-overlay-content')
						)
					)
				) 
			),

			'btn_structure' => array(
				'title'			=> __( 'Button Structure', 'fullscreen-overlay-content' ),
				'fields'		=> array(
					'btn_width'	 => array(
						'type'		  => 'select',
						'label'		  => __('Width', 'fullscreen-overlay-content'),
						'default'		  => 'auto',
						'options'		  => array(
							'auto'		   => _x( 'Auto', 'Width.', 'fullscreen-overlay-content' ),
							'full'		   => __('Full Width', 'fullscreen-overlay-content')
						)
					),

					'btn_align'		=> array(
						'type' 			=> 'select',
						'label' 		=> __('Alignment', 'fullscreen-overlay-content'),
						'default' 		=> 'left',
						'options' 		=> array(
							'left' 			=> __('Left', 'fullscreen-overlay-content'),
							'center'		=> __('Center', 'fullscreen-overlay-content'),
							'right' 		=> __('Right', 'fullscreen-overlay-content'),
						)
					),

					'btn_font_size' => array(
						'type' 			=> 'unit',
						'label' 		=> __( 'Font Size', 'fullscreen-overlay-content' ),
						'default' 		=> '14',
						'maxlength' 	=> '3',
						'size' 			=> '4',
						'description' 	=> 'px'
					),

					'btn_padding'	 => array(
						'type'		  => 'unit',
						'label'		  => __( 'Padding', 'fullscreen-overlay-content' ),
						'default'		  => '10',
						'maxlength'	  => '3',
						'size'		  => '4',
						'description'	  => 'px'
					),

					'btn_border_radius' => array(
						'type'		  	=> 'unit',
						'label'		  	=> __( 'Round Corners', 'fullscreen-overlay-content' ),
						'default' 		=> '4',
						'maxlength'	  	=> '3',
						'size'		  	=> '4',
						'description' 	=> 'px'
					)
				)
			),

			'closebtn_style' => array(
				'title'			=> __( 'Close Button Style', 'fullscreen-overlay-content' ),
				'fields'		=> array(
					'close_btn_color' 		=> array(
						'type'          => 'color',
						'label'         => __('Color', 'fullscreen-overlay-content'),
						'default' 		=> 'ffffff',
						'show_reset'    => true
					),

					'close_btn_hover_color' => array(
						'type'          => 'color',
						'label'         => __('Hover Color', 'fullscreen-overlay-content'),
						'show_reset'    => true,
						'default' 		=> 'e7e7e7',
						'preview'       => array(
							'type'          => 'none'
						)
					),

					'close_btn_font_size' => array(
						'type' 			=> 'unit',
						'label' 		=> __( 'Font Size', 'fullscreen-overlay-content' ),
						'default' 		=> '20',
						'maxlength' 	=> '3',
						'size' 			=> '4',
						'description' 	=> 'px'
					),
				)
			)
		)
	)
));