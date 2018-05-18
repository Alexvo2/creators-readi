<?php

class BBNodesVisibility
{
	static public function init()
	{
		self::bbsui_register_visibility_settings_form();
	}
	
	static public function bbsui_register_visibility_settings_form()
	{
		/*FLBuilder::register_settings_form('cfrule', array(
			'title' => __('Custom Field Rule', 'bb-smart-settings-ui'),
			'tabs'  => array(
				'cf_rule' 	=> array(
					'title' 	=> __('General', 'fl-builder'),
					'sections'  => array(
						'general' => array(
							'fields' 	=> array(
								'cf_name' 	=> array(
									'type' 		=> 'text',
									'label' 	=> __('Custom Field Name', 'bb-smart-settings-ui'),
									'placeholder'	=> 'custom_field_name',
									'help' 		=> __('Enter the meta key here.', 'bb-smart-settings-ui')
								),
								'cf_value' 	=> array(
									'type' 		=> 'text',
									'label' 	=> __('Custom Field Value', 'bb-smart-settings-ui'),
									'help' 		=> __('Enter the meta value here. This value will be compared with post/page/cpt meta value.', 'bb-smart-settings-ui')
								),
								'compare' 	=> array(
									'type'          => 'select',
									'label'         => __( 'Compare', 'bb-smart-settings-ui' ),
									'default' 		=> '=',
									'options'       => array(
										'=' 		=> __('Equal to', 'bb-smart-settings-ui'),
										'!=' 		=> __('Not Equal to', 'bb-smart-settings-ui'),
										'>'			=> __('Greater than', 'bb-smart-settings-ui'),
										'>=' 		=> __('Greater than, Equal to', 'bb-smart-settings-ui'),
										'<' 		=> __('Less than', 'bb-smart-settings-ui'),
										'<='		=> __('Less than, Equal to', 'bb-smart-settings-ui')
									)
								),
							),
						),
					),
				),
			),
		));*/

		FLBuilder::register_settings_form('visibility', array(
			'title' => __( 'Visibility Settings', 'bb-smart-settings-ui' ),
			'tabs' => array(
				'general' 	=> array(
					'title' 	=> __('General', 'bb-smart-settings-ui'),
					'sections' 	=> array(
						'general' => array(
							'fields'	=> array(
								'vtype' 		=> array(
									'type' 		=> 'select',
									'label' 	=> __('Type', 'bb-smart-settings-ui'),
									'default' 	=> 'none',
									'options' 	=> array(
										'none' 		=> __('None', 'bb-smart-settings-ui'),
										'bp' 		=> __('Breakpoint', 'bb-smart-settings-ui'),
										//'cf' 		=> __('Custom Field', 'bb-smart-settings-ui'),
										'draft' 	=> __('Save as draft', 'bb-smart-settings-ui'),
										'schedule' 	=> __('Schedule for', 'bb-smart-settings-ui'),
										'expire' 	=> __('Hide on expire date', 'bb-smart-settings-ui'),
										'dt_range' 	=> __('Visible between date range', 'bb-smart-settings-ui'),
									),
									'toggle' 	=> array(
										'bp' 		=> array(
											'sections' 	=> array('breakpiont')
										),
										'schedule' 	=> array(
											'fields'	=> array('schedule_time', 'timezone')
										),
										'expire' 	=> array(
											'fields'	=> array('expire_date', 'timezone')
										),
										'dt_range' 	=> array(
											'fields'	=> array('start_date', 'end_date', 'timezone')
										),
										/*'cf' 	=> array(
											'fields'	=> array('cf_rules')
										)*/
									),
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								'timezone' => array(
									'type'			=> 'timezone',
									'label'			=> __('Timezone', 'bb-smart-settings-ui'),
									'default'		=> get_option('timezone_string'),
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								'schedule_time' => array(
									'type'			=> 'text',
									'label'			=> __('Date', 'bb-smart-settings-ui'),
									'class'			=> 'node_schedule',
									'size' 			=> '25',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								'expire_date' => array(
									'type'			=> 'text',
									'label'			=> __('Date', 'bb-smart-settings-ui'),
									'class'			=> 'node_schedule',
									'size' 			=> '25',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								'start_date' => array(
									'type'			=> 'text',
									'label'			=> __('Start Date', 'bb-smart-settings-ui'),
									'class'			=> 'node_schedule',
									'size' 			=> '25',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								'end_date' => array(
									'type'			=> 'text',
									'label'			=> __('End Date', 'bb-smart-settings-ui'),
									'class'			=> 'node_schedule',
									'size' 			=> '25',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
								/*'cf_rules' 		=> array(
									'type' 			=> 'form',
									'label' 		=> __('Custom Field Rule', 'bb-smart-settings-ui'),
									'form' 			=> 'cfrule',
									'preview_text' 	=> 'cf_name',
									'multiple' 		=> true,
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								)*/
							)
						),
						'breakpiont' => array(
							'title' 	=> __('Breakpoint', 'bb-smart-settings-ui'),
							'fields'	=> array(
								'bp_min' => array(
									'type' 		=> 'text',
									'label' 	=> __('Min Width', 'bb-smart-settings-ui'),
									'placeholder' => '768',
									'description' => 'px',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),

								'bp_max' => array(
									'type' 		=> 'text',
									'label' 	=> __('Max Width', 'bb-smart-settings-ui'),
									'placeholder' => '992',
									'description' => 'px',
									'preview' 	=> array(
										'type' 		=> 'none'
									)
								),
							)
						)
					)
				)
			)
		));
	}
}

BBNodesVisibility::init();