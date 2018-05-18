<?php

class BBNodesSettings
{
	static public $simple_ui 			= '';
	static public $rowUserTemplate 		= '';
	static public $moduleUserTemplate 	= '';
	static public $class 				= '';

	/**
	 * Executes the hooks and filters
	 *
	 * @return void
	 */
	static public function init()
	{
		self::$simple_ui 			= ! FLBuilderUserAccess::current_user_can( 'unrestricted_editing' );
		self::$rowUserTemplate 		= ! FLBuilderModel::is_post_user_template( 'row' );
		self::$moduleUserTemplate 	= ! FLBuilderModel::is_post_user_template( 'module' );

		add_filter( 'fl_builder_ui_bar_buttons', 			__CLASS__ . '::bbsui_ui_bar_buttons' );
		

		add_action( 'wp_enqueue_scripts', 					__CLASS__ . '::bbsui_enqueue_ui_styles_scripts', 90 );
		add_action( 'wp', 									__CLASS__ . '::add_builder_ajax_action', 9 );
		add_action( 'fl_builder_after_ui_bar_title', 		__CLASS__ . '::bbsui_render_ui_panel' );
	}

	/**
	 * Adds the Gear button at title bar
	 *
	 * @param $buttons array
	 * @return array
	 */
	static public function bbsui_ui_bar_buttons( $buttons )
	{
		$simple_ui = ! FLBuilderUserAccess::current_user_can( 'unrestricted_editing' );
		$saved_module = ! FLBuilderModel::is_post_user_template( 'module' );
		$gear_btn = '<svg viewBox="0 0 64 64" width="24" height="24" fill="currentcolor">
					  <path d="M 28.451266828930784 0 L 35.548733171069216 0 L 37.848913477086114 11.830959092273119 A 21 21 0 0 1 42.12585921366158 13.602528021896461 L 52.11808370808484 6.863249712145798 L 57.1367502878542 11.881916291915164 L 50.39747197810354 21.874140786338423 A 21 21 0 0 1 52.16904090772688 26.151086522913886 L 64 28.451266828930784 L 64 35.548733171069216 L 52.16904090772688 37.848913477086114 A 21 21 0 0 1 50.39747197810354 42.12585921366158 L 57.1367502878542 52.11808370808484 L 52.11808370808484 57.1367502878542 L 42.12585921366158 50.39747197810354 A 21 21 0 0 1 37.848913477086114 52.16904090772688 L 35.548733171069216 64 L 28.451266828930784 64 L 26.15108652291389 52.16904090772688 A 21 21 0 0 1 21.874140786338423 50.39747197810354 L 11.881916291915164 57.1367502878542 L 6.863249712145798 52.11808370808484 L 13.602528021896465 42.125859213661585 A 21 21 0 0 1 11.830959092273119 37.848913477086114 L 0 35.54873317106922 L 0 28.45126682893079 L 11.830959092273115 26.15108652291389 A 21 21 0 0 1 13.602528021896461 21.874140786338423 L 6.863249712145791 11.881916291915164 L 11.881916291915157 6.863249712145798 L 21.87414078633841 13.602528021896468 A 21 21 0 0 1 26.151086522913875 11.830959092273122 M 32 20 A 12 12 0 0 0 32 44 A 12 12 0 0 0 32 20"></path>
					</svg>';

		$buttons['nodes-settings'] = array(
			'label' => $gear_btn,
			'show'	=> ! $simple_ui && $saved_module
		);

		return $buttons;
	}

