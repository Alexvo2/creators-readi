<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo plugins_url('css/wtt-core.min.css', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>">
<script>
    try {
        if(typeof jQuery.ui !== 'undefined') {
            jQuery.widget.bridge('uitooltip', jQuery.ui.tooltip);
            jQuery.widget.bridge('uibutton', jQuery.ui.button);
        }
    }
    catch(err) {
        console.warn(err.message);
    }
</script>
<script type="text/javascript" src="<?php echo plugins_url('js/getHtmlContent.js', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('js/observeDom.js', dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url("js/edit-page-controller.min.js", dirname(__FILE__)) . "?ver=" . WTT_VERSION; ?>"></script>

<div ng-controller="editPageController" id="wtt-dashboard">
    <?php

    function require_multi($files)
    {
        $files = func_get_args();
        foreach ($files as $file)
            require_once($file);
    }

    require_multi("WTT_BlockHeader.php", "WTT_BlockWarning.php", "WTT_BlockResearch.php", "WTT_BlockSuggestions.php");

    ?>
</div>

