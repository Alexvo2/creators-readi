<link rel="stylesheet" href="<?php echo plugins_url('../css/wtt-settings-page.min.css', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>">
<link rel="stylesheet" href="<?php echo plugins_url('../css/wtt-admin.min.css', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>">

<div id="wtt-settings" class="wrap">

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <div id="post-body-content">

                <div class="postbox">

                    <h3 class="postbox-title">
                        <span>Webtexttool Settings</span>
                        <img class="webtexttool-logo"
                             src="<?php echo plugins_url('../images/wtt_logo.png', dirname(__FILE__)); ?>"
                             alt="Webtexttool"/>
                    </h3>

                    <div class="inside">

                        <form id="wtt_settings_form" name="settings"
                              action="<?php echo esc_url(admin_url('options.php')) ?>" method="post">

                            <div id="wtt_settings_body">
                                <div>
                                    <div id="wtt_post_type_option" class="wtt_withborder">
                                        <h3 style="font-weight: bold;">Load Webtexttool SEO Optimization for:</h3>
                                        <p class="description">Note: only post types which have their own page (like
                                            posts or pages, but not navigation
                                            menu items) are supported.</p>
                                        <?php
                                        include_once('wtt-post-types-settings.php');
                                        ?>
                                    </div>

                                    <?php if (class_exists('acf')) { ?>

                                        <div id="wtt_acf_option" class="wtt_withborder">
                                            <h3 style="font-weight: bold;">Advanced Custom Fields analysis:</h3>
                                            <p class="description">Ensure that Webtexttool analyzes all Advanced Custom Fields content.</p>
                                            <?php
                                            include_once('wtt-acf-settings.php');
                                            ?>
                                        </div>

                                    <?php } ?>

                                    <?php if (class_exists('RWMB_Loader')) { ?>

                                        <div id="wtt_rwmb_option" class="wtt_withborder">
                                            <h3 style="font-weight: bold;">MetaBox.io analysis:</h3>
                                            <p class="description">Ensure that Webtexttool analyzes all MetaBox.io content.</p>
                                            <?php
                                            include_once('wtt-rwmb-settings.php');
                                            ?>
                                        </div>

                                    <?php } ?>

                                    <div id="wtt_settings_submit">
                                        <?php
                                        settings_fields('wtt_options');
                                        submit_button();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>