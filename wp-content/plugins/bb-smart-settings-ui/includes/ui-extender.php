<?php

add_filter( 'fl_builder_register_settings_form', 'bbsui_add_zindex_settings', 999, 2 );
function bbsui_add_zindex_settings( $form, $slug )
{
	if( $slug === 'module_advanced' )
	{
		$form['sections']['zi'] = bbsui_get_zindex_settings();
		$form['sections']['animation']['fields']['mobile_animation'] = array(
			'type'		=> 'select',
			'label' 	=> __( 'Small Device', 'bb-smart-settings-ui' ),
			'default'	=> 'no',
			'options' 	=> array(
				'no' 		=> __( 'No', 'bb-smart-settings-ui' ),
				'yes'		=> __( 'Yes', 'bb-smart-settings-ui' )
			),
			'help' 		=> __('Are you wanting to enable the animation effect for mobile device also?', 'bb-smart-settings-ui' )
		);
	}

	if( $slug === 'col' )
	{
		$form['tabs']['advanced']['sections']['czi'] = bbsui_get_zindex_settings();
		$form['tabs']['ie'] = bbsui_ie();
	}

	if( $slug === 'row' )
	{
		$form['tabs']['advanced']['sections']['rzi'] = bbsui_get_zindex_settings();
		$form['tabs']['ie'] = bbsui_ie();
	}

	$modules = FLBuilderModel::get_enabled_modules(); //* getting all active modules slug

	if( in_array( $slug, $modules ) )
	{
		$form['ie'] = bbsui_ie();
	}

	return $form;
}

function bbsui_ie()
{
	return array(
		'title' 	=> __('Import/Export', 'bb-smart-settings-ui' ),
		'sections' 	=> array(
			'bbsui_export' => array(
				'title' 	=> __('Export', 'bb-smart-settings-ui' ),
				'fields' 	=> array(
					'export_btn'  => array(
						'type' 			=> 'button',
						'label' 		=> __('Export Settings', 'bb-smart-settings-ui'),
						'class' 		=> 'export-data',
						'preview' 		=> array(
							'type' 			=> 'none'
						)
					),
					'export_data' => array(
						'type' 			=> 'textarea',
						'label' 		=> __('', 'bb-smart-settings-ui'),
						'description' 	=> __('Copy this exported data for import. Select whole by pressing CTRL + A.', 'bb-smart-settings-ui'),
						'rows' 			=> 15,
						'class' 		=> 'hide-textarea',
						'preview' 		=> array(
							'type' 			=> 'none'
						)
					)
				)
			),
			'bbsui_import' => array(
				'title' 	=> __('Import', 'bb-smart-settings-ui' ),
				'fields' 	=> array(
					'import_data' => array(
						'type' 			=> 'textarea',
						'description' 	=> __('Paste the exported content here. Later click on the <strong>"Import Settings"</strong> button at below.', 'bb-smart-settings-ui'),
						'rows' 			=> 15,
						'preview' 		=> array(
							'type' 			=> 'none'
						)
					),
					'export_btn'  => array(
						'type' 			=> 'button',
						'label' 		=> __('Import Settings', 'bb-smart-settings-ui'),
						'class' 		=> 'import-data',
						'preview' 		=> array(
							'type' 			=> 'none'
						)
					),
				)
			)
		)
	);
}

function bbsui_get_zindex_settings()
{
	return array(
		'title' 	=> __('z-index', 'bb-smart-settings-ui'),
		'fields' 	=> array(
			'z_index' 	=> array(
				'type' 		=> 'unit',
				'label' 	=> __('z-index', 'bb-smart-settings-ui'),
				'placeholder' => '0',
				'size' 		=> 5
			),
			'zi_pos' 	=> array(
				'type' 		=> 'select',
				'label' 	=> __('Position', 'bb-smart-settings-ui'),
				'default' 	=> 'none',
				'options' 	=> array(
					'none' 		=> __('None', 'bb-smart-settings-ui'),
					'relative' 	=> __('Relative', 'bb-smart-settings-ui'),
					'absolute' 	=> __('Absolute', 'bb-smart-settings-ui')
				)
			)/*,
			'zi_align' => array(
				'type' 		=> 'dimension',
				'label' 	=> __('Alignment', 'bb-smart-settings-ui'),
				'placeholder' => 0,
				'description' => 'px'
			)*/
		)
	);
}

