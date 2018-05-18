<div class="nodes-setting-panel">
	<div class="bulk-actions">
		<span class="bulk-row-general general active">
			<i class="icon fa fa-wrench"></i><?php _e('General', 'bb-smart-settings-ui'); ?>
		</span>
		<span class="bulk-row-width">
			<i class="icon fa fa-arrows-h"></i><?php _e('Width', 'bb-smart-settings-ui'); ?>
		</span>
		<span class="bulk-row-del">
			<i class="icon fa fa-trash-o"></i><?php _e('Delete', 'bb-smart-settings-ui'); ?>
		</span>
	</div>

	<div class="expand-collapse">
		<span class="refresh-ui-panel"><i class="fa fa-refresh"></i> <?php _e('Refresh', 'bb-smart-settings-ui'); ?></span> | 
		<span class="expand_all"><i class="fa fa-long-arrow-down"></i> <?php _e('Expand All', 'bb-smart-settings-ui'); ?></span> | 
		<span class="collapse_all"><i class="fa fa-long-arrow-up"></i> <?php _e('Collapse All', 'bb-smart-settings-ui'); ?></span>
	</div>
	
	<div class="all-nodes general-content">
	<?php BBNodesSettings::get_all_nodes();?>
	</div>

	<?php include_once BBSUI_DIR . 'includes/ui-spacing.php'; ?>
</div>