	/**
	 * Enqueues the styles and scripts files
	 *
	 * @return void
	 */
	static public function bbsui_enqueue_ui_styles_scripts()
	{
		if( FLBuilderModel::is_builder_enabled() || ( class_exists('FLThemeBuilder') && FLThemeBuilder::has_layout() ) )
		{
			wp_enqueue_script( 'bbsui-visibility', 			BBSUI_URL . 'assets/js/smart.settings.ui.js', array(), time(), true );
		}

		if ( FLBuilderModel::is_builder_active() )
		{
			wp_enqueue_style( 'datetimepicker', 			BBSUI_URL . 'assets/css/jquery.datetimepicker.css', array(), BBSUI_VERSION, 'all' );
			wp_enqueue_script('datetimepicker', 			BBSUI_URL . 'assets/js/jquery.datetimepicker.full.min.js', array(), BBSUI_VERSION, true);

			wp_enqueue_style( 'bbsui-nodes-settings', 		BBSUI_URL . 'assets/css/nodes-settings.css', array(), time(), 'all' );
			wp_enqueue_script( 'bbsui-ui-panel', 			BBSUI_URL . 'assets/js/ui.panel.js', array(), time(), true );
			wp_localize_script( 'bbsui-ui-panel', 'LOADING', 
				array( 'IMG' => '<img src="' . BBSUI_URL .'loading.gif" class="aligncenter" alt="' . __( 'Loading' ) .'" title="' . __( 'Loading' ) .'" />')
			);
		}
	}

	/**
	 * Performs the AJAX
	 *
	 * @return void
	 */
	static public function add_builder_ajax_action()
	{
		FLBuilderAjax::add_action( 'copy_bbsui_row', 			'BBNodesSettings::bbsui_copy_row', array('node_id') );
		FLBuilderAjax::add_action( 'copy_col_group', 			'BBNodesSettings::bbsui_copy_col_group', array('node_id') );
		FLBuilderAjax::add_action( 'copy_bbsui_parent_col', 	'BBNodesSettings::bbsui_copy_parent_col', array('node_id') );
		FLBuilderAjax::add_action( 'copy_bbsui_col', 			'BBNodesSettings::bbsui_copy_col', array('node_id') );
		FLBuilderAjax::add_action( 'refresh_nodes', 			'BBNodesSettings::bbsui_refresh_nodes', array() );
		FLBuilderAjax::add_action( 'bbsui_setting_row_width', 	'BBNodesSettings::bbsui_setting_row_width', array('node') );

		FLBuilderAjax::add_action( 'exported_data', 			'BBNodesSettings::bbsui_exported_settings', array('nodeId', 'settings') );
	}

	static public function bbsui_exported_settings( $nodeId, $settings )
	{
		$node				= FLBuilderModel::get_node( $nodeId );
		$new_settings		= (object) array_merge( (array) $node->settings, (array) $settings );

		if( ! empty( $new_settings->export_data ) )
		{
			unset( $new_settings->export_data );
		}

		return $new_settings;
	}

	/**
	 * Copying a row
	 */
	static public function bbsui_copy_row( $node_id )
	{
		$row = FLBuilderModel::get_node( $node_id );

		return self::get_column_groups($row);
	}

	/**
	 * Copying a column group
	 */
	static public function bbsui_copy_col_group( $node_id )
	{
		$groupId 	= self::copy_columns_group( $node_id );
		$group 		= FLBuilderModel::get_node( $groupId );
		$render 	= FLBuilderAJAXLayout::render($groupId);

		return array_merge( $render, array( 'nodeId' => $groupId, 'colGroup' => self::get_columns($group) ) );
	}

