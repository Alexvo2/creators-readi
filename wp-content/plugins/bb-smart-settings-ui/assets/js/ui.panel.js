(function($){
	
	NodesSettings = {
		init: function()
		{
			// Init TipTips
			FLBuilder._initTipTips();
			NodesSettings._bindEvents();
		},

		_bindEvents: function()
		{
			$('.fl-builder-bar-actions .fl-builder-nodes-settings-button').on('click', NodesSettings._toggleUIPanel);
			$('.fl-builder-bar-actions .fl-builder-content-panel-button').on('click', NodesSettings._closeUIPanel);
			$('.fl-builder-bar-actions .fl-builder-done-button').on('click', NodesSettings._closeUIPanel);
			$('.fl-builder-bar-title').on('click', NodesSettings._closeUIPanel);

			/* Bulk Actions */
			$('body').delegate('.bulk-actions .bulk-row-general', 'click', NodesSettings._bulkGeneralButtonClicked);
			$('body').delegate('.bulk-actions .bulk-row-width', 'click', NodesSettings._bulkWidthButtonClicked);
			$('body').delegate('.bulk-actions .bulk-row-spacing', 'click', NodesSettings._bulkSpacingButtonClicked);
			$('body').delegate('.bulk-actions .bulk-row-del', 'click', NodesSettings._bulkDeleteButtonClicked);

			$('body').delegate('.width-action', 'click', NodesSettings._bulkRowWidthApplyButtonClicked);
			$('body').delegate('.delete-action .fa-trash-o', 'click', NodesSettings._bulkDeleteRowButtonClicked);
			$('body').delegate('.delete-action .fa-close', 'click', NodesSettings._bulkDeleteCloseButtonClicked);

			/* Refresh UI Panel */
			$('body').delegate('.refresh-ui-panel', 'click', NodesSettings._refreshUIPanel);

			/* Expand All */
			$('.expand_all').on('click', NodesSettings._expandAll);

			/* Collapse All */
			$('.collapse_all').on('click', NodesSettings._collapseAll);

			$('body').delegate('#cb-select-all', 'click', NodesSettings._checkedAll);

			/* Expand Only Column Groups */
			$('body').delegate('.bbsui-row .fa-angle-down', 'click', NodesSettings._expandColGroup);
			$('body').delegate('.bbsui-row .fa-angle-up', 'click', NodesSettings._expandColGroup);

			/* Expand Only Columns */
			$('body').delegate('.bbsui-col-group .fa-angle-down', 'click', NodesSettings._expandCol);
			$('body').delegate('.bbsui-col-group .fa-angle-up', 'click', NodesSettings._expandCol);

			/* Expand Only Modules */
			$('body').delegate('.bbsui-col-parent .fa-angle-down', 'click', NodesSettings._expandColModule);
			$('body').delegate('.bbsui-col-parent .fa-angle-up', 'click', NodesSettings._expandColModule);
			$('body').delegate('.bbsui-col .fa-angle-down', 'click', NodesSettings._expandModule);
			$('body').delegate('.bbsui-col .fa-angle-up', 'click', NodesSettings._expandModule);

			/* Row */
			//$('body').delegate('.fl-row', 'mouseenter', NodesSettings._selectBBNSRow);
			$('body').delegate('.bbsui-row', 'mouseenter', NodesSettings._selectRow);
			$('body').delegate('.bbsui-row', 'mouseleave', NodesSettings._deselectRow);
			$('body').delegate('.bbsui-row .bbsui-row-move', 'click', NodesSettings._rowMoveButtonClicked);
			$('body').delegate('.reorder-row .cb', 'change', NodesSettings._reorderRow);
			$('body').delegate('.bbsui-row .bbsui-row-edit', 'click', NodesSettings._rowActionsButtons);
			$('body').delegate('.bbsui-visibility', 'click', NodesSettings._visibilityButtonClicked);
			$('body').delegate('.bbsui-row .bbsui-row-settings', 'click', NodesSettings._rowSettingsClicked);
			$('body').delegate('.bbsui-row .bbsui-row-copy', 'click', NodesSettings._rowCopyClicked);
			$('body').delegate('.bbsui-row .bbsui-row-reset', 'click', NodesSettings._resetRowWidthClicked);
			$('body').delegate('.bbsui-row .bbsui-row-remove', 'click', NodesSettings._deleteRowClicked);
			$('body').delegate('.bbsui-row .bbsui-row-close', 'click', NodesSettings._closeRowActionsButtons);

			$('body').delegate('.fl-row-overlay .fl-block-remove', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-row-overlay .fl-block-copy', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-block-col-copy', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-col-overlay .fl-block-remove', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-block-col-submenu .fl-block-col-delete', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-module-overlay .fl-block-remove', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-module-overlay .fl-block-copy', 'click', NodesSettings._refreshUIPanel);

			$('body').delegate('.fl-user-template', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-user-template-edit', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-user-template-delete', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-builder-template-replace-button', 'click', NodesSettings._refreshUIPanel);
			$('body').delegate('.fl-builder-template-append-button', 'click', NodesSettings._refreshUIPanel);

			/* Columns */
			$('body').delegate('.bbsui-col-group', 'mouseenter', NodesSettings._selectColGroup);
			$('body').delegate('.bbsui-col-group', 'mouseleave', NodesSettings._deselectColGroup);
			$('body').delegate('.bbsui-col-group .fa-square-o', 'click', NodesSettings._bulkMarginsPaddingButtonClicked);
			$('body').delegate('.bbsui-col-group-copy', 'click', NodesSettings._copyColGroupClicked);
			$('body').delegate('.bbsui-col-group-remove', 'click', NodesSettings._deleteColGroupClicked);
			$('body').delegate('.parent-col-wrapper .fa-square-o', 'click', NodesSettings._bulkMarginsPaddingButtonClicked);
			$('body').delegate('.spacing-action.button-update', 'click', NodesSettings._bulkUpdateSpacingButtonClicked);
			$('body').delegate('.spacing-action.button-cancel', 'click', NodesSettings._bulkMarginsPaddingButtonClicked);
			
			$('body').delegate('.bbsui-col-parent', 'mouseenter', NodesSettings._selectParentCol);
			$('body').delegate('.bbsui-col-parent', 'mouseleave', NodesSettings._deselectParentCol);
			$('body').delegate('.bbsui-col', 'mouseenter', NodesSettings._selectCol);
			$('body').delegate('.bbsui-col', 'mouseleave', NodesSettings._deselectCol);
			$('body').delegate('.bbsui-col-parent .bbsui-col-edit', 'click', NodesSettings._parentColActionsButtons);
			$('body').delegate('.bbsui-col-parent .bbsui-col-close', 'click', NodesSettings._closeParentColActionsButtons);
			$('body').delegate('.bbsui-col-parent .bbsui-col-settings', 'click', NodesSettings._parentColSettingsClicked);
			$('body').delegate('.bbsui-col-parent .bbsui-col-copy', 'click', NodesSettings._copyParentColClicked);
			$('body').delegate('.bbsui-col-parent .bbsui-col-remove', 'click', NodesSettings._deleteParentColClicked);
			$('body').delegate('.bbsui-col .bbsui-col-edit', 'click', NodesSettings._colActionsButtons);
			$('body').delegate('.bbsui-col .bbsui-col-close', 'click', NodesSettings._closeColActionsButtons);
			$('body').delegate('.bbsui-col .bbsui-col-settings', 'click', NodesSettings._colSettingsClicked);
			$('body').delegate('.bbsui-col .bbsui-col-copy', 'click', NodesSettings._copyColClicked);
			$('body').delegate('.bbsui-col .bbsui-col-remove', 'click', NodesSettings._deleteColClicked);

			/* Module */
			$('body').delegate('.bbsui-module .bbsui-module-code', 'click', NodesSettings._moduleCodeButtonClicked);
			$('body').delegate('.bbsui-module', 'mouseenter', NodesSettings._selectBBNSModule);
			$('body').delegate('.bbsui-module', 'mouseleave', NodesSettings._deselectBBNSModule);
			$('body').delegate('.bbsui-module .bbsui-module-remove', 'click', NodesSettings._deleteModuleClicked);
			$('body').delegate('.bbsui-module .bbsui-module-settings', 'click', NodesSettings._moduleSettingsClicked);
			$('body').delegate('.bbsui-module .bbsui-module-copy', 'click', NodesSettings._moduleCopyClicked);

			$('body').delegate('.fl-builder-module_code-settings .fl-builder-settings-save', 'click', FLBuilder._saveSettings);
			$('body').delegate('.fl-builder-visibility-settings .fl-builder-settings-save', 'click', FLBuilder._saveSettings);
			$('body').delegate('.fl-builder-visibility-settings .node_schedule', 'mouseenter', NodesSettings._datePicker);
			
			FLBuilder.addHook( 'didStopDrag', NodesSettings._refreshUIPanel );
			FLBuilder.addHook( 'triggerDone', NodeVisibility.init);
			FLBuilder.addHook( 'didPublishLayout', NodeVisibility.init);
			FLBuilder.addHook( 'didCancelDiscard', NodeVisibility.init);
			FLBuilder.addHook( 'previewLayout', NodeVisibility.init);
			FLBuilder.addHook( 'restartEditingSession', NodeVisibility.init);
			FLBuilder.addHook( 'endEditingSession', NodeVisibility.init);

			$('body').delegate('.export-data', 'click', NodesSettings._buttonExportClicked );
			$('body').delegate('.import-data', 'click', NodesSettings._buttonImportClicked );
		},

		_buttonExportClicked: function(e)
		{
			var form     = $(this).closest('.fl-builder-settings'),
				valid    = form.validate().form(),
				settings = FLBuilder._getSettings( form ),
				nodeId   = form.attr( 'data-node' );

			if( valid ) {
				FLBuilder.ajax( {
					action 		: 'exported_data',
					nodeId 		: nodeId,
					settings 	: settings
				}, function( response ){
					form.find('textarea[name="export_data"]').val( response );
					form.find('#fl-field-export_data').show();
				} );
			}

			e.stopPropagation();
		},

		_buttonImportClicked: function(e)
		{
			var form     	= $(this).closest('.fl-builder-settings'),
				nodeId   	= form.attr( 'data-node' ),
				importData 	= form.find('textarea[name="import_data"]').val();

			if( importData ) {
				FLBuilder.ajax( {
					action          : 'save_settings',
					node_id         : nodeId,
					settings        : JSON.parse( importData )
				}, FLBuilder._saveSettingsComplete.bind( NodesSettings, true, FLBuilder.preview ) );

				// Trigger the hook.
				FLBuilder.triggerHook( 'didSaveNodeSettings', {
					nodeId   : nodeId,
					settings : JSON.parse( importData )
				} );

				FLBuilder._lightbox.close();
			}

			e.stopPropagation();
		},

		_bulkGeneralButtonClicked: function(e)
		{
			var button = $(this);

			if( ! NodesSettings._addActiveClass(button) )
				return;

			$('.expand-collapse').show();
			$('.all-nodes').removeAttr('style').html( LOADING.IMG );

			FLBuilder.ajax( {
				action: 'refresh_nodes',
			}, function( response ){
				$('.all-nodes').html( JSON.parse( response ) );
			} );

			e.stopPropagation();
		},

		/**
		 * Render the settings form for Width
		 */
		_bulkWidthButtonClicked: function(e)
		{
			var button = $(this),
				parent = button.closest('.bulk-actions'),
				height = parent.height();

			if( ! NodesSettings._addActiveClass(button) )
				return;

			$('.expand-collapse').hide();
			$('.all-nodes').css({'padding-top' : height}).html( LOADING.IMG );

			FLBuilder.ajax( {
				action: 'bbsui_setting_row_width',
				node: 'width'
			}, function( response ){
				$('.all-nodes').html( JSON.parse( response ) );
			} );

			e.stopPropagation();
		},

		/**
		 * Bulk Action: Editing the width of selected rows
		 */
		_bulkRowWidthApplyButtonClicked: function(e)
		{
			var form 		= $('#form-row-width'),
				valid 		= form.validate().form(),
				data 		= form.serializeArray(),
				name 		= '',
				settings 	= {},
				isChecked 	= $('input[name="cb[]"]:checked').length;
			
			if( ! isChecked ) {
				alert('Atleast one checkbox should be checked.');
				return false;
			}

			// Loop through the form data.
			for ( i = 0; i < data.length; i++ ) {
				value = data[ i ].value.replace( /\r/gm, '' );
				if( value != 'undefined' && value != '' )
				{
					name 	= data[ i ].name.replace( /\[(.*)\]/, '' );
					settings[ name ] = value;
				}
			}

			if(valid)
			{
				$('input[type=checkbox]').each(function(){
					if( $(this).prop("checked") )
					{
						var bbnsRow 	= $(this).closest('.row-wrapper'),
							nodeId 		= bbnsRow.attr('data-node'),
							preview 	= FLBuilder.preview;

						// Show the loader.
						FLBuilder._showNodeLoading( nodeId );

						// Update the settings config object.
						FLBuilderSettingsConfig.nodes[ nodeId ] = settings;

						// Make the AJAX call.
						FLBuilder.ajax( {
							action          : 'save_settings',
							node_id         : nodeId,
							settings        : settings
						}, FLBuilder._saveSettingsComplete.bind( this, true, preview ) );

						// Trigger the hook.
						FLBuilder.triggerHook( 'didSaveNodeSettings', {
							nodeId   : nodeId,
							settings : settings
						} );
					}
				});
			}

			NodesSettings._closeUIPanel();

			e.stopPropagation();
		},

		_bulkSpacingButtonClicked: function()
		{
			var button = $(this),
				parent = button.closest('.bulk-actions'),
				height = parent.height();

			if( ! NodesSettings._addActiveClass(button) )
				return;

			$('.expand-collapse').hide();
			$('.all-nodes').css({'padding-top' : height});
		},

		_bulkDeleteButtonClicked: function(e)
		{
			NodesSettings._closeUIPanel();
			
			$('.fl-row').each(function() {
				nodeId = $(this).attr('data-node');
				$(this).before('<div class="del-row" data-node="' + nodeId + '"><input type="checkbox" class="cb cb-row" name="cb[]" value="' + nodeId + '" /></div>');
			});

			$('body').append('<div class="delete-action bulk-delete"><i class="fa fa-trash-o"></i><i class="fa fa-close"></i></div>');

			e.stopPropagation();
		},

		_bulkDeleteCloseButtonClicked: function()
		{
			$('.del-row').remove();
			$('.delete-action').remove()
		},

		_bulkDeleteRowButtonClicked: function(e)
		{
			var isChecked = $('input[name="cb[]"]:checked').length;
			
			if( ! isChecked ) {
				alert('Atleast one checkbox should be checked.');
				return false;
			}

			var result = confirm(FLBuilderStrings.deleteRowMessage);

			if(result) {
				$('input[type=checkbox]').each(function(){
					if( $(this).prop("checked") )
					{
						var bbnsRow = $(this).closest('.del-row'),
							nodeId 	= bbnsRow.attr('data-node'),
							row 	= $('.fl-row[data-node="' + nodeId + '"]');

						FLBuilder._deleteRow(row);
						bbnsRow.remove();
					}
				});

				FLBuilder._removeAllOverlays();
				NodesSettings._bulkDeleteCloseButtonClicked();
			}

			e.stopPropagation
		},

		_addActiveClass: function(button)
		{
			var parent = button.closest('.bulk-actions');

			if( button.hasClass('active') )
				return false;

			parent.find('span').removeClass('active');
			button.addClass('active');

			return true;
		},

		_refreshUIPanel: function(e)
		{
			setTimeout(function(){ 
				$('.all-nodes').html( LOADING.IMG );

				FLBuilder.ajax( {
					action: 'refresh_nodes',
				}, function( response ){
					$('.all-nodes').html( JSON.parse( response ) );
				} );
			}, 1500);

			e.stopPropagation();
		},

		_finishRefresh: function()
		{
			$('.all-nodes').html( LOADING.IMG );

			FLBuilder.ajax( {
				action: 'refresh_nodes',
			}, function( response ){
				$('.all-nodes').html( JSON.parse( response ) );
			} );
		},

		_toggleUIPanel: function()
		{
			if(	$('.nodes-setting-panel').is(':hidden') ) {
				$('.nodes-setting-panel').slideDown('slow');
				$('.fl-builder-bar-actions .fl-builder-nodes-settings-button').addClass('ui-bar-button-active');
				FLBuilder._closePanel();
				$('.bulk-actions .bulk-row-general').trigger('click');
			} else {
				$('.nodes-setting-panel').slideUp('slow');
				$('.fl-builder-bar-actions .fl-builder-nodes-settings-button').removeClass('ui-bar-button-active');
			}

			// Init TipTips
			FLBuilder._initTipTips();
		},

		_closeUIPanel: function()
		{
			if(	$('.nodes-setting-panel').is(':visible') ) {
				$('.nodes-setting-panel').slideUp(300);
				$('.fl-builder-bar-actions .fl-builder-nodes-settings-button').removeClass('ui-bar-button-active');
			}

			NodesSettings._bulkDeleteCloseButtonClicked();
		},

		_expandAll: function()
		{
			if( $('.col-group-wrapper, .parent-col-wrapper, .col-wrapper, .bbsui-module').is(':hidden') )
			{
				$('.col-group-wrapper, .parent-col-wrapper, .col-wrapper, .bbsui-module').slideDown('slow');
				$('.fa-angle-down').addClass('fa-angle-up');
				$('.fa-angle-down').removeClass('fa-angle-down');
			}

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();
		},

		_collapseAll: function()
		{
			if( $('.col-group-wrapper, .parent-col-wrapper, .col-wrapper, .bbsui-module').is(':visible') )
			{
				$('.col-group-wrapper, .parent-col-wrapper, .col-wrapper, .bbsui-module').slideUp('slow');
				$('.fa-angle-up').addClass('fa-angle-down');
				$('.fa-angle-up').removeClass('fa-angle-up');
			}

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();
			$('.bbsui-row').removeClass('bbsui-row-active');
		},

		_checkedAll: function()
		{
			$('input:checkbox').not(this).prop('checked', this.checked);
		},

		_expandColGroup: function()
		{
			el = $(this).closest('.row-wrapper');
			rowBlock = $(this).closest('.bbsui-row');
			if(	el.find('.col-group-wrapper').is(':hidden') ) {
				el.find('.col-group-wrapper').slideDown('slow');
				$(this).removeClass('fa-angle-down');
				$(this).addClass('fa-angle-up');
				rowBlock.addClass('bbsui-row-active');
			} else {
				el.find('.col-group-wrapper').slideUp('slow');
				$(this).removeClass('fa-angle-up');
				$(this).addClass('fa-angle-down');
				rowBlock.removeClass('bbsui-row-active');
			}
		},

		_expandCol: function()
		{
			el = $(this).closest('.col-group-wrapper');
			if( el.find('.parent-col-wrapper').length )
			{
				if(	el.find('.parent-col-wrapper').is(':hidden') ) {
					el.find('.parent-col-wrapper').slideDown('slow');
					$(this).removeClass('fa-angle-down');
					$(this).addClass('fa-angle-up');
				} else {
					el.find('.parent-col-wrapper').slideUp('slow');
					$(this).removeClass('fa-angle-up');
					$(this).addClass('fa-angle-down')
				}
			}

			if( el.find(' > .col-wrapper').length ) {
				if(	el.find(' > .col-wrapper').is(':hidden') ) {
					el.find(' > .col-wrapper').slideDown('slow');
					$(this).removeClass('fa-angle-down');
					$(this).addClass('fa-angle-up');
				} else {
					el.find(' >.col-wrapper').slideUp('slow');
					$(this).removeClass('fa-angle-up');
					$(this).addClass('fa-angle-down')
				}
			}
		},

		_expandColModule: function()
		{
			el = $(this).closest('.parent-col-wrapper');
			if(	el.children('.bbsui-module').is(':hidden') ) {
				el.children('.bbsui-module').slideDown('slow');
				$(this).removeClass('fa-angle-down');
				$(this).addClass('fa-angle-up');
			} else {
				el.children('.bbsui-module').slideUp('slow');
				$(this).removeClass('fa-angle-up');
				$(this).addClass('fa-angle-down')
			}

			if(el.find('.nested-col-wrapper > .col-wrapper').is(':hidden') ) {
				el.find('.nested-col-wrapper > .col-wrapper').slideDown('slow');
				$(this).removeClass('fa-angle-down');
				$(this).addClass('fa-angle-up');
			} else {
				el.find('.nested-col-wrapper > .col-wrapper').slideUp('slow');
				$(this).removeClass('fa-angle-up');
				$(this).addClass('fa-angle-down')
			}
		},

		_expandModule: function()
		{
			el = $(this).closest('.col-wrapper');
			if(	el.find('.bbsui-module').is(':hidden') ) {
				el.find('.bbsui-module').slideDown('slow');
				$(this).removeClass('fa-angle-down');
				$(this).addClass('fa-angle-up');
			} else {
				el.find('.bbsui-module').slideUp('slow');
				$(this).removeClass('fa-angle-up');
				$(this).addClass('fa-angle-down')
			}
		},

		_selectBBNSRow: function()
		{
			var button = $(this),
				nodeId = button.attr('data-node'),
				bbnsRow = $('.row-wrapper[data-node="' + nodeId + '"]');

			if(	$('.nodes-setting-panel').is(':hidden') || bbnsRow.find('.bbsui-row').hasClass('bbsui-row-active') )
				return;

			NodesSettings._collapseAll();
			$('.bbsui-row').removeClass('bbsui-row-active');
			bbnsRow.find('.bbsui-row').addClass('bbsui-row-active');
			bbnsRow.find('.bbsui-row .fa-angle-down').trigger("click");
			bbnsRow.find('.bbsui-col-group .fa-angle-down').trigger("click");
			bbnsRow.find('.bbsui-col .fa-angle-down').trigger("click");

			$('.nodes-setting-panel').animate({
				scrollTop: bbnsRow.offset().top - 75
			}, 300);
		},

		_selectRow: function()
		{
			var button  = $( this ),
				nodeId  = button.closest('.row-wrapper').attr('data-node'),
				row 	= $('.fl-row[data-node="' + nodeId + '"]');

			row.addClass('selected-row');
			$('html,body').animate({
				scrollTop: row.offset().top - 75
			}, 300);
		},

		_deselectRow: function()
		{
			NodesSettings._unmarkRow();
		},

		_rowActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.row-wrapper').attr('data-node'),
				rowBlock = button.closest( '.bbsui-row' ),
				div = button.closest( '.bbsui-settings-actions' ),
				actions = $( '.bbsui-row-actions' ).clone();

			div.after( actions );
			actions.addClass( 'bbsui-row-actions-active' );
			actions.find('i').addClass('fl-tip');
			rowBlock.addClass('bbsui-row-active');
			FLBuilder._initTipTips();
		},

		_closeRowActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.row-wrapper').attr('data-node'),
				row = button.closest( '.bbsui-row' ),
				actions = row.find( '.bbsui-row-actions' );

			actions.remove().fadeOut();
			row.removeClass('bbsui-row-active');
			$('.fl-row[data-node="' + nodeId + '"]').removeClass('selected-row');
			$('.row-wrapper').find('.reorder-row').removeAttr('style');
		},

		_visibilityButtonClicked: function(e)
		{
			var button = $(this),
				nodeId = button.attr('data-node');

			FLBuilderSettingsForms.render( {
				id        : 'visibility',
				nodeId    : nodeId,
				className : 'fl-builder-visibility-settings',
				attrs     : 'data-node="' + nodeId + '"',
				buttons   : [],
				badges    : [],
				settings  : FLBuilderSettingsConfig.nodes[ nodeId ],
				preview	  : {
					type: 'visibility'
				}
			}, function() {
				NodesSettings._closeUIPanel();
			} );

			e.stopPropagation();
		},

		_rowMoveButtonClicked: function()
		{
			var currentRow 	= $(this).closest('.row-wrapper'),
				nodeId 		= currentRow.attr('data-node'),
				pos 		= currentRow.find('.reorder-row .cb').attr('data-position');

			$('.row-wrapper').find('.reorder-row').css('visibility', 'visible');
			$('.row-wrapper').find('.reorder-row .cb').attr({'data-moved-row': nodeId, 'data-moved-row-pos': pos});
			currentRow.find('.reorder-row').css('visibility', 'hidden');
		},

		_reorderRow: function()
		{
			var newPos = $(this).attr('data-position'),
				nodeId = $(this).attr('data-moved-row'),
				oldpos = $(this).attr('data-moved-row-pos');

			FLBuilder.ajax( {
				action: 'reorder_node',
				node_id: nodeId,
				position: newPos
			}, function( response ) {
				NodesSettings._toggleUIPanel();
				FLBuilder._updateLayout();
				NodesSettings._finishRefresh();
			} );
		},

		_rowSettingsClicked: function( e )
		{		
			NodesSettings._closeUIPanel();

			var button = $( this ),
				nodeId = button.closest( '.row-wrapper' ).attr( 'data-node' ),
				global = button.closest( '.bbsui-global-node' ).length > 0,
				win    = null;

			$('.bbsui-row .bbsui-row-close').trigger('click');
			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			$('.fl-row[data-node="' + nodeId + '"]').addClass('selected-row');

			/*pos = $( '.fl-row[data-node="' + nodeId + '"]' ).position();
			$("html, body").animate({ 
				scrollTop: pos.top - 75 
			}, 350);*/

			if ( global && 'row' != FLBuilderConfig.userTemplateType ) {
				if ( FLBuilderConfig.userCanEditGlobalTemplates ) {
					win = window.open( $( '.fl-row[data-node="' + nodeId + '"]' ).attr( 'data-template-url' ) );
					win.FLBuilderGlobalNodeId = nodeId;
				}
			}
			else if ( button.hasClass( 'bbsui-row-settings' ) ) {

				FLBuilderSettingsForms.render( {
					id        : 'row',
					nodeId    : nodeId,
					className : 'fl-builder-row-settings',
					attrs     : 'data-node="' + nodeId + '"',
					buttons   : ! global ? ['save-as'] : [],
					badges    : global ? [ FLBuilderStrings.global ] : [],
					settings  : FLBuilderSettingsConfig.nodes[ nodeId ],
					preview	  : {
						type: 'row'
					}
				}, function() {
					$( '#fl-field-width select' ).on( 'change', FLBuilder._rowWidthChanged );
					$( '#fl-field-content_width select' ).on( 'change', FLBuilder._rowWidthChanged );
				} );
			}

			e.stopPropagation();
		},

		_rowCopyClicked: function(e)
		{
			var bbnsRow  = $( this ).closest( '.row-wrapper' ),
				nodeId   = bbnsRow.attr( 'data-node' ),
				pos 	 = bbnsRow.index() + 1,
				clone    = bbnsRow.clone(),
				row 	 = $('.fl-row[data-node="' + nodeId + '"]'),
				position = $( FLBuilder._contentClass + ' .fl-row' ).index( row ) + 1,
				flClone  = row.clone();

			flClone.addClass( 'fl-node-' + nodeId + '-clone fl-builder-node-clone' );
			row.after( flClone );

			clone.find( '.bbsui-row-actions' ).remove();
			bbnsRow.after( clone );

			$( 'html, body' ).animate( {
				scrollTop: flClone.offset().top - 75
			}, 300 );

			FLBuilder._showNodeLoading( nodeId + '-clone' );
			FLBuilder._newRowPosition = position;

			FLBuilder.ajax( {
				action: 'copy_row',
				node_id: nodeId
			}, function( response ) {
				var data = JSON.parse( response );
				data.duplicatedRow = nodeId;
				FLBuilder._rowCopyComplete( data );
				clone.attr('data-node', data.nodeId);
				clone.attr('id', 'bbsui-node-' + data.nodeId);
				clone.find('.bbsui-node-id').html('(#' + data.nodeId + ')');
				$('.bbsui-row .bbsui-row-close').trigger('click');
				NodesSettings._rowCopyCompleted(data);
			} );

			e.stopPropagation();
		},

		_rowCopyCompleted: function(data)
		{
			FLBuilder.ajax( {
				action: 'copy_bbsui_row',
				node_id: data.nodeId
			}, function( response ) {
				$('.row-wrapper[data-node="'+ data.nodeId + '"]').find('.col-group-wrapper').remove();
				$('.row-wrapper[data-node="'+ data.nodeId + '"]').append( JSON.parse( response ) );
			} );
		},

		_resetRowWidthClicked: function(e)
		{
			var button 	= $(this),
				bbnsRow = $(this).closest('.row-wrapper'), 
				nodeId 	= bbnsRow.attr('data-node'),
				row 	= $('.fl-row[data-node="' + nodeId + '"]'),
				content  = row.find( '.fl-row-content' ),
				width    = FLBuilderConfig.global.row_width + 'px',
				settings = $( '.fl-builder-row-settings' );

			if ( row.hasClass( 'fl-row-fixed-width' ) ) {
				row.css( 'max-width', width );
			}

			content.css( 'max-width', width );

			if ( settings.length ) {
				settings.find( '[name=max_content_width]' ).val( '' );
			}

			FLBuilder.ajax({
				action	: 'resize_row_content',
				node	: nodeId,
				width   : ''
			});

			FLBuilder._closeAllSubmenus();
			FLBuilder.triggerHook( 'didResetRowWidth', nodeId );

			e.stopPropagation();
		},

		_deleteRowClicked: function( e )
		{
			var button = $(this),
				bbnsRow = $(this).closest('.row-wrapper'), 
				nodeId = bbnsRow.attr('data-node'),
				row    = $('.fl-row[data-node="' + nodeId + '"]'),
				result = null;

			if(!row.find('.fl-module').length) {
				FLBuilder._deleteRow(row);
				bbnsRow.remove();
			}
			else {
				result = confirm(FLBuilderStrings.deleteRowMessage);

				if(result) {
					FLBuilder._deleteRow(row);
					bbnsRow.remove();
				}
			}

			FLBuilder._removeAllOverlays();
			e.stopPropagation();
		},

		_bulkUpdateSpacingButtonClicked: function()
		{
			var nodeId 		= $(this).attr('data-node'),
				group 		= $('.bbsui-node-' + nodeId).closest('.col-group-wrapper'),
				parentGroup = $('.bbsui-node-' + nodeId).closest('.parent-col-wrapper'),
				form 		= $('#col-spacing'),
				valid 		= form.validate().form(),
				data 		= form.serializeArray(),
				name 		= '',
				settings 	= { size: '' },
				preview 	= FLBuilder.preview;

			if(valid)
			{
				// Loop through the form data.
				for ( i = 0; i < data.length; i++ ) {
					value = data[ i ].value.replace( /\r/gm, '' );
					if( value != 'undefined' && value != '' )
					{
						name 	= data[ i ].name.replace( /\[(.*)\]/, '' );
						settings[ name ] = value;
					}
				}

				if( parentGroup.length > 0 )
				{
					parentGroup.find(' > .nested-col-wrapper > .col-wrapper').each(function(){
						var bbnsCol 	= $(this),
							nodeId 		= bbnsCol.attr('data-node'),
							col 		= $('.fl-col[data-node="' + nodeId + '"]');

						settings.size = parseFloat(col[0].style.width);

						// Show the loader.
						FLBuilder._showNodeLoading( nodeId );

						// Update the settings config object.
						FLBuilderSettingsConfig.nodes[ nodeId ] = settings;

						// Make the AJAX call.
						FLBuilder.ajax( {
							action          : 'save_settings',
							node_id         : nodeId,
							settings        : settings
						}, FLBuilder._saveSettingsComplete.bind( this, true, preview ) );

						// Trigger the hook.
						FLBuilder.triggerHook( 'didSaveNodeSettings', {
							nodeId   : nodeId,
							settings : settings
						} );
					});
				} else {
					group.find(' > .col-wrapper, > .parent-col-wrapper').each(function(){
						var bbnsCol 	= $(this),
							nodeId 		= bbnsCol.attr('data-node'),
							col 		= $('.fl-col[data-node="' + nodeId + '"]');

						settings.size = parseFloat(col[0].style.width);
						
						// Show the loader.
						FLBuilder._showNodeLoading( nodeId );

						// Update the settings config object.
						FLBuilderSettingsConfig.nodes[ nodeId ] = settings;

						// Make the AJAX call.
						FLBuilder.ajax( {
							action          : 'save_settings',
							node_id         : nodeId,
							settings        : settings
						}, FLBuilder._saveSettingsComplete.bind( FLBuilder, true, preview ) );

						// Trigger the hook.
						FLBuilder.triggerHook( 'didSaveNodeSettings', {
							nodeId   : nodeId,
							settings : settings
						} );
					});
				}
			}

			NodesSettings._bulkMarginsPaddingButtonClicked();
			NodesSettings._closeUIPanel();
		},

		_bulkMarginsPaddingButtonClicked: function()
		{
			if(	$('.spacing-wrapper').is(':hidden') ) {
				var group = $(this).closest('.bbsui-col-group'),
					pgroup = $(this).closest('.parent-col-wrapper');

				if( pgroup.length > 0 )
					nodeId = pgroup.attr('data-node');
				else
					nodeId = group.attr('data-node');

				$('.spacing-action.button-update').attr('data-node', nodeId);
				$('.spacing-wrapper').slideDown('slow');
			} else {
				$('.spacing-wrapper').slideUp('slow');
				$('.spacing-action.button-update').removeAttr('data-node');
			}
		},

		_selectColGroup: function()
		{
			var nodeId 	= $( this ).attr( 'data-node' ),
				obj 	= $('.fl-col-group[data-node="' + nodeId + '"]');

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			obj.addClass('selected-col');
		},

		_deselectColGroup: function()
		{
			$('.fl-col-group').removeClass('selected-col');
		},

		_deleteColGroupClicked: function(e)
		{
			var button 		= $( this ),
				nodeId 		= button.closest('.bbsui-col-group').attr( 'data-node' ),
				flGroup 	= $( '.fl-col-group[data-node="' + nodeId + '"]' );

			if ( flGroup.find( '.fl-module' ).length > 0 ) {
				result = confirm( FLBuilderStrings.deleteColumnMessage );
			}

			if ( result ) {
				FLBuilder._deleteCol( flGroup );
				FLBuilder._highlightEmptyCols();
				NodesSettings._deleteColGroupCompleted( button );
				NodesSettings._deselectColGroup();
			}

			e.stopPropagation();
		},

		_deleteColGroupCompleted: function( button )
		{
			var row    		= button.closest('.row-wrapper'),
				group 		= button.closest('.col-group-wrapper');

			group.remove();

			if( row.find('.col-group-wrapper').length === 0 ) {
				row.remove();
			}
		},

		_copyColGroupClicked: function(e)
		{
			var button 		= $( this ),
				nodeId 		= button.closest('.bbsui-col-group').attr( 'data-node' ),
				clone2 		= button.closest('.col-group-wrapper').clone(),
				group 		= $( '.fl-col-group[data-node="' + nodeId + '"]' ),
				clone 		= group.clone(),
				position  	= group.index() + 1;

			clone.addClass( 'fl-node-' + nodeId + '-clone fl-builder-node-clone' );
			group.after( clone );

			FLBuilder._showNodeLoading( nodeId + '-clone' );
			FLBuilder._newColGroupParent   = group.closest('.fl-row-content');
			FLBuilder._newColGroupPosition = position;

			FLBuilder.ajax( {
				action: 'copy_col_group',
				node_id: nodeId
			}, function( response ){
				var data = JSON.parse( response );
				data.duplicatedColumn = nodeId;
				NodesSettings._copyColGroupCompleted(data, group, button, clone2);
			} );
		},

		_copyColGroupCompleted: function( data, group, button, clone )
		{
			data.nodeParent   = FLBuilder._newColGroupParent;
			data.nodePosition = FLBuilder._newColGroupPosition;

			FLBuilder._renderLayout( data, function(){

				FLBuilder.triggerHook('didDuplicateColumn', {
					newNodeId : data.nodeId,
					oldNodeId : data.duplicatedColumn
				} );

				FLBuilder._newColGroupParent.find( '.fl-builder-node-loading' ).eq( 0 ).remove();	
			} );
			
			button.closest('.col-group-wrapper').after( clone );
			clone.find('.bbsui-col-group').attr('data-node', data.nodeId);
			clone.find('.bbsui-node-id').eq( 0 ).html('(#' + data.nodeId + ')');
			clone.find('.parent-col-wrapper').remove();
			clone.find('.col-wrapper').remove();
			clone.closest('.col-group-wrapper').append( data.colGroup );
		},
		_selectParentCol: function()
		{
			var nodeId 	= $( this ).closest('.parent-col-wrapper').attr( 'data-node' ),
				obj 	= $('.fl-col[data-node="' + nodeId + '"]');

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			obj.addClass('selected-col');

			$("html, body").animate({ 
				scrollTop: obj.offset().top - 75 
			}, 350);
		},

		_deselectParentCol: function()
		{
			NodesSettings._unmarkColumn();
		},

		_parentColActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.parent-col-wrapper').attr('data-node'),
				colBlock = button.closest( '.bbsui-col-parent' ),
				div = button.closest( '.bbsui-settings-actions' ),
				actions = $( '.bbsui-col-actions' ).clone();

			div.after( actions );
			actions.addClass( 'bbsui-col-actions-active' );
			actions.find('i').addClass('fl-tip');
			FLBuilder._initTipTips();
		},

		_closeParentColActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.parent-col-wrapper').attr('data-node'),
				colParent = button.closest( '.bbsui-col-parent' ),
				actions = colParent.find( '.bbsui-col-actions' );

			actions.remove().fadeOut();
		},

		_parentColSettingsClicked: function(e)
		{
			NodesSettings._closeUIPanel();

			var button   = $( this ),
				nodeId   = button.closest('.parent-col-wrapper').attr('data-node'),
				col      = $('.fl-col[data-node="' + nodeId + '"]'),
				content  = col.find( '> .fl-col-content' ),
				global   = button.closest( '.bbsui-global-node' ).length > 0;

			$('.bbsui-col-parent .bbsui-col-close').trigger('click');

			if ( FLBuilder._colResizing ) {
				return;
			}

			FLBuilderSettingsForms.render( {
				id        : 'col',
				nodeId    : nodeId,
				className : 'fl-builder-col-settings',
				attrs     : 'data-node="' + nodeId + '"',
				badges    : global ? [ FLBuilderStrings.global ] : [],
				settings  : FLBuilderSettingsConfig.nodes[ nodeId ],
				preview   : {
					type: 'col'
				}
			}, function() {
				if ( col.siblings( '.fl-col' ).length === 0  ) {
					$( '#fl-builder-settings-section-general' ).hide();
				}
				else if( content.width() <= 40 ) {
					$( '#fl-field-size' ).hide();
				}
			} );

			e.stopPropagation();
		},

		_deleteParentColClicked: function()
		{
			var button 			= $( this ),
				nodeId 			= button.closest('.parent-col-wrapper').attr('data-node'),
				col 			= $( '.fl-col[data-node="'+ nodeId + '"]' ),
				parentGroup 	= col.closest( '.fl-col-group' ),
				parentCol 		= col.parents( '.fl-col' ),
				hasParentCol 	= parentCol.length > 0,
				parentChildren 	= parentCol.find( '> .fl-col-content > .fl-module, > .fl-col-content > .fl-col-group' ),
				siblingCols 	= col.siblings( '.fl-col' ),
				result 			= true;

			if ( col.find( '.fl-module' ).length > 0 ) {
				result = confirm( FLBuilderStrings.deleteColumnMessage );
			}

			// Handle deleting of nested columns.
			if ( hasParentCol && 1 === parentChildren.length ) {

				if ( 0 === siblingCols.length ) {
					col = parentCol;
				}
				else if ( 1 === siblingCols.length && ! siblingCols.find( '.fl-module' ).length ) {
					col = parentGroup;
				}
			}

			if ( result ) {
				FLBuilder._deleteCol( col );
				FLBuilder._highlightEmptyCols();
				NodesSettings._deleteCol( button.closest('.parent-col-wrapper') );
				NodesSettings._unmarkColumn();
			}

			e.stopPropagation();
		},

		_copyParentColClicked: function( e )
		{
			var button = $( this ),
				nodeId = button.closest('.parent-col-wrapper').attr( 'data-node' ),
				clone2 = button.closest('.parent-col-wrapper').clone(),
				col    = $( '.fl-col[data-node="' + nodeId + '"]' ),
				clone  = col.clone(),
				group  = col.parent();

			clone.addClass( 'fl-node-' + nodeId + '-clone fl-builder-node-clone' );
			col.after( clone );

			FLBuilder._showNodeLoading( nodeId + '-clone' );
			FLBuilder._newColParent   = group;
			FLBuilder._newColPosition = col.index() + 1;
			FLBuilder._resetColumnWidths( group );

			FLBuilder.ajax( {
				action: 'copy_col',
				node_id: nodeId
			}, function( response ){
				var data = JSON.parse( response );
				data.duplicatedColumn = nodeId;
				FLBuilder._copyColComplete( data );
				button.closest('.parent-col-wrapper').after( clone2 );
				clone2.attr('data-node', data.nodeId);
				clone2.attr('id', 'bbsui-node-' + data.nodeId);
				clone2.find('.bbsui-node-id').html('(#' + data.nodeId + ')');
				$('.bbsui-col-parent .bbsui-col-close').trigger('click');
				NodesSettings._copyParentColCompleted(data);
			} );

			e.stopPropagation();
		},

		_copyParentColCompleted: function( data )
		{
			FLBuilder.ajax( {
				action: 'copy_bbsui_parent_col',
				node_id: data.nodeId
			}, function( response ){
				$('.parent-col-wrapper[data-node="'+ data.nodeId + '"]').find('.bbsui-col').remove();
				$('.parent-col-wrapper[data-node="'+ data.nodeId + '"]').find('.bbsui-module').remove();
				$('.parent-col-wrapper[data-node="'+ data.nodeId + '"]').append( JSON.parse( response ) );
			});
		},

		_selectCol: function()
		{
			var nodeId 	= $( this ).closest('.col-wrapper').attr( 'data-node' ),
				obj 	= $('.fl-col[data-node="' + nodeId + '"]');

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			obj.addClass('selected-col');

			$("html, body").animate({ 
				scrollTop: obj.offset().top - 75 
			}, 350);
		},

		_deselectCol: function()
		{
			NodesSettings._unmarkColumn();
		},

		_colSettingsClicked: function(e)
		{
			NodesSettings._closeUIPanel();

			var button   = $( this ),
				nodeId   = button.closest('.col-wrapper').attr('data-node'),
				col      = $('.fl-col[data-node="' + nodeId + '"]'),
				content  = col.find( '> .fl-col-content' ),
				global   = button.closest( '.bbsui-global-node' ).length > 0;

			$('.bbsui-col .bbsui-col-close').trigger('click');

			if ( FLBuilder._colResizing ) {
				return;
			}

			FLBuilderSettingsForms.render( {
				id        : 'col',
				nodeId    : nodeId,
				className : 'fl-builder-col-settings',
				attrs     : 'data-node="' + nodeId + '"',
				badges    : global ? [ FLBuilderStrings.global ] : [],
				settings  : FLBuilderSettingsConfig.nodes[ nodeId ],
				preview   : {
					type: 'col'
				}
			}, function() {
				if ( col.siblings( '.fl-col' ).length === 0  ) {
					$( '#fl-builder-settings-section-general' ).hide();
				}
				else if( content.width() <= 40 ) {
					$( '#fl-field-size' ).hide();
				}
			} );

			e.stopPropagation();
		},

		_colActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.col-wrapper').attr('data-node'),
				colBlock = button.closest( '.bbsui-col' ),
				div = button.closest( '.bbsui-settings-actions' ),
				actions = $( '.bbsui-col-actions' ).clone();

			div.after( actions );
			actions.addClass( 'bbsui-col-actions-active' );
			actions.find('i').addClass('fl-tip');
			FLBuilder._initTipTips();
		},

		_closeColActionsButtons: function()
		{
			var button = $( this ),
				nodeId = button.closest('.col-wrapper').attr('data-node'),
				col = button.closest( '.bbsui-col' ),
				actions = col.find( '.bbsui-col-actions' );

			actions.remove().fadeOut();
		},

		_deleteColClicked: function(e)
		{
			var button 			= $( this ),
				nodeId 			= button.closest('.col-wrapper').attr('data-node'),
				col 			= $( '.fl-col[data-node="'+ nodeId + '"]' ),
				parentGroup 	= col.closest( '.fl-col-group' ),
				parentCol 		= col.parents( '.fl-col' ),
				hasParentCol 	= parentCol.length > 0,
				parentChildren 	= parentCol.find( '> .fl-col-content > .fl-module, > .fl-col-content > .fl-col-group' ),
				siblingCols 	= col.siblings( '.fl-col' ),
				result 			= true;

			if ( col.find( '.fl-module' ).length > 0 ) {
				result = confirm( FLBuilderStrings.deleteColumnMessage );
			}

			// Handle deleting of nested columns.
			if ( hasParentCol && 1 === parentChildren.length ) {

				if ( 0 === siblingCols.length ) {
					col = parentCol;
				}
				else if ( 1 === siblingCols.length && ! siblingCols.find( '.fl-module' ).length ) {
					col = parentGroup;
				}
			}

			if ( result ) {
				FLBuilder._deleteCol( col );
				FLBuilder._highlightEmptyCols();
				NodesSettings._deleteCol( button.closest('.col-wrapper') );
				NodesSettings._unmarkColumn();
			}

			e.stopPropagation();
		},

		_deleteCol: function( col )
		{
			var nodeId = col.attr('data-node'),
				row    = col.closest('.row-wrapper'),
				group  = col.closest('.col-group-wrapper');

			col.remove();
			rowCols   = row.find('.col-group-wrapper .col-wrapper');
			groupCols = group.find('.col-wrapper');
			parentCols = group.find('.parent-col-wrapper');

			if(0 === rowCols.length && 0 === parentCols.length && 'row' != FLBuilderConfig.userTemplateType) {
				row.remove();
			}
			else {
				if(0 === groupCols.length && 0 === parentCols.length) {
					group.remove();
				}
			}
		},

		_copyColClicked: function( e )
		{
			var button = $( this ),
				nodeId = button.closest('.col-wrapper').attr( 'data-node' ),
				clone2 = button.closest('.col-wrapper').clone(),
				col    = $( '.fl-col[data-node="' + nodeId + '"]' ),
				clone  = col.clone(),
				group  = col.parent();

			clone.addClass( 'fl-node-' + nodeId + '-clone fl-builder-node-clone' );
			col.after( clone );

			FLBuilder._showNodeLoading( nodeId + '-clone' );
			FLBuilder._newColParent   = group;
			FLBuilder._newColPosition = col.index() + 1;
			FLBuilder._resetColumnWidths( group );

			FLBuilder.ajax( {
				action: 'copy_col',
				node_id: nodeId
			}, function( response ){
				var data = JSON.parse( response );
				data.duplicatedColumn = nodeId;
				FLBuilder._copyColComplete( data );
				button.closest('.col-wrapper').after( clone2 );
				clone2.attr('data-node', data.nodeId);
				clone2.attr('id', 'bbsui-node-' + data.nodeId);
				clone2.find('.bbsui-node-id').html('(#' + data.nodeId + ')');
				$('.bbsui-col .bbsui-col-close').trigger('click');
				NodesSettings._copyColCompleted(data);
			} );

			e.stopPropagation();
		},

		_copyColCompleted: function( data )
		{
			FLBuilder.ajax( {
				action: 'copy_bbsui_col',
				node_id: data.nodeId
			}, function( response ){
				$('.col-wrapper[data-node="'+ data.nodeId + '"]').find('.bbsui-module').remove();
				$('.col-wrapper[data-node="'+ data.nodeId + '"]').append( JSON.parse( response ) );
			});
		},

		_selectBBNSModule: function()
		{
			var nodeId   = $( this ).attr( 'data-node' );

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			$('.fl-module[data-node="' + nodeId + '"]').addClass('selected-module');

			pos = $( '.fl-module[data-node="' + nodeId + '"]' );//.position();
			$("html, body").animate({ 
				scrollTop: pos.offset().top - 75 
			}, 350);
		},

		_deselectBBNSModule: function()
		{
			NodesSettings._unmarkModule();
		},

		_moduleCodeButtonClicked: function(e)
		{
			var button = $(this),
				nodeId = button.attr('data-node');

			FLBuilderSettingsForms.render( {
				id        : 'module_code',
				nodeId    : nodeId,
				className : 'fl-builder-module_code-settings',
				attrs     : 'data-node="' + nodeId + '"',
				buttons   : [],
				badges    : [],
				settings  : FLBuilderSettingsConfig.nodes[ nodeId ],
				preview	  : {
					type: 'module_code'
				}
			}, function() {
				NodesSettings._closeUIPanel();
			} );

			e.stopPropagation();
		},

		_moduleSettingsClicked: function(e)
		{		
			NodesSettings._closeUIPanel();

			var button   = $( this ),
				type     = button.closest( '.bbsui-module' ).attr( 'data-type' ),
				nodeId   = button.closest( '.bbsui-module' ).attr( 'data-node' ),
				parentId = button.closest( '.col-wrapper' ).attr( 'data-node' ),
				//rowId 	 = button.closest( '.row-wrapper' ).attr( 'data-node' ),
				global 	 = button.closest( '.bbsui-global-node' ).length > 0;

			NodesSettings._unmarkRow();
			NodesSettings._unmarkColumn();
			NodesSettings._unmarkModule();

			$('.fl-module[data-node="' + nodeId + '"]').addClass('selected-module');

			pos = $( '.fl-module[data-node="' + nodeId + '"]' );//.position();
			$("html, body").animate({ 
				scrollTop: pos.offset().top - 75 
			}, 350);

			e.stopPropagation();

			if ( FLBuilder._colResizing ) {
				return;
			}
			if ( global && ! FLBuilderConfig.userCanEditGlobalTemplates ) {
				return;
			}

			FLBuilder._showModuleSettings( {
				type     : type,
				nodeId   : nodeId,
				parentId : parentId,
				global   : global
			} );
		},

		_moduleCopyClicked: function(e)
		{
			var module   = $( this ).closest( '.bbsui-module' ),
				nodeId   = module.attr( 'data-node' ),
				position = module.index() + 1,
				clone    = module.clone(),
				flModule = $( '.fl-module[data-node="' + nodeId + '"]' ),
				flPos 	 = flModule.index() + 1,
				flClone  = flModule.clone();

			module.after( clone );

			flClone.addClass( 'fl-node-' + nodeId + '-clone fl-builder-node-clone' );
			flClone.find( '.fl-block-overlay' ).remove();
			flModule.after( flClone );

			$( 'html, body' ).animate( {
				scrollTop: flClone.offset().top - 75
			}, 500 );

			FLBuilder._showNodeLoading( nodeId + '-clone' );
			FLBuilder._newModuleParent 	 = flModule.parent();
			FLBuilder._newModulePosition = flPos;

			FLBuilder.ajax({
				action: 'copy_module',
				node_id: nodeId
			}, function( response ) {
				var data = JSON.parse( response );
				data.duplicatedModule = nodeId;
				FLBuilder._moduleCopyComplete( data );
				clone.attr('data-node', data.nodeId);
			} );

			e.stopPropagation();
		},

		_deleteModuleClicked: function(e)
		{
			var module = $(this).closest('.bbsui-module'),
				nodeId = module.attr('data-node'),
				flModule = $('.fl-module[data-node="' + nodeId + '"]');
				result = confirm(FLBuilderStrings.deleteModuleMessage);

			if(result) {
				FLBuilder._deleteModule(flModule);
				FLBuilder._removeAllOverlays();
				module.remove();
			}

			e.stopPropagation();
		},

		_unmarkRow: function()
		{
			if( $('.fl-row').hasClass('selected-row') )
			{
				$('.fl-row').removeClass('selected-row');	
			}
		},

		_unmarkColumn: function()
		{
			if( $('.fl-col').hasClass('selected-col') )
			{
				$('.fl-col').removeClass('selected-col');	
			}
		},

		_unmarkModule: function()
		{
			if( $('.fl-module').hasClass('selected-module') )
			{
				$('.fl-module').removeClass('selected-module');	
			}
		},

		_datePicker: function()
		{
			$('.node_schedule').datetimepicker();
		}
	};

	$(function(){
		NodesSettings.init();
	});

})(jQuery);