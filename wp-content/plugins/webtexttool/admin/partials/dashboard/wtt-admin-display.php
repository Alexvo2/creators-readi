<?php
/**
 * Webtexttool login setup and routing
 *
 * @link       http://webtexttool.com
 * @since      1.0.0
 *
 * @package    Webtexttool
 * @subpackage Webtexttool/admin/partials/dashboard
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo plugins_url('../css/wtt-admin.min.css', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>">
<script type="text/javascript" src="<?php echo plugins_url('../js/wtt-admin.min.js', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>"></script>
<script type="text/javascript"
        src="<?php echo plugins_url('../js/app-controller.min.js', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>"></script>

<div ng-app="wtt" ng-controller="appController">

    <header>
        <h1><?php echo esc_html(get_admin_page_title()) . " - v" . WTT_VERSION ?></h1>
    </header>

    <?php

    function require_multi($files)
    {
        $files = func_get_args();
        foreach ($files as $file)
            require_once($file);
    }

    require_multi("wtt-login.php", "wtt-account.php");

    ?>

</div>