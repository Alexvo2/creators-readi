<div class="<?php echo $main_class; ?>">
	<div class="layout-<?php echo $layout; ?>-wrapper">
		<div class="pp-icon-wrapper animated">
			<?php if( $settings->icon_type == 'icon' ) { ?>
				<div class="pp-infobox-icon">
					<div class="pp-infobox-icon-inner">
						<span class="pp-icon <?php echo $settings->icon_select; ?>"></span>
					</div>
				</div>
			<?php } else { ?>
				<div class="pp-infobox-image">
					<?php if ( isset( $settings->image_select_src ) ) { ?>
						<img src="<?php echo $settings->image_select_src; ?>" alt="<?php echo $module->get_alt(); ?>" />
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<div class="pp-heading-wrapper">

				<span class="pp-infobox-title-prefix"><?php echo $settings->title_prefix; ?></span>

				<?php if( $settings->pp_infobox_link_type == 'title' ) { ?>
					<a class="pp-more-link" href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>">
				<?php } ?>
					<div class="pp-infobox-title-wrapper">
						<<?php echo $settings->title_tag; ?> class="pp-infobox-title"><?php echo $settings->title; ?></<?php echo $settings->title_tag; ?>>
					</div>
				<?php if( $settings->pp_infobox_link_type == 'title' ) { ?>
					</a>
				<?php } ?>
			<div class="pp-infobox-description">
				<?php echo $settings->description; ?>
				<?php $module->render_link(); ?>
			</div>
		</div>
	</div>
</div>