.fsoc-content::-webkit-scrollbar {
	width: 5px;
}

.fsoc-content::-webkit-scrollbar-track {
	background: #ddd;
	border-radius: 5px;
}

.fsoc-content::-webkit-scrollbar-thumb {
	border-radius: 8px;
	background: #bbb;
}

.fullscreen-overlay {
	overflow-x: hidden;
	overflow-y: auto!important;
}

.fullscreen-overlay.close {
	z-index: 3243556;
}

@media screen and (max-width: 768px)
{
	.fullscreen-overlay {
		height: 100vh;
	}
}

<?php if( ! FLBuilderModel::is_builder_active() ): ?>
#trigger-overlay-<?php echo $id; ?> {
	position: relative;
	z-index: 99;
}
<?php endif; ?>

<?php if( ! empty( $settings->cnt_bg_color ) && $settings->anim_style !== 'genie' ): ?>
.fsoc-<?php echo $id; ?>-content.fullscreen-overlay {
	background-color: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->cnt_bg_color ) ) ?>, <?php echo $settings->cnt_bg_opacity / 100; ?>);
}
<?php endif; ?>
<?php if( ! empty( $settings->cnt_bg_color ) && $settings->anim_style == 'genie' ): ?>
.fsoc-<?php echo $id; ?>-content .overlay-path {
	fill: rgba(<?php echo implode( ',', FLBuilderColor::hex_to_rgb( $settings->cnt_bg_color ) ) ?>, <?php echo $settings->cnt_bg_opacity / 100; ?>);
}
<?php endif;

if( $settings->btn_type == "button"):
	FLBuilder::render_module_css('button', $id, array(
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
		'link'              => '#',
		'link_target'       => '_self',
		'padding'           => $settings->btn_padding,
		'style'             => $settings->btn_style,
		'text'              => $settings->btn_text,
		'text_color'        => $settings->btn_text_color,
		'text_hover_color'  => $settings->btn_text_hover_color,
		'width'             => $settings->btn_width,
		'align'				=> $settings->btn_align,
		'icon_animation'	=> $settings->btn_icon_animation
	));
endif;

if( $settings->btn_type == "icon"): ?>

<?php if(!empty($settings->icon_align)) : ?>
.fl-node-<?php echo $id; ?>.fl-module-fullscreen-overlay-content .fsoc-cta-wrapper {
	text-align: <?php echo $settings->icon_align; ?>
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fsoc-icon-wrap i.fsoc-icon,
.fl-node-<?php echo $id; ?> .fsoc-icon-wrap i.fsoc-icon:before {
	<?php if($settings->icon_color) : ?>
	color: #<?php echo $settings->icon_color; ?>;
	<?php endif; ?>
	font-size: <?php echo $settings->icon_size; ?>px;
	height: auto;
	width: auto;
	cursor: pointer;
}
.fl-node-<?php echo $id; ?> .fsoc-icon-wrap i.fsoc-icon {
	<?php if( $settings->icon_bg_color ) : ?>
		background: #<?php echo $settings->icon_bg_color; ?>;
	<?php endif; ?>
	<?php if( ( $settings->icon_bg_color ) || ( ! empty($settings->border_color) && (int) $settings->height > 0 ) ) : ?>
	line-height: <?php echo ( ( $settings->icon_size * 1.75) - 2 * (int) $settings->height ); ?>px;
	height: <?php echo $settings->icon_size * 1.75; ?>px;
	width: <?php echo $settings->icon_size * 1.75; ?>px;
	text-align: center;
	<?php endif; ?>

	<?php if( ! empty( $settings->border_color ) ): ?>
	border:<?php echo $settings->height; ?>px <?php echo $settings->border_style; ?> #<?php echo $settings->border_color; ?>;
		<?php if( ! empty( $settings->border_radius ) ): ?>
			border-radius: <?php echo $settings->border_radius;?>px;
		<?php endif; ?>
	<?php endif; ?>
}
.fl-node-<?php echo $id; ?> .fsoc-icon-wrap i.fsoc-icon:hover {
	<?php if(!empty($settings->icon_bg_hover_color)) : ?>
	background: #<?php echo $settings->icon_bg_hover_color; ?>;
	<?php endif; ?>
	<?php if( ! empty( $settings->border_hover_color ) ): ?>
	border:<?php echo $settings->height; ?>px <?php echo $settings->border_style; ?> #<?php echo $settings->border_hover_color; ?>;
	<?php endif; ?>
}
.fl-node-<?php echo $id; ?> .fsoc-icon-wrap i.fsoc-icon:hover:before {
	<?php if(!empty($settings->icon_hover_color)) : ?>
	color: #<?php echo $settings->icon_hover_color; ?>;
	<?php endif; ?>
}
<?php endif; ?>

.fsoc-<?php echo $id; ?>-close-btn,
.fsoc-<?php echo $id; ?>-close-btn i.fa-close,
.fsoc-<?php echo $id; ?>-close-btn i.fa-close:before {
	<?php if(!empty($settings->close_btn_color)) : ?>
	color: #<?php echo $settings->close_btn_color; ?>;
	<?php endif; ?>
	font-size: <?php echo $settings->close_btn_font_size; ?>px;
}

<?php if(!empty($settings->close_btn_hover_color)) : ?>
.fsoc-<?php echo $id; ?>-close-btn:hover,
.fsoc-<?php echo $id; ?>-close-btn:hover i.fa-close,
.fsoc-<?php echo $id; ?>-close-btn:hover i.fa-close:before {
	color: #<?php echo $settings->close_btn_hover_color; ?>;
}
<?php endif; ?>