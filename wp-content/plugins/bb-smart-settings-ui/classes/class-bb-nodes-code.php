<?php

class NodesCode
{
	static public function init()
	{
		self::bbsui_register_module_code_form();
	}

	static public function bbsui_register_module_code_form()
	{
		FLBuilder::register_settings_form('module_code', array(
			'title' => __( 'Module Style', 'bb-smart-settings-ui' ),
			'tabs' => array(
				'mcss' 	=> array(
					'title' 	=> __('CSS', 'bb-smart-settings-ui'),
					'sections' 	=> array(
						'module_css'       => array(
							'fields'        => array(
								'module_css'     => array(
									'type'          => 'code',
									'editor'        => 'css',
									'label'         => '',
									'rows'          => '18',
									'preview' 		=> array(
										'type' 			=> 'none'
									)
								),
							)
						)
					)
				)
			)
		) );
	}
}

NodesCode::init();