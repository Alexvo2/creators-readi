function ActivateBBSUIPlugin( id, action, nonce ) {
  var key = jQuery( '#' + id).val();   
  var data = {
    "action"      : "bbsui_" + action + "_plugin",
    "license_key" : key,
    "security"    : nonce
 };
 
 jQuery('#actplug').css('visibility', 'inherit');
 
 jQuery.post(ajaxurl, data, function( response ) {
    jQuery('#actplug').removeAttr('style');
    if( response != '200' ) {
      jQuery('.bbsui-response').addClass('error').text(response);
    }else {
      jQuery('#btn-' + action + '-license').hide();
      jQuery('.bbsui-response').text('');
      jQuery('.bbsui-response').removeClass('error');
      if( action == 'reactivate' ) {
        jQuery('td .update-nag').hide();
      }
    }   
    
    jQuery('.bbsui-response').show();
 });
}