add_filter( 'fl_builder_row_attributes', 'bbsui_node_attributes', 20, 2 );
add_filter( 'fl_builder_column_attributes', 'bbsui_node_attributes', 20, 2 );
add_filter( 'fl_builder_module_attributes', 'bbsui_node_attributes', 20, 2 );
function bbsui_node_attributes( $attrs, $node )
{
	if( ! empty( $node->settings->vtype ) && $node->settings->vtype === 'bp' )
	{
		$min_width = 0;
		$max_width = 9999;

		if( ! empty( $node->settings->bp_min ) )
			$min_width = $node->settings->bp_min;

		if( ! empty( $node->settings->bp_max ) )
			$max_width = $node->settings->bp_max;

		$attrs['data-min-width'] = $min_width;
		$attrs['data-max-width'] = $max_width;

		$attrs['class'][] = 'check-breakpoint bbsui-visibility-hidden';
	}

	if( ! empty( $node->settings->z_index ) )
	{
		$attrs['class'][] = $node->type . '-zindex';
	}

	if( ! empty( $node->settings->mobile_animation ) && $node->settings->mobile_animation == 'yes' )
	{
		$attrs['class'][] = 'do-mobile-animation';
	}

	return $attrs;
}

add_filter( 'fl_builder_is_node_visible', 'bbsui_is_node_visible', 20, 2 );
function bbsui_is_node_visible( $is_visible, $node )
{
	if( empty( $node->settings->vtype ) )
		return $is_visible;

	if( $node->settings->vtype === "draft" )
	{
		return false;
	}

	if( $node->settings->vtype == 'schedule' && ! empty( $node->settings->schedule_time ) )
	{
		date_default_timezone_set( $node->settings->timezone );

		// date time now.
		$date = new DateTime();
		$date->format( 'Y/n/j H:i' );
		$now = $date->getTimestamp();

		$schedule_time = new DateTime( $node->settings->schedule_time );
		$schedule_time = $schedule_time->getTimestamp();

		if( $schedule_time > $now )
		{
			return false;
		}
	}

	if( $node->settings->vtype == 'expire' && ! empty( $node->settings->expire_date ) )
	{
		date_default_timezone_set( $node->settings->timezone );

		// date time now.
		$date = new DateTime();
		$date->format( 'Y/n/j H:i' );
		$now = $date->getTimestamp();

		$expire_date = new DateTime( $node->settings->expire_date );
		$expire_date = $expire_date->getTimestamp();

		if( $now >= $expire_date )
		{
			return false;
		}
	}

	if( $node->settings->vtype == 'dt_range' && ! empty( $node->settings->start_date ) && ! empty( $node->settings->end_date ) )
	{
		date_default_timezone_set( $node->settings->timezone );

		// date time now.
		$date = new DateTime();
		$date->format( 'Y/n/j H:i' );
		$now = $date->getTimestamp();

		$start_date = new DateTime( $node->settings->start_date );
		$start_date = $start_date->getTimestamp();

		$end_date = new DateTime( $node->settings->end_date );
		$end_date = $end_date->getTimestamp();

		if( $now >= $start_date && $now <= $end_date )
		{
			$is_visible = true;
		} else {
			$is_visible = false;
		}
	}

	return $is_visible;
}

add_filter( 'fl_builder_render_css', 'bbsui_filter_render_css', 999, 2 );
function bbsui_filter_render_css( $css, $nodes )
{
	$css .= '.bbsui-visibility-hidden{ display: none; }';
	$css .= '@media (max-width: 768px) {
				.fl-builder-mobile .do-mobile-animation.fl-animation:not(.fl-animated) {
					opacity: 0;
				}
			}'. "\r\n";

	foreach ( array('rows', 'columns', 'modules' ) as $type )
	{
		foreach ($nodes[$type] as $key => $node) {

			if( ! empty( $node->settings->z_index ) )
			{
				$css .= '.fl-node-' . $node->node . '.' . $node->type . '-zindex { ' . "\r\n";
				$css .= "\t" . 'z-index: ' . $node->settings->z_index . ';' . "\r\n";

				if( ! empty( $node->settings->zi_pos ) )
				{
					$css .= "\t" . 'position: ' . $node->settings->zi_pos . ';' . "\r\n";
				}

				/*foreach ( array('top', 'right', 'bottom', 'left' ) as $value )
				{
					$key = 'zi_align_' . $value;
					if( ! empty( $node->settings->{$key} ) )
					{
						$css .= "\t" . $value . ': ' . $node->settings->{$key} . 'px;' . "\r\n";
					}
				}*/

				$css .= "}" . "\r\n";
			}

			if ( ! class_exists( 'lessc' ) ) {
				require_once BBSUI_DIR . 'classes/class-lessc.php';
			}

			if( ! empty( $node->settings->module_css ) )
			{
				try {
					$less    = new lessc;
					$custom  = '.fl-node-' . $node->node . ' { ';
					$custom .= $node->settings->module_css;
					$custom .= ' }';
					$css    .= @$less->compile( $custom );
				} catch ( Exception $e ) {
					$css .= $node->settings->module_css;
				}
			}
		}
	}

	return $css;
}