	/**
	 * Processing the column group copy action
	 */
	static public function copy_columns_group( $node_id = null )
	{
		$layout_data 	= FLBuilderModel::get_layout_data();
		$group 			= FLBuilderModel::get_node( $node_id );
		$new_group_id 	= FLBuilderModel::generate_node_id();
		$cols		 	= FLBuilderModel::get_nodes( 'column', $group );
		$new_nodes	 	= array();

		// Add the new column.
		$layout_data[ $new_group_id ]			= clone $group;
		$layout_data[ $new_group_id ]->node		= $new_group_id;
		$layout_data[ $new_group_id ]->parent	= $group->parent;
		$layout_data[ $new_group_id ]->position	= $group->position + 1;

		// Unset column template data.
		if ( isset( $layout_data[ $new_group_id ]->template_id ) ) {
			unset( $layout_data[ $new_group_id ]->template_id );
			unset( $layout_data[ $new_group_id ]->template_node_id );
			unset( $layout_data[ $new_group_id ]->template_root_node );
		}

		// Get the new child nodes.
		foreach ( $cols as $col ) {

			$new_nodes[ $col->node ]			= clone $col;
			$new_nodes[ $col->node ]->settings	= clone $col->settings;
			$nodes							    = FLBuilderModel::get_nodes( null, $col );

			foreach ( $nodes as $node ) {

				$new_nodes[ $node->node ] = clone $node;

				if ( 'module' == $node->type ) {
					$new_nodes[ $node->node ]->settings = FLBuilderModel::clone_module_settings( $node->settings );
				} elseif ( 'column-group' == $node->type ) {

					$nested_cols = FLBuilderModel::get_nodes( 'column', $node );

					foreach ( $nested_cols as $nested_col ) {

						$new_nodes[ $nested_col->node ]			  = clone $nested_col;
						$new_nodes[ $nested_col->node ]->settings = clone $nested_col->settings;
						$modules							      = FLBuilderModel::get_nodes( 'module', $nested_col );

						foreach ( $modules as $module ) {
							$new_nodes[ $module->node ]			  = clone $module;
							$new_nodes[ $module->node ]->settings = FLBuilderModel::clone_module_settings( $module->settings );
						}
					}
				}
			}
		}// End foreach().

		// Generate new child ids.
		$new_nodes = FLBuilderModel::generate_new_node_ids( $new_nodes );

		// Set child parent ids to the new column id and unset template data.
		foreach ( $new_nodes as $child_node_id => $child ) {
			if ( $child->parent == $group->node || ( isset( $group->template_node_id ) && $child->parent == $group->template_node_id ) ) {
				$new_nodes[ $child_node_id ]->parent = $new_group_id;
			}

			if ( isset( $new_nodes[ $child_node_id ]->template_id ) ) {
				unset( $new_nodes[ $child_node_id ]->template_id );
				unset( $new_nodes[ $child_node_id ]->template_node_id );
			}
		}

		// Merge the child data.
		$layout_data = array_merge( $layout_data, $new_nodes );

		// Update the layout data.
		FLBuilderModel::update_layout_data( $layout_data );

		// Position the new row.
		FLBuilderModel::reorder_node( $new_group_id, $group->position + 1 );

		// Return the new column group.
		return $new_group_id;
	}

	/**
	 * Copying the parent column
	 */
	static public function bbsui_copy_parent_col( $node_id )
	{
		$html = '';

		$col = FLBuilderModel::get_node( $node_id );
		$col_children = FLBuilderModel::get_nodes( null, $col );

		foreach ( $col_children as $col_child ) {

			if ( 'module' == $col_child->type ) {

				$html .= self::get_modules( $col_child );

			} elseif ( 'column-group' == $col_child->type ) {

				$sub_col = '';
				$parent = FLBuilderModel::get_node_parent( $col_child );

				if ( 'column' == $parent->type ) {
					$label 		= __('Sub Column', 'bb-smart-settings-ui');
					$class_wrap = 'nested-col-wrapper';
					$sub_col 	= ' sub-col';
				} else {
					$label 		= __('Column <span class="bbsui-node-id">(#' . $col_child->node . ')</span>', 'bb-smart-settings-ui');
					$class_wrap = 'sub-col-wrapper';
				}

				$html .= '<div class="' . $class_wrap . self::$class . '" id="bbsui-node-' . $col_child->node .'" data-node="' . $col_child->node .'">' . "\n";
				$html .= '<div class="bbsui-col bbsui-node-' . $col_child->node . $sub_col . '">' . "\n";
				$html .= '<div class="bbsui-title">' . $label . '</div>' . "\n";
				$html .= '<div class="bbsui-settings-actions">' . "\n";
				
				if ( 'column' !== $parent->type && ! self::$simple_ui ) {
					$html .= '<i class="bbsui-col-edit fa fa-columns fl-tip" title="' . __('Edit Column', 'bb-smart-settings-ui') . '"></i>' . "\n";
				}

				$html .= '<i class="fa fa-angle-down fl-tip" title="' . __('Expand', 'bb-smart-settings-ui') . '"></i>' . "\n";
				$html .= '</div>' . "\n";
				$html .= '</div>' . "\n";
				$html .= self::get_columns( $col_child );
				$html .= '</div>' . "\n";
			}
		}

		return $html;
	}

