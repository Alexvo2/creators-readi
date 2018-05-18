<?php $global_settings	= FLBuilderModel::get_global_settings(); ?>
<form id="form-row-width" action="">
	<div class="fl-builder-settings-fields">
		<table class="fl-form-table">
			<tbody>
				<tr id="fl-field-width" class="fl-field" data-type="select">
					<th class="fl-field-label">
						<label for="width"><?php _e('Width', 'fl-builder'); ?>
						<span class="fl-help-tooltip">
							<i class="fl-help-tooltip-icon fa fa-question-circle"></i>
							<span class="fl-help-tooltip-text" style="display: none;"><?php _e('Full width rows span the width of the page from edge to edge. Fixed rows are no wider than the Row Max Width set in the Global Settings.', 'fl-builder'); ?></span>
						</span>
						</label>
					</th>
					<td class="fl-field-control">
						<div class="fl-field-control-wrapper">
							<select name="width">
								<option value=""><?php _e('Default', 'fl-builder'); ?></option>
								<option value="fixed"><?php _e('Fixed', 'fl-builder'); ?></option>
								<option value="full"><?php _e('Full Width', 'fl-builder'); ?></option>
							</select>
						</div>
					</td>
				</tr>
				<tr id="fl-field-content_width" class="fl-field">
					<th class="fl-field-label">
						<label for="content_width"><?php _e('Content Width', 'fl-builder'); ?>
							<span class="fl-help-tooltip">
								<i class="fl-help-tooltip-icon fa fa-question-circle"></i>
								<span class="fl-help-tooltip-text" style="display: none;"><?php _e('Full width content spans the width of the page from edge to edge. Fixed content is no wider than the Row Max Width set in the Global Settings.', 'fl-builder'); ?></span>
							</span>
						</label>
					</th>
					<td class="fl-field-control">
						<div class="fl-field-control-wrapper">
							<select name="content_width">
								<option value=""><?php _e('Default', 'fl-builder'); ?></option>
								<option value="fixed"><?php _e('Fixed', 'fl-builder'); ?></option>
								<option value="full"><?php _e('Full Width', 'fl-builder'); ?></option>
							</select>
						</div>
					</td>
				</tr>
				<tr id="fl-field-max_content_width" class="fl-field">
					<th class="fl-field-label">
						<label for="max_content_width"><?php _e('Fixed Width', 'fl-builder'); ?></label>
					</th>
					<td class="fl-field-control">
						<div class="fl-field-control-wrapper">
							<input type="number" name="max_content_width" value="" placeholder="<?php echo $global_settings->row_width; ?>" class="" step="1">
							<span class="fl-field-description">px</span>
					
						</div>
					</td>
				</tr>
				<tr id="fl-field-full_height" class="fl-field" >
					<th class="fl-field-label">
						<label for="full_height"><?php _e('Height', 'fl-builder'); ?>
							<span class="fl-help-tooltip">
								<i class="fl-help-tooltip-icon fa fa-question-circle"></i>
								<span class="fl-help-tooltip-text" style="display: none;"><?php _e('Full height rows fill the height of the browser window.', 'fl-builder'); ?></span>
							</span>
						</label>
					</th>
					<td class="fl-field-control">
						<div class="fl-field-control-wrapper">
							<select name="full_height">
								<option value=""><?php _e('None', 'fl-builder'); ?></option>
								<option value="default"><?php _e('Default', 'fl-builder'); ?></option>
								<option value="full"><?php _e('Full Height', 'fl-builder'); ?></option>
							</select>
						</div>
					</td>
				</tr>
				<tr id="fl-field-content_alignment" class="fl-field">
					<th class="fl-field-label">
						<label for="content_alignment"><?php _e('Content Alignment', 'fl-builder'); ?></label>
					</th>
					<td class="fl-field-control">
						<div class="fl-field-control-wrapper">
							<select name="content_alignment">
								<option value=""><?php _e('Default', 'fl-builder'); ?></option>
								<option value="top"><?php _e('Top', 'fl-builder'); ?></option>
								<option value="center"><?php _e('Center', 'fl-builder'); ?></option>
								<option value="bottom"><?php _e('Bottom', 'fl-builder'); ?></option>
							</select>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</form>