	/**
	 * Copying a column
	 */
	static public function bbsui_copy_col( $node_id )
	{
		$html 			= '';
		$col 			= FLBuilderModel::get_node( $node_id );
		$col_children 	= FLBuilderModel::get_nodes( null, $col );

		foreach ( $col_children as $col_child ) {
			if ( 'module' == $col_child->type ) {
				$html .= self::get_modules( $col_child );
			}
		}

		return $html;
	}

	/**
	 * Refreshing the panel content
	 *
	 * @return string
	 */
	static public function bbsui_refresh_nodes()
	{
		global $wp_query;

		return self::get_all_nodes( false );
	}

	/**
	 * Getting all column groups of current page
	 *
	 * @return string
	 */
	static public function get_column_groups( $row )
	{
		$html 	= '';
		$groups = FLBuilderModel::get_nodes( 'column-group', $row ); //print_r($groups);
		$colg 	= 1;

		foreach ( $groups as $group ) 
		{	
			$html .= '<div class="col-group-wrapper">' . "\n";
			$html .= '<div class="bbsui-col-group bbsui-node-' . $group->node .'" id="bbsui-node-' . $group->node .'" data-node="' . $group->node .'">' . "\n";
			$html .= '<div class="bbsui-title">' . __('Column Group', 'bb-smart-settings-ui') . ' <span class="bbsui-node-id">(#' . $group->node . ')</span></div>' . "\n";
			$html .= '<div class="bbsui-settings-actions">' . "\n";
			if( ! self::$simple_ui ) {
				$html .= '<i class="bbsui-col-group-spacing fa fa-square-o fl-tip" title="' . __('Margins/Padding', 'bb-smart-settings-ui') . '"></i>' . "\n";
				$html .= '<i class="bbsui-col-group-copy fa fa-clone fl-tip" title="' . __('Duplicate','bb-smart-settings-ui') . '"></i>' . "\n";
				$html .= '<i class="bbsui-col-group-remove fa fa-trash-o fl-tip" title="' . __('Remove', 'bb-smart-settings-ui') . '"></i>' . "\n";
			}

			$html .= '<i class="fa fa-angle-down fl-tip" title="' . __('Expand', 'bb-smart-settings-ui') . '"></i>' . "\n";
			$html .= '</div>' . "\n";
			$html .= '</div>' . "\n";

			$html .= self::get_columns( $group );
			$html .= '</div>' . "\n";

			$colg++;
		}

		return $html;
	}

	/**
	 * Getting all columns of current page
	 *
	 * @return string
	 */
	static public function get_columns( $group )
	{
		$html 		= '';
		$cols 		= FLBuilderModel::get_nodes( 'column', $group );

		foreach ( $cols as $col ) 
		{
			$parent_col = '';
			$nested = FLBuilderModel::get_nodes( 'column-group', $col );

			if( count( $nested ) > 0 ) {
				$label = __('Parent Column <span class="bbsui-node-id">(#' . $col->node . ')</span>', 'bb-smart-settings-ui');
				$class_wrap = 'parent-col-wrapper';
				$parent_col = '-parent';
			} else {
				$label = __('Column <span class="bbsui-node-id">(#' . $col->node . ')</span>', 'bb-smart-settings-ui');
				$class_wrap = 'col-wrapper';
			}

			$html .= '<div class="' . $class_wrap . self::$class . ' bbsui-node-' . $col->node .'" id="bbsui-node-' . $col->node .'" data-node="' . $col->node .'">' . "\n";
			$html .= '<div class="bbsui-col' . $parent_col .' bbsui-node-' . $col->node .'">' . "\n";
			$html .= '<div class="bbsui-title">' . $label . '</div>' . "\n";
			$html .= '<div class="bbsui-settings-actions">' . "\n";
			if( ! self::$simple_ui ) {
				$html .= '<i class="bbsui-col-edit fa fa-columns fl-tip" title="' . __('Edit Column', 'bb-smart-settings-ui') . '"></i>' . "\n";
				if( $parent_col != '' )
					$html .= '<i class="bbsui-col-spacing fa fa-square-o fl-tip" title="' . __('Margins/Padding', 'bb-smart-settings-ui') . '"></i>' . "\n";

				$html .= '<i class="bbsui-visibility fa fa-eye fl-tip" title="' . __('Visibility', 'bb-smart-settings-ui') . '" data-node="' . $col->node .'"></i>' . "\n";
			}

			$html .= '<i class="fa fa-angle-down fl-tip" title="' . __('Expand', 'bb-smart-settings-ui') . '"></i>' . "\n";
			$html .= '</div>' . "\n";
			$html .= '</div>' . "\n";

			$col_children = FLBuilderModel::get_nodes( null, $col );

			foreach ( $col_children as $col_child ) {

				if ( 'module' == $col_child->type ) {

					$html .= self::get_modules( $col_child );

				} elseif ( 'column-group' == $col_child->type ) {

					$sub_col = '';
					$parent = FLBuilderModel::get_node_parent( $col_child );

					if ( 'column' == $parent->type ) {
						$label = __('Sub Column', 'bb-smart-settings-ui');
						$class_wrap = 'nested-col-wrapper';
						$sub_col = ' sub-col';
					} else {
						$label = __('Column <span class="bbsui-node-id">(#' . $col_child->node . ')</span>', 'bb-smart-settings-ui');
						$class_wrap = 'sub-col-wrapper';
					}

					$html .= '<div class="' . $class_wrap . self::$class . '" id="bbsui-node-' . $col_child->node .'" data-node="' . $col_child->node .'">' . "\n";
					$html .= '<div class="bbsui-col bbsui-node-' . $col_child->node . $sub_col . '">' . "\n";
					$html .= '<div class="bbsui-title">' . $label . '</div>' . "\n";
					$html .= '<div class="bbsui-settings-actions">' . "\n";
					
					if ( 'column' !== $parent->type && ! self::$simple_ui ) {
						$html .= '<i class="bbsui-col-edit fa fa-columns fl-tip" title="' . __('Edit Column', 'bb-smart-settings-ui') . '"></i>' . "\n";
					}

					$html .= '<i class="fa fa-angle-down fl-tip" title="' . __('Expand', 'bb-smart-settings-ui') . '"></i>' . "\n";
					$html .= '</div>' . "\n";
					$html .= '</div>' . "\n";
					$html .= self::get_columns( $col_child );
					$html .= '</div>' . "\n";
				}
			}

			$html .= '</div>' . "\n";
		}

		return $html;
	}

	/**
	 * Getting all modules of current page
	 *
	 * @return string
	 */
	static public function get_modules( $col )
	{
		$html 		= '';
		$module 	= FLBuilderModel::get_module( $col );

		$html .= '<div class="bbsui-module bbsui-node-' . $module->node . self::$class . '" id="bbsui-node-' . $module->node .'" data-node="' . $module->node .'" data-name="' . $module->name .'" data-type="' . $module->settings->type .'">' . "\n";
		$html .= '<div class="bbsui-title">' . $module->name . '</div>' . "\n";

		$html .= '<div class="bbsui-settings-actions">' . "\n";
		$html .= '<i class="bbsui-module-settings fa fa-wrench fl-tip" title="' . __( $module->name . ' Settings', 'bb-smart-settings-ui') . '"></i>' . "\n";
		if( self::$moduleUserTemplate && ! self::$simple_ui ) {
			$html .= '<i class="bbsui-module-copy fa fa-clone fl-tip" title="' . __('Duplicate', 'bb-smart-settings-ui') . '"></i>' . "\n";
			$html .= '<i class="bbsui-module-code fa fa-code fl-tip" title="' . __('CSS', 'bb-smart-settings-ui') . '" data-node="' . $module->node .'" data-type="module"></i>' . "\n";
			$html .= '<i class="bbsui-visibility fa fa-eye fl-tip" title="' . __('Visibility', 'bb-smart-settings-ui') . '" data-node="' . $module->node .'"></i>' . "\n";
			$html .= '<i class="bbsui-module-remove fa fa-trash-o fl-tip" title="' . __('Remove', 'bb-smart-settings-ui') . '"></i>' . "\n";
		}
		$html .= '</div>' . "\n";
		$html .= '</div>' . "\n";

		return $html;
	}

	/**
	 * Getting all nodes of current page
	 *
	 * @return string
	 */
	static public function get_all_nodes( $echo = true )
	{
		$html = '';
		$rows = FLBuilderModel::get_nodes( 'row' );

		foreach ( $rows as $row )
		{
			if( FLBuilderModel::is_node_global($row) )
				self::$class = ' bbsui-global-node';

			$html .= '<div class="row-wrapper' . self::$class . '" id="bbsui-node-' . $row->node .'" data-node="' . $row->node .'">' . "\n";
			$html .= '<div class="bbsui-row bbsui-node-' . $row->node . '">' . "\n";
			$html .= '<div class="bbsui-title">' . __('Row', 'fl-builder') . ' <span class="bbsui-node-id">(#' . $row->node . ')</span></div>' . "\n";
			$html .= '<div class="bbsui-settings-actions">' . "\n";

			if( ! FLBuilderUserAccess::current_user_can( 'global_node_editing' ) && FLBuilderModel::is_node_global($row) )
			{
				$html .= '<i class="fa fa-lock fl-tip" title="' . __('Locked', 'bb-smart-settings-ui') . '"></i>' . "\n";
			} else {
				$html .= '<i class="bbsui-row-edit fa fa-sliders fl-tip" title="' . __('Edit Row', 'bb-smart-settings-ui') . '"></i>' . "\n";
				if( ! FLBuilderModel::is_node_global($row) )
				{
					$html .= '<i class="bbsui-visibility fa fa-eye fl-tip" title="' . __('Visibility', 'bb-smart-settings-ui') . '" data-node="' . $row->node .'"></i>' . "\n";
					$html .= '<i class="fa fa-angle-down fl-tip" title="' . __('Expand', 'bb-smart-settings-ui') . '"></i>' . "\n";
				}
			}

			$html .= '</div>' . "\n";

			$html .= '<div class="reorder-row">' . "\r\n";
			$html .= '<div class="bbsui-title">' . __('Will move here?', 'bb-smart-settings-ui') . '</div>' . "\n";
			$html .= '<div class="cb-wrap"><input type="checkbox" class="cb cb-reorder-row" name="cb-reorder-row"  data-position="' . $row->position . '" /> ' . __('Yes', 'bb-smart-settings-ui') . '</div>' . "\n";
			$html .= '</div>' . "\n";
			
			$html .= '</div>' . "\n";

			if( FLBuilderModel::is_node_global($row) ) {
				$html .= '</div>' . "\n";
				continue;
			}

			$html .= self::get_column_groups($row);

			$html .= '</div>' . "\n";
		}

		$html .= '<div class="bbsui-row-actions">' . "\n";
		$html .= '<i class="bbsui-row-move fa fa-arrows" title="' . __('Move','bb-smart-settings-ui') . '"></i>
				<i class="bbsui-row-settings fa fa-wrench" title="' . __('Row Settings','bb-smart-settings-ui') . '"></i>
				<i class="bbsui-row-copy fa fa-clone" title="' . __('Duplicate','bb-smart-settings-ui') . '"></i>
				<i class="bbsui-row-reset fa fa-undo" title="' . __('Reset Width','bb-smart-settings-ui') . '"></i>
				<i class="bbsui-row-remove fa fa-trash-o" title="' . __('Remove','bb-smart-settings-ui') . '"></i>
				<i class="bbsui-row-close fa fa-times" title="' . __('Close','bb-smart-settings-ui') . '"></i>' . "\n";
		$html .= '</div>' . "\n";

		$html .= '<div class="bbsui-col-actions">' . "\n";
		$html .= '<!--i class="bbsui-col-move fa fa-arrows" title="' . __('Move','bb-smart-settings-ui') . '"></i-->
					<i class="bbsui-col-settings fa fa-wrench" title="' . __('Column Settings','bb-smart-settings-ui') . '"></i>
					<i class="bbsui-col-copy fa fa-clone" title="' . __('Duplicate','bb-smart-settings-ui') . '"></i>
					<i class="bbsui-col-remove fa fa-trash-o" title="' . __('Remove','bb-smart-settings-ui') . '"></i>
					<i class="bbsui-col-close fa fa-times" title="' . __('Close','bb-smart-settings-ui') . '"></i>' . "\n";
		$html .= '</div>' . "\n";

		if( $echo )
			echo $html;
		else
			return $html;
	}

	/**
	 * Getting all rows of current page
	 *
	 * @return string
	 */
	static public function bbsui_get_row_nodes( $node )
	{
		$html = '';
		$rows = FLBuilderModel::get_nodes( 'row' );

		if( is_array( $rows ) )
		{
			if( $node == 'delete' ) {
				$html = '<p class="description">' . __('* Check the checkbox(s) at below and click on the <strong>DELETE</strong> button.', 'bb-smart-settings-ui') . '</p>';
			}

			if( $node == 'width') {
				$html = '<p class="description">' . __('* Check the checkbox(s) at below and click on the <strong>APPLY</strong> button.', 'bb-smart-settings-ui') . '</p>';
			}

			$html .='<div class="select-rows">
						<span>' . __('Select All', 'bb-smart-settings-ui') . ' <input id="cb-select-all" type="checkbox" class="cb" />
						</span>
					 </div>' . "\n";

			foreach ( $rows as $row )
			{
				if( FLBuilderModel::is_node_global($row) )
					continue;

				$html .= '<div class="row-wrapper" id="bbsui-node-' . $row->node .'" data-node="' . $row->node .'">' . "\n";
				$html .= '<div class="bbsui-row bbsui-node-' . $row->node . '">' . "\n";
				$html .= '<div class="bbsui-title">Row <span class="bbsui-node-id">(#' . $row->node . ')</span></div>' . "\n";
				$html .= '<input id="cb-select-' . $row->node .'" type="checkbox" name="cb[]" value="' . $row->node .'" class="cb cb-row">' . "\n";
				$html .= '</div>' . "\n";
				$html .= '</div>' . "\n";
			}

			if( $node == 'delete' ) {
				$html .= '<button class="apply-button fl-builder-button delete-action">'. __('DELETE', 'bb-smart-settings-ui') .'</button>' . "\n";
			}

			if( $node == 'width' ) {
				$html .= '<button class="apply-button fl-builder-button width-action">'. __('APPLY', 'bb-smart-settings-ui') .'</button>' . "\n";
			}
		}

		return $html;
	}

	/**
	 * Resetting the row width
	 *
	 * @return string
	 */
	static public function bbsui_setting_row_width( $node )
	{
		ob_start();

		include_once BBSUI_DIR . "includes/ui-width-tpl.php";
		
		$html = ob_get_clean();
		$html .= self::bbsui_get_row_nodes($node);

		return $html;
	}

	/**
	 * Rendering the Samrt Settings UI panel
	 *
	 * @return string
	 */
	static public function bbsui_render_ui_panel()
	{
		if ( FLBuilderModel::is_builder_active() )
		{
			include BBSUI_DIR . 'includes/ui-panel.php';
		}
	}
}

BBNodesSettings::init();